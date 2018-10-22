<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller {

    /**
     * @api {get} /api/services-list  All services list
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
        $houseKeeping = Service::where(["type" => "Housekeeping", "is_active" => 1])->get();
        $issues = Service::where(["type" => "Issue", "is_active" => 1])->get();


        $response['success'] = true;
        $response['message'] = "Services listing.";
        $response['data'] = [
            "housekeeping" => $houseKeeping,
            "issues" => $issues
        ];
        return $this->jsonData($response);
    }

    /**
     * @api {post} /api/raise-service-request Raise service Request
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiName PostRaiseServicerequest
     * @apiGroup Services
     * 
     * @apiParam {String} user_id User id.
     * @apiParam {String} service_id Service id.
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
     * @apiError CommentMissing The comment was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Comment missing.",
     *  "data": {}
     * }
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
        if (!$request->service_id) {
            $response['success'] = false;
            $response['message'] = "service id missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }
        if (!$request->comment) {
            $response['success'] = false;
            $response['message'] = "Comment missing.";
            $response['data'] = (object) [];
            return $this->jsonData($response);
        }

        $response['success'] = true;
        $response['message'] = "Request successfully created.";
        $response['data'] = (object) [];
        return $this->jsonData($response);
    }

}
