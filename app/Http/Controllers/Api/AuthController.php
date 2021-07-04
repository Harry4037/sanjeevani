<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use App\Models\UserBookingDetail;
use App\Models\Resort;
use App\Models\CityMaster;
use App\Models\Cart;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtp;

class AuthController extends Controller {

    /**
     * @api {post} /api/send-otp  Send OTP
     * @apiHeader {String} Accept application/json. 
     * @apiName PostSendOtp
     * @apiGroup Auth
     * 
     * @apiParam {String} mobile_number User unique mobile number*.
     * @apiParam {String} email_id Email User email id.
     * @apiParam {String} user_type User type*. (Staff member => 2 or Customer => 3).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message OTP sent successfully.
     * @apiSuccess {JSON} data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *  {
     *     "status": true,
     *     "status_code": 200,
     *     "message": "OTP sent successfully.",
     *     "data": {}
     *  }
     * 
     * @apiError MobileNumberMissing The mobile number is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Mobile number missing.",
     *       "data": {}
     *   }
     * 
     * @apiError UserTypeMissing The User type is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "User type missing.",
     *     "data": {}
     *  }
     * 
     * @apiError MobileNumber10Digit The Mobile number should be 10 digit.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Mobile number should be 10 digit.",
     *    "data": {}
     * }
     * 
     * @apiError InvalidUserType The User invalid user type.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *     "message": "User type invalid.",
     *     "data": {}
     * }
     * 
     * 
     */
    public function signup(Request $request) {
        try {
            if (!$request->mobile_number) {
                return $this->sendErrorResponse("Mobile number missing.", (object) []);
            }
            if (strlen($request->mobile_number) != 10) {
                return $this->sendErrorResponse("Mobile number should be 10 digit.", (object) []);
            }
            if (!$request->user_type) {
                return $this->sendErrorResponse("User type missing.", (object) []);
            }
            if (!(in_array($request->user_type, [2, 3]))) {
                return $this->sendErrorResponse("User type invalid.", (object) []);
            }


            $userExist = User::where("mobile_number", $request->mobile_number)
                    ->where("user_type_id", $request->user_type)
                    ->first();

            if ($request->user_type == 2) {
                if ($userExist) {
                    if ($userExist->is_active == 0) {
                        return $this->sendInactiveAccountResponse();
                    }
                    $OTP = rand(1000, 9999);
                    $this->sendOtp($request->mobile_number, $OTP, env('SMS_STAFF_KEY', "GHOZEKphzT/"));

                    $userExist->otp = $OTP;
                    $userExist->password = bcrypt($OTP);
                    if ($userExist->save()) {
                        return $this->sendSuccessResponse("OTP sent successfully.", (object) []);
                    } else {
                        return $this->administratorResponse();
                    }
                } else {
                    return $this->sendErrorResponse("User doesn't exist in our record.", (object) []);
                }
            } else {
                if (!$userExist) {
                    $OTP = rand(1000, 9999);
                    $user = new User([
                        'mobile_number' => $request->mobile_number,
                        'user_type_id' => $request->user_type,
                        'email_id' => $request->email_id,
                        'otp' => $OTP,
                        'password' => bcrypt($OTP)
                    ]);
                    if ($user->save()) {

                        $this->sendOtp($request->mobile_number, $OTP, env('SMS_CUSTOMER_KEY', "ftG8wwUM+Sm"));
                        if ($request->email_id) {
                            Mail::to($request->email_id)->send(new LoginOtp($OTP));
                        }
                        return $this->sendSuccessResponse("OTP sent successfully.", (object) []);
                    } else {
                        return $this->administratorResponse();
                    }
                } else {
                    if ($userExist->is_active == 0) {
                        return $this->sendInactiveAccountResponse();
                    }
                    $OTP = rand(1000, 9999);
                    $userExist->otp = $OTP;

                    $userExist->password = bcrypt($OTP);
                    if ($userExist->save()) {
                        $this->sendOtp($request->mobile_number, $OTP, env('SMS_CUSTOMER_KEY', "ftG8wwUM+Sm"));
                        if ((strlen($userExist->email_id) > 0) || (strlen($request->email_id) > 0)) {
                            if (strlen($userExist->email_id) == 0 || ($userExist->email_id == "")) {
                                $userExist->email_id = $request->email_id;
                                $userExist->save();
                            }
                            try {
                                Mail::to($request->email_id)->send(new LoginOtp($OTP));
                            } catch (\Exception $e) {
                                
                            }
                        }
                        return $this->sendSuccessResponse("OTP sent successfully.", (object) []);
                    } else {
                        return $this->administratorResponse();
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), (object) []);
        }
    }

    /**
     * @api {post} /api/verify-otp  Verify OTP
     * @apiHeader {String} Accept application/json.
     * @apiName PostVerifyOtp
     * @apiGroup Auth
     *
     * @apiParam {String} mobile_number Users mobile number*.
     * @apiParam {String} otp OTP*.
     * @apiParam {String} user_type User type*. (Staff member => 2 or Customer => 3).
     * @apiParam {String} device_id User device Id (IMEI number)*.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String}   message OTP verified successfully.
     * @apiSuccess {JSON}   data User detail with unique token.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *  {
     *      "status": true,
     *      "status_code": 200,
     *      "message": "OTP verified successfully.",
     *      "data": {
     *          "id": 149,
     *          "cart_count": 0,
     *          "user_name": "Om",
     *          "first_name": "Om",
     *          "mid_name": "",
     *          "last_name": "",
     *          "email_id": "om@mail.com",
     *          "user_type_id": 3,
     *          "is_checked_in": false,
     *          "address": "",
     *          "state": "",
     *          "city": "",
     *          "pincode": "",
     *          "screen_name": "",
     *          "profile_pic_path": "http://127.0.0.1:1234/img/no-image.jpg",
     *          "mobile_number": "8077575835",
     *          "token_type": "Bearer",
     *          "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImMxMjM0MWFmY2JlMzYwMzEwMDEwYTllM2QzZTg0YjM2ZGQ4MDFmNjNmZDA4NzJkNGY2OTk4ODNiZjI0MTBmYmQ5YzVlOWFjYzY2YTMwZDNmIn0.eyJhdWQiOiI1IiwianRpIjoiYzEyMzQxYWZjYmUzNjAzMTAwMTBhOWUzZDNlODRiMzZkZDgwMWY2M2ZkMDg3MmQ0ZjY5OTg4M2JmMjQxMGZiZDljNWU5YWNjNjZhMzBkM2YiLCJpYXQiOjE1NTE2NzUzODcsIm5iZiI6MTU1MTY3NTM4NywiZXhwIjoxNTgzMjk3Nzg3LCJzdWIiOiIxNDkiLCJzY29wZXMiOltdfQ.KS-8efmZcedmsFzqD-AyCZ3jeL07HIvXbrrSnjlciTHl9oHlq5lwtT5UgC6bKaC9nHZx1MHDEKvEcft4SYiguszvhBeJmCSoigaGIKhVJEk-JLBtjA_KU6vqpJKsnC96X00f8lvqoHlNsttj0_4t0JoSCrp2ARbJ18WyRBGHCj1XYFXRzklukJPOX3T5KYQnLKj_op_n50_JUJnhaLX-KoLFFilvNMMuPGMYF-eVhsgQut4kqXgTnK8-6CRC01lk3X-8BCMKh1gtN2pG0KD3NqOapczuuv2raiafphe3OpZSRRsiRbh4KsG_2JX4_6CQ50qCerPy1hWm45sVT11mWb3DiuUgsXLgE4SqdCjmryFZy7AWb65R_DyCWLb0cWDkaMv8ulQfBcI8EHPg7ugUG5LzgSkoBOSitnU8qbD3YBGqhXIviI0yzgfwySPsErE1q1EsiEe_OranNibocSTMJLZn0T3DcPYkFPy5TbHG7N9twzuyAkx9LZ_AFNsDeNCl9U_p0YxFyCiBN6n4DLL3dCRzYPWOwD9NgTCtI-EyTSjvUuIoP9ELw2E7s7WsyPL09vxzo-S-qgrS8fe8aa573H5vgysF0UTmdbu17LFlhu-znYtUDUayPTsz9ThMa0F9X4O8rvYYgYDjluV9mBorv_9Ln2FcFiIFXFOtKAf9cgQ",
     *          "source_name": "GOIBO",
     *          "source_id": "GOIBO123456",
     *          "resort_room_no": "T-2",
     *          "room_type": "Tent",
     *          "check_in_pin": 7015,
     *          "check_out_pin": 3336,
     *          "check_in_date": "04-Mar-2019",
     *          "check_in_time": "12:00 AM",
     *          "check_out_date": "30-Mar-2019",
     *          "check_out_time": "10:00 AM",
     *          "booking_id": "GOIBO123456",
     *          "no_of_guest": "1 Adult and 1 Child",
     *          "guest_detail": [
     *              {
     *                  "id": 23,
     *                  "person_name": "Ankit",
     *                  "person_age": "10",
     *                  "person_type": "Child"
     *              },
     *              {
     *                  "id": 24,
     *                  "person_name": "Anshu",
     *                  "person_age": "25",
     *                  "person_type": "Adult"
     *             }
     *         ],
     *          "membership": {
     *              "membership_id": "ABCDE",
     *              "valid_from": "04-Mar-2019 12:00 AM",
     *              "valid_till": "07-Mar-2019 12:00 AM"
     *          },
     *          "resort": {
     *              "id": 2,
     *              "name": "Dintex",
     *              "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
     *              "amenities": "1#2#3#4#5#6#7#8#10",
     *              "other_amenities": "Other Amenity",
     *              "contact_number": "8588936238",
     *              "other_contact_number": null,
     *              "address_1": "U-701",
     *              "address_2": null,
     *              "address_3": null,
     *              "pincode": 201301,
     *              "city_id": 181,
     *              "latitude": 28.5355,
     *              "longitude": 77.391,
     *              "is_active": 1,
     *              "domain_id": 0,
     *              "created_by": "1",
     *             "updated_by": "1",
     *              "created_at": "2018-12-20 21:19:14",
     *              "updated_at": "2019-02-21 08:12:15",
     *              "deleted_at": null
     *         }
     *      }
     *  }
     *  
     * @apiError MobileNumberMissing The mobile number is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Mobile number missing.",
     *     "data": {}
     *  }
     *
     * @apiError MobileNumber10Digit The Mobile number should be 10 digit.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Mobile number should be 10 digit.",
     *     "data": {}
     *  }
     *  
     * @apiError OTPMissing The OTP is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "OTP missing.",
     *     "data": {}
     *  }
     * 
     * @apiError UserTypeMissing The User Type is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "User type missing.",
     *     "data": {}
     *  }
     * 
     * @apiError InvalidUserType The user type invalid 
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "User type invalid.",
     *     "data": {}
     *  }
     * 
     * @apiError IncorrectOTP The OTP or mobile number incorrect.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "OTP or mobile number incorrect.",
     *     "data": {}
     *  }
     * 
     */
    public function login(Request $request) {
        try {
            if (!$request->mobile_number) {
                return $this->sendErrorResponse("Mobile number missing.", (object) []);
            }
            if (strlen($request->mobile_number) != 10) {
                return $this->sendErrorResponse("Mobile number should be 10 digit.", (object) []);
            }
            if (!$request->otp) {
                return $this->sendErrorResponse("OTP missing.", (object) []);
            }
            if (!$request->user_type) {
                return $this->sendErrorResponse("User type missing.", (object) []);
            }
            if (!(in_array($request->user_type, [2, 3]))) {
                return $this->sendErrorResponse("User type invalid.", (object) []);
            }

            $credentials = [
                'user_type_id' => $request->user_type,
                'mobile_number' => $request->mobile_number,
                'password' => $request->otp
            ];
            if (!Auth::attempt($credentials)) {
                return $this->sendErrorResponse("OTP or mobile number incorrect.", (object) []);
            }

            if ($request->user()->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }
            $user = $request->user();

            $this->cleanDeviceToken($request->device_id, $request->user_type);
            $this->invalidateAllUsertokens($user->id);
            $tokenResult = $user->createToken('SanjeevaniToken');
            $token = $tokenResult->token;
//        $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            if ($user->user_type_id == 2) {
                $userBookingDetail = UserBookingDetail::where("user_id", $user->id)
                        ->first();
            } else {
                $userBookingDetail = UserBookingDetail::where("user_id", $user->id)
                        ->where("check_out", ">=", date("Y-m-d H:i:s"))
                        ->where("is_cancelled", "!=", 1)
                        ->orderBy("check_out", "ASC")
                        ->first();
            }
            $adultNo = 0;
            $childNo = 0;
            if ($userBookingDetail) {
                if ($userBookingDetail->bookingpeople_accompany) {
                    foreach ($userBookingDetail->bookingpeople_accompany as $guest) {
                        if ($guest->person_type == "Adult") {
                            $adultNo += 1;
                        } elseif ($guest->person_type == "Child") {
                            $childNo += 1;
                        }
                    }
                }
                $userResort = Resort::find($userBookingDetail->resort_id);
            }
            $userMembership = UserMembership::where("user_id", $user->id)->first();
            $cityState = CityMaster::find($user->city_id);
            $cart = Cart::where(["user_id" => $user->id])->count();

            $userArray['id'] = $user->id;
            $userArray['notification_status'] = $user->is_push_on ? true : false;
            $userArray['is_booking'] = $user->is_booking ? $user->is_booking : 0;
            $user['access_token'] = $tokenResult->accessToken;
            $user['token_type'] = "Bearer";
            $userArray['cart_count'] = $cart;
            $userArray['user_name'] = $user->user_name != "" ? $user->user_name : "Welcome Guest";
            $userArray['first_name'] = $user->first_name;
            $userArray['mid_name'] = $user->mid_name;
            $userArray['last_name'] = $user->last_name;
            $userArray['email_id'] = $user->email_id;
            $userArray['user_type_id'] = $user->user_type_id;
            $userArray['is_checked_in'] = $user->user_type_id == 4 ? false : isset($userBookingDetail->is_checked_in) && ($userBookingDetail->is_checked_in == 1) ? true : false;
            $userArray['address'] = $user->address1;
            $userArray['state'] = isset($cityState->state->state) ? $cityState->state->state : "";
            $userArray['city'] = isset($cityState->city) ? $cityState->city : "";
            $userArray['pincode'] = $user->pincode;
            $userArray['screen_name'] = $user->screen_name;
            $userArray['profile_pic_path'] = $user->profile_pic_path;
            $userArray['mobile_number'] = $user->mobile_number;
            $userArray['mobile_number'] = $user->mobile_number;
            $userArray['token_type'] = $user->token_type;
            $userArray['access_token'] = $user->access_token;

            $userArray['source_name'] = $userBookingDetail ? $userBookingDetail->source_name : '';
            $userArray['source_id'] = $userBookingDetail ? $userBookingDetail->source_id : '';
            $userArray['resort_room_no'] = $userBookingDetail ? $userBookingDetail->resort_room_no : "Not available";
            $userArray['room_type'] = $userBookingDetail ? $userBookingDetail->room_type_name : "Not available";
            $userArray['check_in_pin'] = $userBookingDetail ? $userBookingDetail->check_in_pin : '';
            $userArray['check_out_pin'] = $userBookingDetail ? $userBookingDetail->check_out_pin : '';
            $userArray['check_in_date'] = $userBookingDetail ? Carbon::parse($userBookingDetail->check_in)->format('d-M-Y') : '';
            $userArray['check_in_time'] = $userBookingDetail ? Carbon::parse($userBookingDetail->check_in)->format('h:i A') : '';
            $userArray['check_out_date'] = $userBookingDetail ? Carbon::parse($userBookingDetail->check_out)->format('d-M-Y') : '';
            $userArray['check_out_time'] = $userBookingDetail ? Carbon::parse($userBookingDetail->check_out)->format('h:i A') : '';
            $userArray['booking_id'] = $userBookingDetail ? $userBookingDetail->source_id : '';
            $userArray['no_of_guest'] = $adultNo . " Adult and " . $childNo . " Child";
            $userArray['guest_detail'] = isset($userBookingDetail->bookingpeople_accompany) ? $userBookingDetail->bookingpeople_accompany : [];
            $userArray['membership']['membership_id'] = isset($userMembership->membership_id) ? $userMembership->membership_id : "";
            $userArray['membership']['valid_from'] = isset($userMembership->valid_from) ? Carbon::parse($userMembership->valid_from)->format('d-M-Y h:i A') : "";
            $userArray['membership']['valid_till'] = isset($userMembership->valid_till) ? Carbon::parse($userMembership->valid_till)->format('d-M-Y h:i A') : "";

            if (isset($userResort)) {
                $userArray['resort'] = $userResort;
            } else {
                $userArray['resort'] = (object) [];
            }

            return $this->sendSuccessResponse("OTP verified successfully.", $userArray);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), (object) []);
        }
    }

    /**
     * @api {post} /api/referesh-token  Referesh token
     * @apiHeader {String} Accept application/json.
     * @apiName PostRefereshToken
     * @apiGroup Auth
     *
     * @apiParam {String} user_id User id*.
     * @apiParam {String} secret_key Secret key(fgwjdksA5Cyh2UuOIzGb6z+USJtc)*.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String}   message Token refreshed successfully.
     * @apiSuccess {JSON}   data User unique token.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "status_code": 200,
     * "message": "Token refreshed successfully.",
     * "data": {
     * "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQyZjQwOGQyNzE4N2RlZDVlMDEyZWZjODZhZDQ5NTQyZjJhNzQ5MzQ4NzVlODg0OTQ1ZDE0MjM2YzQzNDQyOTQ5YmVjYTE5Y2FhNDg0YzRiIn0.eyJhdWQiOiIxIiwianRpIjoiZDJmNDA4ZDI3MTg3ZGVkNWUwMTJlZmM4NmFkNDk1NDJmMmE3NDkzNDg3NWU4ODQ5NDVkMTQyMzZjNDM0NDI5NDliZWNhMTljYWE0ODRjNGIiLCJpYXQiOjE1NDA4MzgzNDAsIm5iZiI6MTU0MDgzODM0MCwiZXhwIjoxNTcyMzc0MzQwLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.yV9o9kgadV-Spbl9MyFUEbiXNnrPRDQeanAAc1jJPZIGEaPlGh5VzlkTqY0NYXsvGUjaXRhXddUkAp4vY5EwDVzEAo-_cN0hW7sdQ43MNQJujCuwF2UZRTiNtOR0UV28Bu1ijZh7EBD1jn8OJ4qH4W7yXXCM3xMu7YlMYETJe5iELMMo7lwXmKpsOAXkQGcodPVgFZ0khBTmMO6ZP5SYSTJX5uv0kb586LzLpYbzWzse9BzQ3lk1JsZh6V9FFJ2SmHqoVadUGzcQQxxQBWI9J-iyncMZI4_J7Kp8WdsR4D0N5HfyBD6rMCnrW1Vunl7tE8SnXx7VLtPMv9CmqscTxrd3J2Eng-h0w3dOBUYdg4MqVGZFwuni7t0nGA_zhLCdXGEuurM-67UbWRPG5EwrJdzu9VcUYbmDqOCPDZkygjqBzhNpeuXmReOod2FxbiAvnhB0iRwDxOT1DnpPMuZpzUjKK6XL3vw82O-49OWoANbS4G4r1VI27vZwPZcYZUV8MZvPY3IGmqEPTHTfY0ccwjtfdOtLlzVtX4d8czOW5uynfpWmUdglY1RH9B7kda4KOsTXf4_kuLLyQU6cZs_F7SRIJ0gQCkP_87YrAK0cS_5jNZyUq7x7YriHYeMsyCtZ8vuh_vld8iPsd75w8eN2p4txRGVKd1Th54qLrKxMlBw"
     * }
     * }
     *  
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     * "status": false,
     * "status_code": 404,
     * "message": "User id missing.",
     * "data": {}
     * }
     *
     * @apiError SecretKeyMissing The Mobile number should be 10 digit.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     * "status": false,
     * "status_code": 404,
     * "message": "Secret key missing.",
     * "data": {}
     * }
     *  
     * @apiError InvalidSecretKey The Secret key is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     * "status": false,
     * "status_code": 404,
     * "message": "Invalid Seceret key.",
     * "data": {}
     * }
     * 
     * 
     */
    public function refereshToken(Request $request) {
        $seceret_key = "fgwjdksA5Cyh2UuOIzGb6z+USJtc";
        if (!$request->user_id) {
            return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => "User id missing.",
                        'data' => (object) []
            ]);
        }
        if (!$request->secret_key) {
            return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => "Secret key missing.",
                        'data' => (object) []
            ]);
        }
        if ($request->secret_key != $seceret_key) {
            return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => "Invalid Seceret key.",
                        'data' => (object) []
            ]);
        }

        try {
            $user = User::find($request->user_id);

            if ($user) {
                $credentials = [
                    'user_type_id' => $user->user_type_id,
                    'mobile_number' => $user->mobile_number,
                    'password' => $user->otp
                ];
                if (!Auth::attempt($credentials)) {
                    return response()->json([
                                'status' => false,
                                'status_code' => 404,
                                'message' => "OTP or mobile number incorrect.",
                                'data' => (object) []
                    ]);
                }

                $user = $request->user();
                $tokenResult = $user->createToken('SanjeevaniToken');
                $token = $tokenResult->token;
                $token->save();

                return response()->json([
                            'status' => true,
                            'status_code' => 200,
                            'message' => "Token refreshed successfully.",
                            'data' => [
                                "token" => $tokenResult->accessToken
                            ]
                ]);
            } else {
                return response()->json([
                            'status' => false,
                            'status_code' => 404,
                            'message' => "Invalid user",
                            'data' => (object) []
                ]);
            }
        } catch (Exception $ex) {
            return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => $ex->getMessage(),
                        'data' => (object) []
            ]);
        }
    }

    /**
     * @api {get} /api/logout  Logout
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName GetLogout
     * @apiGroup Auth
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String}   message logout successfully.
     * @apiSuccess {JSON}   data {}.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "logout successfully",
     *       "data": {}
     *   }
     *  
     * 
     */
    public function logout(Request $request) {
        $user = User::find($request->user()->id);
        if ($user) {
            if ($user->user_type_id == 2) {
                $user->device_token = NULL;
                $user->device_type = NULL;
                $user->device_id = NULL;
                $user->save();
            }
        }
        $request->user()->token()->revoke();
        return $this->sendSuccessResponse("logout successfully", (object) []);
    }

}
