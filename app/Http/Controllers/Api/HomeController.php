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
      {
      "status": true,
      "status_code": 200,
      "message": "service successfully access.",
      "data": {
      "user": {
      "id": 5,
      "user_name": "Ankit gangwar",
      "mobile_number": "5555555555",
      "email_id": "ankit@mail.com",
      "voter_id": "",
      "aadhar_id": "",
      "address1": "",
      "city_id": 0,
      "user_type_id": 3,
      "no_of_rooms": "1",
      "user_health_detail": {
      "id": 1,
      "user_id": 5,
      "medical_documents": "http://127.0.0.1:8000/storage/medical_document/xEQs2e8AiANXf0cRvUNSfdTG4Jzr47c3WoDd1oNm.jpeg",
      "fasting": "fasting",
      "bp": "BP",
      "insullin_dependency": "Insuline",
      "diabeties": "yes",
      "ppa": "yes",
      "hba_1c": "yes"
      },
      "user_booking_detail": {
      "id": 1,
      "room_type_id": 1,
      "resort_room_id": 1,
      "user_id": 5,
      "booking_id": "QWERTY12345",
      "source_name": "Makemy trip",
      "resort_id": 1,
      "package_id": 1,
      "check_in": "23-12-2018",
      "check_in_time": "12:00:00 AM",
      "check_out": "31-12-2018",
      "check_out_time": "01:00:00 AM",
      "resort": {
      "id": 1,
      "name": "Grand Dragon Ladakh",
      "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took</p>",
      "contact_number": "9808243372",
      "address_1": "city center of Leh"
      },
      "bookingpeople_accompany": [
      {
      "id": 1,
      "person_name": "Ankit",
      "person_age": "25",
      "person_type": "Adult"
      }
      ],
      "room_type_detail": {
      "id": 1,
      "name": "Tent",
      "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took</p>",
      "icon": "http://127.0.0.1:8000/storage/room_icon/uQHZEASJzM7ovwjcO9kLMJ0mcSRvZAOqDKEf74MU.png",
      "is_active": 1,
      "domain_id": 0,
      "created_by": "1",
      "updated_by": "1",
      "created_at": "2018-12-19 18:50:41",
      "updated_at": "2018-12-19 18:50:41",
      "deleted_at": null
      },
      "room_detail": {
      "id": 1,
      "resort_id": 1,
      "room_type_id": 1,
      "room_no": "100",
      "other_detail": null,
      "is_active": 1,
      "domain_id": 0,
      "created_by": "1",
      "updated_by": "1",
      "created_at": "2018-12-19 18:52:55",
      "updated_at": "2018-12-19 18:52:55"
      }
      }
      },
      "banners": [
      {
      "id": 1,
      "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/YhliQQRrsZwnFVanTfxCWa0w2z9PyMQax4c4KLuX.jpeg"
      },
      {
      "id": 2,
      "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/KKL4cFe51jnyavdwSjOqu5SjMrXXqxczAHc476bj.jpeg"
      },
      {
      "id": 3,
      "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/km3wD8615JmSVxILarH4D49RBtQJ6yzpLbAHmf2L.jpeg"
      },
      {
      "id": 4,
      "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/jDHvovp4xMjhPhSVVEXRzTqg6GScme1l2gn9bnej.jpeg"
      },
      {
      "id": 5,
      "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/e0CvLts9IZj3zOELnukXtDBaX06wDxfqAr8kpVrL.jpeg"
      },
      {
      "id": 6,
      "banner_image_url": "http://127.0.0.1:8000/storage/banner_images/QbCKc9qNOOlJ8rgOCyXTuYRSt5RkXFIWGc6LtQdC.jpeg"
      }
      ],
      "nearby_attaractions": [
      {
      "id": 6,
      "name": "iouoiyiuyoiuy",
      "description": "<p>,mnm,nuoijlk</p>",
      "distance": 56,
      "precautions": "<p>iuiyugbvhjvhjff</p>",
      "address": "oiuyryerwsresxdf",
      "latitude": "28.608510",
      "longitude": "77.347370",
      "images": [
      {
      "id": 6,
      "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/NnsTbodWaaavDkF4TTT8uCwNhzknzja4wEXBqblF.jpeg"
      }
      ]
      },
      {
      "id": 5,
      "name": "nbvctryfghj",
      "description": "<p>nbv hgifyutg</p>",
      "distance": 54,
      "precautions": "<p>yutyugfvngcvbcvb</p>",
      "address": "uyutyuyu",
      "latitude": "28.608510",
      "longitude": "77.347370",
      "images": [
      {
      "id": 5,
      "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/0OM7dJUc4hvee6XODrTEz1do3QnpetWDMlHbTlC9.jpeg"
      }
      ]
      },
      {
      "id": 4,
      "name": "tyutuu",
      "description": "<p>,mnbnlj;olkm.,</p>",
      "distance": 67,
      "precautions": "<p>lkjhvbnm</p>",
      "address": "oiuupo",
      "latitude": "28.608510",
      "longitude": "77.347370",
      "images": [
      {
      "id": 4,
      "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/InbCIqWMFZv2Fd4is9xuYu7Y0tIVt2cmUar2lIbu.jpeg"
      }
      ]
      },
      {
      "id": 3,
      "name": "ghfuytyutyi",
      "description": "<p>&#39;lkjhkiuyoiuhjlkn,m</p>",
      "distance": 54,
      "precautions": "<p>kjlllpoilkj.,m</p>",
      "address": "poiuyoi",
      "latitude": "28.608510",
      "longitude": "77.347370",
      "images": [
      {
      "id": 3,
      "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/nDdH33B6epsxxb6UnVNDQNy9dEfk0enThmOL5Ng7.jpeg"
      }
      ]
      },
      {
      "id": 2,
      "name": "Sonbhadra",
      "description": "<p>dfdsfd;lkjh</p>",
      "distance": 123,
      "precautions": "<p>lkjhvvbn ,m.</p>",
      "address": "city center of Leh",
      "latitude": "28.608510",
      "longitude": "77.347370",
      "images": [
      {
      "id": 2,
      "banner_image_url": "http://127.0.0.1:8000/storage/nearby_images/gpUMWc6KUQIOtsNDPkaqyBqqb6dyUiEi2dY4l8GK.jpeg"
      }
      ]
      }
      ],
      "best_offers": [],
      "health_care": [
      {
      "id": 1,
      "name": "Healthcare Package",
      "description": "<p>dfsdsadsa</p>",
      "start_from": "26-12-2018",
      "end_to": "26-12-2018",
      "total_days": 3,
      "healthcare_images": [
      {
      "id": 1,
      "banner_image_url": "http://127.0.0.1:8000/storage/healthcare_images/ss8zkcOBsoRl09sn3BaMWclhigzKNWeX7GurYiFj.jpeg",
      "health_program_id": 1
      }
      ],
      "healthcare_days": [
      {
      "id": 1,
      "day": "1",
      "description": "<p>ersfsd</p>",
      "health_program_id": 1
      },
      {
      "id": 2,
      "day": "2",
      "description": "<p>kjhkjhkl</p>",
      "health_program_id": 1
      },
      {
      "id": 3,
      "day": "3",
      "description": "<p>hlkj</p>",
      "health_program_id": 1
      }
      ]
      }
      ]
      }
      }
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
                            $query->selectRaw(DB::raw('id, room_type_id, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%m-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%m-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time'));
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

            if ($user) {
                $user['no_of_rooms'] = "1";
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
                $nearbyArray[$k]['latitude'] = "28.608510";
                $nearbyArray[$k]['longitude'] = "77.347370";
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
                "user" => $user ? $user : (object) [],
                "banners" => $bannerArray,
                "nearby_attaractions" => $nearbyArray,
                "best_offers" => $offerArray,
                "health_care" => $dataHealthArray
            ];
            return $this->jsonData($response);
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
