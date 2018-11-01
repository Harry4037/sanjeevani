<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;

class MyjobsController extends Controller {

    /**
     * @api {get} /api/order-request-list  Order & Request list
     * @apiHeader {String} Accept application/json. 
     * @apiName GetOrderRequestlist
     * @apiGroup Order & Request
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
     *       "message": "Order & Request found.",
     *       "data": {
     *           "order_request": [
     *               {
     *                   "id": 1,
     *                   "comment": "issue",
     *                   "service_id": 1,
     *                   "question_id": "1",
     *                   "request_status_id": 2,
     *                   "accepted_by_id": 2,
     *                   "service_detail": {
     *                       "id": 1,
     *                       "name": "Air conditioner"
     *                   },
     *                   "question_detail": {
     *                       "id": 1,
     *                       "name": "question 1"
     *                   },
     *                   "request_status": {
     *                       "id": 2,
     *                       "status": "Accepted"
     *                   },
     *                   "accepted_by": {
     *                       "id": 2,
     *                       "user_name": "Hariom Gangwar",
     *                       "first_name": "Hariom",
     *                       "last_name": "Gangwar"
     *                   }
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
            $serviceRequest['order_request'] = ServiceRequest::select('id', 'comment', 'service_id', 'question_id', 'request_status_id', 'accepted_by_id')->where(["user_id" => $request->user_id])
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->select('id', 'name');
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
                    ])->where("user_id", $request->user_id)->get();

            if ($serviceRequest['order_request']->toArray()) {
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

}
