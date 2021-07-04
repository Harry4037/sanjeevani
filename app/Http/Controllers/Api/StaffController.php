<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Resort;
use App\Models\ServiceRequest;
use App\Models\MealOrder;
use App\Models\MealOrderItem;
use App\Models\MealItem;
use App\Models\Amenity;
use App\Models\AmenityRequest;
use App\Models\AmenityTimeSlot;
use App\Models\User;
use App\Models\UserBookingDetail;
use App\Models\BookingpeopleAccompany;
use App\Models\Service;
use App\Models\AmenityImage;
use App\Models\RoomType;
use App\Models\ResortRoom;
use App\Models\UserhealthDetail;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller {

    /**
     * @api {get} /api/service-request-list Service Request Listing
     * @apiHeader {String} Accept application/json.
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostServicerequestlist
     * @apiGroup Staff Service
     * 
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Service request found..
     * @apiSuccess {JSON}   data Array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Service request found.",
     *    "data": {
     *            "services": [
     *               {
     *                    "id": 1,
     *                    "service_name": "Do Not Disturbe",
     *                    "service_comment": "",
     *                    "service_icon": "http://127.0.0.1:8000/storage/Service_icon/XfNlJoZ3L4Pj0dbM8lJIyIXtkqTK4FXaANlUwwOo.jpeg",
     *                    "user_name": "Hariom Gangwar",
     *                    "room_no": "300",
     *                    "created_at": "17:11 pm"
     *                }
     *            ],
     *        "meal_orders": [
     *            {
     *                "id": 1,
     *                "invoice_id": "1544634201",
     *                "item_total_amount": 240.6,
     *                "gst_amount": 0,
     *                "total_amount": 240.6,
     *                "user_name": "Hariom Gangwar",
     *                "room_no": "300",
     *                "created_at": "17:03 pm",
     *                "meal_item_count": 1,
     *                "meal_items": [
     *                    {
     *                        "id": 1,
     *                        "meal_item_name": "sadsad",
     *                        "price": 120,
     *                        "quantity": 2,
     *                        "image_url": ""
     *                    }
     *                ]
     *            }
     *        ],
     *       "amenities": [
     *           {
     *               "id": 2,
     *               "name": "sadsaGym",
     *               "icon": null,
     *               "booking_count": 1
     *           },
     *           {
     *               "id": 1,
     *               "name": "Gym",
     *               "icon": null,
     *               "booking_count": 0
     *           }
     *       ]
     *    }
     * }
     * 
     * 
     * @apiError ResortIdMissing The resort id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Resort id missing.",
     *    "data": {}
     * }
     * 
     * @apiError InvalidResort The resort is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "status": false,
     *   "status_code": 404,
     *   "message": "Invalid resort.",
     *   "data": {}
     * }
     * 
     * 
     */
    public function serviceRequestListing(Request $request) {
        try {
            //If user account deactivated by admin
            if ($request->user()->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }
            //If user not registered with any resort
            $userResort = UserBookingDetail::where("user_id", $request->user()->id)->first();
            if (!$userResort) {
                return $this->sendErrorResponse("User not registered with any resort.", (object) []);
            }
            //If Resort not exist in our database
            $resort = Resort::where(["id" => $userResort->resort_id])->first();
            if (!$resort) {
                return $this->sendErrorResponse("Invalid resort.", (object) []);
            }
            //If registered resort deactivated by admin.
            if ($resort->is_active == 0) {
                return $this->sendErrorResponse("Resort deactivated by admin.", (object) []);
            }

            if ($request->user()->is_push_on == 0) {
                $data["services"] = [];
                $data["meal_orders"] = [];
                $data["amenities"] = [];
                return $this->sendSuccessResponse("Service request found.", $data);
            }

            //If services & issues is authorized for user
            $serviceArray = [];
            if ($request->user()->is_service_authorise == 1) {
                $newServices = ServiceRequest::select('id', 'comment', 'questions', 'service_id', 'user_id', 'created_at', 'room_type_name', 'resort_room_no')->where(["resort_id" => $userResort->resort_id, "request_status_id" => 1])
                        ->with([
                            'serviceDetail' => function($query) {
                                $query->select('id', 'name', 'icon', 'type_id');
                            }
                        ])
                        ->with([
                            'userDetail' => function($query) {
                                $query->select('id', 'user_name', 'email_id', 'mobile_number')
                                ->with([
                                    'userBookingDetail' => function($query) {
                                        $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                    }
                                ]);
                            }
                        ])->latest()
                        ->get();

                foreach ($newServices as $k => $newService) {
                    $created_at = Carbon::parse($newService->created_at);
                    $serviceArray[$k]["id"] = $newService->id;
                    $serviceArray[$k]["service_name"] = $newService->serviceDetail ? $newService->serviceDetail->name : "";
                    $serviceArray[$k]["service_comment"] = $newService->comment;
                    $serviceArray[$k]["service_icon"] = $newService->serviceDetail ? $newService->serviceDetail->icon : "";
                    $serviceArray[$k]["user_name"] = $newService->userDetail ? $newService->userDetail->user_name : "";
                    $serviceArray[$k]["room_no"] = $newService->resort_room_no;
                    $serviceArray[$k]["date"] = $created_at->format('d-M-Y');
                    $serviceArray[$k]["time"] = $created_at->format('h:i A');
                    $serviceArray[$k]["created_at"] = $created_at->format('d-m-Y h:i a');
                    if ($newService->questions) {
                        $reasons = explode(",", $newService->questions);
                        foreach ($reasons as $l => $reason) {
                            $serviceArray[$k]["reasons"][$l]['reason'] = $reason;
                        }
                    } else {
                        $serviceArray[$k]["reasons"] = [];
                    }
                }
            }

            //If Meal order is authorized for user
            $mealDataArray = [];
            if ($request->user()->is_meal_authorise == 1) {
                $mealOrders = MealOrder::where(["resort_id" => $userResort->resort_id, "status" => 1])
                        ->with([
                            'userDetail' => function($query) {
                                $query->select('id', 'user_name', 'email_id', 'mobile_number')
                                ->with([
                                    'userBookingDetail' => function($query) {
                                        $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id', 'room_type_id', 'resort_room_id');
                                    }
                                ]);
                            }
                        ])->latest()
                        ->get();


                foreach ($mealOrders as $j => $mealOrder) {
                    $mealItems = MealOrderItem::where("meal_order_id", $mealOrder->id)->get();
                    $meal_created_at = Carbon::parse($mealOrder->created_at);
                    $mealDataArray[$j]["id"] = $mealOrder->id;
                    $mealDataArray[$j]["invoice_id"] = $mealOrder->invoice_id;
                    $mealDataArray[$j]["item_total_amount"] = $mealOrder->item_total_amount;
                    $mealDataArray[$j]["gst_amount"] = ($mealOrder->total_amount - $mealOrder->item_total_amount);
                    $mealDataArray[$j]["gst_percentage"] = $mealOrder->gst_amount;
                    $mealDataArray[$j]["total_amount"] = $mealOrder->total_amount;
                    $mealDataArray[$j]["user_name"] = $mealOrder->userDetail->user_name;
                    $mealDataArray[$j]["room_no"] = $mealOrder->resort_room_no;
                    $mealDataArray[$j]["date"] = $meal_created_at->format('d-M-Y');
                    $mealDataArray[$j]["time"] = $meal_created_at->format('h:i A');
                    $mealDataArray[$j]["created_at"] = $meal_created_at->format('d-m-Y h:i a');
                    $mealDataArray[$j]["meal_item_count"] = count($mealItems);
                    if ($mealItems) {
                        foreach ($mealItems as $f => $mealItem) {
                            $mealImage = MealItem::find($mealItem->meal_item_id);
                            $mealDataArray[$j]["meal_items"][$f]["id"] = $mealItem->id;
                            $mealDataArray[$j]["meal_items"][$f]["meal_item_name"] = $mealItem->meal_item_name;
                            $mealDataArray[$j]["meal_items"][$f]["price"] = $mealItem->price;
                            $mealDataArray[$j]["meal_items"][$f]["quantity"] = $mealItem->quantity;
                            $mealDataArray[$j]["meal_items"][$f]["image_url"] = isset($mealImage->image_name) ? $mealImage->image_name : "";
                        }
                    }
                }
            }

            //Authorized amenity ids
            $authoriseAmenityIds = explode("#", $request->user()->authorise_amenities_id);
            $amenities = Amenity::where(["resort_id" => $userResort->resort_id, "is_active" => 1])
                    ->whereIn("id", $authoriseAmenityIds)
                    ->latest()
                    ->get();
            $amenitiesDataArray = [];
            foreach ($amenities as $z => $amenitie) {
                $amenityImage = AmenityImage::where("amenity_id", $amenitie->id)->first();
                $amenitiesBookingCount = AmenityRequest::where(["amenity_id" => $amenitie->id, "booking_date" => date("Y-m-d")])->count();
                $amenitiesDataArray[$z]["id"] = $amenitie->id;
                $amenitiesDataArray[$z]["name"] = $amenitie->name;
                $amenitiesDataArray[$z]["description"] = $amenitie->short_description;
                $amenitiesDataArray[$z]["icon"] = $amenityImage ? $amenityImage->image_name : '';
                $amenitiesDataArray[$z]["booking_count"] = $amenitiesBookingCount;
            }

            $data["services"] = $serviceArray;
            $data["meal_orders"] = $mealDataArray;
            $data["amenities"] = $amenitiesDataArray;
            return $this->sendSuccessResponse("Service request found.", $data);
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {post} /api/service-request-accept Service Request Accept
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName PostServicerequestaccept
     * @apiGroup Staff Service
     * 
     * @apiParam {String} request_id Service Request id(required).
     * @apiParam {String} user_id Staff user id(required).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Request accepted
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "status": true,
     *   "status_code": 200,
     *   "message": "Request accepted.",
     *   "data": {}
     * }
     * 
     * @apiError RequestIdMissing The request id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Request id missing.",
     *    "data": {}
     * }
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "status": false,
     *   "status_code": 404,
     *   "message": "User id missing.",
     *   "data": {}
     * }
     * 
     * 
     */
    public function requestAccept(Request $request) {
        try {
            if (!$request->request_id) {
                return $this->sendErrorResponse("Request id missing.", (object) []);
            }
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if ($request->user()->user_type_id != 2) {
                return $this->sendErrorResponse("Invalid login.", (object) []);
            }
            if ($request->user()->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }

            $serviceRequest = ServiceRequest::where(["id" => $request->request_id, "is_active" => 1])->first();
            if (!$serviceRequest) {
                return $this->sendErrorResponse("Invalid request.", (object) []);
            }
            if ($serviceRequest->request_status_id != 1) {
                return $this->sendErrorResponse("Request already accepted.", (object) []);
            }
            $serviceRequest->request_status_id = 2;
            $serviceRequest->accepted_by_id = $request->user_id;
            if ($serviceRequest->save()) {
                $service = Service::withTrashed()->find($serviceRequest->service_id);
                $user = User::find($serviceRequest->user_id);
                $this->generateNotification($user->id, "Service accepted", "Your " . $service->name . " request is accepted by " . $request->user()->user_name, 1);
                if ($user->device_token) {
                    $this->androidPushNotification(3, "Service Request", "Your " . $service->name . " request is accepted by " . $request->user()->user_name, $user->device_token, 1, $serviceRequest->service_id, $this->notificationCount($user->id));
                }
                return $this->sendSuccessResponse("Request accepted.", (object) []);
            } else {
                return $this->sendErrorResponse("Something went be wrong.", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {get} /api/myjobs Myjobs
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName GetMyjobs
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id Staff user id(required).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message My jobs
     * @apiSuccess {JSON}   data Array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "My jobs.",
     *    "data": {
     *        "ongoing_jobs": [
     *            {
     *               "id": 1,
     *               "service_name": "Do Not Disturbe",
     *               "service_comment": "",
     *               "service_icon": "http://127.0.0.1:8000/storage/Service_icon",
     *               "user_name": "Hariom Gangwar",
     *               "room_no": "300",
     *               "created_at": "18:22 pm"
     *               "type": 1
     *            },
     *            {
     *                "id": 1,
     *                "record_id": 1,
     *                "name": "1544722346",
     *                "icon": "",
     *                "date": "13-12-2018",
     *                "time": "17:32 pm",
     *                "total_item_count": 1,
     *                "total_amount": 240.6,
     *                "status_id": 1,
     *                "status": "Confirmed",
     *                "acceptd_by": "",
     *                "type": 4
     *            }
     *        ],
     *        "under_approval_jobs": [],
     *        "completed_jobs": []
     *    }
     * }
     * 
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "status": false,
     *   "status_code": 404,
     *   "message": "User id missing.",
     *   "data": {}
     * }
     * 
     * 
     */
    public function myJobListing(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if ($request->user()->user_type_id != 2) {
                return $this->sendErrorResponse("Invalid login.", (object) []);
            }

            $ongoing_jobs = ServiceRequest::select('id', 'comment', 'questions', 'staff_reasons', 'staff_comment', 'service_id', 'request_status_id', 'user_id', 'room_type_name', 'resort_room_no', 'created_at')->where(["accepted_by_id" => $request->user()->id, "request_status_id" => 2, "is_active" => 1])
                    ->with([
                        'serviceDetail' => function($query) {
                            $query->select('id', 'name', 'icon', 'type_id');
                        }
                    ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->staffRequestStatus();
                        }
                    ])->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number')
                            ->with([
                                'userBookingDetail' => function($query) {
                                    $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                }
                            ]);
                        }
                    ])
                    ->get();

            $ongoingJobArray = [];
            $i = 0;
            foreach ($ongoing_jobs as $ongoing_job) {
                $created_at = Carbon::parse($ongoing_job->created_at);
                $ongoingJobArray[$i]["id"] = $ongoing_job->id;
                $ongoingJobArray[$i]["service_name"] = $ongoing_job->serviceDetail ? $ongoing_job->serviceDetail->name : "";
                $ongoingJobArray[$i]["service_comment"] = $ongoing_job->comment;
                $ongoingJobArray[$i]["service_icon"] = $ongoing_job->serviceDetail ? $ongoing_job->serviceDetail->icon : "";
                $ongoingJobArray[$i]["user_name"] = $ongoing_job->userDetail ? $ongoing_job->userDetail->user_name : "";
                $ongoingJobArray[$i]["room_no"] = $ongoing_job->resort_room_no;
                $ongoingJobArray[$i]["date"] = $created_at->format('d-M-Y');
                $ongoingJobArray[$i]["time"] = $created_at->format('h:i A');
                $ongoingJobArray[$i]["date_time"] = $created_at->format('d-m-Y H:i:s');
                $ongoingJobArray[$i]["created_at"] = $created_at->format('d-m-Y h:i a');
                $ongoingJobArray[$i]["type"] = 1;
                if ($ongoing_job->questions) {
                    $reasons = explode(",", $ongoing_job->questions);
                    foreach ($reasons as $l => $reason) {
                        $ongoingJobArray[$i]["reasons"][$l]['reason'] = $reason;
                    }
                } else {
                    $serviceArray[$i]["reasons"] = [];
                }
                $i++;
            }

            $ongoingMealOrders = MealOrder::where(["accepted_by" => $request->user_id])
                    ->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number')
                            ->with([
                                'userBookingDetail' => function($query) {
                                    $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                }
                            ]);
                        }
                    ])
                    ->where(function($q) {
                        $q->where("status", 2);
                    })->latest()
                    ->get();
            foreach ($ongoingMealOrders as $ongoingMealOrder) {
                $createdAt = Carbon::parse($ongoingMealOrder->created_at);
                $mealItems = MealOrderItem::where("meal_order_id", $ongoingMealOrder->id)->get();
                $ongoingJobArray[$i]["id"] = $ongoingMealOrder->id;
                $ongoingJobArray[$i]["record_id"] = $ongoingMealOrder->id;
                $ongoingJobArray[$i]["name"] = $ongoingMealOrder->invoice_id;
                $ongoingJobArray[$i]["icon"] = "";
                $ongoingJobArray[$i]["date"] = $createdAt->format("d-M-Y");
                $ongoingJobArray[$i]["time"] = $createdAt->format("h:i A");
                $ongoingJobArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingJobArray[$i]["total_item_count"] = count($mealItems);
                $ongoingJobArray[$i]["user_name"] = $ongoingMealOrder->userDetail->user_name;
                $ongoingJobArray[$i]["room_no"] = $ongoingMealOrder->resort_room_no;
                $ongoingJobArray[$i]["gst_amount"] = ($ongoingMealOrder->total_amount - $ongoingMealOrder->item_total_amount);
                $ongoingJobArray[$i]["gst_percentage"] = $ongoingMealOrder->gst_amount;
                $ongoingJobArray[$i]["item_total_amount"] = $ongoingMealOrder->item_total_amount;
                $ongoingJobArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
                $ongoingJobArray[$i]["status_id"] = $ongoingMealOrder->status;
                $ongoingJobArray[$i]["status"] = "Pending";
                $ongoingJobArray[$i]["acceptd_by"] = "";
                $ongoingJobArray[$i]["type"] = 4;
                if ($mealItems) {
                    $ongoingJobArray[$i]["meal_items"] = [];
                    foreach ($mealItems as $f => $mealItem) {
                        $mealImage = MealItem::find($mealItem->meal_item_id);
                        $ongoingJobArray[$i]["meal_items"][$f]["id"] = $mealItem->id;
                        $ongoingJobArray[$i]["meal_items"][$f]["meal_item_name"] = $mealItem->meal_item_name;
                        $ongoingJobArray[$i]["meal_items"][$f]["price"] = $mealItem->price;
                        $ongoingJobArray[$i]["meal_items"][$f]["quantity"] = $mealItem->quantity;
                        $ongoingJobArray[$i]["meal_items"][$f]["image_url"] = isset($mealImage->image_name) ? $mealImage->image_name : "";
                    }
                } else {
                    $ongoingJobArray[$i]["meal_items"] = [];
                }
                $i++;
            }

            $under_approval_jobs = ServiceRequest::select('id', 'comment', 'questions', 'staff_reasons', 'staff_comment', 'service_id', 'request_status_id', 'user_id', 'room_type_name', 'resort_room_no', 'created_at')
                    ->with([
                        'serviceDetail' => function($query) {
                            $query->select('id', 'name', 'icon', 'type_id');
                        }
                    ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->staffRequestStatus();
                        }
                    ])->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number')
                            ->with([
                                'userBookingDetail' => function($query) {
                                    $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                }
                            ]);
                        }
                    ])
                    ->where(["accepted_by_id" => $request->user()->id, "is_active" => 1])
                    ->where(function($q) {
                        $q->where("request_status_id", 3)
                        ->orWhere("request_status_id", 5)
                        ;
                    })
                    ->get();

            $underApprovalJobArray = [];
            $j = 0;
            foreach ($under_approval_jobs as $under_approval_job) {
                $created_at = Carbon::parse($under_approval_job->created_at);
                $underApprovalJobArray[$j]["id"] = $under_approval_job->id;
                $underApprovalJobArray[$j]["service_name"] = $under_approval_job->serviceDetail ? $under_approval_job->serviceDetail->name : "";
                $underApprovalJobArray[$j]["service_comment"] = $under_approval_job->comment;
                $underApprovalJobArray[$j]["service_icon"] = $under_approval_job->serviceDetail ? $under_approval_job->serviceDetail->icon : "";
                $underApprovalJobArray[$j]["user_name"] = $under_approval_job->userDetail ? $under_approval_job->userDetail->user_name : "";
                $underApprovalJobArray[$j]["room_no"] = $under_approval_job->resort_room_no;
                $underApprovalJobArray[$j]["date"] = $created_at->format('d-M-Y');
                $underApprovalJobArray[$j]["time"] = $created_at->format('h:i A');
                $underApprovalJobArray[$j]["date_time"] = $created_at->format('d-m-Y H:i:s');
                $underApprovalJobArray[$j]["created_at"] = $created_at->format('d-m-Y h:i a');
                $underApprovalJobArray[$j]["type"] = 1;
                if ($under_approval_job->questions) {
                    $reasons = explode(",", $under_approval_job->questions);
                    foreach ($reasons as $l => $reason) {
                        $underApprovalJobArray[$j]["reasons"][$l]['reason'] = $reason;
                    }
                } else {
                    $underApprovalJobArray[$j]["reasons"] = [];
                }
                $j++;
            }

            $underMealOrders = MealOrder::where(["accepted_by" => $request->user_id])
                    ->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number')
                            ->with([
                                'userBookingDetail' => function($query) {
                                    $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                }
                            ]);
                        }
                    ])
                    ->where(function($q) {
                        $q->where("status", 3)
                        ->orWhere("status", 5)
                        ;
                    })->latest()
                    ->get();
            foreach ($underMealOrders as $ongoingMealOrder) {
                $createdAt = Carbon::parse($ongoingMealOrder->created_at);
                $mealItems = MealOrderItem::where("meal_order_id", $ongoingMealOrder->id)->get();
                $underApprovalJobArray[$j]["id"] = $ongoingMealOrder->id;
                $underApprovalJobArray[$j]["record_id"] = $ongoingMealOrder->id;
                $underApprovalJobArray[$j]["name"] = $ongoingMealOrder->invoice_id;
                $underApprovalJobArray[$j]["icon"] = "";
                $underApprovalJobArray[$j]["date"] = $createdAt->format("d-M-Y");
                $underApprovalJobArray[$j]["time"] = $createdAt->format("h:i A");
                $underApprovalJobArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $underApprovalJobArray[$j]["total_item_count"] = count($mealItems);
                $underApprovalJobArray[$j]["user_name"] = $ongoingMealOrder->userDetail->user_name;
                $underApprovalJobArray[$j]["room_no"] = $ongoingMealOrder->resort_room_no;
                $underApprovalJobArray[$j]["gst_amount"] = ($ongoingMealOrder->total_amount - $ongoingMealOrder->item_total_amount);
                $underApprovalJobArray[$j]["gst_percentage"] = $ongoingMealOrder->gst_amount;
                $underApprovalJobArray[$j]["total_amount"] = $ongoingMealOrder->total_amount;
                $underApprovalJobArray[$j]["item_total_amount"] = $ongoingMealOrder->item_total_amount;
                $underApprovalJobArray[$j]["status_id"] = $ongoingMealOrder->status;
                $underApprovalJobArray[$j]["status"] = "Under Apporval";
                $underApprovalJobArray[$j]["acceptd_by"] = "";
                $underApprovalJobArray[$j]["type"] = 4;
                if ($mealItems) {
                    $underApprovalJobArray[$j]["meal_items"] = [];
                    foreach ($mealItems as $f => $mealItem) {
                        $mealImage = MealItem::find($mealItem->meal_item_id);
                        $underApprovalJobArray[$j]["meal_items"][$f]["id"] = $mealItem->id;
                        $underApprovalJobArray[$j]["meal_items"][$f]["meal_item_name"] = $mealItem->meal_item_name;
                        $underApprovalJobArray[$j]["meal_items"][$f]["price"] = $mealItem->price;
                        $underApprovalJobArray[$j]["meal_items"][$f]["quantity"] = $mealItem->quantity;
                        $underApprovalJobArray[$j]["meal_items"][$f]["image_url"] = isset($mealImage->image_name) ? $mealImage->image_name : "";
                    }
                } else {
                    $underApprovalJobArray[$j]["meal_items"] = [];
                }
                $j++;
            }

            $completed_jobs = ServiceRequest::select('id', 'comment', 'questions', 'staff_reasons', 'staff_comment', 'service_id', 'request_status_id', 'user_id', 'room_type_name', 'resort_room_no', 'created_at')->where(["accepted_by_id" => $request->user()->id, "request_status_id" => 4, "is_active" => 1])
                    ->with([
                        'serviceDetail' => function($query) {
                            $query->select('id', 'name', 'icon', 'type_id');
                        }
                    ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->staffRequestStatus();
                        }
                    ])->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number')
                            ->with([
                                'userBookingDetail' => function($query) {
                                    $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                }
                            ]);
                        }
                    ])
                    ->get();
            $completedJobArray = [];
            $i = 0;
            foreach ($completed_jobs as $completed_job) {
                $created_at = Carbon::parse($completed_job->created_at);
                $completedJobArray[$i]["id"] = $completed_job->id;
                $completedJobArray[$i]["service_name"] = $completed_job->serviceDetail ? $completed_job->serviceDetail->name : "";
                $completedJobArray[$i]["service_comment"] = $completed_job->comment;
                $completedJobArray[$i]["service_icon"] = $completed_job->serviceDetail ? $completed_job->serviceDetail->icon : "";
                $completedJobArray[$i]["user_name"] = $completed_job->userDetail ? $completed_job->userDetail->user_name : "";
                $completedJobArray[$i]["room_no"] = $completed_job->resort_room_no;
                $completedJobArray[$i]["date"] = $created_at->format('d-M-Y');
                $completedJobArray[$i]["time"] = $created_at->format('h:i A');
                $completedJobArray[$i]["date_time"] = $created_at->format('d-m-Y H:i:s');
                $completedJobArray[$i]["created_at"] = $created_at->format('d-m-Y h:i a');
                $completedJobArray[$i]["type"] = 1;
                if ($completed_job->questions) {
                    $reasons = explode(",", $completed_job->questions);
                    foreach ($reasons as $l => $reason) {
                        $completedJobArray[$i]["reasons"][$l]['reason'] = $reason;
                    }
                } else {
                    $completedJobArray[$i]["reasons"] = [];
                }
                $i++;
            }

            $comeleteMealOrders = MealOrder::where(["accepted_by" => $request->user_id])
                    ->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number')
                            ->with([
                                'userBookingDetail' => function($query) {
                                    $query->select('id', 'user_id', 'source_name', 'source_id', 'resort_id');
                                }
                            ]);
                        }
                    ])
                    ->where(function($q) {
                        $q->where("status", 4);
                    })->latest()
                    ->get();
            foreach ($comeleteMealOrders as $ongoingMealOrder) {
                $createdAt = Carbon::parse($ongoingMealOrder->created_at);
                $mealItems = MealOrderItem::where("meal_order_id", $ongoingMealOrder->id)->get();
                $completedJobArray[$i]["id"] = $ongoingMealOrder->id;
                $completedJobArray[$i]["record_id"] = $ongoingMealOrder->id;
                $completedJobArray[$i]["name"] = $ongoingMealOrder->invoice_id;
                $completedJobArray[$i]["icon"] = "";
                $completedJobArray[$i]["date"] = $createdAt->format("d-M-Y");
                $completedJobArray[$i]["time"] = $createdAt->format("h:i A");
                $completedJobArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedJobArray[$i]["total_item_count"] = count($mealItems);
                $completedJobArray[$i]["user_name"] = $ongoingMealOrder->userDetail->user_name;
                $completedJobArray[$i]["room_no"] = $ongoingMealOrder->resort_room_no;
                $completedJobArray[$i]["gst_amount"] = ($ongoingMealOrder->total_amount - $ongoingMealOrder->item_total_amount);
                $completedJobArray[$i]["gst_percentage"] = $ongoingMealOrder->gst_amount;
                $completedJobArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
                $completedJobArray[$i]["item_total_amount"] = $ongoingMealOrder->item_total_amount;
                $completedJobArray[$i]["status_id"] = $ongoingMealOrder->status;
                $completedJobArray[$i]["status"] = "Under Apporval";
                $completedJobArray[$i]["acceptd_by"] = "";
                $completedJobArray[$i]["type"] = 4;
                if ($mealItems) {
                    $completedJobArray[$i]["meal_items"] = [];
                    foreach ($mealItems as $f => $mealItem) {
                        $mealImage = MealItem::find($mealItem->meal_item_id);
                        $completedJobArray[$i]["meal_items"][$f]["id"] = $mealItem->id;
                        $completedJobArray[$i]["meal_items"][$f]["meal_item_name"] = $mealItem->meal_item_name;
                        $completedJobArray[$i]["meal_items"][$f]["price"] = $mealItem->price;
                        $completedJobArray[$i]["meal_items"][$f]["quantity"] = $mealItem->quantity;
                        $completedJobArray[$i]["meal_items"][$f]["image_url"] = isset($mealImage->image_name) ? $mealImage->image_name : "";
                    }
                } else {
                    $completedJobArray[$i]["meal_items"] = [];
                }
                $i++;
            }
            usort($ongoingJobArray, function ($a, $b) {
                $t1 = strtotime($a['date_time']);
                $t2 = strtotime($b['date_time']);
                return $t2 - $t1;
            });
            usort($underApprovalJobArray, function ($a, $b) {
                $t1 = strtotime($a['date_time']);
                $t2 = strtotime($b['date_time']);
                return $t2 - $t1;
            });
            usort($completedJobArray, function ($a, $b) {
                $t1 = strtotime($a['date_time']);
                $t2 = strtotime($b['date_time']);
                return $t2 - $t1;
            });
            $data["ongoing_jobs"] = $ongoingJobArray;
            $data["under_approval_jobs"] = $underApprovalJobArray;
            $data["completed_jobs"] = $completedJobArray;
            return $this->sendSuccessResponse("My jobs.", $data);
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {post} /api/job-mark-complete My Job mark as completed
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName POSTMyjobMarkComplete
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id Staff user id(required).
     * @apiParam {String} job_id Job Id(required).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Your job status has been changed. Now your job in under approval.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "status": true,
     *   "status_code": 200,
     *   "message": "Your job status has been changed. Now your job in under approval.",
     *   "data": {}
     * }
     * 
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "status": false,
     *   "status_code": 404,
     *   "message": "User id missing.",
     *   "data": {}
     * }
     * 
     * 
     * @apiError JobIdMissing The job id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Job id missing.",
     *    "data": {}
     * }
     * 
     * 
     */
    public function markasComplete(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if ($request->user()->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }
            if (!$request->job_id) {
                return $this->sendErrorResponse("Job id missing", (object) []);
            }
            if (!$request->type) {
                return $this->sendErrorResponse("Type missing", (object) []);
            }
            if ($request->type == 1) {
                $job = ServiceRequest::where(['id' => $request->job_id, 'request_status_id' => 2])->first();
                if (!$job) {
                    return $this->sendErrorResponse("Invalid job", (object) []);
                }

                $job->request_status_id = 3;
                if ($job->save()) {
                    $service = Service::withTrashed()->find($job->service_id);
                    $user = User::find($job->user_id);
                    $this->generateNotification($job->user_id, "Service Request Completed", "Your " . $service->name . " request marked as completed by " . $request->user()->user_name, 1);
                    if ($user->device_token) {
                        $this->androidPushNotification(3, "Service Request Completed", "Your " . $service->name . " request marked as completed by " . $request->user()->user_name, $user->device_token, 1, $job->service_id, $this->notificationCount($user->id));
                    }
                    return $this->sendSuccessResponse("Your job status has been changed. Now your job in under approval.", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } elseif ($request->type == 4) {
                $job = MealOrder::where(['id' => $request->job_id, 'status' => 2])->first();
                if (!$job) {
                    return $this->sendErrorResponse("Invalid job", (object) []);
                }
                $job->status = 3;
                if ($job->save()) {
                    $user = User::find($job->user_id);
                    $this->generateNotification($user->id, "Meal Order Delivered", "Your meal order with invoice# $job->invoice_id is delivered.", 4);
                    if ($user->device_token) {
                        $this->androidPushNotification(3, "Meal Order Completed", "Your meal order with invoice# $job->invoice_id completed by " . $request->user()->user_name, $user->device_token, 4, $job->id, $this->notificationCount($user->id));
                    }
                    return $this->sendSuccessResponse("Your job status has been changed. Now your job in under approval.", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } else {
                return $this->sendErrorResponse("Invalid type.", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex, (object) []);
        }
    }

    /**
     * @api {post} /api/job-mark-notresolve My Job mark as not resolve
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName POSTMyjobMarkNotResolve
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id Staff user id(required).
     * @apiParam {String} job_id Job Id(required).
     * @apiParam {String} reasons Reasons (with comma separated).
     * @apiParam {String} comment Comment.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Your job status has been changed.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "status": true,
     *   "status_code": 200,
     *   "message": "Your job status has been changed.",
     *   "data": {}
     * }
     * 
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "status": false,
     *   "status_code": 404,
     *   "message": "User id missing.",
     *   "data": {}
     * }
     * 
     * 
     * @apiError JobIdMissing The job id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Job id missing.",
     *    "data": {}
     * }
     * 
     * 
     */
    public function markasNotResolve(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->job_id) {
                return $this->sendErrorResponse("Job id missing", (object) []);
            }
            if (!$request->type) {
                return $this->sendErrorResponse("Type missing", (object) []);
            }
            if ($request->type == 1) {
                $job = ServiceRequest::where(['id' => $request->job_id, 'request_status_id' => 2])->first();
                ;
                if (!$job) {
                    return $this->sendErrorResponse("Invalid job", (object) []);
                }

                $job->request_status_id = 5;
                $job->staff_reasons = $request->reasons;
                $job->staff_comment = $request->comment;
                if ($job->save()) {
                    $user = User::find($job->user_id);
                    $this->generateNotification($user->id, "Service Request Rejected", "Unfortunately! Your request is not resolved by " . $request->user()->user_name, 1);
                    if ($user->device_token) {
                        $this->androidPushNotification(3, "Service Request Rejected", "Unfortunately! Your request is not resolved by " . $request->user()->user_name, $user->device_token, 1, $job->service_id, $this->notificationCount($user->id));
                    }
                    return $this->sendSuccessResponse("Your job status has been changed.", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } elseif ($request->type == 4) {
                $job = MealOrder::where(['id' => $request->job_id, 'status' => 2])->first();
                if (!$job) {
                    return $this->sendErrorResponse("Invalid job", (object) []);
                }

                $job->status = 5;
                $job->staff_reasons = $request->reasons;
                $job->staff_comment = $request->comment;
                if ($job->save()) {
                    $user = User::find($job->user_id);
                    $this->generateNotification($user->id, "Meal Order", "Unfortunately! Your meal order request rejected by " . $request->user()->user_name, 1);
                    if ($user->device_token) {
                        $this->androidPushNotification(3, "Meal Order", "Unfortunately! Your meal order request rejected by " . $request->user()->user_name, $user->device_token, 1, $job->id, $this->notificationCount($user->id));
                    }
                    return $this->sendSuccessResponse("Your job status has been changed.", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            }
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {post} /api/accept-reject-meal-order Accept/Reject meal order.
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName POSTAcceptRejectMealOrer
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} order_id Order id*.
     * @apiParam {String} status 1=>Accepted order, -1=> Rejected Order .
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Order accepted successfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "status": true,
     *   "status_code": 200,
     *   "message": "Order accepted successfully.",
     *   "data": {}
     * }
     * 
     * 
     * 
     */
    public function acceptRejectOrder(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if (!$request->status) {
                return $this->sendErrorResponse("Status missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->order_id) {
                return $this->sendErrorResponse("Order id missing", (object) []);
            }
            $order = MealOrder::find($request->order_id);
            if (!$order) {
                return $this->sendErrorResponse("Invalid order", (object) []);
            }

            $order->status = $request->status == -1 ? 5 : $request->status;
            $order->staff_reasons = $request->reasons;
            $order->staff_comment = $request->comment;
            $order->accepted_by = $request->user_id;
            if ($order->save()) {
                $user = User::find($order->user_id);
                $msg = "Invalid status.";
                if ($order->status == 5) {
                    $this->generateNotification($user->id, "Meal Order Rejected", "Unfortunately! Your meal order with invoice# $order->invoice_id rejected by " . $request->user()->user_name, 4);
                    if ($user->device_token) {
                        $this->androidPushNotification(3, "Meal Order Rejected", "Unfortunately! Your meal order with invoice# $order->invoice_id rejected by " . $request->user()->user_name, $user->device_token, 4, $order->id, $this->notificationCount($user->id));
                    }
                    $msg = "Order rejected successfully.";
                }
                if ($order->status == 2) {
                    $this->generateNotification($user->id, "Meal Order Accepted", "Your meal order with invoice# $order->invoice_id accepted by " . $request->user()->user_name, 4);
                    if ($user->device_token) {
                        $this->androidPushNotification(3, "Meal Order Accepted", "Your meal order with invoice# $order->invoice_id accepted by " . $request->user()->user_name, $user->device_token, 4, $order->id, $this->notificationCount($user->id));
                    }
                    $msg = "Order accepted successfully.";
                }
                return $this->sendSuccessResponse($msg, (object) []);
            } else {
                return $this->administratorResponse();
            }
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/amenities-bookings-details Amenity bookings detail.
     * @apiHeader {String} Accept application/json.
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName getAmenityBookingsDetail
     * @apiGroup Staff Service
     * 
     * @apiParam {String} amenity_id Amenity id*.
     * @apiParam {String} booking_date Booking date id* (format yy-mm-dd).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message bookings details
     * @apiSuccess {JSON}   data array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "booking detail",
     *       "data": [
     *           {
     *               "slot": "04:00-05:00",
     *               "bookings": [
     *                   {
     *                       "id": 1,
     *                       "user_name": "Hariom Gangwar",
     *                       "room_no": "100",
     *                       "created_at": "13-12-18 05:48 PM"
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     * 
     * 
     * 
     */
    public function amenitiesBooking(Request $request) {
        try {
            //If user account deactivated by admin
            if ($request->user()->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }
            //If user not registered with any resort
            $userResort = UserBookingDetail::where("user_id", $request->user()->id)->first();
            if (!$userResort) {
                return $this->sendErrorResponse("User not registered with any resort.", (object) []);
            }
            if (!$request->amenity_id) {
                return $this->sendErrorResponse("amenity id missing.", (object) []);
            }
            $amenity = Amenity::find($request->amenity_id);
            if (!$amenity) {
                return $this->sendErrorResponse("Invalid amenity.", (object) []);
            }

            $amenitySlots = AmenityTimeSlot::where(["amenity_id" => $request->amenity_id, "is_active" => 1])->get();
            //dd($amenitySlots->toArray());
            $amenitySlotData = [];
            foreach ($amenitySlots as $i => $amenitySlot) {

                $amenitiesRequests = AmenityRequest::where(["amenity_id" => $request->amenity_id, "from" => $amenitySlot->from, "to" => $amenitySlot->to, "booking_date" => $request->booking_date])
                        ->with("userDetail")
                        ->get();


                $from = Carbon::parse($amenitySlot->from);
                $to = Carbon::parse($amenitySlot->to);
                $amenitySlotData[$i]['slot'] = $from->format("h:i A");
                if ($amenitiesRequests) {

                    foreach ($amenitiesRequests as $j => $amenitiesRequest) {
                        $created_at = Carbon::parse($amenitiesRequest->created_at);
                        $amenitySlotData[$i]['bookings'][$j]["id"] = $amenitiesRequest->id;
                        $amenitySlotData[$i]['bookings'][$j]["user_name"] = $amenitiesRequest->userDetail->user_name;
                        $amenitySlotData[$i]['bookings'][$j]["room_no"] = $amenitiesRequest->room_no;
                        $amenitySlotData[$i]['bookings'][$j]["created_at"] = $created_at->format("d-m-y h:i A");
                    }
                } else {
                    $amenitySlotData[$i]['bookings'] = [];
                }
            }

            return $this->sendSuccessResponse("booking detail", $amenitySlotData);
        } catch (Exception $ex) {
            dd($ex);
            return $this->administratorResponse();
        }
    }

    /**
     * @api {post} /api/update-push-status Update push status
     * @apiHeader {String} Accept application/json.
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostUpdatePushStatus
     * @apiGroup Staff Service
     * 
     * @apiParam {String} status Status*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Status updated
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Service request found.",
     *    "data": {}
     * 
     * 
     * @apiError StatusMissing The status was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "status missing.",
     *    "data": {}
     * }
     * 
     * 
     * 
     */
    public function updateNotificaionStatus(Request $request) {
        try {
//            if (!$request->status) {
//                return $this->sendErrorResponse("Status missing.", (object) []);
//            }
            $user = User::find($request->user()->id);
            $user->is_push_on = $request->status;
            $user->save();
            return $this->sendSuccessResponse("Status updated.", (object) []);
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {get} /api/room-type-list Room Type & Package List
     * @apiHeader {String} Accept application/json.
     * @apiName Getroomtypelist
     * @apiGroup Staff Service
     * 
     * @apiParam {String} check_in Check In Date*.
     * @apiParam {String} check_out Check Out Date*.
     * @apiParam {String} resort_id Resort Id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} Resort room list
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Resort room & Package list",
     *       "data": {
     *           "room_list": [
     *               {
     *                   "id": 1,
     *                   "room_type": "Tent",
     *                   "rooms": [
     *                       {
     *                           "id": 52,
     *                           "room_no": "t-2"
     *                       },
     *                       {
     *                           "id": 53,
     *                           "room_no": "T-3"
     *                       },
     *                       {
     *                           "id": 54,
     *                           "room_no": "T-4"
     *                       },
     *                       {
     *                           "id": 55,
     *                           "room_no": "T-5"
     *                       },
     *                       {
     *                           "id": 56,
     *                           "room_no": "T-6"
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 2,
     *                   "room_type": "Cottage",
     *                   "rooms": [
     *                       {
     *                           "id": 50,
     *                           "room_no": "C-1"
     *                       },
     *                       {
     *                           "id": 57,
     *                           "room_no": "C-3"
     *                       },
     *                       {
     *                           "id": 58,
     *                           "room_no": "C-2"
     *                       },
     *                       {
     *                           "id": 59,
     *                           "room_no": "C-4"
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 4,
     *                   "room_type": "Villa",
     *                   "rooms": [
     *                       {
     *                           "id": 51,
     *                           "room_no": "V-1"
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 8,
     *                   "room_type": "Dummy",
     *                   "rooms": [
     *                       []
     *                   ]
     *               }
     *           ],
     *           "packages": [
     *               {
     *                   "id": 1,
     *                   "name": "Healthcare Package Reverse Diabetes in 3 Days"
     *               },
     *               {
     *                   "id": 3,
     *                   "name": "Healthcare Package Reverse Diabetes in 7 Days"
     *               },
     *               {
     *                   "id": 4,
     *                   "name": "Reverse Diabetes in 14 Days"
     *               },
     *               {
     *                   "id": 5,
     *                   "name": "Reverse Diabetes in 21 Days"
     *               }
     *           ]
     *       }
     *   }
     * 
     * 
     * @apiError CheckInMissing The Check In date missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Check In missing.",
     *    "data": {}
     * }
     * 
     * @apiError CheckOutMissing The Check Out date missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Check Out missing.",
     *    "data": {}
     * }
     * 
     * @apiError ResortIdMissing The Resort Id date missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Resort Id missing.",
     *    "data": {}
     * }
     * 
     * 
     * 
     */
    public function resortList(Request $request) {
        if (!$request->check_in) {
            return $this->sendErrorResponse("Check In date missing", (object) []);
        }
        if (!$request->check_out) {
            return $this->sendErrorResponse("Check Out date missing", (object) []);
        }
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort Id missing", (object) []);
        }

        $roomTypes = RoomType::where(["is_active" => 1, "resort_id" => $request->resort_id])->get();
        if ($roomTypes->count()) {
            $check_in = date("Y-m-d H:s:i", strtotime($request->check_in));
            $check_out = date("Y-m-d H:s:i", strtotime($request->check_out));
            $resort = $request->resort_id;

            $roomIds = UserBookingDetail::where("resort_id", $resort)
                    ->where(function($query) use($check_in, $check_out) {
                        $query->orWhere(function($query) use($check_in) {
                            $query->where("check_in", "<=", $check_in)
                            ->where("check_out", ">=", $check_in);
                        });
                        $query->orWhere(function($query) use($check_out) {
                            $query->where("check_in", "<", $check_out)
                            ->where("check_out", ">=", $check_out);
                        });
                        $query->orWhere(function($query) use($check_in, $check_out) {
                            $query->where("check_in", ">=", $check_in)
                            ->where("check_out", "<=", $check_out);
                        });
                    })
                    ->pluck("resort_room_id");
            $dataArray = [];
            foreach ($roomTypes as $key => $roomType) {
                $dataArray[$key]['id'] = $roomType->id;
                $dataArray[$key]['room_type'] = $roomType->name;

                $query = ResortRoom::query();
                $query->where(["resort_id" => $resort, "room_type_id" => $roomType->id, "is_active" => 1]);
                if (!empty($roomIds)) {
                    $query->whereNotIn("id", $roomIds);
                }
                $resortRooms = $query->get();
                if ($resortRooms->count()) {
                    foreach ($resortRooms as $j => $resortRoom) {
                        $dataArray[$key]['rooms'][$j]['id'] = $resortRoom->id;
                        $dataArray[$key]['rooms'][$j]['room_no'] = $resortRoom->room_no;
                    }
                } else {
                    $dataArray[$key]['rooms'] = [];
                }
            }
            $data['room_list'] = $dataArray;
        } else {
            $data['room_list'] = [];
        }

        $Programs = \App\Models\HealthcateProgram::where(["resort_id" => $request->resort_id, "is_active" => 1])->get();
        if ($Programs->count()) {
            $packageArray = [];
            foreach ($Programs as $i => $Program) {
                $packageArray[$i]['id'] = $Program->id;
                $packageArray[$i]['name'] = $Program->name;
            }
            $data['packages'] = $packageArray;
        } else {
            $data['packages'] = [];
        }

        return $this->sendSuccessResponse("Resort room & Package list", $data);
    }

    /**
     * @api {post} /api/add-user Add User
     * @apiHeader {String} Accept application/json.
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName Postadduser
     * @apiGroup Staff Service
     * 
     * @apiParam {String} mobile_number Mobile Number*.
     * @apiParam {String} user_name User Name*.
     * @apiParam {String} country_code Country code*.
     * @apiParam {String} email_id Email id.
     * @apiParam {String} resort_room_type_id Resort room type Id*.
     * @apiParam {String} resort_room_id Resort room Id*.
     * @apiParam {String} booking_source_name Booking Source name*.
     * @apiParam {String} booking_source_id Booking Source Id*.
     * @apiParam {String} booking_source Booking source*.
     * @apiParam {String} booking_amount Booking amount*.
     * @apiParam {String} booking_amount_type Booking amount type* (1 => Prepaid, 2 => Outstanding).
     * @apiParam {String} resort_id Resort Id*.
     * @apiParam {String} package_id Package Id*.
     * @apiParam {String} check_in Check In date time*.
     * @apiParam {String} check_out Check Out date time*.
     * @apiParam {String} check_out Check Out date time*.
     * @apiParam {String} is_membership Membership (0 or 1).
     * @apiParam {String} membership_id Membership Id.
     * @apiParam {String} membership_from Membership From.
     * @apiParam {String} membership_till Membership Till.
     * @apiParam {String} is_medical Medical (0 or 1).
     * @apiParam {String} is_diabeties Diabetirs (0 or 1).
     * @apiParam {String} is_ppa PPA (0 or 1).
     * @apiParam {String} hba_1c HBA_1C (0 or 1).
     * @apiParam {String} fasting Fasting.
     * @apiParam {String} bp BP.
     * @apiParam {String} insullin_dependency Insullin dependency.
     * @apiParam {File} medical_documents Medical document.
     * @apiParam {String} discount Discount.
     * @apiParam {Array} person_name Person name.
     * @apiParam {Array} person_age Person age.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} Something went be wrong
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *      "status": true,
     *     "status_code": 200,
     *     "message": "User registered successfully",
     *      "data": {}
     *   }
     * 
     * 
     * 
     * 
     */
    public function addUser(Request $request) {
        if (!$request->user_name) {
            return $this->sendErrorResponse("Username missing", (object) []);
        }
        if (!$request->country_code) {
            return $this->sendErrorResponse("Country code missing", (object) []);
        }
        if (!$request->mobile_number) {
            return $this->sendErrorResponse("Mobile number missing", (object) []);
        }
        if (!$request->resort_room_type_id) {
            return $this->sendErrorResponse("Room type missing", (object) []);
        }
        if (!$request->resort_room_id) {
            return $this->sendErrorResponse("Room No. missing", (object) []);
        }
        if (!$request->booking_source_name) {
            return $this->sendErrorResponse("Booking Source name missing", (object) []);
        }
        if (!$request->booking_source_id) {
            return $this->sendErrorResponse("Booking Source Id missing", (object) []);
        }
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort Id missing", (object) []);
        }
        if (!$request->check_in) {
            return $this->sendErrorResponse("Check In missing", (object) []);
        }
        if (!$request->check_out) {
            return $this->sendErrorResponse("Check Out missing", (object) []);
        }
        if (!$request->booking_source) {
            return $this->sendErrorResponse("Source of booking is missing.", (object) []);
        }
        if (!$request->booking_amount) {
            return $this->sendErrorResponse("Booking amount is missing.", (object) []);
        }
        if (!$request->booking_amount_type) {
            return $this->sendErrorResponse("Booking amount type.", (object) []);
        }
        if ($request->user()->is_booking == 0) {
            return $this->sendErrorResponse("You can not create booking. Please contact to admin", (object) []);
        }
        if ($request->user()->is_push_on == 0) {
            return $this->sendErrorResponse("Your duty status is offline.", (object) []);
        }


        $isExist = User::where(["user_type_id" => 3, "mobile_number" => $request->mobile_number])->get();
        if ($isExist->count()) {
            return $this->sendErrorResponse("User already registered", (object) []);
        }
        $user = new User();
        $name = explode(" ", $request->user_name);

        $user->user_type_id = 3;
        $user->discount = $request->discount ? $request->discount : 0;
        $user->user_name = $request->user_name;
        $user->first_name = isset($name[0]) ? $name[0] : '';
        $user->last_name = isset($name[1]) ? $name[1] : '';
        $user->mobile_number = $request->mobile_number;
        $user->otp = 9999;
        $user->password = bcrypt(9999);
        $user->email_id = $request->email_id;
        $user->created_by = 0;
        $user->updated_by = 0;
        $user->discount = $request->discount ? $request->discount : 0;
        if ($user->save()) {
            if (isset($request->is_medical) && ($request->is_medical)) {
                $doc_file_name = '';
                if ($request->hasFile("medical_documents")) {
                    $medical_documents = $request->file("medical_documents");
                    $medical_doc = Storage::disk('public')->put('medical_document', $medical_documents);
                    $doc_file_name = basename($medical_doc);
                }

                $userHealthDetail = new UserhealthDetail();
                $userHealthDetail->is_diabeties = $request->is_diabeties ? $request->is_diabeties : 0;
                $userHealthDetail->is_ppa = $request->is_ppa ? $request->is_ppa : 0;
                $userHealthDetail->hba_1c = $request->hba_1c ? $request->hba_1c : 0;
                $userHealthDetail->fasting = $request->fasting ? $request->fasting : '';
                $userHealthDetail->bp = $request->bp ? $request->bp : '';
                $userHealthDetail->insullin_dependency = $request->insullin_dependency ? $request->insullin_dependency : '';
                $userHealthDetail->medical_documents = $doc_file_name;
                $userHealthDetail->user_id = $user->id;
                $userHealthDetail->save();
            }

            if (isset($request->is_membership) && ($request->is_membership)) {
                $userMembership = new UserMembership();

                $userMembership->user_id = $user->id;
                $userMembership->membership_id = $request->membership_id;
                $membership_from = Carbon::parse($request->membership_from);
                $userMembership->valid_from = $membership_from->format('Y-m-d H:i:s');
                $membership_till = Carbon::parse($request->membership_till);
                $userMembership->valid_till = $membership_till->format('Y-m-d H:i:s');
                $userMembership->save();
            }

//            if (isset($request->is_booking) && ($request->is_booking == "on")) {
            $roomType = RoomType::find($request->resort_room_type_id);
            $room = ResortRoom::find($request->resort_room_id);
            $userBooking = new UserBookingDetail();
            $userBooking->source_name = $request->booking_source_name;
            $userBooking->source_id = $request->booking_source_id;
            $userBooking->booking_source = $request->booking_source;
            $userBooking->booking_amount = $request->booking_amount;
            $userBooking->booking_amount_type = $request->booking_amount_type;
            $userBooking->user_id = $user->id;
            $userBooking->resort_id = $request->resort_id;
            $userBooking->package_id = $request->package_id;
            $userBooking->room_type_id = $request->resort_room_type_id;
            $userBooking->room_type_name = $roomType ? $roomType->name : "";
            $userBooking->resort_room_id = $request->resort_room_id;
            $userBooking->resort_room_no = $room ? $room->room_no : "";
            $check_in_date = Carbon::parse($request->check_in);
            $userBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
            $check_out_date = Carbon::parse($request->check_out);
            $userBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
            $userBooking->check_in_pin = rand(1111, 9999);
            $userBooking->check_out_pin = rand(1111, 9999);
            if ($userBooking->save()) {
                if (!empty($request->person_name) && !empty($request->person_age)) {
                    foreach ($request->person_name as $key => $person_name) {
                        if (!empty($person_name) && !empty($request->person_age[$key])) {
                            $familyMember = new BookingpeopleAccompany();
                            $familyMember->person_name = $person_name ? $person_name : ' ';
                            $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                            $familyMember->person_type = $request->person_age[$key] > 17 ? "Adult" : "Child";
                            $familyMember->booking_id = $userBooking->id;
                            $familyMember->save();
                        }
                    }
                }
            }
//            }

            $this->sendRegistration($user->mobile_number, $user->user_name);
            return $this->sendSuccessResponse("User registered successfully", (object) []);
        }

        return $this->sendErrorResponse("Somethin went be wrong.", (object) []);
    }

    /**
     * @api {get} /api/search-user Search User
     * @apiHeader {String} Accept application/json.
     * @apiName Getsearchuser
     * @apiGroup Staff Service
     * 
     * @apiParam {String} search_keyword Search keyword*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} User list
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *  {
     *      "status": true,
     *      "status_code": 200,
     *      "message": "user list",
     *      "data": {
     *          "user_list": [
     *              {
     *                  "id": 81,
     *                  "name": "Hariom Gangwar",
     *                  "email_id": "hariom4037@gmail.com",
     *                  "mobile_number": "8077575834",
     *                  "country_code": ""
     *              },
     *              {
     *                  "id": 114,
     *                  "name": "",
     *                  "email_id": "",
     *                  "mobile_number": "8077575832",
     *                  "country_code": ""
     *              },
     *              {
     *                  "id": 117,
     *                  "name": "Ankit Singh",
     *                  "email_id": "ankit@yopmail.com",
     *                  "mobile_number": "8077575837",
     *                  "country_code": ""
     *              },
     *              {
     *                  "id": 118,
     *                  "name": "Ankit Singh",
     *                  "email_id": "ankit@yopmail.com",
     *                  "mobile_number": "8077575835",
     *                  "country_code": ""
     *              }
     *          ]
     *      }
     *  }
     * 
     * 
     * @apiError SeacrhKeywordMissing Search keyword missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "Search Keyword missing.",
     *    "data": {}
     * }
     * 
     * 
     * 
     */
    public function searchUser(Request $request) {
        if (!$request->search_keyword) {
            return $this->sendErrorResponse("Search keyword missing", (object) []);
        }
        $users = User::where(function ($query) use ($request) {
                    $query->where('user_name', 'like', "%" . $request->search_keyword . "%")
                            ->orWhere('email_id', 'like', "%" . $request->search_keyword . "%")
                            ->orWhere('mobile_number', 'like', "%" . $request->search_keyword . "%");
                })->where("user_type_id", 3)->get();
        $dataArray = [];
        if ($users->count()) {
            foreach ($users as $k => $user) {
                $dataArray[$k]['id'] = $user->id;
                $dataArray[$k]['name'] = $user->user_name ? $user->user_name : '';
                $dataArray[$k]['email_id'] = $user->email_id ? $user->email_id : '';
                $dataArray[$k]['mobile_number'] = $user->mobile_number ? $user->mobile_number : '';
                $dataArray[$k]['country_code'] = $user->country_code ? $user->country_code : '';
            }
        }
        $data['user_list'] = $dataArray;
        return $this->sendSuccessResponse("user list", $data);
    }

    /**
     * @api {get} /api/get-bookings User booking list
     * @apiHeader {String} Accept application/json.
     * @apiName Getuserbookings
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id User Id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} Booking list
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "booking list",
     *       "data": [
     *           {
     *               "source_name": "Makemy trip",
     *               "source_id": "QWERTY12345",
     *               "resort": "Sanjeevani Resorts & Tents",
     *               "package": "Healthcare Package Reverse Diabetes in 3 Days",
     *               "check_in": "31-May-2019 12:00 PM",
     *               "check_out": "31-May-2019 01:00 PM",
     *               "room_no": "T-1",
     *               "status": "Completed"
     *           },
     *           {
     *               "source_name": "GOIBIBO",
     *               "source_id": "GOIBIBO007",
     *               "resort": "Sanjeevani Resorts & Tents",
     *               "package": "Healthcare Package Reverse Diabetes in 7 Days",
     *               "check_in": "31-May-2019 02:00 PM",
     *               "check_out": "31-May-2019 04:00 PM",
     *               "room_no": "T-3",
     *               "status": "Cancelled"
     *           },
     *           {
     *               "source_name": "XYZ",
     *               "source_id": "12345XYZ",
     *               "resort": "Sanjeevani Resorts & Tents",
     *               "package": "Healthcare Package Reverse Diabetes in 3 Days",
     *               "check_in": "01-Jun-2019 12:00 AM",
     *               "check_out": "10-Jun-2019 12:00 AM",
     *               "room_no": "t-2",
     *               "status": "Current"
     *           },
     *           {
     *               "source_name": "XYZ",
     *               "source_id": "12345XYZ",
     *               "resort": "Sanjeevani Resorts & Tents",
     *               "package": "Healthcare Package Reverse Diabetes in 3 Days",
     *               "check_in": "01-Jun-2019 12:00 AM",
     *               "check_out": "10-Jun-2019 12:00 AM",
     *               "room_no": "t-2",
     *               "status": "Current"
     *           },
     *           {
     *               "source_name": "XYZ",
     *               "source_id": "12345XYZ",
     *               "resort": "Sanjeevani Resorts & Tents",
     *               "package": "Healthcare Package Reverse Diabetes in 3 Days",
     *               "check_in": "01-Jun-2019 12:00 AM",
     *               "check_out": "10-Jun-2019 12:00 AM",
     *               "room_no": "t-2",
     *               "status": "Current"
     *           },
     *           {
     *               "source_name": "XYZ",
     *               "source_id": "12345XYZ",
     *               "resort": "Sanjeevani Resorts & Tents",
     *               "package": "Healthcare Package Reverse Diabetes in 3 Days",
     *               "check_in": "01-Jun-2019 12:00 AM",
     *               "check_out": "10-Jun-2019 12:00 AM",
     *               "room_no": "t-2",
     *               "status": "Current"
     *           }
     *       ]
     *   }
     * 
     * 
     * @apiError UserIdMissing User Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "User Id missing.",
     *    "data": {}
     * }
     * 
     * 
     * 
     */
    public function getUserBookings(Request $request) {
        if (!$request->user_id) {
            return $this->sendErrorResponse("User id missing.", (object) []);
        }
        $userBookings = UserBookingDetail::where("user_id", $request->user_id)->get();

        $bookinDetailArray = [];
        if ($userBookings->count()) {
            foreach ($userBookings as $i => $userBookingDetail) {
                $currentDataTime = strtotime(date("d-m-Y H:i:s"));
                $checkInTime = strtotime($userBookingDetail->check_in);
                $checkOutTime = strtotime($userBookingDetail->check_out);
                $stat = "";
                if ($userBookingDetail->is_cancelled == 1) {
                    $stat = "Cancelled";
                } else {
                    if ($currentDataTime > $checkOutTime) {
                        $stat = "Completed";
                    } elseif ($currentDataTime < $checkInTime) {
                        $stat = "Upcoming";
                    } else {
                        $stat = "Current";
                    }
                }

                $bookinDetailArray[$i]["source_name"] = $userBookingDetail->source_name;
                $bookinDetailArray[$i]["source_id"] = $userBookingDetail->source_id;
                $bookinDetailArray[$i]["resort"] = isset($userBookingDetail->resortDetail->name) ? $userBookingDetail->resortDetail->name : "";
                $bookinDetailArray[$i]["package"] = isset($userBookingDetail->packageDetail->name) ? $userBookingDetail->packageDetail->name : "";
                $bookinDetailArray[$i]["check_in"] = isset($userBookingDetail->check_in) ? date("d-M-Y h:i A", strtotime($userBookingDetail->check_in)) : "";
                $bookinDetailArray[$i]["check_out"] = isset($userBookingDetail->check_out) ? date("d-M-Y h:i A", strtotime($userBookingDetail->check_out)) : "";
                $bookinDetailArray[$i]["room_no"] = isset($userBookingDetail->resort_room_no) ? $userBookingDetail->resort_room_no : "";
                $bookinDetailArray[$i]["status"] = $stat;
            }
        } else {
            $bookinDetailArray = [];
        }
        usort($bookinDetailArray, function($a, $b) {
            $datetime1 = strtotime($a['check_in']);
            $datetime2 = strtotime($b['check_in']);
            return $datetime2 - 1;
        });
        return $this->sendSuccessResponse("booking list", $bookinDetailArray);
    }

    /**
     * @api {post} /api/create-booking Create user booking.
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName Postcreateuserbooking
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id User Id*.
     * @apiParam {String} check_in Check In(YYYY-MM-DD H:i:s)*.
     * @apiParam {String} check_out Check Out(YYYY-MM-DD H:i:s)*.
     * @apiParam {String} resort_id Resort Id*.
     * @apiParam {String} resort_room_type_id Resort room type Id*.
     * @apiParam {String} resort_room_id Resort room Id*.
     * @apiParam {String} booking_source_name Booking source name*.
     * @apiParam {String} booking_source_id Booking source Id*.
     * @apiParam {String} booking_source Booking source*.
     * @apiParam {String} booking_amount Booking amount*.
     * @apiParam {String} booking_amount_type Booking amount type* (1 => Prepaid, 2 => Outstanding).
     * @apiParam {String} package_id Package Id*.
     * @apiParam {Array} person_name Person name.
     * @apiParam {Array} person_age Person age.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} Booking list
     * @apiSuccess {JSON}   data {}.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "User booking created successfully.",
     *       "data": {}
     *   }
     * 
     * 
     * @apiError UserIdMissing User Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "User Id missing.",
     *    "data": {}
     * }
     * 
     * 
     * 
     */
    public function createBooking(Request $request) {

        if (!$request->user_id) {
            return $this->sendErrorResponse("User id missing.", (object) []);
        }
        if (!$request->check_in) {
            return $this->sendErrorResponse("Check In missing.", (object) []);
        }
        if (!$request->check_out) {
            return $this->sendErrorResponse("Check Out missing.", (object) []);
        }
        if (!$request->resort_room_type_id) {
            return $this->sendErrorResponse("Room type missing", (object) []);
        }
        if (!$request->resort_room_id) {
            return $this->sendErrorResponse("Room No. missing", (object) []);
        }
        if (!$request->booking_source_name) {
            return $this->sendErrorResponse("Booking Source name missing", (object) []);
        }
        if (!$request->booking_source_id) {
            return $this->sendErrorResponse("Booking Source Id missing", (object) []);
        }
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort Id missing", (object) []);
        }
//        if (!$request->source_booking) {
//            return $this->sendErrorResponse("Source of booking is missing.", (object) []);
//        }
        if (!$request->booking_amount) {
            return $this->sendErrorResponse("Booking amount is missing.", (object) []);
        }
        if (!$request->booking_amount_type) {
            return $this->sendErrorResponse("Booking amount type.", (object) []);
        }
        if ($request->user()->is_booking == 0) {
            return $this->sendErrorResponse("You can not create booking. Please contact to admin", (object) []);
        }
        if ($request->user()->is_push_on == 0) {
            return $this->sendErrorResponse("Your duty status is offline.", (object) []);
        }
        $user = User::find($request->user_id);

        $existingBookingCount = $this->checkUserbookingExist($request->check_in, $request->check_out, $request->user_id, $request->resort_id);
//        $existingRecord = UserBookingDetail::where("check_in", "<=", date("Y-m-d H:i:s", strtotime($request->check_in)))
//                ->where("check_out", ">=", date("Y-m-d H:i:s", strtotime($request->check_out)))
//                ->where("user_id", $request->user_id)
//                ->first();
        if ($existingBookingCount > 0) {
            return $this->sendErrorResponse("Booking already exist with these date's.", (object) []);
        }

        $isCurrentBooking = $this->isCurrentBooking($user->id);
        $roomType = RoomType::find($request->resort_room_type_id);
        $room = ResortRoom::find($request->resort_room_id);
        $userBooking = new UserBookingDetail();
        $userBooking->source_name = $request->booking_source_name;
        $userBooking->source_id = $request->booking_source_id;
        $userBooking->booking_source = $request->booking_source;
        $userBooking->booking_amount = $request->booking_amount;
        $userBooking->booking_amount_type = $request->booking_amount_type;
        $userBooking->user_id = $request->user_id;
        $userBooking->resort_id = $request->resort_id;
        $userBooking->package_id = $request->package_id ? $request->package_id : 0;
        $userBooking->room_type_id = $request->resort_room_type_id;
        $userBooking->room_type_name = $roomType ? $roomType->name : "";
        $userBooking->resort_room_id = $request->resort_room_id;
        $userBooking->resort_room_no = $room ? $room->room_no : "";
        $check_in_date = Carbon::parse($request->check_in);
        $userBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
        $check_out_date = Carbon::parse($request->check_out);
        $userBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
        $userBooking->check_in_pin = rand(1111, 9999);
        $userBooking->check_out_pin = rand(1111, 9999);
        if ($userBooking->save()) {
            if (!empty($request->person_name) && !empty($request->person_age)) {
                foreach ($request->person_name as $key => $person_name) {
                    if (!empty($person_name) && !empty($request->person_age[$key])) {
                        $familyMember = new BookingpeopleAccompany();
                        $familyMember->person_name = $person_name ? $person_name : ' ';
                        $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                        $familyMember->person_type = $request->person_age[$key] > 17 ? "Adult" : "Child";
                        $familyMember->booking_id = $userBooking->id;
                        $familyMember->save();
                    }
                }
            }
        }

        if ($user->device_token) {
            if ($isCurrentBooking) {
                $this->generateNotification($user->id, "Booking Created", "Your booking created successfully", 5);
                $this->androidPushNotification(3, "Booking Created", "Your booking created successfully", $user->device_token, 123, 0);
            } else {
                $this->generateNotification($user->id, "Booking Created", "Your upcoming booking created successfully", 5);
                $this->androidBookingPushNotification("Booking Created", "Your upcoming booking created successfully", $user->device_token, $this->notificationCount($user->id));
            }
        }

//        $this->sendRegistration($user->mobile_number, $user->user_name);
        return $this->sendSuccessResponse("User booking created successfully.", (object) []);
    }

    /**
     * @api {get} /api/duty-status Duty status
     * @apiHeader {String} Accept application/json.
     * @apiName GetDutyStatus
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id Staff user id(required).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Request accepted
     * @apiSuccess {JSON}   data object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "status": true,
     *   "status_code": 200,
     *   "message": "Duty status.",
     *   "data": {
     *      "duty_status" : 1
     *      "is_booking" : 1
     *    }
     * }
     * 
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "status": false,
     *   "status_code": 404,
     *   "message": "User id missing.",
     *   "data": {}
     * }
     * 
     * 
     */
    public function dutyStatus(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            $staff = User::find($request->user_id);
            if ($staff) {

                $data['duty_status'] = $staff->is_push_on ? $staff->is_push_on : 0;
                $data['is_booking'] = $staff->is_booking ? $staff->is_booking : 0;
                return $this->sendSuccessResponse("Duty status", $data);
            } else {
                return $this->sendErrorResponse("User not fount", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}
