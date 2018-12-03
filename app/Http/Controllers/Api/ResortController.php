<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\ResortRoom;
use App\Models\RoomType;
use App\Models\RoomtypeImage;

class ResortController extends Controller {

    /**
     * @api {get} /api/resort-detail Resort detail
     * @apiHeader {String} Accept application/json. 
     * @apiName GetResortDetail
     * @apiGroup Resort
     * 
     * @apiParam {String} user_id User id.
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Resort found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Resort found.",
     *       "data": {
     *           "resort": {
     *               "id": 1,
     *               "name": "Parth Inn",
     *               "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>",
     *               "address": "sector 63",
     *               "latitude": "sector 63",
     *               "longitude": "sector 63",
     *               "room_types": [
     *                   {
     *                       "id": 1,
     *                       "name": "Tent",
     *                       "icon": "http://127.0.0.1:8000/storage/room_type_icon",
     *                       "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s,</p>",
     *                        "room_images": [
     *                           {
     *                               "id": 1,
     *                               "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/room_images/Q2czItOa8fzuQ25kNsXRYTQxI3AP9CAHrBvVi068.jpeg"
     *                           },
     *                           {
     *                               "id": 2,
     *                               "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/room_images/WInHZfmKjbhbFL6nsjR1liQGOUKTXWtDth0TR6Bv.jpeg"
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "id": 2,
     *                       "name": "Cottage",
     *                       "icon": "http://127.0.0.1:8000/storage/room_type_icon",
     *                       "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s,</p>",
     *                        "room_images": [
     *                           {
     *                               "id": 1,
     *                               "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/room_images/Q2czItOa8fzuQ25kNsXRYTQxI3AP9CAHrBvVi068.jpeg"
     *                           },
     *                           {
     *                               "id": 2,
     *                               "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/room_images/WInHZfmKjbhbFL6nsjR1liQGOUKTXWtDth0TR6Bv.jpeg"
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "id": 3,
     *                       "name": "Delux Room",
     *                       "icon": "http://127.0.0.1:8000/storage/room_type_icon",
     *                       "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s,</p>",
     *                        "room_images": [
     *                           {
     *                               "id": 1,
     *                               "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/room_images/Q2czItOa8fzuQ25kNsXRYTQxI3AP9CAHrBvVi068.jpeg"
     *                           },
     *                           {
     *                               "id": 2,
     *                               "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/room_images/WInHZfmKjbhbFL6nsjR1liQGOUKTXWtDth0TR6Bv.jpeg"
     *                           }
     *                       ]
     *                   }
     *               ],
     *               "resort_images": [
     *                   {
     *                       "id": 1,
     *                       "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/Resort/ptjHTnrFSngDDbqO20ZHl4YDy035S0z1cIuop8EC.jpeg",
     *                       "resort_id": 1
     *                   },
     *                   {
     *                       "id": 2,
     *                       "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/Resort/xQvt0XF682PO9gzaA05gTB2MQKP0ZH62XYGsgn2i.jpeg",
     *                       "resort_id": 1
     *                   },
     *                   {
     *                       "id": 3,
     *                       "image_name": "http://sanjeevani.dbaquincy.com/storage/Resort/NqHeZs8Qw9gIyuRNNg3YgtD3JrS0Cx5QH8OmYaAy.jpeg",
     *                       "resort_id": 1
     *                   },
     *                   {
     *                       "id": 4,
     *                       "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/Resort/kVkodMPi1Y5QfPKeOjY8LXbf0tiKoOS4sHbaQOMu.jpeg",
     *                       "resort_id": 1
     *                   }
     *               ],
     *               "resort_amenities": [
     *                   {
     *                       "id": 1,
     *                       "resort_id": 1,
     *                       "name": "Gym",
     *                       "icon": "http://127.0.0.1:8000/storage/amenities_icon"
     *                   },
     *                   {
     *                       "id": 2,
     *                       "resort_id": 1,
     *                       "name": "SPA",
     *                       "icon": "http://127.0.0.1:8000/storage/amenities_icon"
     *                   }
     *               ],
     *               "resort_near_by_places": [
     *                   {
     *                       "id": 1,
     *                       "name": "Water Fall",
     *                       "distance_from_resort": 25,
     *                       "resort_id": 1
     *                   },
     *                   {
     *                       "id": 2,
     *                       "name": "Nilgri forest",
     *                       "distance_from_resort": 10,
     *                       "resort_id": 1
     *                   }
     *               ]
     *           }
     *       }
     *   }
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
     * 
     */
    public function resortDetail(Request $request) {
        try {
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing.", (object) []);
            }

            $resort = Resort::select('id', 'name', 'description', 'address_1 as address', 'latitude', 'longitude')->where(["id" => $request->resort_id, "is_active" => 1])->with([
                        'resortImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'resort_id');
                        }
                    ])->with([
                        'resortAmenities' => function($query) {
                            $query->select('id', 'resort_id', 'name', 'icon');
                        }
                    ])->with([
                        'resortNearByPlaces' => function($query) {
                            $query->select('id', 'name', 'distance_from_resort', 'resort_id');
                        }
                    ])->first();

