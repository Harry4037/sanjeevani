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
     * @api {post} /api/check-in  Check In user
     * @apiName PostCheckIn
     * @apiGroup User
     *
     * @apiParam {String} user_id User id*.
     * @apiParam {String} full_name User full name*.
     * @apiParam {String} booking_id User booking id*.
     * @apiParam {String} email_id User email address*.
     * @apiParam {String} check_in_date User check in date*.
     * @apiParam {String} check_out_date User check in date*.
     * @apiParam {File} aadhar_id User aadhar id document*.
     * @apiParam {File} voter_id User voter id document*.
     * @apiParam {JSON} members User members detail {"total_member":2,"members":{"full_name": "Ankit",	"age": 20},{"full_name": "Hariom","age": 20},
      }".
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
     * @apiError FullNameMissing The full name was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Full name missing.",
     *  "data": []
     * }
     * 
     * @apiError BookingIdMissing The booking id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Booking Id missing.",
     *  "data": []
     * }
     * 
     * @apiError EmailIdMissing The email id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Email Id missing.",
     *  "data": []
     * }
     * 
     * @apiError CheckInMissing The check In date was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Check In date missing.",
     *  "data": []
     * }
     * 
     * @apiError CheckOutMissing The check Out date was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Check out date missing.",
     *  "data": []
     * }
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
     * @apiError VoterIdMissing The voter document was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Voter id missing.",
     *  "data": []
     * }
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
            $response['data'] = [];
            return $this->jsonData($response);
        }
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
            $response['message'] = "Email Id missing.";
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


        $user = User::find($request->user_id);
        if (!$user) {
            $response['success'] = false;
            $response['message'] = "Invalid user.";
            $response['data'] = [];
            return $this->jsonData($response);
        } else {
            $name = explode(" ", $request->full_name);

            $user->user_name = $request->full_name;
            $user->first_name = isset($name[0]) ? $name[0] : '';
            $user->last_name = isset($name[1]) ? $name[1] : '';
            $user->booking_id = $request->booking_id;
            $user->email_id = $request->email_id;
            $check_in_date = Carbon::parse($request->check_in_date);
            $user->check_in_date = $check_in_date->format('Y-m-d');
            $check_out_date = Carbon::parse($request->check_out_date);
            $user->check_out_date = $check_out_date->format('Y-m-d');
            $user->other_info = $request->members;
            $user->aadhar_id = $aadhar_file_name;
            $user->voter_id = $voter_file_name;
            if ($user->save()) {
                $response['success'] = true;
                $response['message'] = "User check-in successfully.";
                $response['data'] = [];
                return $this->jsonData($response);
            } else {
                $response['success'] = false;
                $response['message'] = "Something went be wrong.";
                $response['data'] = [];
                return $this->jsonData($response);
            }
        }
    }

}
