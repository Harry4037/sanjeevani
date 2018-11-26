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
use App\Models\NearbyPlaceImage;

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
      "status": true,
      "status_code": 200,
      "message": "service successfully access.",
      "data": {
      "user": {
      "id": 3,
      "user_name": "Amit Singh",
      "mobile_number": "8888888888",
      "email_id": "amit@mail.com",
      "voter_id": null,
      "aadhar_id": null,
      "address1": null,
      "city_id": 87,
      "user_type_id": 3,
      "no_of_rooms": "1",
      "user_health_detail": {
      "id": 2,
      "user_id": 3,
      "medical_documents": "http://sanjeevani.dbaquincy.com/storage/medical_document/rU4C2wTS2oMnTakZpfFf8zd7LNS6Oe4b3ISx7pxP.jpeg",
      "fasting": "Fasting",
      "bp": "BP",
      "insullin_dependency": "insuline",
      "diabeties": "yes",
      "ppa": "yes",
      "hba_1c": "yes"
      },
      "user_booking_detail": {
      "id": 2,
      "user_id": 3,
      "booking_id": "ZXC12345",
      "source_name": "Makemy trip",
      "resort_id": 2,
      "package_id": 1,
      "resort": {
      "id": 2,
      "name": "Royal Heritage Resor",
      "description": "<p>There are six independent hut style accomodations, which come with double occupancy rooms and living cum dining areas. There are 12 standard rooms as well, and each room comes with various amenities such as high speed internet access, Bose CD System and much more.</p>",
      "contact_number": "9808243372",
      "address_1": "city center of Leh"
      },
      "room_booking": {
      "id": 2,
      "check_in": "16-11-2018",
      "check_in_time": "12:00:00 AM",
      "check_out": "22-11-2018",
      "check_out_time": "12:00:00 AM",
      "room_type_id": 1,
      "resort_room_id": 21,
      "room_type": {
      "id": 1,
      "name": "Tent"
      },
      "resort_room": null
      },
      "bookingpeople_accompany": [
      {
      "id": 4,
      "person_name": "Maan singh",
      "person_age": "35",
      "person_type": "Adult"
      },
      {
      "id": 5,
      "person_name": "Pratiraksha",
      "person_age": "5",
      "person_type": "Child"
      }
      ]
      }
      },
      "banners": [
      {
      "id": 1,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/banner_images/fozc4dLglmoMnMFr9XADAjgZrRJt6MM339LBtOof.jpeg"
      },
      {
      "id": 2,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/banner_images/pQH8non1kv3GsVNmTUo8u0q2NKWfL9K6z5Zau8Wq.jpeg"
      },
      {
      "id": 3,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/banner_images/qN0RhbeOvz93GmXi2pJrfzffwyslrVXEXDdk6lxZ.jpeg"
      },
      {
      "id": 4,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/banner_images/VcdwF9xCFN7FnlxFQWIFv1YVAbSOLq9WANUHxmzD.jpeg"
      },
      {
      "id": 5,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/banner_images/ZgI7mMDQuvSODcIwcKGi00xcdLlZe721WO6PeLJW.jpeg"
      }
      ],
      "nearby_attaractions": [
      {
      "id": 1,
      "name": "Water Fall"
      },
      {
      "id": 2,
      "name": "Nilgiri Forest"
      },
      {
      "id": 3,
      "name": "Bird sanctuary"
      },
      {
      "id": 4,
      "name": "Water Fall New"
      },
      {
      "id": 5,
      "name": "Nilgiri Forest"
      }
      ],
      "best_offers": [
      {
      "id": 1,
      "name": "3 Days, 3 Nights",
      "price": 2100,
      "discount": "10% OFF",
      "discounted_price": 1890,
      "offer_images": [
      {
      "id": 1,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/offer_images/AvgLdM35wzdYPDGf6qshxzwBXXbxEznofnIwx2Br.jpeg",
      "offer_id": 1
      },
      {
      "id": 2,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/offer_images/Hav6f0MNfvvqHW0ppsROIBDLcwlhFgfxRKhZELkC.jpeg",
      "offer_id": 1
      }
      ]
      },
      {
      "id": 2,
      "name": "3 Days, 2 Nights",
      "price": 5000,
      "discount": "20% OFF",
      "discounted_price": 4000,
      "offer_images": [
      {
      "id": 3,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/offer_images/hJvW1nKfqDArBg4zjJPtnSozN63WOBD7fkcNC0V2.jpeg",
      "offer_id": 2
      },
      {
      "id": 4,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/offer_images/i9ny0wdWBuJMrRI0n0pevbZHS2SdMrmy4vQ4DTUK.jpeg",
      "offer_id": 2
      }
      ]
      }
      ],
      "health_care": [
      {
      "id": 1,
      "name": "Diabetes Program",
      "healthcare_images": [
      {
      "id": 1,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/offer_images/AvgLdM35wzdYPDGf6qshxzwBXXbxEznofnIwx2Br.jpeg",
      "health_program_id": 1
      },
      {
      "id": 2,
      "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/offer_images/Hav6f0MNfvvqHW0ppsROIBDLcwlhFgfxRKhZELkC.jpeg",
      "health_program_id": 1
      }
      ]
      }
      ]
      }
     *   }
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

        if ($user) {
            $user['no_of_rooms'] = "1";
        }

        $nearby = ResortNearbyPlace::select('id', 'name')->where(["is_active" => 1])->get();

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

        $offers = offer::where(["is_active" => 1])->with([
                    'offerImages' => function($query) {
                        $query->select('id', 'image_name as banner_image_url', 'offer_id');
                    }
                ])->get();
        $offerArray = [];
        if ($offers) {
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

        $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["is_active" => 1, "resort_id" => $request->resort_id])
                        ->with([
                            'healthcareImages' => function($query) {
                                $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                            }
                        ])
                        ->with([
                            'healthcareDays' => function($query) {
                                $query->select('id', 'day', 'description', 'health_program_id');
                            }
                        ])->get();
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
    }

}
