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
use App\Models\RoomBooking;
use App\Models\CityMaster;
use App\Models\Cart;

class AuthController extends Controller {

    /**
     * @api {post} /api/send-otp  Send OTP
     * @apiHeader {String} Accept application/json. 
     * @apiName PostSendOtp
     * @apiGroup Auth
     * 
     * @apiParam {String} mobile_number User unique mobile number*.
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
            if (!$userExist) {
                $user = new User([
                    'mobile_number' => $request->mobile_number,
                    'user_type_id' => $request->user_type,
                    'otp' => 9999,
                    'password' => bcrypt(9999)
                ]);
                if ($user->save()) {
                    return $this->sendSuccessResponse("OTP sent successfully.", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } else {
                $userExist->otp = 9999;
                $userExist->password = bcrypt(9999);
                $userExist->save();
                if ($userExist->save()) {
                    return $this->sendSuccessResponse("OTP sent successfully.", (object) []);
                } else {
                    return $this->administratorResponse();
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
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String}   message OTP verified successfully.
     * @apiSuccess {JSON}   data User detail with unique token.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "OTP verified successfully.",
     *    "data": {
     *        "id": 2,
     *        "user_name": "Hariom",
     *        "first_name": "Hariom",
     *        "mid_name": null,
     *        "last_name": "",
     *        "email_id": "hariom4037@gmail.com",
     *        "user_type_id": 3,
     *        "is_checked_in": false,
     *        "address": null,
     *        "state": "UP",
     *        "city": "Noida",
     *        "pincode": "201301",
     *        "screen_name": null,
     *        "profile_pic_path": null,
     *        "mobile_number": "9808243372",
     *        "token_type": "Bearer",
     *        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg2ZjM5ZTA0ZjQxN2
     *          QwNDNhZmRkYWY4NDJlNTNlNTQ3NjMxYzJkMTdkMThmZDVlM2VhMTk1OTc3MGZmZjQzMWE2NjI1ZjI
     * 0YzE5NDk1ZjllIn0.eyJhdWQiOiIxIiwianRpIjoiODZmMzllMDRmNDE3ZDA0M2FmZGRhZjg0MmU1M2U1NDc2M
     * zFjMmQxN2QxOGZkNWUzZWExOTU5NzcwZmZmNDMxYTY2MjVmMjRjMTk0OTVmOWUiLCJpYXQiOjE1NDIyNTU5MDY
     * sIm5iZiI6MTU0MjI1NTkwNiwiZXhwIjoxNTczNzkxOTA2LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.qnRi5ZXrBR
     * Yk2DJdNi8GbsRkb9g3g26MoBinbHJdGYS0hEfYiItve5yAhRmvQhPiIW_GXIhKRKPAcGmy1tHsneiUEScDjD35EW
     * Zwd39bpQGDx_VQAGp5JlM2rlj5KOVv52BqFiyLiod8621eevI7SvduWm7VojLFXPRqsWbCilVcQQB5WPIFdTNfor
     * g3giro7Qa_nzmEZH_iUl0_955HWHx9L9XmuSg9pznePzcDqbyG4M7gB6guJUk0hIUP3cO3Aueu91LZtsA-jGXRkj
     * dT2S9ONpVRWewl1aksPzjYFxtdUSfH2PQveGWsCMCka85i1B5v1JlyqDb38gNeWbB3Gqy8-2rV9AYS5gYy1lAgCv
     * xrR9XoElyyguLU_BHQCMuU7_-034A1UbHZfg9_r3IR85_u25McRvSTHiZWPQXVDD2tHh5zLyhyDJjcD_Bh9jMxSE
     * 9E3b9HruJiJv8DVhTkvW6re95astIZe5X7oW8j7fDHvwWBUMdBfSnnBcyCp-6HVl6nByxevw3-OV_ugsCDuhsOKWw
     * jaUT4KkyJFxFjKjmbSQautj2FBum3Vy85fOMkgye_8rfYADsKXw81RQjixkflRfmifP4Ii68tES77apdXGqxJricNc
     * VSBPzBiUThcnPCd_X8f4-vuQwp3KM-Jn8-rC0RT1lUHhlnHPyEzAmQ",
     *        "source_name": "Make my trip",
     *        "source_id": "QWERT123456",
     *        "resort_room_no": 1,
     *        "room_type": "Delux",
     *        "check_in_date": "15-Nov-2018",
     *        "check_in_time": "00:00 AM",
     *        "check_out_date": "17-Nov-2018",
     *        "check_out_time": "00:00 AM",
     *        "booking_id": 1,
     *        "no_of_guest": "1 Adult and 2 Child",
     *        "guest_detail": [
     *            {
     *                "id": 1,
     *                "person_name": "Ankit",
     *                "person_age": "25",
     *                "person_type": "Adult"
     *            },
     *            {
     *                "id": 2,
     *                "person_name": "Anshu",
     *                "person_age": "5",
     *                "person_type": "Child"
     *            },
     *            {
     *                "id": 3,
     *                "person_name": "om",
     *                "person_age": "10",
     *                "person_type": "Child"
     *            }
     *        ],
     *        "resort": {
     *            "id": 1,
     *            "name": "Parth Inn",
     *            "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *            "contact_number": "9808243372",
     *            "other_contact_number": null,
     *            "address_1": "Sector 66",
     *            "address_2": null,
     *            "address_3": null,
     *            "pincode": 243601,
     *            "city_id": 50,
     *            "latitude": 0,
     *            "longitude": 0,
     *            "is_active": 1,
     *            "domain_id": 0,
     *            "created_by": "1",
     *            "updated_by": "1",
     *            "created_at": "2018-11-14 13:51:50",
     *            "updated_at": "2018-11-14 13:52:58"
     *        }
     *    }
     * }
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
                return $this->sendErrorResponse("Your account has been In-active.Please contact to admin.", (object) []);
            }
            $user = $request->user();
            $tokenResult = $user->createToken('SanjeevaniToken');
            $token = $tokenResult->token;
//        $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            $userBookingDetail = UserBookingDetail::where("user_id", $user->id)->first();
            $userRoom = [];
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
                $userRoom = RoomBooking::find($userBookingDetail->id);
            }
            $cityState = CityMaster::find($user->city_id);
            $cart = Cart::where(["user_id" => $user->id])->count();
//            dd($cityState->toArray());
            $userArray['id'] = $user->id;
            $user['access_token'] = $tokenResult->accessToken;
            $user['token_type'] = "Bearer";
            $userArray['cart_count'] = $cart;
            $userArray['user_name'] = $userBookingDetail ? $user->user_name : "Welcom guest";
            $userArray['first_name'] = $user->first_name;
            $userArray['mid_name'] = $user->mid_name;
            $userArray['last_name'] = $user->last_name;
            $userArray['email_id'] = $user->email_id;
            $userArray['user_type_id'] = $userBookingDetail ? 3 : 4;
            $userArray['is_checked_in'] = $user->aadhar_id ? true : false;
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
            $userArray['resort_room_no'] = $userRoom ? $userRoom->resort_room_id : '';
            $userArray['room_type'] = "Delux";
            $userArray['check_in_date'] = $userRoom ? Carbon::parse($userRoom->check_in)->format('d-M-Y') : '';
            $userArray['check_in_time'] = $userRoom ? Carbon::parse($userRoom->check_in)->format('H:i A') : '';
            $userArray['check_out_date'] = $userRoom ? Carbon::parse($userRoom->check_out)->format('d-M-Y') : '';
            $userArray['check_out_time'] = $userRoom ? Carbon::parse($userRoom->check_out)->format('H:i A') : '';
            $userArray['booking_id'] = $userBookingDetail ? $userBookingDetail->id : "";
            $userArray['no_of_guest'] = $adultNo . " Adult and " . $childNo . " Child";
            $userArray['guest_detail'] = isset($userBookingDetail->bookingpeople_accompany) ? $userBookingDetail->bookingpeople_accompany : [];
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

    public function logout() {
        return $this->sendSuccessResponse("logout successfully", (object) []);
    }

}
