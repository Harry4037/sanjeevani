<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\offer;

class OfferController extends Controller {

    /**
     * @api {get} /api/activities-list  Activity listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetActivitiesList
     * @apiGroup Activity
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Activities found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Activities found.",
     *    "data": [
     *        {
     *            "id": 2,
     *            "name": "Activity",
     *            "description": "<p>tretretwfdsf</p>\r\n\r\n<p>gffdwerew</p>",
     *            "address": "sector 62, Noida, UP",
     *            "latitude": "28.608510",
     *            "longitude": "77.347370",
     *            "is_booking_avaliable": true,
     *            "activity_images": [
     *                {
     *                    "id": 2,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/activity_images/ekD0YEH9vfWaSqFIyeufWzroj3MmH2HMQOJHwGNV.jpeg",
     *                    "amenity_id": 2
     *                }
     *            ]
     *        }
     *    ]
     * }
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Resort id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function offerListing(Request $request) {
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort id missing", (object) []);
        }
        $offers = offer::where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
                    'offerImages' => function($query) {
                        $query->select('id', 'image_name as banner_image_url', 'offer_id');
                    }
                ])->get();
        dd($offers);
        if (count($amenities) > 0) {
            foreach ($amenities as $key => $amenity) {
                $slots = ActivityTimeSlot::where('amenity_id', $amenity->id)->count();
                $dataArray[$key] = $amenity;
                $dataArray[$key]['address'] = "sector 62, Noida, UP";
                $dataArray[$key]['latitude'] = "28.608510";
                $dataArray[$key]['longitude'] = "77.347370";
                $dataArray[$key]['is_booking_avaliable'] = $slots > 0 ? true : false;
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Activities found.";
            $response['data'] = $dataArray;
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Activities not found.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
    }

}
