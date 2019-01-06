<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Amenity;
use App\Models\AmenityTimeSlot;
use App\Models\AmenityRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Anemities found.",
     *    "data": [
     *        {
     *            "id": 1,
     *            "name": "Gym",
     *            "description": "<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Opening Timings</strong>:-</p>\r\n\r\n<p>9:00 AM to 11:00 AM</p>\r\n<p>5:00 PM to 7:00 PM</p>\r\n",
     *            "address": "sector 62, Noida, UP",
     *            "is_booking_avaliable": false,
     *            "amenity_images": [
     *                {
     *                    "id": 1,
     *                    "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/amenities_images/ptjHTnrFSngDDbqO20ZHl4YDy035S0z1cIuop8EC.jpeg",
     *                    "amenity_id": 1
     *                },
     *                {
     *                    "id": 2,
     *                    "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/amenities_images/xQvt0XF682PO9gzaA05gTB2MQKP0ZH62XYGsgn2i.jpeg",
     *                    "amenity_id": 1
     *                }
     *            ]
     *        },
     *        {
     *            "id": 2,
     *            "name": "SPA",
     *            "description": "<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Timings</strong>:-</p>\r\n\r\n<p>9:00 AM to 10:00 AM</p>\r\n<p>4:00 PM to 5:00 PM</p>\r\n",
     *            "address": "sector 62, Noida, UP",
     *            "is_booking_avaliable": true,
     *            "amenity_images": [
     *                {
     *                    "id": 3,
     *                    "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/amenities_images/NqHeZs8Qw9gIyuRNNg3YgtD3JrS0Cx5QH8OmYaAy.jpeg",
     *                    "amenity_id": 2
     *                },
     *                {
     *                    "id": 4,
     *                    "banner_image_url": "http://sanjeevani.dbaquincy.com/storage/amenities_images/kVkodMPi1Y5QfPKeOjY8LXbf0tiKoOS4sHbaQOMu.jpeg",
     *                    "amenity_id": 2
     *                }
     *            ]
     *        }
     *    ]
     *}
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
        $amenities = Amenity::select('id', 'name', 'description', 'address')->where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
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
                    $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2])->pluck("device_token")->toArray();
                    $this->androidPushNotification(2, "Booked Amenity", "$amenity->name booked by customer", $staffDeviceTokens, 1, $request->amenity_id);
                    
                    return $this->sendSuccessResponse("Anemity booking created", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            }
        } else {
            return $this->sendErrorResponse("Invalid time slot", (object) []);
        }
    }

    /**
     * @api {get} /api/amenities-time-slots  Amenities Time slots
     * @apiHeader {String} Accept application/json. 
     * @apiName GetAmenityTimeSlots
     * @apiGroup Amenities
     * 
     * @apiParam {String} amenity_id Amenity id*.
     * @apiParam {String} booking_date Booking date (yyyy/mm/dd).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Anemity time slots
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "time slots",
     *    "data": [
     *        {
     *            "id": 1,
     *            "from": "09:00:00",
     *            "to": "10:00:00",
     *            "is_booking_available": false
     *        },
     *        {
     *            "id": 2,
     *            "from": "10:00:00",
     *            "to": "11:00:00",
     *            "is_booking_available": true
     *        }
     *    ]
     * }
     * 
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
     */
    public function amenityTimeSlots(Request $request) {
        if (!$request->amenity_id) {
            return $this->sendErrorResponse("amenity id missing.", (object) []);
        }
        if (!$request->booking_date) {
            return $this->sendErrorResponse("booking date missing.", (object) []);
        }

        $amenity = Amenity::find($request->amenity_id);
        if (!$amenity) {
            return $this->sendErrorResponse("Invalid amenity.", (object) []);
        }
        $amenityTimeSlots = AmenityTimeSlot::select(DB::raw('id, DATE_FORMAT(from, "%h:%i %a") as from, DATE_FORMAT(to, "%h:%i %a") as to, allow_no_of_member')->where([
                    "amenity_id" => $request->amenity_id
                ])->get();
        if ($amenityTimeSlots) {
            $slotArray = [];
            foreach ($amenityTimeSlots as $key => $amenityTimeSlot) {
                $bookings = AmenityRequest::where([
                            "booking_date" => $request->booking_date,
                            "from" => $amenityTimeSlot->from,
                            "to" => $amenityTimeSlot->to,
                        ])->count();
                $flag = true;
                if ($bookings >= $amenityTimeSlot->allow_no_of_member) {
                    $flag = false;
                }

                $slotArray[$key]['id'] = $amenityTimeSlot->id;
                $slotArray[$key]['from'] = $amenityTimeSlot->from;
                $slotArray[$key]['to'] = $amenityTimeSlot->to;
                $slotArray[$key]['is_booking_available'] = $flag;
            }
            return $this->sendSuccessResponse("time slots", $slotArray);
        } else {
            return $this->sendErrorResponse("No time slot available for booking", (object) []);
        }
    }

}