            if ($resort) {
                $resortRoomTypes = ResortRoom::select('room_type_id')->where("resort_id", $resort->id)->distinct()->get();
                $resortRoomArray = [];
                if ($resortRoomTypes) {
                    foreach ($resortRoomTypes as $key => $resortRoomType) {
                        $roomType = RoomType::find($resortRoomType->room_type_id);
                        $resortRoomArray[$key]['id'] = $roomType->id;
                        $resortRoomArray[$key]['name'] = $roomType->name;
                        $resortRoomArray[$key]['icon'] = $roomType->icon;
                        $resortRoomArray[$key]['description'] = $roomType->description;
                        $roomImages = RoomtypeImage::select('id', 'image_name as banner_image_url')->where("roomtype_id", $resortRoomType->room_type_id)->get();
                        if($roomImages){
                            $resortRoomArray[$key]['room_images'] = $roomImages;
                        }else{
                            $resortRoomArray[$key]['room_images'] = [];
                        }
                    }
                }

                $data['resort'] = $resort;
                $data['resort']['room_types'] = $resortRoomArray;

                return $this->sendSuccessResponse("Resort found.", $data);
            } else {

                return $this->sendErrorResponse("Resort not found.", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/resort-listing Resort listing
     * @apiHeader {String} Accept application/json. 
     * @apiName GetResortListing
     * @apiGroup Resort
     * 
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Resorts found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *{
     *    "status": true,
     *    "status_code": 200,
     *    "message": "resorts found",
     *    "data": [
     *           {
     *            "id": 1,
     *            "name": "Parth Inn",
     *            "description": "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>",
     *            "address": "Secotr 66",
     *            "resort_images": [
     *                {
     *                    "id": 1,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/resort_images/VSDtAK5sVV7tcJadizsWBnlDsvzg2Zh8E5PAY2yG.jpeg",
     *                    "resort_id": 1
     *                },
     *                {
     *                    "id": 2,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/resort_images/eaxPGN8eFHbOuVRzzWpwWBQr5X93ynaNsFbwlXLC.jpeg",
     *                    "resort_id": 1
     *                },
     *                {
     *                    "id": 3,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/resort_images/gTuqwCLAVaSklGpvJJHvEz2Aa6DUENpSVjqIGEUC.jpeg",
     *                    "resort_id": 1
     *                },
     *                {
     *                    "id": 4,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/resort_images/4VXIhvL8Xp4wQk3rrkoqODEGuHOH4zMB4nSZZsvp.jpeg",
     *                    "resort_id": 1
     *                }
     *            ]
     *        }
     *    ]
     *}
     * 
     * 
     * 
     */
    public function resortListing(Request $request) {
        try {

            $resorts = Resort::select('id', 'name', 'description', 'address_1 as address')->where(["is_active" => 1])->with([
                        'resortImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'resort_id');
                        }
                    ])->get();
            if ($resorts) {
                return $this->sendSuccessResponse("resorts found", $resorts);
            } else {
                return $this->sendSuccessResponse("resorts not found", $resorts);
            }
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
