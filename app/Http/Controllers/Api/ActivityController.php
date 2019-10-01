<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Activity;
use App\Models\ActivityTimeSlot;
use App\Models\ActivityRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Resort;

class ActivityController extends Controller {

    /**
     * @api {get} /api/activities-list  Activity listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetActivitiesList
     * @apiGroup Activity
     * 
     * @apiParam {String} resort_id Resort Id* (For guest user use resort id value -1).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Activities found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Activities found.",
     *       "data": [
     *           {
     *               "id": 8,
     *               "name": "Running",
     *               "description": "<p>If you like to run, then we&#39;re throwing down a challenge to see who the best runners are. Simply pick up a biometric wristband at the new Porto Sani gym and off you go. When you return from your run we&#39;ll upload the stats onto our computer and make a leader board to show the ranking of all our runners. The challenge is open to all our guests over 16 years old.We will reward the three best runners with personal training sessions and valuable spa credits.</p>",
     *               "address": "Dehradun | Uttarakhand | India",
     *               "latitude": 19.53,
     *               "longitude": 57.524848,
     *               "is_booking_avaliable": true,
     *               "activity_images": [
     *                   {
     *                       "id": 23,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/activity_images/3HNmS1PqIBpOWHM7z02hmzLNQvf3F8aoyw7SdGhd.jpeg",
     *                       "amenity_id": 8
     *                   },
     *                   {
     *                       "id": 24,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/activity_images/fUyFGNmOrnHlBYvTTeIfrbmbOzSVJh3dZ9kxBzuy.jpeg",
     *                       "amenity_id": 8
     *                   }
     *               ]
     *           },
     *           {
     *               "id": 9,
     *               "name": "Yoga",
     *               "description": "<p>Start a day with morning yoga to balance body and soul at roof top Yoga pavilion while enjoy the cool morning breeze, a warm sunrise entering every space of the jungle leaves. Yoga is ancient art based on a harmonizing system of development for the body, mind, and spirit. The continued practice of yoga will lead to a sense of peace and well-being, and also a feeling of being at one with their environment that help to harmonize human consciousness with the divine consciousness.</p>",
     *               "address": "Dehradun | Uttarakhand | India",
     *               "latitude": 19.53,
     *               "longitude": 57.524848,
     *               "is_booking_avaliable": true,
     *               "activity_images": [
     *                   {
     *                       "id": 25,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/activity_images/bsAmNB1gLB2Z3QDD3KHK9si6sow6guVrwerOv10R.jpeg",
     *                       "amenity_id": 9
     *                   },
     *                   {
     *                       "id": 26,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/activity_images/bMdjvCYdRpexlenEW2WKSiRqYVkXTTj8e8TZVSDT.jpeg",
     *                       "amenity_id": 9
     *                   }
     *               ]
     *           },
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
    public function activitiesListing(Request $request) {

        if ($request->resort_id == -1) {
            $resortId = 0;
            $defaultResort = Resort::where("is_default", 1)->first();
            if ($defaultResort) {
                $resortId = $defaultResort->id;
            } else {
                $defaultResort = Resort::query()->first();
                $resortId = $defaultResort->id;
            }

            $amenities = Activity::select('id', 'name', 'description', 'address', 'latitude', 'longitude')->where(["is_active" => 1, "resort_id" => $resortId])->with([
                        'activityImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'amenity_id');
                        }
                    ])->get();
        } else {
            $amenities = Activity::select('id', 'name', 'description', 'address', 'latitude', 'longitude')->where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
                        'activityImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'amenity_id');
                        }
                    ])->get();
        }

        if (count($amenities) > 0) {
            foreach ($amenities as $key => $amenity) {
                $amenity = $amenity->toArray();
                $slots = ActivityTimeSlot::where('amenity_id', $amenity['id'])->count();
                $dataArray[$key] = $amenity;
                if (count($amenity['activity_images']) > 0) {
                    $dataArray[$key]['activity_images'] = $amenity['activity_images'];
                } else {
                    $dataArray[$key]['activity_images'][0] = [
                        'id' => 0,
                        'banner_image_url' => asset('img/image_loader.png')
                    ];
                }
                $dataArray[$key]['is_booking_avaliable'] = $slots > 0 ? true : false;
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Activities found.";
            $response['data'] = $dataArray;
            return $this->jsonData($response);
        } else {
            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Activities not found.";
            $response['data'] = [];
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
     * @apiParam {String} booking_date Booking date* (DD/MM/YYYY).
     * @apiParam {String} from_time From Time* (24 hours format).
     * @apiParam {String} to_time To Time* (24 hours format).
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
        if (!$this->bookBeforeCheckInDate($request->user_id)) {
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

        $userBooking = User::with('userBookingDetail')->find($request->user_id);
        if ($userBooking->is_active == 0) {
            return $this->sendInactiveAccountResponse();
        }
        $amenity = Activity::find($request->activity_id);
        if (!$amenity) {
            return $this->sendErrorResponse("Invalid activity.", (object) []);
        }
        if (isset($userBooking->userBookingDetail)) {
            $user_book_date = Carbon::parse($userBooking->userBookingDetail->check_out)->format("Y/m/d");
            $user_book_time = Carbon::parse($userBooking->userBookingDetail->check_out)->format("H:i:s");

            if (strtotime($request->booking_date) > strtotime($user_book_date)) {
                return $this->sendErrorResponse("You can't book amenity after your checkout date.", (object) []);
            } elseif (strtotime($request->booking_date) == strtotime($user_book_date)) {
                if (strtotime($request->to_time) > strtotime($user_book_time)) {
                    return $this->sendErrorResponse("You can't book amenity after checkout time.", (object) []);
                }
            } else {
                
            }
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
                $user = User::select('id', 'user_name', 'mobile_number', 'email_id', 'voter_id', 'aadhar_id', 'address1', 'city_id', 'user_type_id')
                        ->where(["id" => $request->user_id])
                        ->with([
                            'userBookingDetail'
//                            => function($query) {
//                                $query->selectRaw(DB::raw('id, resort_room_no, room_type_id, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%b-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%b-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time'));
//                            }
                        ])
                        ->first();

                $bookingRequest = new ActivityRequest();
                $bookingRequest->amenity_id = $request->activity_id;
                $bookingRequest->room_no = isset($user->userBookingDetail->resort_room_no) ? $user->userBookingDetail->resort_room_no : "";
                $bookingRequest->activity_name = $amenity->name;
                $bookingRequest->resort_id = $request->resort_id;
                $bookingRequest->user_id = $request->user_id;
                $bookingRequest->booking_date = $book_date->format('Y-m-d');
                $bookingRequest->from = $request->from_time;
                $bookingRequest->to = $request->to_time;
                if ($bookingRequest->save()) {
//                    $tokens = [];
//                    $l = 0;
//                    $staffs = User::where(["is_active" => 1, "user_type_id" => 2])->get();
//                    foreach ($staffs as $staff) {
//                        $amenityArray = explode("#", $staff->authorise_amenities_id);
//                        if (in_array($request->amenity_id, $amenityArray) && ($staff->device_token != "")) {
//                            $tokens[$l] = $staff->device_token;
//                            $l++;
//                        }
//                    }
//                    if ($tokens) {
//                        $this->androidPushNotification(2, "Amenity Booked", "$amenity->name booked by " . $request->user()->user_name . " for " . $book_date->format('d M'), $tokens, 1, $request->amenity_id, 1);
//                    }
                    $this->generateNotification($request->user()->id, "Activity Booked", "Your $amenity->name booking is confirmed" . " for " . $book_date->format('d M'), 2);
                    if ($request->user()->device_token) {
                        $this->androidPushNotification(3, "Activity Booked", "Your $amenity->name booking is confirmed" . " for " . $book_date->format('d M'), $request->user()->device_token, 3, $bookingRequest->id, $this->notificationCount($request->user()->id));
                    }
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
     * @apiParam {String} booking_date Booking date* (YYYY/MM/DD).
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

        $query = ActivityTimeSlot::query();
        $query->select('id', 'from', 'to', 'allow_no_of_member');
        $query->where([
            "amenity_id" => $request->activity_id
        ]);
        if (strtotime($request->booking_date) == strtotime(date("Y-m-d"))) {
            $query->where("from", ">", date("H:i:s"));
        }
        $amenityTimeSlots = $query->orderby("from", "ASC")->get();
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
