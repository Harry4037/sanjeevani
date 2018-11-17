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
                    return $this->sendSuccessResponse("Request successfully created.", (object) []);
                } else {
                    return $this->sendErrorResponse("Something went be wrong.", (object) []);
                }
            }
        } catch (\Exception $ex) {
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
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Order & Request found.",
     *    "data": {
     *        "order_request": [
     *           {
     *                "id": 1,
     *                "comment": "",
     *                "service_id": 1,
     *                "question_id": 1,
     *                "request_status_id": 1,
     *                "accepted_by_id": 1,
     *                "date": "15-11-2018",
     *                "time": "04:31:35 AM",
     *                "service_detail": {
     *                    "id": 1,
     *                    "name": "Iron",
     *                    "type_id": 1,
     *                    "icon": "http://127.0.0.1:8000/storage/Service_icon/O43z5c9J2lUhL1iRmQHNietloHjRLHbpiD842V2X.jpeg",
     *                    "service_type": {
     *                        "id": 1,
     *                        "name": "Housekeeping"
     *                    }
     *                },
     *                "question_detail": {
     *                    "id": 1,
     *                    "name": "Lorem Ipsum is simply dummy text"
     *                },
     *                "request_status": {
     *                    "id": 1,
     *                    "status": "Pending"
     *                },
     *                "accepted_by": {
     *                    "id": 1,
     *                    "user_name": "Admin",
     *                    "first_name": "Admin",
     *                    "last_name": null
     *                }
     *            }
     *        ]
     *    }
     * }
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
            $serviceRequest['order_request']['ongoing_order'] = ServiceRequest::select(DB::raw('id, comment, service_id, question_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time'))
                            ->where(["user_id" => $request->user_id])
                            ->where(function($q) {
                                $q->where("request_status_id", 3)
                                ->orWhere("request_status_id", 1)
                                ->orWhere("request_status_id", 2);
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

            $serviceRequest['order_request']['completed_order'] = ServiceRequest::select(DB::raw('id, comment, service_id, question_id, request_status_id, accepted_by_id, DATE_FORMAT(created_at, "%d-%m-%Y") as date, DATE_FORMAT(created_at, "%r") as time'))->where(["user_id" => $request->user_id, "request_status_id" => 4])
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

            if ($serviceRequest['order_request']) {
                return response()->json([
                            'status' => true,
                            'status_code' => 200,
                            'message' => "Order & Request found.",
                            'data' => $serviceRequest
                ]);
            } else {
                return response()->json([
                            'status' => false,
                            'status_code' => 404,
                            'message' => "Order & Request not found.",
                            'data' => $serviceRequest
                ]);
            }
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
            if (!$request->service_id) {
                return $this->sendErrorResponse("service id missing.", (object) []);
            }

            $user = User::where(["id" => $request->user_id, "is_active" => 1])->first();
            if (!$user) {
                return $this->sendErrorResponse("Invalid user.", (object) []);
            }

            $serviceRequest = ServiceRequest::where(["id" => $request->service_id, "request_status_id" => 3, "is_active" => 1])->first();
            if (!$serviceRequest) {
                return $this->sendErrorResponse("Invalid service & order.", (object) []);
            }
            $serviceRequest->request_status_id = 4;
            if ($serviceRequest->save()) {
                return $this->sendSuccessResponse("Service approved successfully", (object) []);
            } else {
                return $this->administratorResponse();
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
