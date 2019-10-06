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
use App\Models\Resort;

class AmenityController extends Controller {

    /**
     * @api {get} /api/amenities-list  Amenities listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetAmenitiesList
     * @apiGroup Amenities
     * 
     * @apiParam {String} resort_id Resort Id* (For guest user use resort id value -1).
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
     *               "name": "Gym",
     *               "description": "<hr />\r\n<p>The Sanjeevani Health Club encompasses 117 square metres (1,259 square feet) of dedicated workout space with a wide range of state-of-the-art equipment. Facilities include an exercise room, sauna, steam rooms for men and women, sunlit pool, cardiovascular machines and free weights. Certified trainers are available upon request to help guests get the most out of their workouts.</p>\r\n\r\n<p>Keep up with your fitness routine whilst you&rsquo;re away with our free hotel gym. Packed with cardio and resistance equipment and free weights, you can unwind after a busy day in the capital at the Sanjeevani Resort</p>\r\n\r\n<p><strong>Highlights</strong></p>\r\n\r\n<p>&bull; Cross-trainer and treadmills<br />\r\n&bull; Stationary bikes and rowing machine<br />\r\n&bull; Free weights area<br />\r\n&bull; Floor-to-ceiling mirrors<br />\r\n&bull; Healthy snacks and juices available at&nbsp;Sacred Caf&eacute;</p>\r\n\r\n<p><strong>Gym facilities</strong></p>\r\n\r\n<p>All guests over the age of 16 who visit the Sanjeevani Resort are invited to use our in-house hotel gym to exercise and unwind.</p>\r\n\r\n<p>With a mix of equipment and weights, our hotel gym will cater to you whether you want to do a cardio workout, or if you want to give your muscles some strength training or toning exercises.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Timings Morning&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong><strong>Timings Evening</strong></p>\r\n\r\n<p><strong>4:00AM - 5:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4:30PM - 6:00PM</strong></p>\r\n\r\n<p><strong>5:30AM - 7:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6:00PM - 7:30PM</strong></p>\r\n\r\n<p><strong>7:00AM - 8:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7:30PM - 9:00PM</strong></p>\r\n\r\n<p><strong>8:30AM - 10:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;9:00PM - 10:30PM</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<hr />\r\n<p>The Sanjeevani Health Club encompasses 117 square metres (1,259 square feet) of dedicated workout space with a wide range of state-of-the-art equipment. Facilities include an exercise room, sauna, steam rooms for men and women, sunlit pool, cardiovascular machines and free weights. Certified trainers are available upon request to help guests get the most out of their workouts.</p>\r\n\r\n<p>Keep up with your fitness routine whilst you&rsquo;re away with our free hotel gym. Packed with cardio and resistance equipment and free weights, you can unwind after a busy day in the capital at the Sanjeevani Resort</p>\r\n\r\n<p>&nbsp;</p>",
     *               "address": "Horawala | Dehradoon | Uttarakhand-248197",
     *               "is_booking_avaliable": true,
     *               "amenity_images": [
     *                   {
     *                       "id": 19,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/amenity_images/a17xfSfM9pwtUzHxGksYEJvEWtvjDluB4HXH9B3Y.jpeg",
     *                       "amenity_id": 1
     *                   },
     *                   {
     *                       "id": 20,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/amenity_images/0xnhuoEd3bH6fjeY0BaD9Sfn1orxtcjndWx1PFoq.jpeg",
     *                       "amenity_id": 1
     *                   }
     *               ]
     *           },
     *           {
     *               "id": 2,
     *               "name": "SPA",
     *               "description": "<p>If it&rsquo;s been a hard day&rsquo;s night, relax and rejuvenate at our decadent Spa. Our on-site spa offers signature Hard Rock swagger in a sophisticated and modern spa environment, catering to your every need. You can also take advantage of our full-service spa menu offered right in your suite. Whether you need a post-party facial or a poolside massage, you&rsquo;re already on our VIP list.</p>\r\n\r\n<p>Sanjeevani is the best of Dehradoon City spa hotels, with a huge menu of signature massages, baths, body treatments, facials, and other beauty services. There&rsquo;s something for every member of the family with treatments designed specifically for men, women, kids, and teens.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Timings Mornings&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Timings Evenings</strong></p>\r\n\r\n<p><strong>4:00AM - 5:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;4:30PM - 6:00PM</strong></p>\r\n\r\n<p><strong>5:30AM - 7:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6:00PM - 7:30PM</strong></p>\r\n\r\n<p><strong>7:00AM - 8:30AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;7:30PM - 9:00PM</strong></p>\r\n\r\n<p><strong>8:30AM - 10:00AM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;9:00PM - 10:30PM</strong></p>",
     *               "address": "Horawala | Dehradoon| Uttrakhand-248197",
     *               "is_booking_avaliable": true,
     *               "amenity_images": [
     *                   {
     *                       "id": 17,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/amenity_images/QKYvWDznmpjcuowP9UsHMPKm6ruJ8h9pgCtN94Ub.jpeg",
     *                       "amenity_id": 2
     *                   },
     *                   {
     *                       "id": 18,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/amenity_images/3KIITP6paeE66HhJjNMQlrXERLTPw747z8alN5sb.png",
     *                       "amenity_id": 2
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
    public function amenitiesListing(Request $request) {
        if (!$request->resort_id) {
            $response['success'] = false;
            $response['status_code'] = 404;
            $response['message'] = "Resort id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if ($request->resort_id == -1) {
            $resortId = 0;
            $defaultResort = Resort::where("is_default", 1)->first();
            if ($defaultResort) {
                $resortId = $defaultResort->id;
            } else {
                $defaultResort = Resort::query()->first();
                $resortId = $defaultResort->id;
            }

            $amenities = Amenity::select('id', 'name', 'description', 'address')->where(["is_active" => 1, "resort_id" => $resortId])->with([
                        'amenityImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'amenity_id');
                        }
                    ])->get();
        } else {
            $amenities = Amenity::select('id', 'name', 'description', 'address')->where(["is_active" => 1, "resort_id" => $request->resort_id])->with([
                        'amenityImages' => function($query) {
                            $query->select('id', 'image_name as banner_image_url', 'amenity_id');
                        }
                    ])->get();
        }

        if (count($amenities) > 0) {
            foreach ($amenities as $key => $amenity) {
                $amenity = $amenity->toArray();
                $slots = AmenityTimeSlot::where('amenity_id', $amenity['id'])->count();
                $dataArray[$key] = $amenity;
                if (count($amenity['amenity_images']) > 0) {
                    $dataArray[$key]['amenity_images'] = $amenity['amenity_images'];
                } else {
                    $dataArray[$key]['amenity_images'][0] = [
                        'id' => 0,
                        'banner_image_url' => asset('img/image_loader.png')
                    ];
                }
                $dataArray[$key]['is_booking_avaliable'] = $slots > 0 ? true : false;
            }

            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Anemities found.";
            $response['data'] = $dataArray;
            return $this->jsonData($response);
        } else {
            $response['success'] = true;
            $response['status_code'] = 200;
            $response['message'] = "Anemities not found.";
            $response['data'] = [];
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
     * @apiParam {String} booking_date Booking date* (DD/MM/YYYY).
     * @apiParam {String} from_time From Time* (24 hours format).
     * @apiParam {String} to_time To Time* (24 hours format).
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
        if (!$this->bookBeforeCheckInDate($request->user_id)) {
            return $this->sendErrorResponse("Sorry! You can not raised request before checkIn date or after checkout date.", (object) []);
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

        $userBooking = User::with('userBookingDetail')->find($request->user_id);
        if ($userBooking->is_active == 0) {
            return $this->sendInactiveAccountResponse();
        }
        $amenity = Amenity::find($request->amenity_id);
        if (!$amenity) {
            return $this->sendErrorResponse("Invalid amenity.", (object) []);
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
                $user = User::select('id', 'user_name', 'mobile_number', 'email_id', 'voter_id', 'aadhar_id', 'address1', 'city_id', 'user_type_id')
                        ->where(["id" => $request->user_id])
                        ->with([
                            'userBookingDetail'
//                            => function($query) {
//                                $query->selectRaw(DB::raw('id, resort_room_no, room_type_id, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%b-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%b-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time'));
//                            }
                        ])
                        ->first();

                $bookingRequest = new AmenityRequest();
                $bookingRequest->amenity_id = $request->amenity_id;
                $bookingRequest->room_no = isset($user->userBookingDetail->resort_room_no) ? $user->userBookingDetail->resort_room_no : "";
                $bookingRequest->resort_id = $request->resort_id;
                $bookingRequest->amenity_name = $amenity->name;
                $bookingRequest->user_id = $request->user_id;
                $bookingRequest->booking_date = $book_date->format('Y-m-d');
                $bookingRequest->from = $request->from_time;
                $bookingRequest->to = $request->to_time;
                if ($bookingRequest->save()) {
                    $tokens = [];
                    $l = 0;
                    $staffs = User::where(["is_active" => 1, "user_type_id" => 2, "is_push_on" => 1])->get();
                    foreach ($staffs as $staff) {
                        $amenityArray = explode("#", $staff->authorise_amenities_id);
                        if (in_array($request->amenity_id, $amenityArray) && ($staff->device_token != "")) {
                            $tokens[$l] = $staff->device_token;
                            $l++;
                        }
                    }
                    $from = Carbon::parse($bookingRequest->from);
                    if ($tokens) {
                        $this->androidPushNotification(2, "Amenity Booked", "$amenity->name booked by " . $request->user()->user_name . " for " . $book_date->format('d M'). " at " . $from->format("h:i a"), $tokens, 1, $request->amenity_id, 1);
                    }
                    $this->generateNotification($request->user()->id, "Amenity Booked", "Your $amenity->name booking is confirmed" . " for " . $book_date->format('d M'). " at " . $from->format("h:i a"), 3);
                    if ($request->user()->device_token) {
                        
                        $this->androidPushNotification(3, "Amenity Booked", "Your $amenity->name booking is confirmed" . " for " . $book_date->format('d M') . " at " . $from->format("h:i a"), $request->user()->device_token, 3, $bookingRequest->id, $this->notificationCount($request->user()->id));
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
        $query = AmenityTimeSlot::query();
        $query->select('id', 'from', 'to', 'allow_no_of_member');
        $query->where([
            "amenity_id" => $request->amenity_id
        ]);
        if (strtotime($request->booking_date) == strtotime(date("Y-m-d"))) {
            $query->where("from", ">", date("H:i:s"));
        }
        $amenityTimeSlots = $query->orderby("from", "ASC")->get();
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
