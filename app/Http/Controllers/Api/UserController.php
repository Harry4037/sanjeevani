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
use App\Models\StateMaster;
use App\Models\CityMaster;
use App\Models\UserMembership;
use App\Models\UserBookingDetail;
use App\Models\Resort;
use App\Models\Cart;

class UserController extends Controller {

    /**
     * @api {post} /api/check-in  Check In user
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostCheckIn
     * @apiGroup User
     *
     * @apiParam {String} user_id User id*.
     * @apiParam {File} aadhar_id User aadhar id document*.
     * @apiParam {File} other_id User other document.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String}   message User check-in successfully.
     * @apiSuccess {JSON}   data blank array.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *     "id": 2,
     *     "salutation_id": 0,
     *     "user_name": null,
     *     "first_name": null,
     *     "mid_name": null,
     *     "last_name": null,
     *     "gender": null,
     *     "user_type_id": 4,
     *     "designation_id": 0,
     *     "department_id": 0,
     *     "city_id": 0,
     *     "language_id": 0,
     *     "email_id": null,
     *     "alternate_email_id": null,
     *     "screen_name": null,
     *     "date_of_joining": null,
     *     "authority_id": "0",
     *     "user_id_RA": null,
     *     "date_of_birth": null,
     *     "profile_pic_path": "http://127.0.0.1:8000/storage/profile_pic",
     *     "id_card": null,
     *     "is_user_loked": 0,
     *     "mobile_number": "9999999999",
     *     "other_contact_number": null,
     *     "address1": null,
     *     "address2": null,
     *     "address3": null,
     *     "pincode": null,
     *     "secuity_question": null,
     *     "secuity_questio_answer": null,
     *     "ref_time_zone_id": null,
     *     "login_expiry_date": null,
     *     "other_info": null,
     *     "password": "$2y$10$GqnkutHraNcdrbOw5gFEoe7nR.nJiP9ShiKm2jbtdpELGLLwbbtvK",
     *     "remember_token": null,
     *     "aadhar_id": "7SKegf9AESUmVrLhzoWsiEG9xL5RFbwkQyAFPx0J.jpeg",
     *     "voter_id": null,
     *     "is_active": 1,
     *     "domain_id": 0,
     *     "otp": "9999",
     *     "oath_token": null,
     *     "created_by": "0",
     *     "updated_by": "0",
     *     "created_at": "2018-12-04 09:05:25",
     *     "updated_at": "2018-12-04 09:07:07",
     *     "is_checked_in": true,
     *     "user_booking_detail": null
     * }
     *  
     * @apiError UserIdMissing The user id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User Id missing.",
     *  "data": []
     * }
     * 
     * 
     * @apiError AadharIdMissing The aadhar document missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Aadhar id missing.",
     *  "data": []
     * }
     * 
     * @apiError AadharIdNotValidFile The aadhar document not valid file type.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "aadhar id not valid file type.",
     *  "data": []
     * }
     * 
     * @apiError OtherIdNotValidFile The other document not valid file type.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "other id not valid file type.",
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
        try {

            if (!$request->user_id) {
                return $this->sendErrorResponse("User Id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->aadhar_id) {
                return $this->sendErrorResponse("Aadhar id document missing.", (object) []);
            }
            if (!$request->other_aadhar_id) {
                return $this->sendErrorResponse("Aadhar id other side document missing.", (object) []);
            }
            if (!$request->hasFile('aadhar_id')) {
                return $this->sendErrorResponse("aadhar id not valid file type.", (object) []);
            }
            if (!$request->hasFile('other_aadhar_id')) {
                return $this->sendErrorResponse("other side aadhar id not valid file type.", (object) []);
            }


            $user = User::find($request->user_id);
            if (!$user) {
                return $this->sendErrorResponse("Invalid user.", (object) []);
            } else {
                if ($request->other_id) {
                    if (!$request->hasFile('other_id')) {
                        return $this->sendErrorResponse("other id not valid file type.", (object) []);
                    }
                    $other_id = $request->file("other_id");
                    $otherId = Storage::disk('public')->put('other_id', $other_id);
                    $other_file_name = basename($otherId);

                    $user->voter_id = $other_file_name;
                }

                $other_aadhar_id = $request->file("other_aadhar_id");
                $other_aadhar = Storage::disk('public')->put('other_aadhar_id', $other_aadhar_id);
                $other_aadhar_file_name = basename($other_aadhar);

                $user->other_aadhar_id = $other_aadhar_file_name;

                $aadhar_id = $request->file("aadhar_id");
                $aadhar = Storage::disk('public')->put('aadhar_id', $aadhar_id);
                $aadhar_file_name = basename($aadhar);

                $user->aadhar_id = $aadhar_file_name;
                if ($user->save()) {
                    $user['is_checked_in'] = true;
                    return $this->sendSuccessResponse("User check-in successfully.", $user);
                } else {
                    return $this->administratorResponse();
                }
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {post} /api/update-profile Update user profile
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostUpdateUserProfile
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} full_name Full name.
     * @apiParam {String} email_id Email Id.
     * @apiParam {String} address Address.
     * @apiParam {String} pincode Pincode.
     * @apiParam {String} city_id City id.
     * @apiParam {File} profile_pic Profile Pic.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Profile update succesfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Profile update succesfully.",
     *       "data": {
     *           "id": 2,
     *           "user_name": "Hariom Gangwar n",
     *           "first_name": "Hariom",
     *           "last_name": "Gangwar",
     *           "email_id": "hariom4037@gmail.com",
     *           "profile_pic_path": "http://127.0.0.1:8000/storage/profile_pic/Kq6zsnPUpHQRWax8bladuQxs9zSxDxr0IE7VkAMI.jpeg",
     *           "address1": "test",
     *           "pincode": "222222",
     *           "city_id": 63,
     *           "state": "West Bengal",
     *           "city": "Asansol"
     *       }
     *   }
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
     * @apiError NotValidFileType The profile pic not valid file type.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Profile pic not valid file type.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function updateProfile(Request $request) {
        if (!$request->user_id) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "User id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if ($request->user_id != $request->user()->id) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Unauthorized user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $user = User::find($request->user_id);
        if ($user) {
            $name = explode(" ", $request->full_name);

            if ($request->full_name) {
                $user->user_name = $request->full_name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
            }
            if ($request->email_id) {
                $user->email_id = $request->email_id;
            }
            if ($request->address) {
                $user->address1 = $request->address;
            }
            if ($request->city_id) {
                $user->city_id = $request->city_id;
            }
            if ($request->pincode) {
                $user->pincode = $request->pincode;
            }

            if ($request->profile_pic) {
                if (!$request->hasFile("profile_pic")) {
                    $response['success'] = false;
                    $response['status_code'] = 404;
                    $response['message'] = "Profile pic not valid file type.";
                    $response['data'] = (object) [];
                    return $this->jsonData($response);
                }
                $profile_pic = $request->file("profile_pic");
                $profile = Storage::disk('public')->put('profile_pic', $profile_pic);
                $profile_file_name = basename($profile);

                $user->profile_pic_path = $profile_file_name;
            }

            if ($request->is_remove_pic) {
                $user->profile_pic_path = "";
            }
            if ($user->save()) {
                $userData = User::select('id', 'user_name', 'first_name', 'last_name', 'email_id', 'profile_pic_path', 'address1', 'pincode', 'city_id')->find($user->id);
                $userMembership = UserMembership::where("user_id", $user->id)->first();
                $cityState = CityMaster::find($userData->city_id);
                $userData['state'] = isset($cityState->state->state) ? $cityState->state->state : "";
                $userData['city'] = isset($cityState->city) ? $cityState->city : "";
                $userData['membership_id'] = isset($userMembership->membership_id) ? $userMembership->membership_id : "";
                $userData['valid_from'] = isset($userMembership->valid_from) ? Carbon::parse($userMembership->valid_from)->format('d-M-Y h:i A') : "";
                $userData['valid_till'] = isset($userMembership->valid_till) ? Carbon::parse($userMembership->valid_till)->format('d-M-Y h:i A') : "";
                $response['success'] = true;
                $response['status_code'] = 200;
                $response['message'] = "Profile update succesfully.";
                $response['data'] = $userData;
                return $this->jsonData($response);
            } else {
                $response['success'] = false;
                $response['status_code'] = 404;
                $response['message'] = "Something went be wrong.";
                $response['data'] = (object) [];
                return $this->jsonData($response);
            }
        } else {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Invalid user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
    }

    /**
     * @api {post} /api/change-password Change User Password
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostChangePassword
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} old_password old Password.
     * @apiParam {String} new_password New Password.
     * @apiParam {String} confirm_password Confirm Password.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
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
     * @apiError InvalidUser The user is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid user.",
     *  "data": {}
     * }
     * 
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
            $response['status_code'] = 404;
            $response['message'] = "User id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if ($request->user_id != $request->user()->id) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Unauthorized user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if (!$request->new_password) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "New Password missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if (!$request->confirm_password) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Confirm Password missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
        if ($request->new_password != $request->confirm_password) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Confirm Password doesn't match.";
            $response['data'] = [];
            return $this->jsonData($response);
        }

        $user = User::find($request->user_id);
        if (!$user) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Invalid user.";
            $response['data'] = [];
            return $this->jsonData($response);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();
        $response['success'] = true;
        $response['status_code'] = 200;
        $response['message'] = "Password Changed successfully.";
        $response['data'] = [];
        return $this->jsonData($response);
    }

    /**
     * @api {get} /api/state-city-list State City list
     * @apiHeader {String} Accept application/json. 
     * @apiName GetStateCity
     * @apiGroup User
     * 
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message state and city listing.
     * @apiSuccess {JSON}   data state city array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "state and city listing",
     *       "data": [
     *           {
     *               "id": 1,
     *               "state_name": "Andaman & Nicobar Islands",
     *               "cities": [
     *                   {
     *                       "id": 93,
     *                       "city_name": "Carnicobar",
     *                       "state": null
     *                   },
     *                   {
     *                       "id": 149,
     *                       "city_name": "Diglipur",
     *                       "state": null
     * *                   },
     *                   {
     *                       "id": 174,
     *                       "city_name": "Ferrargunj",
     *                       "state": null
     *                   },
     *                   {
     *                       "id": 220,
     *                       "city_name": "Hut Bay",
     *                       "state": null
     *                   },
     *                   {
     *                       "id": 331,
     *                       "city_name": "Mayabander",
     *                       "state": null
     *                   },
     * .........
     * 
     * 
     */
    public function stateCityList(Request $request) {
        $states = StateMaster::all();
        $dataArray = [];
        if ($states) {
            foreach ($states as $key => $state) {
                $cities = CityMaster::select('id', 'city as city_name')->where("state_id", $state->id)->get();

                $dataArray[$key]['id'] = $state->id;
                $dataArray[$key]['state_name'] = $state->state;
                $dataArray[$key]['cities'] = $cities;
            }
        }

        return $this->sendSuccessResponse("state and city listing", $dataArray);
    }

