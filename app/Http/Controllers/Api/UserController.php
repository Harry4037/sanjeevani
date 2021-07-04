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
use App\Models\CountryMaster;

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
     * @apiParam {File} other_aadhar_id User Other side aadhar id document*.
     * @apiParam {File} other_id User other document.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String}   message User check-in successfully.
     * @apiSuccess {JSON}   data blank array.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "User check-in successfully.",
      "data": {
      "id": 149,
      "discount": 10,
      "salutation_id": 0,
      "user_name": "Om",
      "first_name": "Om",
      "mid_name": "",
      "last_name": "",
      "gender": null,
      "user_type_id": 3,
      "designation_id": 0,
      "department_id": 0,
      "city_id": 0,
      "language_id": 0,
      "email_id": "om@mail.com",
      "alternate_email_id": null,
      "screen_name": "",
      "date_of_joining": null,
      "authority_id": "0",
      "user_id_RA": null,
      "date_of_birth": null,
      "profile_pic_path": "http://127.0.0.1:1234/img/no-image.jpg",
      "id_card": null,
      "is_user_loked": 0,
      "mobile_number": "8077575835",
      "other_contact_number": null,
      "address1": "",
      "address2": null,
      "address3": null,
      "pincode": "",
      "secuity_question": null,
      "secuity_questio_answer": null,
      "ref_time_zone_id": null,
      "login_expiry_date": null,
      "other_info": null,
      "password": "$2y$10$EeEc0jxjDXyE/rH0Ri20lObAg2JjpMBHeOFsYQLo.zmgzG4oF1K/.",
      "remember_token": null,
      "aadhar_id": "http://127.0.0.1:1234/storage/aadhar_id/lH9ghKYDYDDrBYstCe7IlJyJbCwVttZuWa0DC7jc.png",
      "other_aadhar_id": "http://127.0.0.1:1234/storage/other_aadhar_id/oHBhMKEU8XBLpliH5ja4nRW465iolmRcRRnJg1W6.png",
      "voter_id": "http://127.0.0.1:1234/img/no-image.jpg",
      "authorise_amenities_id": null,
      "is_service_authorise": 0,
      "is_meal_authorise": 0,
      "device_token": "153dsf45dsf4d5s31f32ds1f32ds1f32ds1f32s",
      "device_type": "Android",
      "device_id": null,
      "is_active": 1,
      "domain_id": 0,
      "otp": "2062",
      "oath_token": null,
      "created_by": "1",
      "updated_by": "1",
      "created_at": "2019-03-04 10:18:06",
      "updated_at": "2019-03-04 12:03:48",
      "is_checked_in": true
      }
      }
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
                    $userBookingDetail = UserBookingDetail::where("user_id", $user->id)
                            ->where("check_out", ">=", date("Y-m-d H:i:s"))
                            ->where("is_cancelled", "!=", 1)
                            ->orderBy("check_out", "ASC")
                            ->first();
                    if ($userBookingDetail) {
                        $userBookingDetail->is_checked_in = 1;
                        $userBookingDetail->save();
                        Cart::where("user_id", $userBookingDetail->user_id)->where("resort_id", "!=", $userBookingDetail->resort_id)->delete();
                    } else {
                        Cart::where(["user_id" => $userBookingDetail->user_id])->delete();
                    }
                    $user['is_checked_in'] = true;
                    $user['cart_count'] = Cart::where("user_id", $user->id)->count();
                    Cart::where('user_id', $user->id)->delete();
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
      {
      "status": true,
      "status_code": 200,
      "message": "Profile update succesfully.",
      "data": {
      "id": 149,
      "user_name": "Om",
      "first_name": "Om",
      "last_name": "",
      "email_id": "om@mail.com",
      "profile_pic_path": "http://127.0.0.1:1234/img/no-image.jpg",
      "address1": "",
      "pincode": "",
      "city_id": 0,
      "state": "",
      "city": "",
      "membership_id": "ABCDE",
      "valid_from": "04-Mar-2019 12:00 AM",
      "valid_till": "07-Mar-2019 12:00 AM"
      }
      }
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
                if (isset($cityState->state->countryId)) {
                    $country = CountryMaster::find($cityState->state->countryId);
                    $userData['country'] = $country->conutry;
                } else {
                    $userData['country'] = "";
                }

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
     * @apiParam {String} new_password New Password*.
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
     * @api {post} /api/state-city-list State City list
     * @apiHeader {String} Accept application/json. 
     * @apiName PostStateCity
     * @apiGroup User
     * 
     * @apiParam {String} country_id Country id*.
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

        $states = StateMaster::where("countryId", $request->country_id)->get();
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
     * @apiParam {String} device_type Device Type* (Android or Iphone).
     * @apiParam {String} device_id Unique Device ID*.
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

    /**
     * @api {get} /api/get-checkin-detail Get Check-In detail
     * @apiHeader {String} Accept application/json. 
     * @apiName GetCheckInDetail
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message User check In detail.
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "User.",
      "data": {
      "checkin_detail": {
      "id": 149,
      "cart_count": 0,
      "user_name": "Om",
      "first_name": "Om",
      "mid_name": "",
      "last_name": "",
      "email_id": "om@mail.com",
      "user_type_id": 3,
      "is_checked_in": false,
      "address": "",
      "state": "",
      "city": "",
      "pincode": "",
      "screen_name": "",
      "profile_pic_path": "http://127.0.0.1:1234/img/no-image.jpg",
      "mobile_number": "8077575835",
      "source_name": "GOIBO",
      "source_id": "GOIBO123456",
      "resort_room_no": "T-2",
      "room_type": "Tent",
      "check_in_pin": 7015,
      "check_out_pin": 3336,
      "check_in_date": "04-Mar-2019",
      "check_in_time": "12:00 AM",
      "check_out_date": "30-Mar-2019",
      "check_out_time": "10:00 AM",
      "booking_id": "GOIBO123456",
      "no_of_guest": "1 Adult and 1 Child",
      "guest_detail": [
      {
      "id": 23,
      "person_name": "Ankit",
      "person_age": "10",
      "person_type": "Child"
      },
      {
      "id": 24,
      "person_name": "Anshu",
      "person_age": "25",
      "person_type": "Adult"
      }
      ],
      "membership": {
      "membership_id": "ABCDE",
      "valid_from": "04-Mar-2019 12:00 AM",
      "valid_till": "07-Mar-2019 12:00 AM"
      },
      "resort": {
      "id": 2,
      "name": "Dintex",
      "description": "<p>Rindex Media Pvt. limited, brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness.As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>",
      "amenities": "1#2#3#4#5#6#7#8#10",
      "other_amenities": "Other Amenity",
      "contact_number": "8588936238",
      "other_contact_number": null,
      "address_1": "U-701",
      "address_2": null,
      "address_3": null,
      "pincode": 201301,
      "city_id": 181,
      "latitude": 28.5355,
      "longitude": 77.391,
      "is_active": 1,
      "domain_id": 0,
      "created_by": "1",
      "updated_by": "1",
      "created_at": "2018-12-20 21:19:14",
      "updated_at": "2019-02-21 08:12:15",
      "deleted_at": null
      }
      }
      }
      }
     * 
     * 
     */
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
                    ->orderBy("check_out", "ASC")
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
            $userArray['is_checked_in'] = $user->user_type_id == 4 ? false : isset($userBookingDetail->is_checked_in) && ($userBookingDetail->is_checked_in == 1) ? true : false;
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
            return $this->sendSuccessResponse("User check In detail", ["checkin_detail" => $userArray]);
        } catch (Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {get} /api/user-counts User counts
     * @apiHeader {String} Accept application/json. 
     * @apiName GetUserCounts
     * @apiGroup User
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Conts.
     * @apiSuccess {JSON}   data Array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "counts",
     *       "data": {
     *           "notification_count": 0
     *       }
     *   }
     * 
     * 
     */
    public function userCounts(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User Id missing.", (object) []);
            }
            $notificationCount = $this->notificationCount($request->user_id);

            return $this->sendSuccessResponse("counts", [
                        'notification_count' => $notificationCount
            ]);
        } catch (Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}
