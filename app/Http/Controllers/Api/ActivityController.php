<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Activity;
use App\Models\ActivityTimeSlot;
use App\Models\ActivityRequest;
use App\Models\User;

class ActivityController extends Controller {

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
    public function activitiesListing(Request $request) {
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort id missing", (object) []);
        }
        $amenities = Activity::select('id', 'name', 'description', 'address', 'latitude', 'longitude')->where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
                    'activityImages' => function($query) {
                        $query->select('id', 'image_name as banner_image_url', 'amenity_id');
                    }
                ])->get();

        if (count($amenities) > 0) {
            foreach ($amenities as $key => $amenity) {
                $slots = ActivityTimeSlot::where('amenity_id', $amenity->id)->count();
                $dataArray[$key] = $amenity;
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

    /**
     * @api {post} /api/book-activities  Activity Booking
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostActivityBooking
     * @apiGroup Activity
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} resort_id Resort id*.
     * @apiParam {String} activity_id Amenity id*.
     * @apiParam {String} booking_date Booking date (dd/mm/yyyy).
     * @apiParam {String} from_time From Time (24 hours format).
     * @apiParam {String} to_time To Time (24 hours format).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Activity booking created
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Activity booking created",
     *    "data": {}
     * }
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "user id missing.",
     *    "data": {}
     * } 
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "resort id missing.",
     *    "data": {}
     * } 
     * 
     * @apiError ActivityIdMissing The amenity is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "activity id missing.",
     *    "data": {}
     * } 
     * 
     * @apiError BooingDateMissing The booking date is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "booking date id missing.",
     *    "data": {}
     * } 
     * 
     * @apiError FromTimeMissing The From time is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "From time missing.",
     *    "data": {}
     * } 
     * 
     * @apiError ToTimeMissing The To time is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "To time missing.",
     *    "data": {}
     * } 
     * 
     */
    public function bookAmenities(Request $request) {
        if (!$request->user_id) {
            return $this->sendErrorResponse("user id missing.", (object) []);
        }
         if(!$this->bookBeforeCheckInDate($request->user_id)){
              return $this->sendErrorResponse("Sorry! You can not raised request before checkIn date or after checkout date.", (object) []);   
            }
        if (!$request->resort_id) {
            return $this->sendErrorResponse("resort id missing.", (object) []);
        }
        if (!$request->activity_id) {
            return $this->sendErrorResponse("activity id missing.", (object) []);
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
        $amenity = Activity::find($request->activity_id);
        if (!$amenity) {
            return $this->sendErrorResponse("Invalid activity.", (object) []);
        }
        $book_date = Carbon::parse($request->booking_date);
        $timeSlot = ActivityTimeSlot::where(["from" => $request->from_time, "to" => $request->to_time])->first();
        if ($timeSlot) {
            $booking = ActivityRequest::where([
                        "user_id" => $request->user_id,
                        "amenity_id" => $request->activity_id,
                        "booking_date" => $book_date->format('Y-m-d'),
                        "from" => $request->from_time,
                        "to" => $request->to_time,
                    ])->count();
            if ($booking > 0) {
                return $this->sendErrorResponse("Booking already created with these details", (object) []);
            } else {
                $bookingRequest = new ActivityRequest();
                $bookingRequest->amenity_id = $request->activity_id;
                $bookingRequest->user_id = $request->user_id;
                $bookingRequest->booking_date = $book_date->format('Y-m-d');
                $bookingRequest->from = $request->from_time;
                $bookingRequest->to = $request->to_time;
                if ($bookingRequest->save()) {
                    $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2])->pluck("device_token")->toArray();
                    $this->androidPushNotification(2, "Booked Activity", "$amenity->name booked by customer", $staffDeviceTokens, 1, $request->activity_id);

                    return $this->sendSuccessResponse("We look forward to serve you.", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            }
        } else {
            return $this->sendErrorResponse("Invalid time slot", (object) []);
        }
    }

    /**
     * @api {get} /api/activity-time-slots  Activity Time slots
     * @apiHeader {String} Accept application/json. 
     * @apiName GetActivityTimeSlots
     * @apiGroup Activity
     * 
     * @apiParam {String} activity_id Activity id*.
     * @apiParam {String} booking_date Booking date (yyyy/mm/dd).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Activity time slots
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
     *            "id": 3,
     *            "from": "00:00:00",
     *            "to": "01:00:00",
     *            "is_booking_available": true
     *        },
     *        {
     *            "id": 4,
     *            "from": "02:00:00",
     *            "to": "03:00:00",
     *            "is_booking_available": true
     *        }
     *    ]
     * }
     * 
     * 
     * @apiError ActivityIdMissing The activity is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "activity id missing.",
     *    "data": {}
     * } 
     * 
     * @apiError BooingDateMissing The booking date is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "booking date id missing.",
     *    "data": {}
     * } 
     * 
     */
    public function activityTimeSlots(Request $request) {
        if (!$request->activity_id) {
            return $this->sendErrorResponse("activity id missing.", (object) []);
        }
        if (!$request->booking_date) {
            return $this->sendErrorResponse("booking date missing.", (object) []);
        }

        $amenity = Activity::find($request->activity_id);
        if (!$amenity) {
            return $this->sendErrorResponse("Invalid activity.", (object) []);
        }
        $amenityTimeSlots = ActivityTimeSlot::select('id', 'from', 'to', 'allow_no_of_member')->where([
                    "amenity_id" => $request->activity_id
                ])->get();
        if ($amenityTimeSlots) {
            $slotArray = [];
            foreach ($amenityTimeSlots as $key => $amenityTimeSlot) {
                $bookings = ActivityRequest::where([
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
