<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\ServiceQuestionaire;
use App\Models\Question;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\ServiceType;
use App\Models\Resort;
use App\Models\MealOrder;
use App\Models\MealOrderItem;
use App\Models\Amenity;
use App\Models\AmenityRequest;
use App\Models\Activity;
use App\Models\ActivityRequest;
use Carbon\Carbon;
use App\Models\ResortRoom;
use App\Models\RoomType;
use App\Models\UserBookingDetail;

class ServiceController extends Controller {

    /**
     * @api {get} /api/services-list  All services list
     * @apiHeader {String} Accept application/json. 
     * @apiName GetServiceList
     * @apiGroup Services
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Services listing.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Services listing.",
     *    "data": {
     *        "housekeeping": [
     *            {
     *                "id": 1,
     *                "name": "Air conditioner",
     *                "icon": "http://127.0.0.1:8000/storage/Service_icon/cWpiFZ9YG4duaP7Cfch2DgeVn3AYdSBAZPWFkd6g.png",
     *                "questions": [
     *                    {
     *                        "id": 1,
     *                        "name": "question 1"
     *                    },
     *                    {
     *                        "id": 2,
     *                        "name": "question 2"
     *                    }
     *                ]
     *            },
     *            {
     *                "id": 3,
     *                "name": "Air conditioners",
     *                "icon": "http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png",
     *                "questions": [
     *                     {
     *                        "id": 1,
     *                        "name": "question 1"
     *                     },
     *                    {
     *                        "id": 2,
     *                        "name": "question 2"
     *                    }
     *                ]
     *            }
     *        ],
     *        "issues": [
     *            {
     *                 "id": 2,
     *                "name": "Room Cleaning",
     *                "icon": "http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png",
     *                "questions": [
     *                    {
     *                        "id": 1,
     *                        "name": "question 1"
     *                    }
     *                ]
     *           },
     *           {
     *               "id": 4,
     *               "name": "Do Not Disturbe",
     *               "icon": "http://127.0.0.1:8000/storage/Service_icon/i0hRXnlJoVdUcSENmCNxvHANVZ1drvwyFqtVB14O.png",
     *               "questions": [
     *                   {
     *                       "id": 1,
     *                       "name": "question 1"
     *                   },
     *                   {
     *                       "id": 2,
     *                       "name": "question 2"
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     * }
     * 
     * 
     * 
     */
    public function serviceListing(Request $request) {

        $houseKeeping = Service::where(["resort_id" => $request->resort_id, "type_id" => 1, "is_active" => 1])->get();
        $houseKeepingArrray = [];
        if ($houseKeeping) {
            $i = 0;
            foreach ($houseKeeping as $houseKeep) {
                $serviceQuestion = ServiceQuestionaire::where("service_id", $houseKeep->id)->get();
                $houseKeepingArrray[$i]['id'] = $houseKeep->id;
                $houseKeepingArrray[$i]['name'] = $houseKeep->name;
                $houseKeepingArrray[$i]['icon'] = $houseKeep->icon;
                if ($serviceQuestion) {
                    $houseKeepingArrray[$i]['questions'] = [];
                    $j = 0;
                    foreach ($serviceQuestion as $serviceQues) {
//                        $houseKeepingArrray[$i]['questions'][$j]['id'] = $question->id;
                        $houseKeepingArrray[$i]['questions'][$j]['name'] = $serviceQues->question;
                        $j++;
                    }
                } else {
                    $houseKeepingArrray[$i]['questions'] = [];
                }
                $i++;
            }
        } else {
            $houseKeepingArrray = [];
        }

        $issues = Service::where(["resort_id" => $request->resort_id, "type_id" => 2, "is_active" => 1])->get();
        $issuesArrray = [];
        if ($issues) {
            $i = 0;
            foreach ($issues as $issue) {
                $serviceQuestion = ServiceQuestionaire::where("service_id", $issue->id)->get();
                $issuesArrray[$i]['id'] = $issue->id;
                $issuesArrray[$i]['name'] = $issue->name;
                $issuesArrray[$i]['icon'] = $issue->icon;
                if ($serviceQuestion) {
                    $issuesArrray[$i]['questions'] = [];
                    $j = 0;
                    foreach ($serviceQuestion as $serviceQues) {
//                        $question = Question::find($serviceQues->question_id);
//                        $issuesArrray[$i]['questions'][$j]['id'] = $question->id;
                        $issuesArrray[$i]['questions'][$j]['name'] = $serviceQues->question;
                        $j++;
                    }
                } else {
                    $issuesArrray[$i]['questions'] = [];
                }
                $i++;
            }
        } else {
            $issuesArrray = [];
        }

        $response['success'] = true;
        $response['status_code'] = 200;
        $response['message'] = "Services listing.";
        $response['data'] = [
            "housekeeping" => $houseKeepingArrray,
            "issues" => $issuesArrray
        ];
        return $this->jsonData($response);
    }

