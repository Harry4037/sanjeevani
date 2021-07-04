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
     * @apiParam {String} resort_id Resort Id (For guest user use resort id value -1).
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
     *                        "name": "question 1"
     *                    },
     *                    {
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
     *                        "name": "question 1"
     *                     },
     *                    {
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
     *                       "name": "question 1"
     *                   },
     *                   {
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

        if ($request->resort_id == -1) {
            $resortId = 0;
            $defaultResort = Resort::where("is_default", 1)->first();
            if ($defaultResort) {
                $resortId = $defaultResort->id;
            } else {
                $defaultResort = Resort::query()->first();
                $resortId = $defaultResort->id;
            }

            $houseKeeping = Service::where(["resort_id" => $resortId, "type_id" => 1, "is_active" => 1])->get();
        } else {
            $houseKeeping = Service::where(["resort_id" => $request->resort_id, "type_id" => 1, "is_active" => 1])->get();
        }
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

        if ($request->resort_id == -1) {
            $resortId = 0;
            $defaultResort = Resort::where("is_default", 1)->first();
            if ($defaultResort) {
                $resortId = $defaultResort->id;
            } else {
                $defaultResort = Resort::query()->first();
                $resortId = $defaultResort->id;
            }

            $issues = Service::where(["resort_id" => $resortId, "type_id" => 2, "is_active" => 1])->get();
        } else {
            $issues = Service::where(["resort_id" => $request->resort_id, "type_id" => 2, "is_active" => 1])->get();
        }
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
     * @apiParam {String} resort_id Resort id*.
     * @apiParam {String} question_id questions by comma separated.
     * @apiParam {String} comment Comment.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Request successfully created.
     * @apiSuccess {JSON}   data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "Our staff member will contact you soon.",
      "data": {}
      }
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
            if (!$this->bookBeforeCheckInDate($request->user_id)) {
                return $this->sendErrorResponse("Sorry! You can not raise request before checkIn date or after checkout date.", (object) []);
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
//            $existingServiceRequest = ServiceRequest::where([
//                        "user_id" => $request->user_id,
//                        "resort_id" => $request->resort_id,
//                        "service_id" => $request->service_id,
//                    ])->where(function($q) {
//                        $q->where("request_status_id", 1)
//                                ->orWhere("request_status_id", 2);
//                    })->first();
//            if ($existingServiceRequest) {
//                return $this->sendErrorResponse("Request already raised.", (object) []);
//            } else {
            $userDetail = User::where("id", $request->user_id)->with([
                        'userBookingDetail'
//                        => function($query) {
//                            $query->selectRaw(DB::raw('id, room_type_id, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%b-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%b-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time, resort_room_no, room_type_name'));
//                        }
                    ])->first();
            $serviceRequest = new ServiceRequest();
            $serviceRequest->resort_id = $request->resort_id;
            $serviceRequest->user_id = $request->user_id;
            $serviceRequest->service_id = $request->service_id;
            $serviceRequest->room_type_name = $userDetail->userBookingDetail ? $userDetail->userBookingDetail->room_type_name : "";
            $serviceRequest->resort_room_no = $userDetail->userBookingDetail ? $userDetail->userBookingDetail->resort_room_no : "";
            $serviceRequest->comment = $request->comment ? $request->comment : '';
            $serviceRequest->questions = $request->question_id ? $request->question_id : 0;
            $serviceRequest->request_status_id = 1;
            if ($serviceRequest->save()) {
                $resortUsers = UserBookingDetail::where("resort_id", $request->resort_id)->pluck("user_id");
                $this->generateNotification($request->user_id, "Service Raised", "$service->name request raised by you", 1);
                if ($user->device_token) {
                    $this->androidPushNotification(3, "Service Raised", "$service->name request raised by you", $user->device_token, 1, $service->id, $this->notificationCount($user->id));
                }
                if ($resortUsers) {
                    $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2, "is_service_authorise" => 1, "is_push_on" => 1])
                            ->where("device_token", "!=", NULL)
                            ->whereIn("id", $resortUsers->toArray())
                            ->pluck("device_token");
                    if (count($staffDeviceTokens) > 0) {
                        $this->androidPushNotification(2, "Service Raised", "$service->name request raised from Room# " . $serviceRequest->resort_room_no . " by " . $userDetail->user_name, $staffDeviceTokens->toArray(), 1, $service->id, 0, 1);
                    }
                }
                return $this->sendSuccessResponse("Our staff member will contact you soon.", (object) []);
            } else {
                return $this->sendErrorResponse("Something went be wrong.", (object) []);
            }
