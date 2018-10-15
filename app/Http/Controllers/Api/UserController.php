<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {

    /**
     * @apiDescription This api can be use to send OTP
     * parameter as their arguments.Please check the curl example for better explanation
     * @api {post} /api/send-otp  Send OTP
     * @apiName send otp
     * @apiGroup User
     *
     * @apiParam {mobile_number} string Users mobile number.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String}   message for the User.
     * @apiSuccess {JSON}   data blank array.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
      "status": true,
      "message": "OTP send successfully.",
      "data": []
      }
     *  @apiVersion 1.0.0
     */
    public function checkIn(Request $request) {

        if (!$request->full_name) {
            $response['success'] = false;
            $response['message'] = "Full name missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->booking_id) {
            $response['success'] = false;
            $response['message'] = "Booking Id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->email_id) {
            $response['success'] = false;
            $response['message'] = "Booking Id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->check_in_date) {
            $response['success'] = false;
            $response['message'] = "Check In date missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->check_out_date) {
            $response['success'] = false;
            $response['message'] = "Check out date missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->aadhar_id) {
            $response['success'] = false;
            $response['message'] = "Aadhar id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->voter_id) {
            $response['success'] = false;
            $response['message'] = "Voter id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }

        
        $aadhar_id = $request->file("aadhar_id");       
        $aadhar = Storage::disk('local')->put('Aadhar', $aadhar_id);
        $aadhar_file_name = basename($aadhar);
        
        $voter_id = $request->file("voter_id");       
        $voter = Storage::disk('local')->put('Voter', $voter_id);
        $voter_file_name = basename($voter);
        
        
        $userExist = User::where("mobile_number", $request->mobile_number)->first();
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

}
