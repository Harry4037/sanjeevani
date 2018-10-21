<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;

class AuthController extends Controller {

    /**
     * @api {post} /api/send-otp  Send OTP
     * @apiName PostSendOtp
     * @apiGroup Auth
     * 
     * @apiParam {String} mobile_number User unique mobile number.
     * @apiParam {String} user_type User type (Customer => 3 or Staff member => 2).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String}   message for the User.
     * @apiSuccess {JSON}   data blank array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *  "status": true,
     *  "message": "OTP send successfully.",
     *  "data": []
     * }
     * 
     * @apiError MobileNumberMissing The mobile number of the User was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Mobile number missing.",
     *  "data": []
     * }
     * 
     * @apiError MobileNumberRegistered The mobile number of the User was already registered.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Your mobile number is already registered.",
     *  "data": []
     * }
     * 
     */
    public function signup(Request $request) {
        if (!$request->mobile_number) {
            return response()->json([
                        'status' => false,
                        'message' => "Mobile number missing",
                        'data' => []
            ]);
        }

        if (!$request->user_type) {
            return response()->json([
                        'status' => false,
                        'message' => "User type missing.",
                        'data' => []
            ]);
        }
        
        $userExist = User::where("mobile_number", $request->mobile_number)
        ->where("user_type_id", $request->user_type)
        ->first();
        if (!$userExist) {
            $user = new User([
                'mobile_number' => $request->mobile_number,
                'otp' => 9999,
                'password' => bcrypt(9999)
            ]);
            $user->save();
            return response()->json([
                        'status' => true,
                        'message' => "OTP send successfully.",
                        'data' => []
            ]);
        } else {
            $response['success'] = false;
            $response['message'] = "Your mobile number is already registered.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
    }

    /**
     * @api {post} /api/verify-otp  Verify OTP
     * @apiName PostVerifyOtp
     * @apiGroup Auth
     *
     * @apiParam {String} mobile_number Users mobile number.
     * @apiParam {String} otp OTP.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String}   message OTP verified successfully.
     * @apiSuccess {JSON}   data User detail with unique token.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
      "status": true,
      "message": "OTP verified successfully.",
      "data": {
      "id": 3,
      "salutation_id": 0,
      "user_name": null,
      "password": "$2y$10$9Q4IrH1lk21oNaeZ5R7UtOxQv7mn9Rodg6HNyrgn5lS.XSeFNQdUq",
      "first_name": null,
      "mid_name": null,
      "last_name": null,
      "gender": null,
      "email_id": null,
      "alternate_email_id": null,
      "user_type_id": 0,
      "designation_id": 0,
      "department_id": 0,
      "city_id": 0,
      "language_id": 0,
      "screen_name": null,
      "date_of_joining": null,
      "authority_id": "0",
      "date_of_birth": null,
      "is_user_loked": 0,
      "profile_pic_path": null,
      "mobile_number": "8077575835",
      "other_contact_number": null,
      "address1": null,
      "address2": null,
      "address3": null,
      "pincode": null,
      "secuity_question": null,
      "secuity_questio_answer": null,
      "ref_time_zone_id": null,
      "login_expiry_date": null,
      "other_info": null,
      "user_id_RA": null,
      "is_active": 1,
      "domain_id": 0,
      "remember_token": null,
      "otp": "9999",
      "createdBy": "0",
      "updatedBy": "0",
      "created_at": "2018-10-12 07:02:45",
      "updated_at": "2018-10-12 07:02:45",
      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM5YjczODZiM2FlZjQxMmRmZWFiMzgwZjliZTE5YjgwNWZhZTJkYTA0OTk1ZDMxYjEzMDBmYzkzYmQ2NGFmNGU3MGNhODQ5OGZjMDI1MzQwIn0.eyJhdWQiOiIxIiwianRpIjoiMzliNzM4NmIzYWVmNDEyZGZlYWIzODBmOWJlMTliODA1ZmFlMmRhMDQ5OTVkMzFiMTMwMGZjOTNiZDY0YWY0ZTcwY2E4NDk4ZmMwMjUzNDAiLCJpYXQiOjE1MzkzMjg2OTcsIm5iZiI6MTUzOTMyODY5NywiZXhwIjoxNTcwODY0Njk3LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.TXVDzonROY7nW3YLIaPnAFywYjiNskNrpwcM5pprcL99lrKwtplNuiq0S4Ad2Pjt84YTI9hbDhm24hG_ROJx8IZqRsCWtY9YUk4719Hf-tW3P6FIs4eUxWQKGTPncB3h95VsREuIqFe1FuwWcoCVlpwreGttiJk-8ciuZTec8alpowZ-m4EObtaOt4uCI3vntZnc4J_fUyUTjlRAsiebvTpPPcDL-NvmRaJ_luu81Mm3iD0L1ieoPLG2oy79cNtgzsHwYoA9ebtzCPR-zoRRzbI5jL7M1JdtHdsaD1xp2RSXN27BG9X3Isy_dq0IGLGKb698UdqccYlSupDZ1pnSzsUBkOm847wEIPBOtonkNNGFH7OKONpUKWaIkYJ38AUkR4hRQK92x_5TrNaz1eSn6iuqQG-2J_c8d9wRh6QRST_bhNseMIotSGIKX6ZFqx7OaqqUrK_KPlYqULzXPeXEWEbGoSs6-knQ9cwdXFAXd1vm4f6VzVGZUwwP8z33olrSN-MQklNGs9rw_kPnXhxMMPX4Pn5Ii7UdmNgjiRZNzhu6DpsxHuk9oKrASox4O1BhpiHRBfToyqfA3XJW2b0MQdfE4CCmx61wnmittVeO6hAGFmxn0_xPYLfKrm2jny6WVUGh1A7lxUJNJSRVotA3bd20yJTabcn2SZ0XiI25Z6E",
      "token_type": "Bearer",
      "expires_at": "2018-10-19 07:18:18"
      }
      }
     *  
     * @apiError MobileNumberMissing The mobile number of the User was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Mobile number missing.",
     *  "data": []
     * }
     * 
     * @apiError OTPMissing The OTP was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "OTP missing.",
     *  "data": []
     * }
     * 
     * @apiError IncorrectOTP The OTP was incorrect.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Incorrect OTP.",
     *  "data": []
     * }
     * 
     */
    public function login(Request $request) {
        if (!$request->mobile_number) {
            return response()->json([
                        'status' => false,
                        'message' => "Mobile number missing.",
                        'data' => []
            ]);
        }
        if (!$request->otp) {
            return response()->json([
                        'status' => false,
                        'message' => "OTP missing.",
                        'data' => []
            ]);
        }

        $credentials = [
            'mobile_number' => $request->mobile_number,
            'password' => $request->otp
        ];
        if (!Auth::attempt($credentials))
            return response()->json([
                        'status' => false,
                        'message' => "Incorrect OTP.",
                        'data' => []
            ]);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $user['access_token'] = $tokenResult->accessToken;
        $user['token_type'] = "Bearer";
        $user['expires_at'] = Carbon::parse(
                        $tokenResult->token->expires_at
                )->toDateTimeString();
        return response()->json([
                    'status' => true,
                    'message' => "OTP verified successfully.",
                    'data' => $user,
        ]);
    }

    /**
     * @api {get} /api/logout Logout User
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName GetLogoutUser
     * @apiGroup Auth
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String}  message Success message
     * @apiSuccess {JSON}  data blank array.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *
     * {
     *   "status": true,
     *   "message": "User successfully logged out.",
     *   "data": []
     * }
     * 
     */
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
                    'success' => True,
                    'message' => 'User successfully logged out.',
                    'data' => []
        ]);
    }

}
