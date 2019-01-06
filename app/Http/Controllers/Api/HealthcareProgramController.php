<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\HealthcateProgram;
use App\Models\HealthcateProgramImages;
use App\Models\HealthcateProgramDay;
use App\Models\User;
use App\Models\UserBookingDetail;

class HealthcareProgramController extends Controller {

    /**
     * @api {get} /api/health-program-listing  Healthcare programs listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetHealthcareProgram
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Activities found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "healthcare program found.",
     *    "data": [
     *        {
     *            "id": 1,
     *            "name": "Diabetes Program",
     *            "description": "<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>",
     *            "start_from": "24-11-2018",
     *            "end_to": "27-11-2018",
     *            "total_days": 4,
     *            "healthcare_images": [
     *                {
     *                    "id": 1,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/offer_images/6ucWdCWKsZeZPDfIxfGVlzbg4VtjpLXG8HhpON8g.jpeg",
     *                    "health_program_id": 1
     *                },
     *                {
     *                    "id": 2,
     *                    "banner_image_url": "http://127.0.0.1:8000/storage/offer_images/QKSTxwKTkrHBY1vp3OmMNSONGjse5lUT27xo8PXf.jpeg",
     *                    "health_program_id": 1
     *                }
     *            ],
     *            "healthcare_days": [
     *                {
     *                    "id": 1,
     *                    "day": "1",
     *                    "description": "<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>",
     *                    "health_program_id": 1
     *                },
     *                {
     *                    "id": 2,
     *                    "day": "2",
     *                    "description": "<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>",
     *                    "health_program_id": 1
     *                },
     *                {
     *                    "id": 3,
     *                    "day": "3",
     *                    "description": "<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>",
     *                    "health_program_id": 1
     *                },
     *                {
     *                    "id": 4,
     *                    "day": "4",
     *                    "description": "<h1>&nbsp;simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</h1>",
     *                    "health_program_id": 1
     *                }
     *            ]
     *        }
     *    ]
     * }
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Resort id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function healthcareListing(Request $request) {

        try {
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing", (object) []);
            }
            if($request->resort_id == -1){
                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["is_active" => 1])
                            ->with([
                                'healthcareImages' => function($query) {
                                    $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                }
                            ])
                            ->with([
                                'healthcareDays' => function($query) {
                                    $query->select('id', 'day', 'description', 'health_program_id');
                                }
                            ])latest()->get();
            }else{
                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["is_active" => 1, "resort_id" => $request->resort_id])
                            ->with([
                                'healthcareImages' => function($query) {
                                    $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                }
                            ])
                            ->with([
                                'healthcareDays' => function($query) {
                                    $query->select('id', 'day', 'description', 'health_program_id');
                                }
                            ])->get();
            }

            if (count($healthcare) > 0) {
                foreach ($healthcare as $key => $health) {
                    $healthcareDays = HealthcateProgramDay::where('health_program_id', $health->id)->count();
                    $dataArray[$key] = $health;
                    $dataArray[$key]['total_days'] = $healthcareDays;
                }

                return $this->sendSuccessResponse("healthcare program found.", $dataArray);
            } else {
                return $this->sendErrorResponse("healthcare program not found.", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/my-health-program  My Healthcare Package
     * @apiHeader {String} Accept application/json. 
     * @apiName GetMyHealthcarePackage
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message My Health Package.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "My Health Package",
     *       "data": {
     *           "id": 2,
     *           "name": "Healthcare Package",
     *           "description": "<p>Testing</p>",
     *           "start_from": "28-11-2018",
     *           "end_to": "28-11-2018",
     *           "healthcare_images": [
     *               {
     *                   "id": 2,
     *                   "banner_image_url": "http://127.0.0.1:8000/storage/healthcare_images/58PUwfdKYmUzP4hO8WdQMLLrhuhUAbXXp5WoNgNO.jpeg",
     *                   "health_program_id": 2
     *               },
     *               {
     *                   "id": 3,
     *                   "banner_image_url": "http://127.0.0.1:8000/storage/healthcare_images/m9MW1Nb8LWCMrZa992hcHoLSPgBlMkkjw9fsKAri.jpeg",
     *                   "health_program_id": 2
     *               }
     *           ],
     *           "healthcare_days": [
     *               {
     *                   "id": 4,
     *                   "day": "1",
     *                   "description": "<p>Testing</p>",
     *                   "health_program_id": 2
     *               },
     *               {
     *                   "id": 5,
     *                   "day": "2",
     *                   "description": "<p>Testing</p>",
     *                   "health_program_id": 2
     *               },
     *               {
     *                   "id": 6,
     *                   "day": "3",
     *                   "description": "<p>Testing</p>",
     *                   "health_program_id": 2
     *               }
     *           ]
     *       }
     *   }
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function myHealthcareProgram(Request $request) {

        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }

            $user = User::find($request->user_id);
            if ($user) {

                $booking = UserBookingDetail::where("check_in", "<=", date("Y-m-d H:i:s"))
                        ->where("check_out", ">=", date("Y-m-d H:i:s"))
                        ->where("user_id", $request->user_id)
                        ->first();

                if ($booking) {

                    $healthcare = HealthcateProgram::selectRaw(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["id" => $booking->package_id])
                                    ->with([
                                        'healthcareImages' => function($query) {
                                            $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                        }
                                    ])
                                    ->with([
                                        'healthcareDays' => function($query) {
                                            $query->select('id', 'day', 'description', 'health_program_id');
                                        }
                                    ])->first();
                    if ($healthcare) {
                        return $this->sendSuccessResponse("My Health Package", $healthcare);
                    } else {
                        return $this->sendErrorResponse("My Health Package not found", (object) []);
                    }
                } else {
                    return $this->sendErrorResponse("My Health Package not found", (object) []);
                }
            } else {
                return $this->sendErrorResponse("Invalid User", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/my-upcoming-complete-program  My Upcoming & Completed Healthcare Package
     * @apiHeader {String} Accept application/json. 
     * @apiName GetMyUpcomingCompleteHealthcarePackage
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Upcoming & Completed Health Package.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Health Package found",
     *       "data": {
     *           "upcoming": [
     *               {
     *                   "id": 2,
     *                   "name": "Healthcare Package",
     *                   "duration": "28-11-2018 to 28-11-2018",
     *                   "status": "Booking Confirmed"
     *               }
     *           ],
     *           "complete": [
     *               {
     *                   "id": 2,
     *                   "name": "Healthcare Package",
     *                   "duration": "28-11-2018 to 28-11-2018",
     *                   "status": "Booking Confirmed"
     *               }
     *           ]
     *       }
     *   }
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function myUpcomingCompleteProgram(Request $request) {

        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }

            $user = User::find($request->user_id);
            if ($user) {

                $completedPackages = UserBookingDetail::with([
                            "packageDetail" => function($query) {
                                $query->selectRaw(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'));
                            }
                        ])
                        ->where("check_out", "<", date("Y-m-d H:i:s"))
                        ->where("user_id", $request->user_id)
                        ->get();
                $upcomingPackages = UserBookingDetail::with([
                            "packageDetail" => function($query) {
                                $query->selectRaw(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'));
                            }
                        ])
                        ->where("check_in", ">", date("Y-m-d H:i:s"))
                        ->where("user_id", $request->user_id)
                        ->get();
                $completedArray = [];
                foreach ($completedPackages as $i => $completedPackage) {
                    $completedArray[$i]["id"] = $completedPackage->packageDetail->id;
                    $completedArray[$i]["name"] = $completedPackage->packageDetail->name;
                    $completedArray[$i]["duration"] = $completedPackage->packageDetail->start_from . " to " . $completedPackage->packageDetail->end_to;
                    $completedArray[$i]["status"] = "Completed";
                }
                $data['complete'] = $completedArray;
                $upcomingArray = [];
                foreach ($upcomingPackages as $i => $upcomingPackage) {
                    $upcomingArray[$i]["id"] = $upcomingPackage->packageDetail->id;
                    $upcomingArray[$i]["name"] = $upcomingPackage->packageDetail->name;
                    $upcomingArray[$i]["duration"] = $upcomingPackage->packageDetail->start_from . " to " . $upcomingPackage->packageDetail->end_to;
                    $upcomingArray[$i]["status"] = "Upcoming";
                }
                $data['upcoming'] = $upcomingArray;
                return $this->sendSuccessResponse("Health Package found", $data);
            } else {
                return $this->sendErrorResponse("Invalid User", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {post} /api/cancel-package  Cancel Healthcare Package
     * @apiHeader {String} Accept application/json. 
     * @apiName PostCancelHealthcareProgram
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} health_care_package_id Package id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Upcoming & Completed Health Package.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Healthcare package cancelled successsfully",
     *       "data": {}
     *   }
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User id missing.",
     *       "data": {}
     *   } 
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Health care package id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function cancelHealthcareProgram(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }
            if (!$request->health_care_package_id) {
                return $this->sendErrorResponse("Health care package id missing", (object) []);
            }

            return $this->sendSuccessResponse("Healthcare package cancelled successsfully", (object) []);
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

}
