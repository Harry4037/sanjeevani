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
use App\Models\Service;

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

            //If services & issues is authorized for user
            $serviceArray = [];
            if ($request->user()->is_service_authorise == 1) {
                $newServices = ServiceRequest::select('id', 'comment', 'questions', 'service_id', 'user_id', 'created_at', 'room_type_name', 'resort_room_no')->where(["resort_id" => $request->resort_id, "request_status_id" => 1])
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
                $mealOrders = MealOrder::where(["resort_id" => $request->resort_id, "status" => 1])
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
                    $mealDataArray[$j]["gst_amount"] = $mealOrder->gst_amount;
                    $mealDataArray[$j]["total_amount"] = $mealOrder->total_amount;
                    $mealDataArray[$j]["user_name"] = $mealOrder->userDetail->user_name;
                    $mealDataArray[$j]["room_no"] = "";
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
            $amenities = Amenity::where(["resort_id" => $request->resort_id, "is_active" => 1])
                    ->whereIn("id", $authoriseAmenityIds)
                    ->latest()
                    ->get();
            $amenitiesDataArray = [];
            foreach ($amenities as $z => $amenitie) {
                $amenitiesBookingCount = AmenityRequest::where(["amenity_id" => $amenitie->id, "booking_date" => date("Y-m-d")])->count();
                $amenitiesDataArray[$z]["id"] = $amenitie->id;
                $amenitiesDataArray[$z]["name"] = $amenitie->name;
                $amenitiesDataArray[$z]["icon"] = $amenitie->icon;
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
                $this->generateNotification($user->id, "Service accepted", "Your service request accepted by our staff member. Our staff will contact you soon.", 1);
                $this->androidPushNotification(3, "Service Request", "Your ".$service->name." request is accepted by ".$request->user()->user_name, $user->device_token, 1, $serviceRequest->service_id);
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

            $ongoing_jobs = ServiceRequest::select('id', 'comment', 'questions', 'staff_reasons', 'staff_comment', 'service_id', 'request_status_id', 'user_id', 'room_type_name', 'resort_room_no')->where(["accepted_by_id" => $request->user()->id, "request_status_id" => 2, "is_active" => 1])
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
                $ongoingJobArray[$i]["date"] = $createdAt->format("d-m-Y");
                $ongoingJobArray[$i]["time"] = $createdAt->format("h:i a");
                $ongoingJobArray[$i]["total_item_count"] = count($mealItems);
                $ongoingJobArray[$i]["user_name"] = $ongoingMealOrder->userDetail->user_name;
                $ongoingJobArray[$i]["room_no"] = "";
                $ongoingJobArray[$i]["gst_amount"] = $ongoingMealOrder->gst_amount;
                $ongoingJobArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
                $ongoingJobArray[$i]["status_id"] = $ongoingMealOrder->status;
                $ongoingJobArray[$i]["status"] = "Pending";
                $ongoingJobArray[$i]["acceptd_by"] = "";
                $ongoingJobArray[$i]["type"] = 4;
                if ($mealItems) {
                    $ongoingJobArray[$i]["meal_items"] = [];
//                    $ongoingJobArray[$i]["meal_items"][0]["id"] = 1;
//                    $ongoingJobArray[$i]["meal_items"][0]["meal_item_name"] = "Dummy";
//                    $ongoingJobArray[$i]["meal_items"][0]["price"] = 123;
//                    $ongoingJobArray[$i]["meal_items"][0]["quantity"] = 25;
//                    $ongoingJobArray[$i]["meal_items"][0]["image_url"] = "";
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
//                    $ongoingJobArray[$i]["meal_items"][0]["id"] = 1;
//                    $ongoingJobArray[$i]["meal_items"][0]["meal_item_name"] = "Dummy";
//                    $ongoingJobArray[$i]["meal_items"][0]["price"] = 123;
//                    $ongoingJobArray[$i]["meal_items"][0]["quantity"] = 25;
//                    $ongoingJobArray[$i]["meal_items"][0]["image_url"] = "";
                }
                $i++;
            }

            $under_approval_jobs = ServiceRequest::select('id', 'comment', 'questions', 'staff_reasons', 'staff_comment', 'service_id', 'request_status_id', 'user_id', 'room_type_name', 'resort_room_no')->where(["accepted_by_id" => $request->user()->id, "request_status_id" => 3, "is_active" => 1])
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
                        $q->where("status", 3);
                    })->latest()
                    ->get();
            foreach ($underMealOrders as $ongoingMealOrder) {
                $createdAt = Carbon::parse($ongoingMealOrder->created_at);
                $mealItems = MealOrderItem::where("meal_order_id", $ongoingMealOrder->id)->get();
                $underApprovalJobArray[$j]["id"] = $ongoingMealOrder->id;
                $underApprovalJobArray[$j]["record_id"] = $ongoingMealOrder->id;
                $underApprovalJobArray[$j]["name"] = $ongoingMealOrder->invoice_id;
                $underApprovalJobArray[$j]["icon"] = "";
                $underApprovalJobArray[$j]["date"] = $createdAt->format("d-m-Y");
                $underApprovalJobArray[$j]["time"] = $createdAt->format("h:i a");
                $underApprovalJobArray[$j]["total_item_count"] = count($mealItems);
                $underApprovalJobArray[$j]["user_name"] = $ongoingMealOrder->userDetail->user_name;
                $underApprovalJobArray[$j]["room_no"] = "";
                $underApprovalJobArray[$j]["gst_amount"] = $ongoingMealOrder->gst_amount;
                $underApprovalJobArray[$j]["total_amount"] = $ongoingMealOrder->total_amount;
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

            $completed_jobs = ServiceRequest::select('id', 'comment', 'questions', 'staff_reasons', 'staff_comment', 'service_id', 'request_status_id', 'user_id', 'room_type_name', 'resort_room_no')->where(["accepted_by_id" => $request->user()->id, "request_status_id" => 4, "is_active" => 1])
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
                $completedJobArray[$i]["date"] = $createdAt->format("d-m-Y");
                $completedJobArray[$i]["time"] = $createdAt->format("h:i a");
                $completedJobArray[$i]["total_item_count"] = count($mealItems);
                $completedJobArray[$i]["user_name"] = $ongoingMealOrder->userDetail->user_name;
                $completedJobArray[$i]["room_no"] = "";
                $completedJobArray[$i]["gst_amount"] = $ongoingMealOrder->gst_amount;
                $completedJobArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
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
                    $this->generateNotification($job->user_id, "Service Request", "Your service completed by ".$request->user()->user_name, 1);
                    $this->androidPushNotification(3, "Service Request", "Your ".$service->name." request marked as commplete by ".$request->user()->user_name, $user->device_token, 1, $job->service_id);
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
                    $this->generateNotification($user->id, "Meal Order", "You meal order with invoice Id $job->invoice_id completed by ".$request->user()->user_name, 4);

                    $this->androidPushNotification(3, "Meal Order", "You meal order with invoice Id $job->invoice_id completed by ".$request->user()->user_name, $user->device_token, 4, $job->id);
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
                    $this->generateNotification($user->id, "Service Request", "Unfortunately! Your request is not resolved by ".$request->user()->user_name, 1);
                    $this->androidPushNotification(3, "Service Request", "Unfortunately! Your request is not resolved by ".$request->user()->user_name, $user->device_token, 1, $job->service_id);
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
                if ($job->save()) {
                    $user = User::find($job->user_id);
                    $this->generateNotification($user->id, "Meal Order", "Unfortunately! Your meal order request rejected by ".$request->user()->user_name, 1);
                    $this->androidPushNotification(3, "Meal Order", "Unfortunately! Your meal order request rejected by ".$request->user()->user_name, $user->device_token, 1, $job->id);
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

            $order->status = $request->status;
            $order->accepted_by = $request->user_id;
            if ($order->save()) {
                $user = User::find($order->user_id);
                $msg = "Invalid status.";
                if ($order->status == -1) {
                    $this->generateNotification($user->id, "Meal Order", "Unfortunately!You meal order with invoice Id $order->invoice_id rejected by ".$request->user()->user_name, 4);
                    $this->androidPushNotification(3, "Meal Order", "Unfortunately!Your meal order with invoice id $order->invoice_id rejected by ".$request->user()->user_name, $user->device_token, 4, $order->id);

                    $msg = "Order rejected succeffully.";
                }
                if ($order->status == 1) {
                    $this->generateNotification($user->id, "Meal Order", "You meal order with invoice Id $order->invoice_id accepted by ".$request->user()->user_name, 4);
                    $this->androidPushNotification(3, "Meal Order", "Your meal order with invoice id $order->invoice_id accepted by ".$request->user()->user_name, $user->device_token, 4, $order->id);
                    $msg = "Order accepted succeffully.";
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
            if (!$request->amenity_id) {
                return $this->sendErrorResponse("amenity id missing.", (object) []);
            }
            $amenity = Amenity::find($request->amenity_id);
            if (!$amenity) {
                return $this->sendErrorResponse("Invalid amenity.", (object) []);
            }
            $amenitySlots = AmenityTimeSlot::where(["amenity_id" => $request->amenity_id, "is_active" => 1])->get();
            $amenitySlotData = [];
            foreach ($amenitySlots as $i => $amenitySlot) {
                $amenitiesRequests = AmenityRequest::where(["amenity_id" => $request->amenity_id, "from" => $amenitySlot->from, "to" => $amenitySlot->to, "booking_date" => $request->booking_date])
                        ->with("userDetail")
                        ->get();
                $from = Carbon::parse($amenitySlot->from);
                $to = Carbon::parse($amenitySlot->to);
                $amenitySlotData[$i]['slot'] = $from->format("H:i") . "-" . $to->format("H:i");
                if ($amenitiesRequests) {
                    $amenitySlotData[$i]['bookings'] = [];
                    foreach ($amenitiesRequests as $j => $amenitiesRequest) {
                        $created_at = Carbon::parse($amenitiesRequest->created_at);
                        $amenitySlotData[$i]['bookings'][$j]["id"] = $amenitiesRequest->id;
                        $amenitySlotData[$i]['bookings'][$j]["user_name"] = $amenitiesRequest->userDetail->user_name;
                        $amenitySlotData[$i]['bookings'][$j]["room_no"] = "100";
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

}
