<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    /**
     * @api {post} /api/check-in  Check In user
     * @apiName PostCheckIn
     * @apiGroup User
     *
     * @apiParam {String} user_id User id*.
     * @apiParam {File} aadhar_id User aadhar id document*.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String}   message User check-in successfully.
     * @apiSuccess {JSON}   data blank array.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *  "status": true,
     *  "message": "User check-in successfully.",
     *  "data": []
     * }
     *  
     * @apiError UserIdMissing The user id of the User was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User Id missing.",
     *  "data": []
     * }
     * 
     * 
     * @apiError AadharIdMissing The aadhar document was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Aadhar id missing.",
     *  "data": []
     * }
     * 
     * 
     * @apiError InvalidUser This user was invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid user.",
     *  "data": []
     * }
     * 
     */
    public function checkIn(Request $request) {

        if (!$request->user_id) {
            $response['success'] = false;
            $response['message'] = "User Id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        // if (!$request->full_name) {
        //     $response['success'] = false;
        //     $response['message'] = "Full name missing.";
        //     $response['data'] = [];
        //     return $this->jsonData($response);
        // }
        // if (!$request->booking_id) {
        //     $response['success'] = false;
        //     $response['message'] = "Booking Id missing.";
        //     $response['data'] = [];
        //     return $this->jsonData($response);
        // }
        // if (!$request->email_id) {
        //     $response['success'] = false;
        //     $response['message'] = "Email Id missing.";
        //     $response['data'] = [];
        //     return $this->jsonData($response);
        // }
        // if (!$request->check_in_date) {
        //     $response['success'] = false;
        //     $response['message'] = "Check In date missing.";
        //     $response['data'] = [];
        //     return $this->jsonData($response);
        // }
        // if (!$request->check_out_date) {
        //     $response['success'] = false;
        //     $response['message'] = "Check out date missing.";
        //     $response['data'] = [];
        //     return $this->jsonData($response);
        // }
        if (!$request->aadhar_id) {
            $response['success'] = false;
            $response['message'] = "Aadhar id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        // if (!$request->voter_id) {
        //     $response['success'] = false;
        //     $response['message'] = "Voter id missing.";
        //     $response['data'] = [];
        //     return $this->jsonData($response);
        // }


        $aadhar_id = $request->file("aadhar_id");
        $aadhar = Storage::disk('local')->put('Aadhar', $aadhar_id);
        $aadhar_file_name = basename($aadhar);

        // $voter_id = $request->file("voter_id");
        // $voter = Storage::disk('local')->put('Voter', $voter_id);
        // $voter_file_name = basename($voter);


        $user = User::find($request->user_id);
        if (!$user) {
            $response['success'] = false;
            $response['message'] = "Invalid user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        } else {
//            $name = explode(" ", $request->full_name);
            // $user->user_name = $request->full_name;
            // $user->first_name = isset($name[0]) ? $name[0] : '';
            // $user->last_name = isset($name[1]) ? $name[1] : '';
            // $user->booking_id = $request->booking_id;
            // $user->email_id = $request->email_id;
            // $check_in_date = Carbon::parse($request->check_in_date);
            // $user->check_in_date = $check_in_date->format('Y-m-d');
            // $check_out_date = Carbon::parse($request->check_out_date);
            // $user->check_out_date = $check_out_date->format('Y-m-d');
            // $user->other_info = $request->members;
            $user->aadhar_id = $aadhar_file_name;
            // $user->voter_id = $voter_file_name;
            if ($user->save()) {
                $response['success'] = true;
                $response['message'] = "User check-in successfully.";
                $response['data'] = $user;
                return $this->jsonData($response);
            } else {
                $response['success'] = false;
                $response['message'] = "Something went be wrong.";
                $response['data'] = (object) [];
                return $this->jsonData($response);
            }
        }
    }

    /**
     * @api {post} /api/update-profile Update user profile
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostUpdateUserProfile
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id.
     * @apiParam {String} full_name Full name.
     * @apiParam {String} email_id Full name.
     * @apiParam {File} profile_pic Profile Pic.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} message Profile update succesfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Profile update succesfully.",
     * "data": {}
     * }
     * 
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User id missing.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function updateProfile(Request $request) {
        if (!$request->user_id) {
            $response['success'] = false;
            $response['message'] = "User id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $user = User::find($request->user_id);
        if ($user) {
            $name = explode(" ", $request->full_name);

            $user->user_name = $request->full_name;
            $user->first_name = isset($name[0]) ? $name[0] : '';
            $user->last_name = isset($name[1]) ? $name[1] : '';
            $user->email_id = $request->email_id;

            if ($request->profile_pic) {
                $profile_pic = $request->file("profile_pic");
                $profile = Storage::disk('public')->put('Profile_pic', $profile_pic);
                $profile_file_name = basename($profile);

                $user->profile_pic_path = $profile_file_name;
            }

            if ($user->save()) {
                $response['success'] = true;
                $response['message'] = "Profile update succesfully.";
                $response['data'] = (object) [];
                return $this->jsonData($response);
            } else {
                $response['success'] = false;
                $response['message'] = "Something went be wrong.";
                $response['data'] = (object) [];
                return $this->jsonData($response);
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Invalid user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
    }

    /**
     * @api {post} /api/change-password Change User Password
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostChangePassword
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id.
     * @apiParam {String} old_password old Password.
     * @apiParam {String} new_password New Password.
     * @apiParam {String} confirm_password Confirm Password.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} message Password Changed successfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Password Changed successfully.",
     * "data": {}
     * }
     * 
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User id missing.",
     *  "data": {}
     * }
     * 
     * @apiError OldPasswordMissing The old password was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Old Password missing.",
     *  "data": {}
     * }
     * 
     * @apiError NewPasswordMissing The new password was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "New Password missing.",
     *  "data": {}
     * }
     * 
     * @apiError ConfirmPasswordMissing The confirm password was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Confirm Password missing.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function changesPassword(Request $request) {
        if (!$request->user_id) {
            $response['success'] = false;
            $response['message'] = "User id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->old_password) {
            $response['success'] = false;
            $response['message'] = "Old Password missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->new_password) {
            $response['success'] = false;
            $response['message'] = "New Password missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->confirm_password) {
            $response['success'] = false;
            $response['message'] = "Confirm Password missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if ($request->new_password != $request->confirm_password) {
            $response['success'] = false;
            $response['message'] = "Confirm Password doesn't match.";
            $response['data'] = [];
            return $this->jsonData($response);
        }

        $user = User::find($request->user_id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            $response['success'] = true;
            $response['message'] = "Password Changed successfully.";
            $response['data'] = [];
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['message'] = "Incorrect old password.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
    }

    /**
     * @api {post} /api/change-password Change User Password
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostChangePassword
     * @apiGroup User
     * 
     * @apiParam {String} email_id User email id.
     * @apiParam {String} user_type User type(Staff=> 2, Customer => 3).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} message Password Changed successfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Link send successfully. please check your email.",
     * "data": {}
     * }
     * 
     *  
     * @apiError UserTypeMissing The user type was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User type missing.",
     *  "data": {}
     * }
     * 
     * @apiError EmailIdMissing The email id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Email id missing.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function forgetPassword() {
        if (!$request->email_id) {
            $response['success'] = false;
            $response['message'] = "Email id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->user_type) {
            $response['success'] = false;
            $response['message'] = "User type missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        $response['success'] = true;
        $response['message'] = "Link send successfully. please check your email.";
        $response['data'] = [];
    }

}
