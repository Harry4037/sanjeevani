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
     * "status": true,
     * "message": "OTP verified successfully.",
     * "data":{
     * "id": 2,
     * "user_name": null,
     * "first_name": null,
     * "mid_name": null,
     * "last_name": null,
     * "email_id": null,
     * "user_type_id": 3,
     * "address": null,
     * "screen_name": null,
     * "profile_pic_path": null,
     * "mobile_number": "8077575835",
     * "token_type": "Bearer",
     * "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU1OGZlMmI1NjcxN2Q3MDI2YmFhNmEzMjAxNmYxY2ZlODU5NDVjMGQ5YmI1MjFmZWViZTBjZmQ2MmI3MmE5NDU1YmM3NDU4NGI4ZWQxZDZmIn0.eyJhdWQiOiIxIiwianRpIjoiZTU4ZmUyYjU2NzE3ZDcwMjZiYWE2YTMyMDE2ZjFjZmU4NTk0NWMwZDliYjUyMWZlZWJlMGNmZDYyYjcyYTk0NTViYzc0NTg0YjhlZDFkNmYiLCJpYXQiOjE1NDA2NTk3NTQsIm5iZiI6MTU0MDY1OTc1NCwiZXhwIjoxNTcyMTk1NzU0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.NQCP1kv1nQzvK9ExA0KCug-kXSE23heVLUL-1BuxB8tY6w_cI7XJ4ETAMBiZvIcgepyd_MjU-ngVRkx6WQCIhn4JJ2Zmu6ULUDSPeFWN2BwLcxRl-DziLixcyYTEWzY8LLrCxK7qtjD39_fOZFmW81wFlIfyBfwCpmKJenmR-GxMB4Ltbs-mHbQQs9Xwazi_JgtVc4oPJmHXrBGpXD4nU8ULSkDXbyH6VNkaJbGjvjqQplmRXbns6U04110hkWDUoMn2FmRyuuBj10aMMVrcsqi4yUP2IDlKXTTfnH8x5Ae6zzX0LHZJFiWE3KNZFXsaamVQfCHHnUAnPKFW3SHUBzUKjWXfFB6G0WsiM_dcZsGduu9Qnd-PpiMcWq8Uhq31FMBl2qHNenX_1mwpM0p3sfnYotVQaoNUu9-2IM1zmRXCEoGA3SsDto7nfdChdBPh6Z-6VILo2AqzkhzuYpRuNyHcvv2bOAXH1RgXbeH1A4ru0_glMKTp2jwd9IStJdkCMdADk_sUo31oeEMtkApRzYZc1qzWENtNdYWtpniADOHlMpJe1lv7X3qsgnI3hD7uZNZlZ72-xj5M15SvDCBW3uLWXd0TioI0s3311wzX9Li8HdjAcjwRsJJy1xij4NJgdEE9UZ_6jGyHt6ghEhdBgL691xUrwI1fAaHe0aLZSKA",
     * "source_name": "Source Name",
     * "source_id": "Source Id",
     * "resort":{"id": 1, "name": "Parth Inn", "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",…}
     * }
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

            $user = $request->user();
            $tokenResult = $user->createToken('SanjeevaniToken');
            $token = $tokenResult->token;
//        $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            $userBookingDetail = UserBookingDetail::where("user_id", $user->id)->first();
            $userRoom = [];
            if ($userBookingDetail) {
                $userResort = Resort::find($userBookingDetail->resort_id);
                $userRoom = RoomBooking::find($userBookingDetail->id);
            }
            $userArray['id'] = $user->id;
            $user['access_token'] = $tokenResult->accessToken;
            $user['token_type'] = "Bearer";
            $userArray['user_name'] = $user->user_name;
            $userArray['first_name'] = $user->first_name;
            $userArray['mid_name'] = $user->mid_name;
            $userArray['last_name'] = $user->last_name;
            $userArray['email_id'] = $user->email_id;
            $userArray['user_type_id'] = $userBookingDetail ? 3 : 4;
            $userArray['address'] = $user->address;
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
            $userArray['check_in'] = $userRoom ? $userRoom->check_in : '';
            $userArray['check_out'] = $userRoom ? $userRoom->check_out : '';
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

}