    /**
     * @api {post} /api/update-device-token Update Device Token
     * @apiHeader {String} Accept application/json. 
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostUpdateDeviceToken
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} device_token Device Token*.
     * @apiParam {String} device_type Device Type*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Device token updated successfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Device token updated successfully.",
     *    "data": {}
     * }
     * 
     * 
     */
    public function updateDeviceToken(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if (!$request->device_token) {
                return $this->sendErrorResponse("Device token missing.", (object) []);
            }
            if (!$request->device_type) {
                return $this->sendErrorResponse("Device type missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }

            $user = User::find($request->user_id);
            if ($user) {
                $user->device_token = $request->device_token;
                $user->device_type = $request->device_type;
                $user->device_id = $request->device_id;

                if ($user->save()) {
                    return $this->sendSuccessResponse("Device token updated successfully.", (object) []);
                } else {
                    return $this->sendErrorResponse("User not found.", (object) []);
                }
            } else {
                return $this->sendErrorResponse("User object not found", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    public function getCheckInDetail(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User Id missing.", (object) []);
            }
            $user = User::find($request->user_id);
            if (!$user) {
                return $this->sendErrorResponse("Invalid User.", (object) []);
            }
            $userBookingDetail = UserBookingDetail::where("user_id", $user->id)
                    ->where("check_out", ">=", date("Y-m-d H:i:s"))
                    ->where("is_cancelled", "!=", 1)
                    ->orderBy("id", "ASC")
                    ->first();
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
            $userArray['cart_count'] = $cart;
            $userArray['user_name'] = $user->user_name != "" ? $user->user_name : "Welcome guest";
            $userArray['first_name'] = $user->first_name;
            $userArray['mid_name'] = $user->mid_name;
            $userArray['last_name'] = $user->last_name;
            $userArray['email_id'] = $user->email_id;
            $userArray['user_type_id'] = $user->user_type_id;
            $userArray['is_checked_in'] = $user->aadhar_id == null ? false : true;
            $userArray['address'] = $user->address1;
            $userArray['state'] = isset($cityState->state->state) ? $cityState->state->state : "";
            $userArray['city'] = isset($cityState->city) ? $cityState->city : "";
            $userArray['pincode'] = $user->pincode;
            $userArray['screen_name'] = $user->screen_name;
            $userArray['profile_pic_path'] = $user->profile_pic_path;
            $userArray['mobile_number'] = $user->mobile_number;
            $userArray['mobile_number'] = $user->mobile_number;
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
            return $this->sendSuccessResponse("User.", ["checkin_detail" => $userArray]);
        } catch (Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}
