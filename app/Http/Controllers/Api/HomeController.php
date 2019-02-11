<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Banner;
use App\Models\UserBookingDetail;
use App\Models\Resort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ResortNearbyPlace;
use App\Models\offer;
use Carbon\Carbon;
use App\Models\HealthcateProgram;
use App\Models\NearbyPlaceImage;
use App\Models\HealthcateProgramDay;
use App\Models\Notification;

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
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "service successfully access.",
     *       "data": {
     *           "user": {
     *               "id": 2,
     *               "user_name": "Hariom G",
     *               "mobile_number": "9999999999",
     *               "email_id": "hariom4037@mail.com",
     *               "voter_id": "",
     *               "aadhar_id": "7SKegf9AESUmVrLhzoWsiEG9xL5RFbwkQyAFPx0J.jpeg",
     *               "address1": "",
     *               "city_id": 26,
     *               "user_type_id": 3,
     *               "no_of_rooms": "1",
     *               "user_health_detail": {
     *                   "id": 1,
     *                   "user_id": 2,
     *                   "medical_documents": "http://127.0.0.1:8000/storage/medical_document/kXWzl0GYEMojSAMPiLHLOvPpuC9ToOm8hKStnwh8.png",
     *                   "fasting": "FF",
     *                   "bp": "BP",
     *                   "insullin_dependency": "Ins",
     *                   "diabeties": "yes",
     *                   "ppa": "yes",
     *                   "hba_1c": "yes"
     *               },
     *               "user_booking_detail": {
     *                   "id": 5,
     *                   "room_type_id": 1,
     *                   "resort_room_id": 1,
     *                   "user_id": 2,
     *                   "booking_id": "AAAA",
     *                   "source_name": "AAAA",
     *                   "resort_id": 1,
     *                   "package_id": 1,
     *                   "check_in": "28-12-2018",
     *                   "check_in_time": "12:00:00 AM",
     *                   "check_out": "10-01-2019",
     *                   "check_out_time": "10:00:00 AM",
     *                   "resort": {
     *                       "id": 1,
     *                       "name": "Resort",
     *                       "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *                       "contact_number": "9999999999",
     *                       "address_1": "Sector 66"
     *                   },
     *                   "bookingpeople_accompany": [
     *                       {
     *                           "id": 4,
     *                           "person_name": "Anhu",
     *                           "person_age": "25",
     *                           "person_type": "Adult"
     *                       }
     *                   ],
     *                   "room_type_detail": {
     *                       "id": 1,
     *                       "name": "Tent",
     *                       "description": "<p>sadasdsa</p>",
     *                       "icon": "http://127.0.0.1:8000/storage/room_icon"
     *                   },
     *                   "room_detail": {
     *                       "id": 1,
     *                       "resort_id": 1,
     *                       "room_type_id": 1,
     *                       "room_no": "100"
     *                   }
     *               }
     *           },
     *           "banners": [
     *               {
     *                   "id": 1,
     *                   "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/hZXHtETg3LcSSehejZEuhVjOZj4GMWEArtjYADXJ.jpeg"
     *               },
     *               {
     *                   "id": 2,
     *                   "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/xf43HtQsPBdCYfl2wEMmXlUlrR1R1puqTmfDTXmV.jpeg"
     *               }
     *           ],
     *           "nearby_attaractions": [
     *               {
     *                   "id": 1,
     *                   "name": "Nearby place",
     *                   "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
     *                   "distance": 10,
     *                   "precautions": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
     *                   "address": "Sector 153",
     *                   "latitude": "28.608510",
     *                   "longitude": "77.347370",
     *                   "images": [
     *                       {
     *                           "id": 1,
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/v1HPQZG75jz1rawM10ad7lrWfmqSdszNGemUfbBV.jpeg"
     *                       },
     *                       {
     *                           "id": 2,
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/rIbJW533fPlYfkntRiIFPe018QmlVBprAsKEcoJ1.jpeg"
     *                       }
     *                   ]
     *               }
     *           ],
     *           "best_offers": [
     *               {
     *                   "id": 1,
     *                   "name": "Offer",
     *                   "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *                   "valid_to": "Dec-31-2018",
     *                   "price": 5000,
     *                   "discount": "10% OFF",
     *                   "discounted_price": 4500,
     *                   "offer_images": [
     *                       {
     *                           "id": 1,
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/offer_images/9woaFJJx8VltYghdtHGR96v7CVi5ggZB9zfi8yf7.jpeg",
     *                           "offer_id": 1
     *                       },
     *                       {
     *                           "id": 2,
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/offer_images/tpUoMuqQiSHeSZkX7QpdouVBuWUyTTUOqoOf0Egk.jpeg",
     *                           "offer_id": 1
     *                       }
     *                   ]
     *               }
     *           ],
     *           "health_care": [
     *               {
     *                   "id": 1,
     *                   "name": "Package Name",
     *                   "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *                   "start_from": "01-12-2018",
     *                   "end_to": "30-11-2018",
     *                   "total_days": 3,
     *                   "healthcare_images": [
     *                       {
     *                           "id": 1,
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/healthcare_images/3mkKFRMJ74O3DQ8UydMZ136D48FLeZisIUZXhvPD.jpeg",
     *                           "health_program_id": 1
     *                       },
     *                       {
     *                           "id": 2,
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/healthcare_images/0LYAujZECGPXJlPsLiMQkspV2VVad3a3yxko17fP.jpeg",
     *                           "health_program_id": 1
     *                       }
     *                   ],
     *                   "healthcare_days": [
     *                       {
     *                           "id": 1,
     *                           "day": "1",
     *                           "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *                           "health_program_id": 1
     *                       },
     *                       {
     *                           "id": 2,
     *                           "day": "2",
     *                           "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *                           "health_program_id": 1
     *                       },
     *                       {
     *                           "id": 3,
     *                           "day": "3",
     *                           "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *                           "health_program_id": 1
     *                       }
     *                   ]
     *               }
     *           ]
     *       }
     *   }
     * 
     * 
     * 
     */
    public function home(Request $request) {
        try {

            $user = User::select('id', 'user_name', 'mobile_number', 'email_id', 'voter_id', 'aadhar_id', 'address1', 'city_id', 'user_type_id')
                    ->where(["id" => $request->user_id])
                    ->with([
                        'userHealthDetail' => function($query) {
                            $query->select(DB::raw("id, user_id, medical_documents, fasting, bp, insullin_dependency, (CASE WHEN (is_diabeties = '1') THEN 'yes' ELSE 'no' END) as diabeties, (CASE WHEN (is_ppa = '1') THEN 'yes' ELSE 'no' END) as ppa, (CASE WHEN (hba_1c = '1') THEN 'yes' ELSE 'no' END) as hba_1c"));
                        }
                    ])
                    ->with([
                        'userBookingDetail' => function($query) {
                            $query->selectRaw(DB::raw('id, room_type_id, check_in_pin, check_out_pin, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%b-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%b-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time'));
                        }
                    ])
                    ->first();
            if ($user) {
                $user['no_of_rooms'] = "1";
            }

            $notification = Notification::where(["user_id"=> $request->user_id, "is_view"=>0])->count();
            $user['notification_count'] = $notification;
            
            $banners = Banner::where("is_active", 1)->get();
            $bannerArray = [];
            $i = 0;
            foreach ($banners as $banner) {
                $bannerArray[$i]['id'] = $banner->id;
                $bannerArray[$i]['banner_image_url'] = $banner->name;
                $i++;
            }

            if (isset($user->userBookingDetail->resort_id)) {
                $nearby = ResortNearbyPlace::where(["is_active" => 1, "resort_id" => $user->userBookingDetail->resort_id])->take(5)->latest()->get();
            } else {
                $nearby = ResortNearbyPlace::where(["is_active" => 1])->take(5)->latest()->get();
            }

            $nearbyArray = [];
            foreach ($nearby as $k => $near) {
                $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $near->id)->get();
                $nearbyArray[$k]['id'] = $near->id;
                $nearbyArray[$k]['name'] = $near->name;
                $nearbyArray[$k]['description'] = $near->description;
                $nearbyArray[$k]['distance'] = $near->distance_from_resort;
                $nearbyArray[$k]['precautions'] = $near->precautions;
                $nearbyArray[$k]['address'] = $near->address_1;
                $nearbyArray[$k]['latitude'] = $near->latitude;
                $nearbyArray[$k]['longitude'] = $near->longitude;
                if ($nearbyImages) {
                    $j = 0;
                    foreach ($nearbyImages as $nearbyImage) {
                        $nearbyArray[$k]['images'][$j]['id'] = $nearbyImage->id;
                        $nearbyArray[$k]['images'][$j]['banner_image_url'] = $nearbyImage->name;
                        $j++;
                    }
                } else {
                    $nearbyArray[$k]['images'][$j] = [];
                }
            }

            if (isset($user->userBookingDetail->resort_id)) {
                $offers = offer::where(["is_active" => 1, "resort_id" => $user->userBookingDetail->resort_id])->with([
                            'offerImages' => function($query) {
                                $query->select('id', 'image_name as banner_image_url', 'offer_id');
                            }
                        ])->take(5)->latest()->get();
            } else {
                $offers = offer::where(["is_active" => 1])->with([
                            'offerImages' => function($query) {
                                $query->select('id', 'image_name as banner_image_url', 'offer_id');
                            }
                        ])->take(5)->latest()->get();
            }

            $offerArray = [];
            if ($offers) {
                foreach ($offers as $key => $offer) {
                    $validity = Carbon::parse($offer->valid_to);
                    $offerArray[$key]['id'] = $offer->id;
                    $offerArray[$key]['name'] = $offer->name;
                    $offerArray[$key]['description'] = $offer->description;
                    $offerArray[$key]['valid_to'] = $validity->format('M-d-Y');
                    $offerArray[$key]['price'] = $offer->price;
                    $offerArray[$key]['discount'] = $offer->discount_percentage . "% OFF";
                    $offerArray[$key]['discounted_price'] = (int) $offer->price - (int) $offer->calculated_discount;
                    $offerArray[$key]['offer_images'] = $offer->offerImages;
                }
            }

            if (isset($user->userBookingDetail->resort_id)) {

                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))
                                ->with([
                                    'healthcareImages' => function($query) {
                                        $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                    }
                                ])
                                ->with([
                                    'healthcareDays' => function($query) {
                                        $query->select('id', 'day', 'description', 'health_program_id');
                                    }
                                ])->where(["is_active" => 1, "resort_id" => $user->userBookingDetail->resort_id])->take(5)->latest()->get();
            } else {
                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["is_active" => 1])
                                ->with([
                                    'healthcareImages' => function($query) {
                                        $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                    }
                                ])
                                ->with([
                                    'healthcareDays' => function($query) {
                                        $query->select('id', 'day', 'description', 'health_program_id');
                                    }
                                ])->take(5)->latest()->get();
            }

            $dataHealthArray = [];
            if (count($healthcare) > 0) {
                foreach ($healthcare as $key => $health) {
                    $healthcareDays = HealthcateProgramDay::where('health_program_id', $health->id)->count();
                    $dataHealthArray[$key] = $health;
                    $dataHealthArray[$key]['total_days'] = $healthcareDays;
                }
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "service successfully access.";
            $response['data'] = [
                "user" => $user ? $user->toArray() : (object) [],
                "banners" => $bannerArray,
                "nearby_attaractions" => $nearbyArray,
                "best_offers" => $offerArray,
                "health_care" => $dataHealthArray
            ];
            return $this->jsonData($response);
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}
