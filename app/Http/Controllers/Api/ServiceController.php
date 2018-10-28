<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @apiSuccess {String} message Services listing.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Services listing.",
     * "data": {
     * "housekeeping": [
     * {
     * "id": 1,
     * "name": "Room Cleaning",
     * "type": "Housekeeping",
     * "icon": "",
     * "is_active": 1,
     * "created_by": "1",
     * "updated_by": "1",
     * "created_at": "2018-10-22 09:30:58",
     * "updated_at": "2018-10-22 09:40:52"
     * },
     * {
     * "id": 3,
     * "name": "Do Not Disturb",
     * "type": "Housekeeping",
     * "icon": "",
     * "is_active": 1,
     * "created_by": "1",
     * "updated_by": "1",
     * "created_at": "2018-10-22 09:31:42",
     * "updated_at": "2018-10-22 09:31:42"
     * }
     * ],
     * "issues": [
     * {
     * "id": 4,
     * "name": "Shower",
     * "type": "Issue",
     * "icon": "",
     * "is_active": 1,
     * "created_by": "1",
     * "updated_by": "1",
     * "created_at": "2018-10-22 09:31:54",
     * "updated_at": "2018-10-22 09:31:54"
     * }
     * ]
     * }
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
                $houseKeepingArrray[$i]['icon'] = '';
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
                $issuesArrray[$i]['icon'] = '';
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
     * @apiGroup Staff Service
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} service_id Service id*.
     * @apiParam {String} resort_id Service id*.
     * @apiParam {String} question_id question id's by comma separated.
     * @apiParam {String} comment Comment.
     * 
     * @apiSuccess {String} success true 
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
     * @apiError ServiceIdMissing The service id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "service id missing.",
     *  "data": {}
     * }
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User id missing.",
     *  "data": {}
     * }
     * @apiError ResortIdMissing The resort id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "resort id missing",
     *  "data": {}
     * }
     * 
     * @apiError InvalidService The service is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid service",
     *  "data": {}
     * }
     * 
     * @apiError InvalidResort The resort is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid resort",
     *  "data": {}
     * }
     * 
     * @apiError InvalidUser The user is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid user",
     *  "data": {}
     * }
     * 
     * 
     */
    public function raiseServiceRequest(Request $request) {
        if (!$request->user_id) {
            $response['success'] = false;
            $response['message'] = "User id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if ($request->user_id != $request->user()->id) {
            $response['success'] = false;
            $response['message'] = "Unauthorized user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if (!$request->service_id) {
            $response['success'] = false;
            $response['message'] = "service id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if (!$request->resort_id) {
            $response['success'] = false;
            $response['message'] = "resort id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }

        $user = User::find($request->user_id);
        if (!$user) {
            $response['success'] = false;
            $response['message'] = "Invalid user.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }

        $resort = Resort::find($request->resort_id);
        if (!$resort) {
            $response['success'] = false;
            $response['message'] = "Invalid resort.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $service = Service::find($request->service_id);
        if (!$service) {
            $response['success'] = false;
            $response['message'] = "Invalid service.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $serviceRequest = new ServiceRequest();
        $serviceRequest->resort_id = $request->resort_id;
        $serviceRequest->user_id = $request->user_id;
        $serviceRequest->service_id = $request->service_id;
        $serviceRequest->comment = $request->comment;
        $serviceRequest->question_id = $request->question_id;
        $serviceRequest->request_status_id = 1;
        if ($serviceRequest->save()) {
            $response['success'] = true;
            $response['message'] = "Request successfully created.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['message'] = "Something went be wrong.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
    }

    /**
     * @api {get} /api/service-request-list Service Request Listing
     * @apiHeader {String} Accept application/json.
     * @apiName PostServicerequestlist
     * @apiGroup Staff Service
     * 
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} message Service request found..
     * @apiSuccess {JSON}   data Array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "status": true,
     * "message": "Service request found.",
     * "data":[
     * {
     * "id": 1,
     * "service_name": "Air conditioner",
     * "service_type": "Housekeeping",
     * "comment": "hi test",
     * "user_info":{
     * "id": 1,
     * "salutation_id": 0,
     * "user_name": "Admin",
     * "password": "$2y$10$kPpsYwT0fw2mB4F9.cI1AeSBSi1XTndcCH3PLptRtjDebQZDShibK",
     * "first_name": "Admin",
     * "mid_name": null,
     * "last_name": null,
     * "booking_source_name": null,
     * "booking_id": null,
     * "resort_id": 0,
     * "total_room": null,
     * "package_detail_id": 0,
     * "gender": "M",
     * "email_id": "admin@mail.com",
     * "alternate_email_id": null,
     * "user_type_id": 1,
     * "designation_id": 0,
     * "department_id": 0,
     * "city_id": 0,
     * "language_id": 0,
     * "screen_name": null,
     * "date_of_joining": "2018-10-25 19:53:22",
     * "authority_id": "0",
     * "date_of_birth": "2018-10-25 19:53:22",
     * "is_user_loked": 0,
     * "profile_pic_path": null,
     * "aadhar_id": null,
     * "voter_id": null,
     * "check_in_date": null,
     * "check_out_date": null,
     * "mobile_number": null,
     * "other_contact_number": null,
     * "address1": null,
     * "address2": null,
     * "address3": null,
     * "pincode": null,
     * "secuity_question": null,
     * "secuity_questio_answer": null,
     * "ref_time_zone_id": null,
     * "login_expiry_date": null,
     * "other_info": null,
     * "user_id_RA": null,
     * "is_active": 1,
     * "domain_id": 0,
     * "remember_token": null,
     * "otp": null,
     * "created_by": "0",
     * "updated_by": "0",
     * "created_at": "2018-10-25 19:53:22",
     * "updated_at": null
     * }
     * 
     * 
     * @apiError ResortIdMissing The resort id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "resort id missing.",
     *  "data": {}
     * }
     * 
     * @apiError InvalidResort The resort is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid resort.",
     *  "data": {}
     * }
     * 
     * 
     */
    public function serviceRequestListing(Request $request) {
        if (!$request->resort_id) {
            $response['success'] = false;
            $response['message'] = "Resort id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }

        $resort = Resort::find($request->resort_id);
        if (!$resort) {
            $response['success'] = false;
            $response['message'] = "Invalid resort.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        $newServices = ServiceRequest::where(["resort_id" => $request->resort_id, "request_status_id" => 1])->get();

        if ($newServices) {
            $dataArray = [];
            $i = 0;
            foreach ($newServices as $newService) {
                $user = User::find($newService->user_id);
                $service = Service::find($newService->service_id);
//                dd($service);
                $serviceType = ServiceType::find($service->id);
                $dataArray[$i]['id'] = $newService->id;
                $dataArray[$i]['service_name'] = $service->name;
                $dataArray[$i]['service_type'] = $serviceType->name;
                $dataArray[$i]['comment'] = $newService->comment;
                $dataArray[$i]['user_info'] = $user;

                $i++;
            }

            $response['success'] = true;
            $response['message'] = "Service request found.";
            $response['data'] = $dataArray;
            return $this->jsonData($response);
        } else {
            $response['success'] = false;
            $response['message'] = "No service request found.";
            $response['data'] = [];
            return $this->jsonData($response);
        }
    }



}
