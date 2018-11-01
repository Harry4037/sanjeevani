<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Banner;
use App\Models\RoomBooking;
use App\Models\UserBookingDetail;
use App\Models\Resort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

    /**
     * @api {get} /api/home Home
     * @apiHeader {String} Accept application/json. 
     * @apiName PostHome
     * @apiGroup Home
     * 
     * @apiParam {String} user_id User id.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message service successfully access.
     * @apiSuccess {JSON}   data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "service successfully access.",
     * "data":{
     * "user":{
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
     * "source_name": "Source Name",
     * "source_id": "Source Id",
     * "resort":{"id": 1, "name": "Parth Inn", "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",…},
     * "booking":{}
     * },
     * "banners":[]
     * }
     * }
     * 
     * 
     * 
     */
    public function home(Request $request) {
//        if (!$request->user_id) {
//            $response['success'] = false;
//            $response['message'] = "User Id missing.";
//            $response['data'] = [];
//            return $this->jsonData($response);
//        }

        $user = User::find($request->user_id);
//        dd($user);
        if ($user) {
            //User Detail
            $userArray['id'] = $user;
//            $userArray['id'] = $user->id;
//            $userArray['user_name'] = $user->user_name ? $user->user_name : '';
//            $userArray['first_name'] = $user->first_name ? $user->first_name : '';
//            $userArray['mid_name'] = $user->mid_name ? $user->mid_name : '';
//            $userArray['last_name'] = $user->last_name ? $user->last_name : '';
//            $userArray['email_id'] = $user->email_id ? $user->email_id : '';
//            $userArray['mobile_number'] = $user->mobile_number ? $user->mobile_number : '';
//            $userArray['user_type_id'] = $user->booking_detail ? 3 : 4;
//            $userArray['address'] = $user->address ? $user->address : '';
//            $userArray['screen_name'] = $user->screen_name ? $user->screen_name : '';
//            $userArray['profile_pic_path'] = $user->profile_pic_path ? asset("storage/profile_pic/".$user->profile_pic_path) : '';
//            
//            //Health Detail
//            $userArray['health_detail']['id'] =  $user->id;
//            $userArray['health_detail']['is_diabeties'] =  $user->health_detail->is_diabeties == 1 ? "Yes" : "No";
//            $userArray['health_detail']['is_ppa'] =  $user->health_detail->is_ppa == 1 ? "Yes" : "No";
//            $userArray['health_detail']['hba_1c'] =  $user->health_detail->hba_1c == 1 ? "Yes" : "No";
//            $userArray['health_detail']['fasting'] =  $user->health_detail->fasting ? $user->health_detail->fasting : '';
//            $userArray['health_detail']['bp'] =  $user->health_detail->bp ? $user->health_detail->bp : '';
//            $userArray['health_detail']['insullin_dependency'] =  $user->health_detail->insullin_dependency ? $user->health_detail->insullin_dependency : '';
//            $userArray['health_detail']['medical_documents'] =  asset("storage/medical_document/".$user->medical_documents);
//            
//            //Booking Detail
//            $userArray['booking_detail']['id'] =  $user->booking_detail->id;
//            $userArray['booking_detail']['source_name'] =  $user->booking_detail->source_name;
//            $userArray['booking_detail']['source_id'] =  $user->booking_detail->source_id;
//            $userArray['booking_detail']['resort'] =  $user->resort_detail;

//            $userArray['source_name'] = $user->booking_detail ? : (object)[];
//            $userArray['health_detail'] = $user->health_detail ? : (object)[];
            
//            $userArray['source_name'] = $user->booking_detail ? $user->booking_detail->source_name : '';
//            $userArray['source_id'] = $user->booking_detail ? $user->booking_detail->source_id : '';
//            $userArray['resort_room_no'] = $userRoom ? $userRoom->resort_room_id : '';
//            $userArray['room_type'] = "Delux";
//            $userArray['check_in'] = $userRoom ? $userRoom->check_in : '';
//            $userArray['check_out'] = $userRoom ? $userRoom->check_out : '';
//            if (isset($userResort)) {
//                $userArray['resort'] = $userResort;
//            } else {
//                $userArray['resort'] = (object) [];
//            }
        }
        $banners = Banner::all();
        $bannerArray = [];
        $i = 0;
        foreach ($banners as $banner) {
            $bannerArray[$i]['id'] = $banner->id;
            $bannerArray[$i]['banner'] = asset('storage/Banner/' . $banner->name);
            $i++;
        }

        $response['success'] = true;
        $response['status_code'] = 200;
        $response['message'] = "service successfully access.";
        $response['data'] = [
            "user" => isset($userArray) ? $userArray : (object) [],
            "banners" => $bannerArray
        ];
        return $this->jsonData($response);
    }

}
