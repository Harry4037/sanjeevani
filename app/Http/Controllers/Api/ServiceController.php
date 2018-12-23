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
        $houseKeeping = Service::where(["type_id" => 1, "is_active" => 1])->get();
        $houseKeepingArrray = [];
        if ($houseKeeping) {
            $i = 0;
            foreach ($houseKeeping as $houseKeep) {
                $serviceQuestion = ServiceQuestionaire::where("service_id", $houseKeep->id)->get();
                $houseKeepingArrray[$i]['id'] = $houseKeep->id;
                $houseKeepingArrray[$i]['name'] = $houseKeep->name;
                $houseKeepingArrray[$i]['icon'] = $houseKeep->icon;
                if ($serviceQuestion) {
                    $j = 0;
                    foreach ($serviceQuestion as $serviceQues) {
                        $question = Question::find($serviceQues->question_id);
                        $houseKeepingArrray[$i]['questions'][$j]['id'] = $question->id;
                        $houseKeepingArrray[$i]['questions'][$j]['name'] = $question->name;
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

        $issues = Service::where(["type_id" => 2, "is_active" => 1])->get();
        $issuesArrray = [];
        if ($issues) {
            $i = 0;
            foreach ($issues as $issue) {
                $serviceQuestion = ServiceQuestionaire::where("service_id", $issue->id)->get();
                $issuesArrray[$i]['id'] = $issue->id;
                $issuesArrray[$i]['name'] = $issue->name;
                $issuesArrray[$i]['icon'] = $issue->icon;
                if ($serviceQuestion) {
                    $j = 0;
                    foreach ($serviceQuestion as $serviceQues) {
                        $question = Question::find($serviceQues->question_id);
                        $issuesArrray[$i]['questions'][$j]['id'] = $question->id;
                        $issuesArrray[$i]['questions'][$j]['name'] = $question->name;
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
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->service_id) {
                return $this->sendErrorResponse("service id missing.", (object) []);
            }
            if (!$request->resort_id) {
                return $this->sendErrorResponse("resort id missing.", (object) []);
            }

            $user = User::where(["id" => $request->user_id, "is_active" => 1])->first();
            if (!$user) {
                return $this->sendErrorResponse("Invalid user.", (object) []);
            }
            if ($user->user_type_id == 4) {
                return $this->sendErrorResponse("Please provide your check-In details.", (object) []);
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
                    ])->where("request_status_id", "!=", 4)->first();
            if ($existingServiceRequest) {
                return $this->sendErrorResponse("Request already raised.", (object) []);
            } else {
                $serviceRequest = new ServiceRequest();
                $serviceRequest->resort_id = $request->resort_id;
                $serviceRequest->user_id = $request->user_id;
                $serviceRequest->service_id = $request->service_id;
                $serviceRequest->comment = $request->comment ? $request->comment : '';
                $serviceRequest->question_id = $request->question_id ? $request->question_id : 0;
                $serviceRequest->request_status_id = 1;
                if ($serviceRequest->save()) {
                    $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2])->pluck("device_token")->toArray();
                    $this->androidPushNotification(2, "Servie Raised", "$service->name request raised by customer", $staffDeviceTokens, 1, $service->id);
                    return $this->sendSuccessResponse("Request successfully created.", (object) []);
                } else {
                    return $this->sendErrorResponse("Something went be wrong.", (object) []);
                }
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->administratorResponse();
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
            $ongoingServices = ServiceRequest::select(DB::raw('id, comment, service_id, question_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time, DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_timestamp'))
//            $serviceRequest['order_request']['ongoing_order'] = ServiceRequest::select(DB::raw('id, comment, service_id, question_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time'))
                            ->where(["user_id" => $request->user_id])
                            ->where(function($q) {
                                $q->where("request_status_id", 1)
                                ->orWhere("request_status_id", 2)
                                ->orWhere("request_status_id", 3)
                                ->orWhere("request_status_id", 5);
                            })
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->select('id', 'name', 'type_id', 'icon');
                                }
                            ])->with([
                        'questionDetail' => function($query) {
                            $query->select('id', 'name');
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
                $ongoingDataArray[$i]["name"] = $ongoingService->serviceDetail->name;
                $ongoingDataArray[$i]["icon"] = $ongoingService->serviceDetail->icon;
                $ongoingDataArray[$i]["date"] = $ongoingService->date;
                $ongoingDataArray[$i]["time"] = $ongoingService->time;
                $ongoingDataArray[$i]["date_time"] = $ongoingService->created_timestamp;
                $ongoingDataArray[$i]["status_id"] = $ongoingService->requestStatus->id;
                $ongoingDataArray[$i]["status"] = $ongoingService->requestStatus->status;
                $ongoingDataArray[$i]["acceptd_by"] = isset($ongoingService->acceptedBy->user_name) ? $ongoingService->acceptedBy->user_name : "";
                $ongoingDataArray[$i]["type"] = 1;
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
                if($ongoingMealOrder->status == 1){
                    $stat = "Pending";
                }elseif($ongoingMealOrder->status == 2){
                    $stat = "Accepted";
                }elseif($ongoingMealOrder->status == 3){
                  $stat =  "Your approval needed";
                }else{
                    $stat = "Invalid status";
                }
                $createdAt = Carbon::parse($ongoingMealOrder->created_at);
                $totalItem = MealOrderItem::where("meal_order_id", $ongoingMealOrder->id)->count();
                $ongoingDataArray[$i]["id"] = $ongoingMealOrder->id;
                $ongoingDataArray[$i]["record_id"] = $ongoingMealOrder->id;
                $ongoingDataArray[$i]["name"] = $ongoingMealOrder->invoice_id;
                $ongoingDataArray[$i]["icon"] = "";
                $ongoingDataArray[$i]["date"] = $createdAt->format("d-m-Y");
                $ongoingDataArray[$i]["time"] = $createdAt->format("H:i a");
                $ongoingDataArray[$i]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $ongoingDataArray[$i]["total_item_count"] = $totalItem;
                $ongoingDataArray[$i]["total_amount"] = $ongoingMealOrder->total_amount;
                $ongoingDataArray[$i]["status_id"] = $ongoingMealOrder->status;
                $ongoingDataArray[$i]["status"] = $stat;
                $ongoingDataArray[$i]["acceptd_by"] = "";
                $ongoingDataArray[$i]["type"] = 4;
                $i++;
            }


            $completedServices = ServiceRequest::select(DB::raw('id, comment, service_id, question_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time, DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_timestamp'))
                            ->where(["user_id" => $request->user_id, "request_status_id" => 4])
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->select('id', 'name', 'type_id', 'icon');
                                }
                            ])->with([
                        'questionDetail' => function($query) {
                            $query->select('id', 'name');
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
                $completedDataArray[$j]["name"] = $completedService->serviceDetail->name;
                $completedDataArray[$j]["icon"] = $completedService->serviceDetail->icon;
                $completedDataArray[$j]["date"] = $completedService->date;
                $completedDataArray[$j]["time"] = $completedService->time;
                $completedDataArray[$j]["date_time"] = $completedService->created_timestamp;
                $completedDataArray[$j]["status_id"] = $completedService->requestStatus->id;
                $completedDataArray[$j]["status"] = $completedService->requestStatus->status;
                $completedDataArray[$j]["acceptd_by"] = isset($completedService->acceptedBy->user_name) ? $completedService->acceptedBy->user_name : "";
                $completedDataArray[$j]["type"] = 1;
                $j++;
            }

            $completedAmenities = AmenityRequest::where(["user_id" => $request->user_id, "is_active" => 1])->get();
            foreach ($completedAmenities as $completedAmenity) {
                $createdAt = Carbon::parse($completedAmenity->created_at);
                $amenity = Amenity::find($completedAmenity->amenity_id);
                $completedDataArray[$j]["id"] = $completedAmenity->id;
                $completedDataArray[$j]["record_id"] = $completedAmenity->amenity_id;
                $completedDataArray[$j]["name"] = $amenity->name;
                $completedDataArray[$j]["icon"] = "";
                $completedDataArray[$j]["date"] = $createdAt->format("d-m-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("H:i a");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["status_id"] = 1;
                $completedDataArray[$j]["status"] = "Booked";
                $completedDataArray[$j]["acceptd_by"] = "";
                $completedDataArray[$j]["type"] = 2;
                $j++;
            }
            $completedActivities = ActivityRequest::where(["user_id" => $request->user_id, "is_active" => 1])->get();
            foreach ($completedActivities as $completedActivity) {
                $createdAt = Carbon::parse($completedActivity->created_at);
                $activity = Activity::find($completedActivity->amenity_id);
                $completedDataArray[$j]["id"] = $completedActivity->id;
                $completedDataArray[$j]["record_id"] = $completedActivity->amenity_id;
                $completedDataArray[$j]["name"] = $activity->name;
                $completedDataArray[$j]["icon"] = "";
                $completedDataArray[$j]["date"] = $createdAt->format("d-m-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("H:i a");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["status_id"] = 1;
                $completedDataArray[$j]["status"] = "Booked";
                $completedDataArray[$j]["acceptd_by"] = "";
                $completedDataArray[$j]["type"] = 3;
                $j++;
            }

            $completedMealOrders = MealOrder::where(["user_id" => $request->user_id, "status" => 1])
                    ->get();
            foreach ($completedMealOrders as $completedMealOrder) {
                $createdAt = Carbon::parse($completedMealOrder->created_at);
                $totalItem = MealOrderItem::where("meal_order_id", $completedMealOrder->id)->count();
                $completedDataArray[$j]["id"] = $completedMealOrder->id;
                $completedDataArray[$j]["record_id"] = $completedMealOrder->id;
                $completedDataArray[$j]["name"] = $completedMealOrder->invoice_id;
                $completedDataArray[$j]["icon"] = "";
                $completedDataArray[$j]["date"] = $createdAt->format("d-m-Y");
                $completedDataArray[$j]["time"] = $createdAt->format("H:i a");
                $completedDataArray[$j]["date_time"] = $createdAt->format("d-m-Y H:i:s");
                $completedDataArray[$j]["total_item_count"] = $totalItem;
                $completedDataArray[$j]["total_amount"] = $completedMealOrder->total_amount;
                $completedDataArray[$j]["status_id"] = $completedMealOrder->status;
                $completedDataArray[$j]["status"] = "Confirmed";
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
            dd($ex);
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
            if($request->type == 1){
            

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
        }elseif($request->type == 4){
            $serviceRequest = MealOrder::where(["id" => $request->record_id, "status" => 2, "is_active" => 1])->first();
            if (!$serviceRequest) {
                return $this->sendErrorResponse("Invalid service & order.", (object) []);
            }
            $serviceRequest->status = 4;
            if ($serviceRequest->save()) {
                // $staff = User::find($serviceRequest->accepted_by_id);
                // $this->androidPushNotification(2, "Service Request", "Great! your Service approved by customer.", $staff->device_token, 1, $serviceRequest->service_id);
                return $this->sendSuccessResponse("Service approved successfully", (object) []);
            } else {
                return $this->administratorResponse();
            }
        }else{
            return $this->sendErrorResponse("Invalid service & order.", (object) []);
        }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
