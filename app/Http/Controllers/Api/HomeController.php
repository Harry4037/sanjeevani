<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Banner;
use App\Models\RoomBooking;
use App\Models\UserBookingDetail;
use App\Models\Resort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ResortNearbyPlace;
use App\Models\offer;
use Carbon\Carbon;
use App\Models\HealthcateProgram;

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
     * "banners": [
     *    {
     *        "id": 1,
     *        "banner_image_url": "http://127.0.0.1:8000/storage/Banner/5zR5E72L3GDGglqaCQWveafypHYVhEjunOXVzKlx.jpeg"
     *    },
     *    {
     *        "id": 2,
     *        "banner_image_url": "http://127.0.0.1:8000/storage/Banner/2qQnTA8jAuT9eNV7UHXY561xYrZHxXHYWcXILaXO.jpeg"
     *    }
     *  ]
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

        $user = User::select('id', 'user_name', 'mobile_number', 'email_id', 'voter_id', 'aadhar_id', 'address1', 'city_id', 'user_type_id')
                ->where(["id" => $request->user_id])
                ->with([
                    'userHealthDetail' => function($query) {
                        $query->select(DB::raw("id, user_id, medical_documents, fasting, bp, insullin_dependency, (CASE WHEN (is_diabeties = '1') THEN 'yes' ELSE 'no' END) as diabeties, (CASE WHEN (is_ppa = '1') THEN 'yes' ELSE 'no' END) as ppa, (CASE WHEN (hba_1c = '1') THEN 'yes' ELSE 'no' END) as hba_1c"));
                    }
                ])
                ->with([
                    'userBookingDetail' => function($query) {
                        $query->select('id', 'user_id', 'source_id as booking_id', 'source_name', 'resort_id', 'package_id');
                    }
                ])
                ->first();

        $banners = Banner::where("is_active", 1)->get();
        $bannerArray = [];
        $i = 0;
        foreach ($banners as $banner) {
            $bannerArray[$i]['id'] = $banner->id;
            $bannerArray[$i]['banner_image_url'] = $banner->name;
            $i++;
        }

        if($user){
            $user['no_of_rooms'] = "1";
        }

$nearby = ResortNearbyPlace::select('id','name')->where(["is_active" => 1])->get();
$offers = offer::where(["is_active" => 1])->with([
        'offerImages' => function($query) {
            $query->select('id', 'image_name as banner_image_url', 'offer_id');
                }
            ])->get();
$offerArray = [];
if($offers){
    foreach ($offers as $key => $offer) {
                $validity = Carbon::parse($offer->valid_to);
                $offerArray[$key]['id'] = $offer->id;
                $offerArray[$key]['name'] = $offer->name;
                $offerArray[$key]['price'] = $offer->price;
                $offerArray[$key]['discount'] = $offer->discount_percentage . "% OFF";
                $offerArray[$key]['discounted_price'] = (int) $offer->price - (int) $offer->calculated_discount;
                $offerArray[$key]['offer_images'] = $offer->offerImages;
                }
            }

    $healthcare = HealthcateProgram::select(DB::raw('id, name'))->where(["is_active" => 1])
        ->with([
            'healthcareImages' => function($query) {
                    $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                }
                ])->get();


// dd($healthcare->toArray());
        $response['success'] = true;
        $response['status_code'] = 200;
        $response['message'] = "service successfully access.";
        $response['data'] = [
            "user" => $user ? $user : (object) [],
            "banners" => $bannerArray,
            "nearby_attaractions" => $nearby,
            "best_offers" => $offerArray,
            "health_care" => $healthcare
        ];
        return $this->jsonData($response);
    }

}
