<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\ResortRoom;

class ResortController extends Controller {

    /**
     * @api {post} /api/resort-detail Resort detail
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName GetResortDetail
     * @apiGroup Resort
     * 
     * @apiParam {String} user_id User id.
     * @apiParam {String} resort_id Resort id.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} message Resort found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "message": "Resort found.",
      "data":{
      "resort":{
      "id": 1,
      "name": "Parth Inn",
      "description": "resort description",
      "contact_number": "9999999999",
      "other_contact_number": null,
      "address_1": "Noida",
      "address_2": null,
      "address_3": null,
      "pincode": 201301,
      "city_id": 1,
      "latitude": 0,
      "longitude": 0,
      "is_active": 1,
      "domain_id": 0,
      "created_by": "1",
      "updated_by": "1",
      "created_at": "2018-10-23 18:43:57",
      "updated_at": "2018-10-23 18:48:48"
      },
      "images":[
      {
      "id": 1,
      "image": "http://sanjeevani.dbaquincy.com//storage/Resort/vRjSo14bSmWYs3Iuf3lHLVcItYuR5Ib9wrn8jFny.jpeg"
      },
      {
      "id": 2,
      "image": "http://sanjeevani.dbaquincy.com//storage/Resort/56aJrFsQGrr2mvw6xEw9B1jwcutzH3SKiSxnSWmP.jpeg"
      },
      {
      "id": 3,
      "image": "http://sanjeevani.dbaquincy.com//storage/Resort/3HY6kUbXtN4A4HlYHoeqDzri7D1L7E3K04Xm6VxL.jpeg"
      },
      {
      "id": 4,
      "image": "http://sanjeevani.dbaquincy.com//storage/Resort/SQ2PLNjBNKeGicszxZqApeK0nII1iqi08XPkwWqa.jpeg"
      }
      ]
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
     * @apiError ResortIdMissing The resort id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Resort id missing.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function resortDetail(Request $request) {
        if (!$request->user_id) {
            $response['success'] = false;
            $response['message'] = "User id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if (!$request->resort_id) {
            $response['success'] = false;
            $response['message'] = "Resort id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }

        $resort = Resort::where(["id" => $request->resort_id, "is_active" => 1])->first();
        if ($resort) {
            $data['resort'] = $resort;
            $images = ResortImage::where(["resort_id" => $request->resort_id, "is_active" => 1])->get();
            if ($images) {
                $i = 0;
                foreach ($images as $image) {
                    $data['images'][$i]['id'] = $image->id;
                    $data['images'][$i]['image'] = asset('storage/Resort/' . $image->image_name);
                    $i++;
                }
            } else {
                $data['images'] = [];
            }

            $response['success'] = true;
            $response['message'] = "Resort found.";
            $response['data'] = $data;
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['message'] = "Resortnot found.";
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
