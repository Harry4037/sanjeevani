<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Amenity;
use App\Models\AmenityTimeSlot;
use App\Models\AmenityRequest;

class AmenityController extends Controller {

    /**
     * @api {get} /api/amenities-list  Amenities listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetAmenitiesList
     * @apiGroup Amenities
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Anemities found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Anemities found.",
     *       "data": [
     *           {
     *               "id": 1,
     *               "name": "SPA",
     *               "description": "<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Timings</strong>:-</p>\r\n\r\n<p>9:00 AM to 5:00 PM</p>\r\n",
     *               "is_booking_avaliable": true,
     *               "amenity_images": [
     *                   {
     *                       "id": 1,
     *                       "image_name": "http://127.0.0.1:8000/storage/amenities_images/z9HSMKf5VNM5XeBU9UGtBZ8EYgcLvcEAMPDkZXGq.jpeg",
     *                       "amenity_id": 1
     *                   },
     *                   {
     *                       "id": 2,
     *                       "image_name": "http://127.0.0.1:8000/storage/amenities_images/z9HSMKf5VNM5XeBU9UGtBZ8EYgcLvcEAMPDkZXGq.jpeg",
     *                       "amenity_id": 1
     *                   }
     *               ]
     *           }
     *       ]
     *   }
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
    public function amenitiesListing(Request $request) {
        if (!$request->resort_id) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Resort id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $amenities = Amenity::select('id', 'name', 'description')->where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
                    'amenityImages' => function($query) {
                        $query->select('id', 'image_name as banner_image_url', 'amenity_id');
                    }
                ])->get();

        if (count($amenities) > 0) {
            foreach ($amenities as $key => $amenity) {
                $slots = AmenityTimeSlot::where('amenity_id', $amenity->id)->count();
                $dataArray[$key] = $amenity;
                $dataArray[$key]['is_booking_avaliable'] = $slots > 0 ? true : false;
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Anemities found.";
            $response['data'] = $dataArray;
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Anemities not found.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
    }

    /**
     * @api {post} /api/book-amenities  Amenities Booking
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostAmenitiesBooking
     * @apiGroup Amenities
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} resort_id Resort id*.
     * @apiParam {String} amenity_id Amenity id*.
     * @apiParam {String} booking_date Booking date (dd/mm/yyyy).
     * @apiParam {String} from_time From Time (24 hours format).
     * @apiParam {String} to_time To Time (24 hours format).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Anemity booking created
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Anemity booking created",
     *       "data": {}
     *   }
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "user id missing.",
     *       "data": {}
     *   } 
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "resort id missing.",
     *       "data": {}
     *   } 
     * 
     * @apiError AmenityIdMissing The amenity is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "amenity id missing.",
     *       "data": {}
     *   } 
     * 
     * @apiError BooingDateMissing The booking date is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "booking date id missing.",
     *       "data": {}
     *   } 
     * 
     * @apiError FromTimeMissing The From time is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "From time missing.",
     *       "data": {}
     *   } 
     * 
     * @apiError ToTimeMissing The To time is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "To time missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function bookAmenities(Request $request) {
        if (!$request->user_id) {
            return $this->sendErrorResponse("user id missing.", (object) []);
        }
        if (!$request->resort_id) {
            return $this->sendErrorResponse("resort id missing.", (object) []);
        }
        if (!$request->amenity_id) {
            return $this->sendErrorResponse("amenity id missing.", (object) []);
        }
        if ($request->user_id != $request->user()->id) {
            return $this->sendErrorResponse("Unauthorized user.", (object) []);
        }
        if (!$request->booking_date) {
            return $this->sendErrorResponse("booking date missing", (object) []);
        }
        if (!$request->from_time) {
            return $this->sendErrorResponse("From time is missing", (object) []);
        }
        if (!$request->to_time) {
            return $this->sendErrorResponse("To time is missing.", (object) []);
        }
        $amenity = Amenity::find($request->amenity_id);
        if (!$amenity) {
            return $this->sendErrorResponse("Invalid amenity.", (object) []);
        }
        $book_date = Carbon::parse($request->booking_date);
        $timeSlot = AmenityTimeSlot::where(["from" => $request->from_time, "to" => $request->to_time])->first();
        if ($timeSlot) {
            $booking = AmenityRequest::where([
                        "user_id" => $request->user_id,
                        "amenity_id" => $request->amenity_id,
                        "booking_date" => $book_date->format('Y-m-d'),
                        "from" => $request->from_time,
                        "to" => $request->to_time,
                    ])->count();
            if ($booking > 0) {
                return $this->sendErrorResponse("Booking already created with these details", (object) []);
            } else {
                $bookingRequest = new AmenityRequest();
                $bookingRequest->amenity_id = $request->amenity_id;
                $bookingRequest->user_id = $request->user_id;
                $bookingRequest->booking_date = $book_date->format('Y-m-d');
                $bookingRequest->from = $request->from_time;
                $bookingRequest->to = $request->to_time;
                if ($bookingRequest->save()) {
                    return $this->sendSuccessResponse("Anemity booking created", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            }
        } else {
            return $this->sendErrorResponse("Invalid time slot", (object) []);
        }
    }

}
