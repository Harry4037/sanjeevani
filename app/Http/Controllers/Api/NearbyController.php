<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResortNearbyPlace;
use App\Models\NearbyPlaceImage;
use App\Models\User;

class NearbyController extends Controller {

    /**
     * @api {get} /api/nearby-list-detail Nearby place list & detail
     * @apiHeader {String} Accept application/json.
     * @apiName GetNearbyListDetail
     * @apiGroup Resort
     * 
     * @apiParam {String} user_id User id.
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Nearby place found found.
     * @apiSuccess {JSON}   data Json data.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Nearby places found.",
     * "data": {
     * "nearby": [
     * {
     * "id": 1,
     * "name": "Ever green Sweet",
     * "description": "Lore ipsum is the dummy text",
     * "distance": 10,
     * "precautions": "Lore ipsum is the dummy",
     * "address": "noida",
     * "latitude": "28.608510",
     * "longitude": "77.347370",
     * "images": [
     * {
     * "id": 1,
     * "banner_image_url": "http://127.0.0.1:8000/storage/Nearby/ExD6n45wLqb6U3NdEZ34vLjSDdntyUEWA9J6kUNu.jpeg"
     * },
     * {
     * "id": 2,
     * "banner_image_url": "http://127.0.0.1:8000/storage/Nearby/u5SKjA8LzMoIabk87njPSg5nTcFaAFgKkgZN2z1f.jpeg"
     * }
     * ]
     * },
     * {
     * "id": 2,
     * "name": "Testing",
     * "description": "jhkjhjh",
     * "distance": 10,
     * "precautions": "kjhkjhkjhkj",
     * "address": "noida",
     * "latitude": "28.608510",
     * "longitude": "77.347370",
     * "images": [
     * {
     * "id": "http://127.0.0.1:8000/storage/Nearby/qM3wyREsrYaOltoKitTxl75Jxd41Cqy5i8VZy95h.jpeg"
     * }
     * ]
     * }
     * ]
     * }
     * }
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
    public function nearbyListDetail(Request $request) {
       if (!$request->user_id) {
           $response['success'] = false;
           $response['message'] = "User id missing.";
           $response['data'] = (object) [];
           return $this->jsonData($response);
       }
        if (!$request->resort_id) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Resort id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $user = User::find($request->user_id);
        if($user->user_type_id == 4){
          $nearby = ResortNearbyPlace::where(["resort_id" => $request->resort_id, "is_active" => 1])take(5)->latest()->get();
        if ($nearby) {
            $data['nearby'] = [];
            $i = 0;
            foreach ($nearby as $near) {
                $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $near->id)->get();
                $data['nearby'][$i]['id'] = $near->id;
                $data['nearby'][$i]['name'] = $near->name;
                $data['nearby'][$i]['description'] = $near->description;
                $data['nearby'][$i]['distance'] = $near->distance_from_resort;
                $data['nearby'][$i]['precautions'] = $near->precautions;
                $data['nearby'][$i]['address'] = $near->address_1;
                $data['nearby'][$i]['latitude'] = "28.608510";
                $data['nearby'][$i]['longitude'] = "77.347370";
                if ($nearbyImages) {
                    $j = 0;
                    foreach ($nearbyImages as $nearbyImage) {
                        $data['nearby'][$i]['images'][$j]['id'] = $nearbyImage->id;
                        $data['nearby'][$i]['images'][$j]['banner_image_url'] = $nearbyImage->name;
                        $j++;
                    }
                } else {
                    $data['nearby'][$i]['images'][$j] = [];
                }
                $i++;
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Nearby places found.";
            $response['data'] = $data;
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Nearby places not found.";
            $response['data'] = ["nearby" => []];
            return $this->jsonData($response);
        }

        }else{
        $nearby = ResortNearbyPlace::where(["resort_id" => $request->resort_id, "is_active" => 1])->get();
        if ($nearby) {
            $data['nearby'] = [];
            $i = 0;
            foreach ($nearby as $near) {
                $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $near->id)->get();
                $data['nearby'][$i]['id'] = $near->id;
                $data['nearby'][$i]['name'] = $near->name;
                $data['nearby'][$i]['description'] = $near->description;
                $data['nearby'][$i]['distance'] = $near->distance_from_resort;
                $data['nearby'][$i]['precautions'] = $near->precautions;
                $data['nearby'][$i]['address'] = $near->address_1;
                $data['nearby'][$i]['latitude'] = "28.608510";
                $data['nearby'][$i]['longitude'] = "77.347370";
                if ($nearbyImages) {
                    $j = 0;
                    foreach ($nearbyImages as $nearbyImage) {
                        $data['nearby'][$i]['images'][$j]['id'] = $nearbyImage->id;
                        $data['nearby'][$i]['images'][$j]['banner_image_url'] = $nearbyImage->name;
                        $j++;
                    }
                } else {
                    $data['nearby'][$i]['images'][$j] = [];
                }
                $i++;
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Nearby places found.";
            $response['data'] = $data;
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Nearby places not found.";
            $response['data'] = ["nearby" => []];
            return $this->jsonData($response);
        }
     }
    }

}