//            }
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
      {
      "status": true,
      "status_code": 200,
      "message": "Services list",
      "data": {
      "ongoing_services": [
      {
      "id": 67,
      "record_id": 67,
      "name": "1551681813",
      "icon": "http://devsanjeevani.dbaquincy.com/img/my_meal.png",
      "date": "04-Mar-2019",
      "time": "12:13 PM",
      "date_time": "04-03-2019 12:13:33",
      "total_item_count": 1,
      "total_amount": 53,
      "status_id": 1,
      "status": "Pending",
      "acceptd_by": "",
      "type": 4
      }
      ],
      "complete_services": [
      {
      "id": 120,
      "record_id": 120,
      "name": "Room Cleaning",
      "icon": "http://127.0.0.1:1234/storage/Service_icon/bG8tskL0dmA4XmCjBWC35v01uauybI9YyvKx0apH.png",
      "date": "04-Mar-2019",
      "time": "12:23 PM",
      "date_time": "04-03-2019 12:23:31",
      "status_id": 4,
      "status": "Completed",
      "acceptd_by": "Ankit Sharma",
      "type": 1,
      "staff_reasons": null,
      "staff_comment": null
      }
      ]
      }
      }
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
            $ongoingServices = ServiceRequest::select(DB::raw('id, staff_reasons, staff_comment, comment, service_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%b-%Y") as date, DATE_FORMAT(created_at, "%h:%i %p") as time, DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_timestamp'))
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
                $ongoingDataArray[$i]["time"] = $ongoingService->time;
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
                $acceptedBy = User::find($ongoingMealOrder->accepted_by);
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
                $ongoingDataArray[$i]["icon"] = "http://devsanjeevani.dbaquincy.com/img/my_meal.png";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-M-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("h:i A");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["total_item_count"] = $totalItem;
                $ongoingDataArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
                $ongoingDataArray[$i]["status_id"] = $ongoingMealOrder->status;
                $ongoingDataArray[$i]["status"] = $stat;
                $ongoingDataArray[$i]["acceptd_by"] = $acceptedBy ? $acceptedBy->user_name : "";
                $ongoingDataArray[$i]["type"] = 4;
                $i++;
            }

            $ongoingAmenities = AmenityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
                    ->whereRaw("CONCAT(`booking_date`, ' ', `from`) > '" . date("Y-m-d H:i:s") . "'")
                    ->get();
            foreach ($ongoingAmenities as $completedAmenity) {
                $createdAt = Carbon::parse($completedAmenity->created_at);
                $amenity = Amenity::withTrashed()->find($completedAmenity->amenity_id);
                $ongoingDataArray[$i]["id"] = $completedAmenity->id;
                $ongoingDataArray[$i]["record_id"] = $completedAmenity->amenity_id;
                $ongoingDataArray[$i]["name"] = $amenity->name;
                $ongoingDataArray[$i]["icon"] = "http://devsanjeevani.dbaquincy.com/img/my_activities.png";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-M-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("h:i A");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["status_id"] = 2;
                $ongoingDataArray[$i]["status"] = "Confirmed";
                $ongoingDataArray[$i]["acceptd_by"] = "";
                $ongoingDataArray[$i]["type"] = 2;
                $i++;
            }

            $ongoingActivities = ActivityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
                    ->whereRaw("CONCAT(`booking_date`, ' ', `from`) > '" . date("Y-m-d H:i:s") . "'")
                    ->get();
            foreach ($ongoingActivities as $completedActivity) {
                $createdAt = Carbon::parse($completedActivity->created_at);
                $activity = Activity::withTrashed()->find($completedActivity->amenity_id);
                $ongoingDataArray[$i]["id"] = $completedActivity->id;
                $ongoingDataArray[$i]["record_id"] = $completedActivity->amenity_id;
                $ongoingDataArray[$i]["name"] = $activity->name;
                $ongoingDataArray[$i]["icon"] = "http://devsanjeevani.dbaquincy.com/img/my_amenities.png";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-M-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("h:i A");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["status_id"] = 2;
                $ongoingDataArray[$i]["status"] = "Confirmed";
                $ongoingDataArray[$i]["acceptd_by"] = "";
                $ongoingDataArray[$i]["type"] = 3;
                $i++;
            }


            $completedServices = ServiceRequest::select(DB::raw('id,staff_reasons, staff_comment, comment, service_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%b-%Y") as date, DATE_FORMAT(created_at, "%h:%i %p") as time, DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_timestamp'))
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
                $completedDataArray[$j]["time"] = $completedService->time;
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
                    ->whereRaw("CONCAT(`booking_date`, ' ', `from`) <= '" . date("Y-m-d H:i:s") . "'")
                    ->get();
            foreach ($completedAmenities as $completedAmenity) {
                $createdAt = Carbon::parse($completedAmenity->created_at);
                $amenity = Amenity::withTrashed()->find($completedAmenity->amenity_id);
                $completedDataArray[$j]["id"] = $completedAmenity->id;
                $completedDataArray[$j]["record_id"] = $completedAmenity->amenity_id;
                $completedDataArray[$j]["name"] = $amenity->name;
                $completedDataArray[$j]["icon"] = "http://devsanjeevani.dbaquincy.com/img/my_amenities.png";
                $completedDataArray[$j]["date"] = $createdAt->format("d-M-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("h:i A");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["status_id"] = 1;
                $completedDataArray[$j]["status"] = "Confirmed";
                $completedDataArray[$j]["acceptd_by"] = "";
                $completedDataArray[$j]["type"] = 2;
                $j++;
            }
            $completedActivities = ActivityRequest::where(["user_id" => $request->user_id, "is_active" => 1])
                    ->whereRaw("CONCAT(`booking_date`, ' ', `from`) <= '" . date("Y-m-d H:i:s") . "'")
                    ->get();
            foreach ($completedActivities as $completedActivity) {
                $createdAt = Carbon::parse($completedActivity->created_at);
                $activity = Activity::find($completedActivity->amenity_id);
                $completedDataArray[$j]["id"] = $completedActivity->id;
                $completedDataArray[$j]["record_id"] = $completedActivity->amenity_id;
                $completedDataArray[$j]["name"] = $activity->name;
                $completedDataArray[$j]["icon"] = "http://devsanjeevani.dbaquincy.com/img/my_activities.png";
                $completedDataArray[$j]["date"] = $createdAt->format("d-M-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("h:i A");
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
                $acceptedBy = User::find($completedMealOrder->accepted_by);
                $createdAt = Carbon::parse($completedMealOrder->created_at);
                $totalItem = MealOrderItem::where("meal_order_id", $completedMealOrder->id)->count();
                $completedDataArray[$j]["id"] = $completedMealOrder->id;
                $completedDataArray[$j]["record_id"] = $completedMealOrder->id;
                $completedDataArray[$j]["name"] = $completedMealOrder->invoice_id;
                $completedDataArray[$j]["icon"] = "http://devsanjeevani.dbaquincy.com/img/my_meal.png";
                $completedDataArray[$j]["date"] = $createdAt->format("d-M-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("h:i A");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["total_item_count"] = $totalItem;
                $completedDataArray[$j]["total_amount"] = $completedMealOrder->total_amount;
                $completedDataArray[$j]["status_id"] = $completedMealOrder->status;
                $completedDataArray[$j]["status"] = $completedMealOrder->status == 4 ? "Completed" : "Rejected";
                $completedDataArray[$j]["acceptd_by"] = $acceptedBy ? $acceptedBy->user_name : "";
                $completedDataArray[$j]["staff_comment"] = $completedMealOrder->staff_comment;
                $completedDataArray[$j]["staff_reasons"] = $completedMealOrder->staff_reasons;
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
                        'data' => (object) []
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
     * @apiParam {String} type type* (1 => for issues & housekeeping, 4 => for Meals).
     * @apiParam {String} record_id record_id*.
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
     * @apiError RecordIdMissing The service id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "service id missing.",
     *     "data": {}
     * }
     * 
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
                    if ($serviceRequest->accepted_by_id > 0) {
                        $staff = User::find($serviceRequest->accepted_by_id);
                        $this->androidPushNotification(2, "Service Request", "Great! your service request approved by " . $request->user()->user_name, $staff->device_token, 1, $serviceRequest->service_id, 0, 2);
                    }
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
                    if ($serviceRequest->accepted_by > 0) {
                        $staff = User::find($serviceRequest->accepted_by);
                        $this->androidPushNotification(2, "Meal Order Approved", "Great! your meal order approved by " . $request->user()->user_name, $staff->device_token, 1, $serviceRequest->id, 0, 2);
                    }
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

    /**
     * @api {post} /api/reject-service-request Reject service Request
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName PostApproveServicerequest
     * @apiGroup Services
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} record_id Record id*.
     * @apiParam {String} resort_id Resort id*.
     * @apiParam {String} type type*(1 => for issues & housekeeping, 4 => for Meals).
     * @apiParam {String} comment comment*.
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
     * "message": "Service rejected successfully.",
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
     * @apiError ResordIdMissing The record id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "record id missing.",
     *     "data": {}
     * }

     * 
     * 
     * 
     */
    public function rejectServiceRequest(Request $request) {
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
            if (!$request->resort_id) {
                return $this->sendErrorResponse("resort id missing.", (object) []);
            }
            if (!$request->comment) {
                return $this->sendErrorResponse("comment missing.", (object) []);
            }


            if ($request->type == 1) {
                $serviceRequest = ServiceRequest::with('serviceDetail')->where(["id" => $request->record_id, "request_status_id" => 3, "is_active" => 1])->first();
                if (!$serviceRequest) {
                    return $this->sendErrorResponse("Invalid service & order.", (object) []);
                }

                $serviceRequest->accepted_by_id = 0;
                $serviceRequest->request_status_id = 1;
                $serviceRequest->questions = $request->comment;
                if ($serviceRequest->save()) {
                    if ($serviceRequest->serviceDetail->name != NULL) {

                        $resortUsers = UserBookingDetail::where("resort_id", $request->resort_id)->pluck("user_id");

                        if ($resortUsers) {
                            $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2, "is_service_authorise" => 1, "is_push_on" => 1])
                                    ->where("device_token", "!=", "")
                                    ->whereIn("id", $resortUsers->toArray())
                                    ->pluck("device_token");
                            // dd($staffDeviceTokens);
                            if ($staffDeviceTokens) {
                                $this->androidPushNotification(2, "Service Not Approved", $serviceRequest->serviceDetail->name . " request not approved from Room# " . $serviceRequest->resort_room_no . " by " . $user->user_name, $staffDeviceTokens->toArray(), 1, $serviceRequest->serviceDetail->id, 0, 1);
                            }

                            // $this->generateNotification($request->user_id, "Service Not Approved", $serviceRequest->serviceDetail->name." request not approved by you", 1);
                        }
                    }

                    return $this->sendSuccessResponse("Service rejected successfully", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } elseif ($request->type == 4) {

                $serviceRequest = MealOrder::where(["id" => $request->record_id, "status" => 3, "is_active" => 1])->first();
                if (!$serviceRequest) {
                    return $this->sendErrorResponse("Invalid service & order.", (object) []);
                }
                $serviceRequest->status = 1;
                $serviceRequest->accepted_by = 0;
//                $serviceRequest->status = $request->comment;
                if ($serviceRequest->save()) {
                    // if (1==1) {

                    $resortUsers = UserBookingDetail::where("resort_id", $request->resort_id)->pluck("user_id");

                    if ($resortUsers) {
                        $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2, "is_service_authorise" => 1, "is_push_on" => 1])
                                ->where("device_token", "!=", "")
                                ->whereIn("id", $resortUsers->toArray())
                                ->pluck("device_token");
                    }

                    if (count($staffDeviceTokens) > 0) {

                        $this->androidPushNotification(2, "Meal Order Not Approved", "Meal order not approved from Room# " . $serviceRequest->resort_room_no . " by " . $request->user()->user_name, $staffDeviceTokens->toArray(), 4, $serviceRequest->id, 1);
                    }
                    return $this->sendSuccessResponse("Service rejected successfully", (object) []);
                } else {
                    return $this->administratorResponse();
                }
            } else {
                return $this->sendErrorResponse("Invalid service & order.", (object) []);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->administratorResponse();
        }
    }

}
