<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\HealthcateProgram;
use App\Models\HealthcateProgramImages;
use App\Models\HealthcateProgramDay;

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
     *}
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

}
