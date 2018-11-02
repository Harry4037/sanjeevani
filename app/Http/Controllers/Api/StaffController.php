<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\ServiceRequest;

class StaffController extends Controller {

    /**
     * @api {get} /api/service-request-list Service Request Listing
     * @apiHeader {String} Accept application/json.
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
     *   "status": true,
     *   "status_code": 200,
     *   "message": "Service request found.",
     *   "data": [
     *        {
     *            "id": 1,
     *            "comment": "",
     *            "service_id": 1,
     *            "user_id": 2,
     *            "service_detail": {
     *                "id": 1,
     *                "name": "Air conditioner",
     *                "icon": "http://127.0.0.1:8000/storage/Service_icon/cWpiFZ9YG4duaP7Cfch2DgeVn3AYdSBAZPWFkd6g.png",
     *                "type_id": 1,
     *               "service_type": {
     *                   "id": 1,
     *                    "name": "Housekeeping"
     *                }
     *            },
     *            "user_detail": {
     *                "id": 2,
     *                "user_name": null,
     *                "email_id": null,
     *                "mobile_number": "8077575835"
     *           }
     *        },
     *        {
     *            "id": 2,
     *            "comment": "",
     *            "service_id": 2,
     *            "user_id": 2,
     *           "service_detail": {
     *               "id": 2,
     *                "name": "Room Cleaning",
     *                "icon": "http://127.0.0.1:8000/storage/Service_icon/C2taEVpOfEQghJco5Y4uhARv6x1WKMOpE8Szaixn.png",
     *                "type_id": 2,
     *               "service_type": {
     *                    "id": 2,
     *                    "name": "Issue"
     *                }
     *            },
     *            "user_detail": {
     *                "id": 2,
     *                "user_name": null,
     *                "email_id": null,
     *                "mobile_number": "8077575835"
     *           }
     *        }
     *   ]
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
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing.", (object) []);
            }
            $resort = Resort::where(["id" => $request->resort_id, "is_active" => 1])->first();
            if (!$resort) {
                return $this->sendErrorResponse("Invalid resort.", (object) []);
            }

            $newServices = ServiceRequest::select('id', 'comment', 'service_id', 'user_id')->where(["resort_id" => $request->resort_id, "request_status_id" => 1])
                    ->with([
                        'serviceDetail' => function($query) {
                            $query->select('id', 'name', 'icon', 'type_id');
                        }
                    ])
                    ->with([
                        'userDetail' => function($query) {
                            $query->select('id', 'user_name', 'email_id', 'mobile_number');
                        }
                    ])
                    ->get();
            if ($newServices) {
                return $this->sendSuccessResponse("Service request found.", $newServices);
            } else {
                return $this->sendErrorResponse("No service request found.", []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
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
                return $this->sendSuccessResponse("Request accepted.", (object) []);
            } else {
                return $this->sendErrorResponse("Something went be wrong.", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

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
        } catch (Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
