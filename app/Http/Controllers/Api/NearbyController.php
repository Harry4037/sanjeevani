<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResortNearbyPlace;
use App\Models\NearbyPlaceImage;
use App\Models\User;
use App\Models\Resort;

class NearbyController extends Controller {

    /**
     * @api {get} /api/nearby-list-detail Nearby place list & detail
     * @apiHeader {String} Accept application/json.
     * @apiName GetNearbyListDetail
     * @apiGroup Resort
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Nearby place found found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "Nearby places found.",
      "data": {
      "nearby": [
      {
      "id": 7,
      "name": "Tibetan Buddhist Temple",
      "description": "<p>Buddha Temple is a Tibetan monestary, also called as Mindrolling Monastery and was build in 1965 by his eminence the Kochen Rinpoche and few other monks for the promotion and protection of religious &amp;amp; cultural understanding of Buddhism. Built in Japanese architecture style, Buddha Temple complex atmosphere provides a mental peace equal to Buddhist monk. Buddha temple complex was created as one of the four schools of Tibetan religion. This temple complex is known as &#39;Nyigma&#39; while other schools known as Sakya, Kagyu and Geluk respectively.</p>",
      "distance": 28,
      "precautions": "<p>Temple garden and shops are open for all seven days for but temple remains open for Sunday only for public.Visitors are requested to remove shoes before entering the main hall of Buddha temple.</p>",
      "address": "New Basti, Clement Town Uttrakhand Dehradun-248197",
      "latitude": 30.3231,
      "longitude": 78.0473,
      "images": [
      {
      "id": 14,
      "banner_image_url": "http://127.0.0.1:1234/storage/nearby_images/PeIZtPLOGu0nCi4WCW7nRPUT6o5sMxfjfwnz4V13.jpeg"
      }
      ]
      },
      {
      "id": 8,
      "name": "Forest Research Institute",
      "description": "<p>For a bargain entrance fee you get to enjoy the architecture and grounds, several brilliantly old-fashioned museums, and the botanical gardens (though the latter need quite a bit of attention). We wandered into the paper-making office and got a free guided tour of a disused mill by a Dr Gupta and his staff which was fantastic. One of the best afternoons we had in Dehradun and a complete accident! This place is definitely worth a visit.</p>",
      "distance": 15,
      "precautions": "<p>One of the Iconic places in India and especially in Dehradun. Student of the Year has been shot here, and after that, this place has become one of the most visited places in the town.</p>",
      "address": "Mason Rd | Indian Military Academy, Dehradun - 248001",
      "latitude": 25.22222,
      "longitude": 36.55555,
      "images": [
      {
      "id": 16,
      "banner_image_url": "http://127.0.0.1:1234/storage/nearby_images/KZMoKARmBBYICyyQjwkzbApwdS4KtA8cSMWE9XAL.jpeg"
      },
      {
      "id": 20,
      "banner_image_url": "http://127.0.0.1:1234/storage/nearby_images/qiSrpffmBDT8DO3ZqE8xeoswKqFJ7kwsesqoyzoJ.jpeg"
      }
      ]
      }
      ]
      }
      }
     * 
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
    public function nearbyListDetail(Request $request) {
        try {
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing.", (object) []);
            }
            if (!$request->user_id) {
                return $this->sendErrorResponse("user id missing.", (object) []);
            }
            $user = User::find($request->user_id);
            if ($user->user_type_id == 4) {
                $resortId = 0;
                $defaultResort = Resort::where("is_default", 1)->first();
                if ($defaultResort) {
                    $resortId = $defaultResort->id;
                } else {
                    $defaultResort = Resort::query()->first();
                    $resortId = $defaultResort->id;
                }
                $nearby = ResortNearbyPlace::where(["is_active" => 1, 'resort_id' => $resortId])->get();
                if ($nearby) {
                    $data['nearby'] = [];
                    $i = 0;
                    foreach ($nearby as $near) {
                        $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $near->id)->get();
                        $data['nearby'][$i]['id'] = $near->id;
                        $data['nearby'][$i]['name'] = $near->name;
                        $data['nearby'][$i]['description'] = $near->description ? $near->description : '';
                        $data['nearby'][$i]['distance'] = $near->distance_from_resort;
                        $data['nearby'][$i]['precautions'] = $near->precautions ? $near->precautions : '';
                        $data['nearby'][$i]['address'] = $near->address_1;
                        $data['nearby'][$i]['latitude'] = $near->latitude;
                        $data['nearby'][$i]['longitude'] = $near->longitude;
                        if (count($nearbyImages) > 0) {
                            $j = 0;
                            foreach ($nearbyImages as $nearbyImage) {
                                $data['nearby'][$i]['images'][$j]['id'] = $nearbyImage->id;
                                $data['nearby'][$i]['images'][$j]['banner_image_url'] = $nearbyImage->name;
                                $j++;
                            }
                        } else {
                            $data['nearby'][$i]['images'][0] = [
                                'id' => 0,
                                'banner_image_url' => asset('img/image_loader.png')
                            ];
                        }
                        $i++;
                    }

                    return $this->sendSuccessResponse("Nearby places found.", $data);
                } else {
                    return $this->sendErrorResponse("Nearby places not found.", (object) []);
                }
            } else {

                $nearby = ResortNearbyPlace::where(["resort_id" => $request->resort_id, "is_active" => 1])->get();
                if ($nearby) {
                    $data['nearby'] = [];
                    $i = 0;
                    foreach ($nearby as $near) {
                        $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $near->id)->get();
                        $data['nearby'][$i]['id'] = $near->id;
                        $data['nearby'][$i]['name'] = $near->name;
                        $data['nearby'][$i]['description'] = $near->description ? $near->description : '';
                        $data['nearby'][$i]['distance'] = $near->distance_from_resort;
                        $data['nearby'][$i]['precautions'] = $near->precautions ? $near->precautions : '';
                        $data['nearby'][$i]['address'] = $near->address_1;
                        $data['nearby'][$i]['latitude'] = $near->latitude;
                        $data['nearby'][$i]['longitude'] = $near->longitude;
                        if (count($nearbyImages) > 0) {
                            $j = 0;
                            foreach ($nearbyImages as $nearbyImage) {
                                $data['nearby'][$i]['images'][$j]['id'] = $nearbyImage->id;
                                $data['nearby'][$i]['images'][$j]['banner_image_url'] = $nearbyImage->name;
                                $j++;
                            }
                        } else {
                            $data['nearby'][$i]['images'][0] = [
                                'id' => 0,
                                'banner_image_url' => asset('img/image_loader.png')
                            ];
                        }
                        $i++;
                    }

                    return $this->sendSuccessResponse("Nearby places found.", $data);
                } else {
                    return $this->sendErrorResponse("Nearby places not found.", (object) []);
                }
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}