    /**
     * @api {post} /api/raise-service-request Raise service Request
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName PostRaiseServicerequest
     * @apiGroup Services
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} service_id Service id*.
     * @apiParam {String} resort_id Service id*.
     * @apiParam {String} question_id question id.
     * @apiParam {String} comment Comment.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Request successfully created.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Request successfully created.",
     * "data": {}
     * }
     * 
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *      "status": false,
     *      "status_code": 404,
     *      "message": "User id missing.",
     *      "data": {}
     *  }
     * 
     * @apiError UnauthorizedUser The user is unauthorized.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Unauthorized user.",
     *     "data": {}
     * }
     * 
     * @apiError ServiceIdMissing The service id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "service id missing.",
     *     "data": {}
     * }
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "resort id missing.",
     *     "data": {}
     * }
     * 
     * @apiError InvalidResort The resort is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Invalid resort.",
     *     "data": {}
     * }
     * 
     * @apiError InvalidService The service is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Invalid service.",
     *     "data": {}
     * }
     * 
     * 
     * 
     */
    public function raiseServiceRequest(Request $request) {
        try {

            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if(!$this->bookBeforeCheckInDate($request->user_id)){
              return $this->sendErrorResponse("Sorry! You can not raised request before checkIn date or after checkout date.", (object) []);   
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->service_id) {
                return $this->sendErrorResponse("service id missing.", (object) []);
            }
            if (!$request->resort_id) {
                return $this->sendErrorResponse("resort id missing.", (object) []);
            }

            $user = User::where(["id" => $request->user_id])->first();
            if (!$user) {
                return $this->sendErrorResponse("Invalid user.", (object) []);
            }
            if ($user->user_type_id == 4) {
                return $this->sendErrorResponse("Please provide your check-In details.", (object) []);
            }
            if ($user->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }

            $resort = Resort::where(["id" => $request->resort_id, "is_active" => 1])->first();
            if (!$resort) {
                return $this->sendErrorResponse("Invalid resort.", (object) []);
            }
            $service = Service::where(["id" => $request->service_id, "is_active" => 1])->first();
            if (!$service) {
                return $this->sendErrorResponse("Invalid service.", (object) []);
            }
            $existingServiceRequest = ServiceRequest::where([
                        "user_id" => $request->user_id,
                        "resort_id" => $request->resort_id,
                        "service_id" => $request->service_id,
                    ])->where(function($q) {
                        $q->where("request_status_id", 1)
                        ->orWhere("request_status_id", 2);
                    })->first();
            if ($existingServiceRequest) {
                return $this->sendErrorResponse("Request already raised.", (object) []);
            } else {
                $userDetail = User::where("id", $request->user_id)->with([
                            'userBookingDetail' => function($query) {
                                $query->selectRaw(DB::raw('id, room_type_id, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%b-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%b-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time'));
                            }
                        ])->first();

                $serviceRequest = new ServiceRequest();
                $serviceRequest->resort_id = $request->resort_id;
                $serviceRequest->user_id = $request->user_id;
                $serviceRequest->service_id = $request->service_id;
                $serviceRequest->room_type_name = $userDetail->userBookingDetail->room_type_detail ? $userDetail->userBookingDetail->room_type_detail->name : "";
                $serviceRequest->resort_room_no = $userDetail->userBookingDetail->room_detail ? $userDetail->userBookingDetail->room_detail->room_no : "";
                $serviceRequest->comment = $request->comment ? $request->comment : '';
                $serviceRequest->questions = $request->question_id ? $request->question_id : 0;
                $serviceRequest->request_status_id = 1;
                if ($serviceRequest->save()) {
                    $resortUsers = UserBookingDetail::where("resort_id", $request->resort_id)->pluck("user_id");
                    if ($resortUsers) {
                        $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2, "is_service_authorise" => 1])
                                ->whereIn("id", $resortUsers->toArray())
                                ->pluck("device_token");
                        if ($staffDeviceTokens) {
                            $this->androidPushNotification(2, "Servie Raised", "$service->name request raised by customer", $staffDeviceTokens->toArray(), 1, $service->id);
                            $this->generateNotification($request->user_id, "Service Raised", "$service->name request raised by you", 1);
                        }
                    }
                    return $this->sendSuccessResponse("Request successfully created.", (object) []);
                } else {
                    return $this->sendErrorResponse("Something went be wrong.", (object) []);
                }
            }
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {get} /api/order-request-list  Order & Request list
     * @apiHeader {String} Accept application/json. 
     * @apiName GetOrderRequestlist
     * @apiGroup Services
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Order & Request found.
     * @apiSuccess {JSON} data array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Services list",
     *       "data": {
     *           "ongoing_services": [],
     *           "complete_services": [
     *               {
     *                   "id": 1,
     *                   "record_id": 1,
     *                   "name": "Do Not Disturbe",
     *                   "icon": "http://127.0.0.1:8000/storage/Service_icon/XfNlJoZ3L4Pj0dbM8lJIyIXtkqTK4FXaANlUwwOo.jpeg",
     *                   "date": "13-12-2018",
     *                   "time": "04:53:09 PM",
     *                   "status_id": 4,
     *                   "status": "Completed",
     *                   "acceptd_by": "",
     *                   "type": 1
     *               },
     *               {
     *                   "id": 1,
     *                   "record_id": 2,
     *                   "name": "sadsaGym",
     *                   "icon": "",
     *                   "date": "13-12-2018",
     *                   "time": "17:48 pm",
     *                   "status_id": 1,
     *                   "status": "Booked",
     *                   "acceptd_by": "",
     *                   "type": 2
     *               },
     *               {
     *                   "id": 1,
     *                   "record_id": 1,
     *                   "name": "Gym",
     *                   "icon": "",
     *                   "date": "13-12-2018",
     *                   "time": "19:05 pm",
     *                   "status_id": 1,
     *                   "status": "Booked",
     *                   "acceptd_by": "",
     *                   "type": 3
     *               },
     *               {
     *                   "id": 1,
     *                   "record_id": 1,
     *                   "name": "1544722346",
     *                   "icon": "",
     *                   "date": "13-12-2018",
     *                   "time": "17:32 pm",
     *                   "total_item_count": 1,
     *                   "total_amount": 240.6,
     *                   "status_id": 1,
     *                   "status": "Confirmed",
     *                   "acceptd_by": "",
     *                   "type": 4
     *               }
     *           ]
     *       }
     *   }
     * 
     * @apiError OrderRequestNotFound The Order & Request not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Order & Request not found.",
     *       "data": {
     *           "order_request": []
     *       }
     *   }
     * 
     * @apiError UserIdMissing The User id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "user id missing.",
     *       "data": {}
     *   }
     * 
     * 
     */
    public function userServiceRequest(Request $request) {

        try {
            if (!$request->user_id) {
                return response()->json([
                            'status' => false,
                            'status_code' => 404,
                            'message' => "user id missing.",
                            'data' => (object) []
                ]);
            }
            $ongoingServices = ServiceRequest::select(DB::raw('id, staff_reasons, staff_comment, comment, service_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time, DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_timestamp'))
//            $serviceRequest['order_request']['ongoing_order'] = ServiceRequest::select(DB::raw('id, comment, service_id, question_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time'))
                            ->where(["user_id" => $request->user_id])
                            ->where(function($q) {
                                $q->where("request_status_id", 1)
                                ->orWhere("request_status_id", 2)
                                ->orWhere("request_status_id", 3);
//                                ->orWhere("request_status_id", 5);
                            })
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->select('id', 'name', 'type_id', 'icon');
                                }
                            ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->userRequestStatus();
                        }
                    ])->with([
                        'acceptedBy' => function($query) {
                            $query->select('id', 'user_name', 'first_name', 'last_name');
                        }
                    ])->get();

            $ongoingDataArray = [];
            $i = 0;
            foreach ($ongoingServices as $ongoingService) {
                $ongoingDataArray[$i]["id"] = $ongoingService->id;
                $ongoingDataArray[$i]["record_id"] = $ongoingService->id;
                $ongoingDataArray[$i]["name"] = $ongoingService->serviceDetail ? $ongoingService->serviceDetail->name : "";
                $ongoingDataArray[$i]["icon"] = $ongoingService->serviceDetail ? $ongoingService->serviceDetail->icon : "";
                $ongoingDataArray[$i]["date"] = $ongoingService->date;
                $ongoingDataArray[$i]["time"] = $ongoingService->date . " " . $ongoingService->time;
                $ongoingDataArray[$i]["date_time"] = $ongoingService->created_timestamp;
                $ongoingDataArray[$i]["status_id"] = $ongoingService->requestStatus->id;
                $ongoingDataArray[$i]["status"] = $ongoingService->requestStatus ? $ongoingService->requestStatus->status : "";
                $ongoingDataArray[$i]["acceptd_by"] = isset($ongoingService->acceptedBy->user_name) ? $ongoingService->acceptedBy->user_name : "";
                $ongoingDataArray[$i]["type"] = 1;
                $ongoingDataArray[$i]["staff_reasons"] = $ongoingService->staff_reasons;
                $ongoingDataArray[$i]["staff_comment"] = $ongoingService->staff_comment;
                $i++;
            }

            $ongoingMealOrders = MealOrder::where(["user_id" => $request->user_id])
                    ->where(function($q) {
                        $q->where("status", 1)
                        ->orWhere("status", 2)
                        ->orWhere("status", 3);
                    })
                    ->get();
            foreach ($ongoingMealOrders as $ongoingMealOrder) {
                $stat = "";
                if ($ongoingMealOrder->status == 1) {
                    $stat = "Pending";
                } elseif ($ongoingMealOrder->status == 2) {
                    $stat = "Accepted";
                } elseif ($ongoingMealOrder->status == 3) {
                    $stat = "Your approval needed";
                } else {
                    $stat = "Invalid status";
                }
                $createdAt = Carbon::parse($ongoingMealOrder->created_at);
                $totalItem = MealOrderItem::where("meal_order_id", $ongoingMealOrder->id)->count();
                $ongoingDataArray[$i]["id"] = $ongoingMealOrder->id;
                $ongoingDataArray[$i]["record_id"] = $ongoingMealOrder->id;
                $ongoingDataArray[$i]["name"] = $ongoingMealOrder->invoice_id;
                $ongoingDataArray[$i]["icon"] = "";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-m-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("d-m-Y")." ".$createdAt->format("h:i a");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["total_item_count"] = $totalItem;
                $ongoingDataArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
                $ongoingDataArray[$i]["status_id"] = $ongoingMealOrder->status;
                $ongoingDataArray[$i]["status"] = $stat;
                $ongoingDataArray[$i]["acceptd_by"] = "";
                $ongoingDataArray[$i]["type"] = 4;
                $i++;
            }

            $ongoingAmenities = AmenityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
            ->where("booking_date" ,">", date("Y-m-d H:i:s"))
            ->get();
            foreach ($ongoingAmenities as $completedAmenity) {
                $createdAt = Carbon::parse($completedAmenity->created_at);
                $amenity = Amenity::find($completedAmenity->amenity_id);
                $ongoingDataArray[$i]["id"] = $completedAmenity->id;
                $ongoingDataArray[$i]["record_id"] = $completedAmenity->amenity_id;
                $ongoingDataArray[$i]["name"] = $amenity->name;
                $ongoingDataArray[$i]["icon"] = "";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-m-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("d-m-Y")." ".$createdAt->format("h:i a");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["status_id"] = 2;
                $ongoingDataArray[$i]["status"] = "Upcoming";
                $ongoingDataArray[$i]["acceptd_by"] = "";
                $ongoingDataArray[$i]["type"] = 2;
                $i++;
            }

            $ongoingActivities = ActivityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
            ->where("booking_date", ">" , date("Y-m-d H:i:s"))
            ->get();
            foreach ($ongoingActivities as $completedActivity) {
                $createdAt = Carbon::parse($completedActivity->created_at);
                $activity = Activity::find($completedActivity->amenity_id);
                $ongoingDataArray[$i]["id"] = $completedActivity->id;
                $ongoingDataArray[$i]["record_id"] = $completedActivity->amenity_id;
                $ongoingDataArray[$i]["name"] = $activity->name;
                $ongoingDataArray[$i]["icon"] = "";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-m-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("d-m-Y")." ".$createdAt->format("h:i a");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["status_id"] = 2;
                $ongoingDataArray[$i]["status"] = "Upcoming";
                $ongoingDataArray[$i]["acceptd_by"] = "";
                $ongoingDataArray[$i]["type"] = 3;
                $i++;
            }


            $completedServices = ServiceRequest::select(DB::raw('id,staff_reasons, staff_comment, comment, service_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time, DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_timestamp'))
                            ->where(["user_id" => $request->user_id])
                            ->where(function($q) {
                                $q->where("request_status_id", 4)
                                ->orWhere("request_status_id", 5);
                            })
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->select('id', 'name', 'type_id', 'icon');
                                }
                            ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->userRequestStatus();
                        }
                    ])->with([
                        'acceptedBy' => function($query) {
                            $query->select('id', 'user_name', 'first_name', 'last_name');
                        }
                    ])->get();

            $completedDataArray = [];
            $j = 0;
            foreach ($completedServices as $completedService) {
                $completedDataArray[$j]["id"] = $completedService->id;
                $completedDataArray[$j]["record_id"] = $completedService->id;
                $completedDataArray[$j]["name"] = $completedService->serviceDetail ? $completedService->serviceDetail->name : "";
                $completedDataArray[$j]["icon"] = $completedService->serviceDetail ? $completedService->serviceDetail->icon : "";
                $completedDataArray[$j]["date"] = $completedService->date;
                $completedDataArray[$j]["time"] = $completedService->date . " " . $completedService->time;
                $completedDataArray[$j]["date_time"] = $completedService->created_timestamp;
                $completedDataArray[$j]["status_id"] = $completedService->requestStatus->id;
                $completedDataArray[$j]["status"] = $completedService->requestStatus ? $completedService->requestStatus->status : 0;
                $completedDataArray[$j]["acceptd_by"] = isset($completedService->acceptedBy->user_name) ? $completedService->acceptedBy->user_name : "";
                $completedDataArray[$j]["type"] = 1;
                $completedDataArray[$j]["staff_reasons"] = $completedService->staff_reasons;
                $completedDataArray[$j]["staff_comment"] = $completedService->staff_comment;
                $j++;
            }

            $completedAmenities = AmenityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
            ->where("booking_date" ,"<=", date("Y-m-d H:i:s"))
            ->get();
            foreach ($completedAmenities as $completedAmenity) {
                $createdAt = Carbon::parse($completedAmenity->created_at);
                $amenity = Amenity::find($completedAmenity->amenity_id);
                $completedDataArray[$j]["id"] = $completedAmenity->id;
                $completedDataArray[$j]["record_id"] = $completedAmenity->amenity_id;
                $completedDataArray[$j]["name"] = $amenity->name;
                $completedDataArray[$j]["icon"] = "";
                $completedDataArray[$j]["date"] = $createdAt->format("d-m-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("d-m-Y")." ".$createdAt->format("h:i a");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["status_id"] = 1;
                $completedDataArray[$j]["status"] = "Confirmed";
                $completedDataArray[$j]["acceptd_by"] = "";
                $completedDataArray[$j]["type"] = 2;
                $j++;
            }
            $completedActivities = ActivityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
            ->where("booking_date", "<=" , date("Y-m-d H:i:s"))
            ->get();
            foreach ($completedActivities as $completedActivity) {
                $createdAt = Carbon::parse($completedActivity->created_at);
                $activity = Activity::find($completedActivity->amenity_id);
                $completedDataArray[$j]["id"] = $completedActivity->id;
                $completedDataArray[$j]["record_id"] = $completedActivity->amenity_id;
                $completedDataArray[$j]["name"] = $activity->name;
                $completedDataArray[$j]["icon"] = "";
                $completedDataArray[$j]["date"] = $createdAt->format("d-m-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("d-m-Y")." ".$createdAt->format("h:i a");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["status_id"] = 1;
                $completedDataArray[$j]["status"] = "Confirmed";
                $completedDataArray[$j]["acceptd_by"] = "";
                $completedDataArray[$j]["type"] = 3;
                $j++;
            }

            $completedMealOrders = MealOrder::where(["user_id" => $request->user_id])
                    ->where(function($q) {
                        $q->where("status", 4)
                        ->orWhere("status", 5);
                    })
                    ->get();
            foreach ($completedMealOrders as $completedMealOrder) {
                $createdAt = Carbon::parse($completedMealOrder->created_at);
                $totalItem = MealOrderItem::where("meal_order_id", $completedMealOrder->id)->count();
                $completedDataArray[$j]["id"] = $completedMealOrder->id;
                $completedDataArray[$j]["record_id"] = $completedMealOrder->id;
                $completedDataArray[$j]["name"] = $completedMealOrder->invoice_id;
                $completedDataArray[$j]["icon"] = "";
                $completedDataArray[$j]["date"] = $createdAt->format("d-m-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("d-m-Y")." ".$createdAt->format("h:i a");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["total_item_count"] = $totalItem;
                $completedDataArray[$j]["total_amount"] = $completedMealOrder->total_amount;
                $completedDataArray[$j]["status_id"] = $completedMealOrder->status;
                $completedDataArray[$j]["status"] = $completedMealOrder->status == 4 ? "Completed": "Rejected";
                $completedDataArray[$j]["acceptd_by"] = "";
                $completedDataArray[$j]["type"] = 4;
                $j++;
            }

            usort($ongoingDataArray, function ($a, $b) {
                $t1 = strtotime($a['date_time']);
                $t2 = strtotime($b['date_time']);
                return $t2 - $t1;
            });
            usort($completedDataArray, function ($a, $b) {
                $t1 = strtotime($a['date_time']);
                $t2 = strtotime($b['date_time']);
                return $t2 - $t1;
            });
            $data["ongoing_services"] = $ongoingDataArray;
            $data["complete_services"] = $completedDataArray;
            return $this->sendSuccessResponse("Services list", $data);
        } catch (\Exception $ex) {
            return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => $ex->getMessage(),
                        'data' => []
            ]);
        }
    }

    /**
     * @api {post} /api/approve-service-request Approve service Request
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName PostApproveServicerequest
     * @apiGroup Services
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} service_id Service id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Service approved successfully.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Service approved successfully.",
     * "data": {}
     * }
     * 
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *      "status": false,
     *      "status_code": 404,
     *      "message": "User id missing.",
     *      "data": {}
     *  }
     * 
     * @apiError UnauthorizedUser The user is unauthorized.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Unauthorized user.",
     *     "data": {}
     * }
     * 
     * @apiError ServiceIdMissing The service id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "service id missing.",
     *     "data": {}
     * }
     * 
     * @apiError InvalidService The service is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Invalid service.",
     *     "data": {}
     * }
     * 
     * 
     * 
     */
    public function approveServiceRequest(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            $user = User::where(["id" => $request->user_id, "is_active" => 1])->first();
            if (!$user) {
                return $this->sendErrorResponse("Invalid user.", (object) []);
            }
            if (!$request->type) {
                return $this->sendErrorResponse("Type missing.", (object) []);
            }
            if (!$request->record_id) {
                return $this->sendErrorResponse("record id missing.", (object) []);
            }
            if ($request->type == 1) {


                $serviceRequest = ServiceRequest::where(["id" => $request->record_id, "request_status_id" => 3, "is_active" => 1])->first();
                if (!$serviceRequest) {
                    return $this->sendErrorResponse("Invalid service & order.", (object) []);
                }
                $serviceRequest->request_status_id = 4;
                if ($serviceRequest->save()) {
                    $staff = User::find($serviceRequest->accepted_by_id);
                    $this->androidPushNotification(2, "Service Request", "Great! your Service approved by customer.", $staff->device_token, 1, $serviceRequest->service_id);
                    return $this->sendSuccessResponse("Service approved successfully", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } elseif ($request->type == 4) {
                $serviceRequest = MealOrder::where(["id" => $request->record_id, "status" => 3, "is_active" => 1])->first();
                if (!$serviceRequest) {
                    return $this->sendErrorResponse("Invalid service & order.", (object) []);
                }
                $serviceRequest->status = 4;
                if ($serviceRequest->save()) {
                    $staff = User::find($serviceRequest->accepted_by);
                    $this->androidPushNotification(2, "Service Request", "Great! your Meal order service approved by customer.", $staff->device_token, 1, $serviceRequest->id);
                    return $this->sendSuccessResponse("Service approved successfully", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } else {
                return $this->sendErrorResponse("Invalid service & order.", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
