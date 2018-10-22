<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

    /**
     * @api {post} /api/home Home
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostHome
     * @apiGroup Home
     * 
     * @apiParam {String} user_id User id.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} message service successfully access.
     * @apiSuccess {JSON}   data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "message": "service successfully access.",
      "data": {
      "user": {
      "id": 3,
      "salutation_id": 0,
      "user_name": null,
      "password": "$2y$10$e/EVCyHax2XGa9db94NY5O2qdBWRlLTnXvR2w5KQPlkOW9a.ocqOu",
      "first_name": null,
      "mid_name": null,
      "last_name": null,
      "booking_source_name": null,
      "booking_id": null,
      "resort_id": 0,
      "total_room": null,
      "package_detail_id": 0,
      "gender": null,
      "email_id": null,
      "alternate_email_id": null,
      "user_type_id": 3,
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
      "aadhar_id": null,
      "voter_id": null,
      "check_in_date": null,
      "check_out_date": null,
      "mobile_number": "9999999999",
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
      "created_by": "0",
      "updated_by": "0",
      "created_at": "2018-10-22 10:01:59",
      "updated_at": "2018-10-22 10:01:59"
      },
      "banners": [
      {
      "id": 1,
      "banner": "http://127.0.0.1:8000/storage/Banner/ScMwPfuAF6Yq1570eLzKVNNyLMiWVwdFjKkJywEK.jpeg"
      }
      ]
      }
      }
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
    public function home(Request $request) {
        if (!$request->user_id) {
            $response['success'] = false;
            $response['message'] = "User Id missing.";
            $response['data'] = [];
            return $this->jsonData($response);
        }

        $user = User::find($request->user_id);
        $banners = Banner::all();
        $bannerArray = [];
        $i = 0;
        foreach ($banners as $banner) {
            $bannerArray[$i]['id'] = $banner->id;
            $bannerArray[$i]['banner'] = asset('storage/Banner/' . $banner->name);
            $i++;
        }

        $response['success'] = true;
        $response['message'] = "service successfully access.";
        $response['data'] = [
            "user" => $user,
            "banners" => $bannerArray
        ];
        return $this->jsonData($response);
    }

}
