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
use App\Models\HealthcareBooking;
use App\Models\Resort;

class HealthcareProgramController extends Controller {

    /**
     * @api {get} /api/health-program-listing  Healthcare programs listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetHealthcareProgram
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} resort_id Resort id* (For guest user use resort id value -1).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Activities found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "healthcare program found.",
     *       "data": [       
     *           {
     *               "id": 11,
     *               "name": "Healthcare Package Reverse Diabetes in 3 Days",
     *               "description": "<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>",
     *               "start_from": "14-02-2019",
     *               "end_to": "09-03-2019",
     *               "total_days": 3,
     *               "healthcare_images": [
     *                   {
     *                       "id": 31,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/HUjdVCzjj1A51ak7ipjUg9oKWcKQs4dyAtOaOJpT.jpeg",
     *                       "health_program_id": 11
     *                   },
     *                   {
     *                       "id": 32,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/VcE35u8GzY1FSprjK8aQBP3DSIG5fZoLOa8XYRSy.jpeg",
     *                       "health_program_id": 11
     *                   }
     *               ],
     *               "healthcare_days": [
     *                   {
     *                       "id": 418,
     *                       "day": "3",
     *                       "description": "<p><strong>05:00 AM : </strong>Wake Up</p>\r\n\r\n<hr />\r\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\r\n\r\n<hr />\r\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\r\n\r\n<hr />\r\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\r\n\r\n<hr />\r\n<p><strong>07:00 AM :</strong> Coconut Water</p>\r\n\r\n<hr />\r\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\r\n\r\n<hr />\r\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\r\n\r\n<hr />\r\n<p><strong>12:00 AM :</strong> Lunch</p>\r\n\r\n<hr />\r\n<p><strong>12:30 PM : </strong>Walk</p>\r\n\r\n<hr />\r\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\r\n\r\n<hr />\r\n<p><strong>03:30 PM :</strong> Consultancy</p>\r\n\r\n<hr />\r\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\r\n\r\n<hr />\r\n<p><strong>06:00 PM :</strong> Dinner</p>\r\n\r\n<hr />\r\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\r\n\r\n<hr />\r\n<p><strong>08:00 PM :</strong> Bed Time</p>",
     *                       "health_program_id": 11
     *                   },
     *                   {
     *                       "id": 416,
     *                       "day": "1",
     *                       "description": "<p><strong>05:00 AM : </strong>Wake Up</p>\r\n\r\n<hr />\r\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\r\n\r\n<hr />\r\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\r\n\r\n<hr />\r\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\r\n\r\n<hr />\r\n<p><strong>07:00 AM :</strong> Coconut Water</p>\r\n\r\n<hr />\r\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\r\n\r\n<hr />",
     *                       "health_program_id": 11
     *                   },
     *                   {
     *                       "id": 417,
     *                       "day": "2",
     *                       "description": "<p><strong>05:00 AM : </strong>Wake Up</p>\r\n\r\n<hr />\r\n<p><strong>05:30 AM :</strong> Fasting Sugar</p>\r\n\r\n<hr />\r\n<p><strong>05:45 AM :</strong> Tulsi - Ginger Tea</p>\r\n\r\n<hr />\r\n<p><strong>06:00 AM :</strong> Walk/Yoga</p>\r\n\r\n<hr />\r\n<p><strong>07:00 AM :</strong> Coconut Water</p>\r\n\r\n<hr />\r\n<p><strong>08:00 AM : </strong>Salad Breakfast</p>\r\n\r\n<hr />\r\n<p><strong>09:00 AM :</strong> Meditation/Massage</p>\r\n\r\n<hr />\r\n<p><strong>12:00 AM :</strong> Lunch</p>\r\n\r\n<hr />\r\n<p><strong>12:30 PM : </strong>Walk</p>\r\n\r\n<hr />\r\n<p><strong>03:00 PM :</strong> Banana/Cashew/Almond Shake</p>\r\n\r\n<hr />\r\n<p><strong>03:30 PM :</strong> Consultancy</p>\r\n\r\n<hr />\r\n<p><strong>04:00 PM :</strong> Routine Check-up</p>\r\n\r\n<hr />\r\n<p><strong>06:00 PM :</strong> Dinner</p>\r\n\r\n<hr />\r\n<p><strong>07:00 PM :</strong> Spritual Classes</p>\r\n\r\n<hr />\r\n<p><strong>08:00 PM :</strong> Bed Time</p>",
     *                       "health_program_id": 11
     *                   }
     *               ]
     *           },
     *           {
     *               "id": 14,
     *               "name": "Holiday Package",
     *               "description": "<p>2Night and 3 Day</p>",
     *               "start_from": "15-02-2019",
     *               "end_to": "31-05-2019",
     *               "total_days": 3,
     *               "healthcare_images": [
     *                   {
     *                       "id": 49,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/FJ6ZhivkTUozs9FANVwNYQZHlLkXlWd8n5L8v35J.jpeg",
     *                       "health_program_id": 14
     *                   },
     *                   {
     *                       "id": 50,
     *                       "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/FeYWXm2Hho1m5l3fWtNWTfVE02KM4k8r3hfO3QYS.jpeg",
     *                       "health_program_id": 14
     *                   }
     *               ],
     *               "healthcare_days": [
     *                   {
     *                       "id": 440,
     *                       "day": "1",
     *                       "description": "<p>1</p>",
     *                       "health_program_id": 14
     *                   },
     *                   {
     *                       "id": 441,
     *                       "day": "2",
     *                       "description": "<p><br />\r\n2</p>",
     *                       "health_program_id": 14
     *                   },
     *                   {
     *                       "id": 442,
     *                       "day": "3",
     *                       "description": "<p>3</p>",
     *                       "health_program_id": 14
     *                   }
     *               ]
     *           }
     *       ]
     *   }
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

            if ($request->resort_id == -1) {
                $resortId = 0;
                $defaultResort = Resort::where("is_default", 1)->first();
                if ($defaultResort) {
                    $resortId = $defaultResort->id;
                } else {
                    $defaultResort = Resort::query()->first();
                    $resortId = $defaultResort->id;
                }

                $healthcare = HealthcateProgram::select(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'))->where(["is_active" => 1, "resort_id" => $resortId])
                                ->with([
                                    'healthcareImages' => function($query) {
                                        $query->select('id', 'image_name as banner_image_url', 'health_program_id');
                                    }
                                ])
                                ->with([
                                    'healthcareDays' => function($query) {
                                        $query->select('id', 'day', 'description', 'health_program_id');
                                    }
                                ])->latest()->get();
            } else {

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
      {
      "status": true,
      "status_code": 200,
      "message": "My Health Package",
      "data": {
      "id": 6,
      "name": "Reverse Diabetes in 21 Days",
      "description": "<p>Rindex Media Pvt. Ltd., brings to you Sanjeevani, a naturopathy Centre cradled in the valley of nature, in the beautiful city of Dehradun. Sanjeevani is a centre that not only encompasses the treatment of diabetes but also strives to achieve and helps you maintain optimal levels of health with the help of the highly professional staff. The various programs and services such as yoga, meditation, naturopathy, treating diabetes are designed to suit individual needs.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>At the Centre, you&rsquo;ll get the chance to detox your body&rsquo;s equilibrium and feel the eternal bliss of wellness. As such, our holistic approach sets new standards and we are prepared to meet the challenging health issues of today&rsquo;s Indian society/lifestyle.</p>\r\n\r\n<p>___________________________________________________________________________</p>\r\n\r\n<p>Sanjeevani promises you the best natural and organic therapy to address the root cause of any disorder especially diabetes. This will be the best gift you will gift yourself, a wellness program that will have you feeling complete and give you a sense of being one with your mind and body.</p>",
      "start_from": "24-01-2019",
      "end_to": "22-01-2019",
      "healthcare_images": [
      {
      "id": 17,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/Xj6B4ayTdL3F7AkLwGxH6VrfSVzHbkBf3yUregTa.jpeg",
      "health_program_id": 6
      },
      {
      "id": 22,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/dHRAYPVxQkmw9yfLVScYCN5QUvO4OJ8NqQRBI0Ag.jpeg",
      "health_program_id": 6
      },
      {
      "id": 23,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/2IjaxxOCWYNtHvFs564nkSrkyyKU0TQxddp0qyt0.jpeg",
      "health_program_id": 6
      },
      {
      "id": 24,
      "banner_image_url": "http://127.0.0.1:1234/storage/healthcare_images/rTGNijkeoYlZB5xJqQk9JLYU7881mj6O0PqJfns2.jpeg",
      "health_program_id": 6
      }
      ],
      "healthcare_days": [
      {
      "id": 326,
      "day": "2",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 325,
      "day": "1",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 327,
      "day": "3",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 328,
      "day": "4",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 329,
      "day": "5",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 330,
      "day": "6",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 331,
      "day": "7",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 332,
      "day": "8",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 333,
      "day": "9",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 334,
      "day": "10",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 335,
      "day": "11",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 336,
      "day": "12",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 337,
      "day": "13",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 338,
      "day": "14",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 339,
      "day": "15",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 340,
      "day": "16",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 341,
      "day": "17",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 342,
      "day": "18",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 343,
      "day": "19",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 344,
      "day": "20",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      },
      {
      "id": 345,
      "day": "21",
      "description": "<p>05:00 AM : Wake Up</p>\r\n\r\n<p>05:30 AM : Fasting Sugar</p>\r\n\r\n<p>05:45 AM : Tulsi - Ginger Tea</p>\r\n\r\n<p>06:00 AM : Walk/Yoga</p>\r\n\r\n<p>07:00 AM : Coconut Water</p>\r\n\r\n<p>08:00 AM : Salad Breakfast</p>\r\n\r\n<p>09:00 AM : Meditation/Massage</p>\r\n\r\n<p>12:00 AM : Lunch</p>\r\n\r\n<p>12:30 PM : Walk</p>\r\n\r\n<p>03:00 PM : Banana/Cashew/Almond Shake</p>\r\n\r\n<p>03:30 PM : Consultancy</p>\r\n\r\n<p>04:00 PM : Routine Check-up</p>\r\n\r\n<p>06:00 PM : Dinner</p>\r\n\r\n<p>07:00 PM : Spritual Classes</p>\r\n\r\n<p>08:00 PM : Bed Time</p>",
      "health_program_id": 6
      }
      ]
      }
      }
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
                        ->where("is_cancelled", 0)
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
      {
      "status": true,
      "status_code": 200,
      "message": "Health Package found",
      "data": {
      "complete": [
      {
      "id": 11,
      "name": "Healthcare Package Reverse Diabetes in 3 Days",
      "duration": "01-Feb-2019 to 02-Feb-2019",
      "status": "Completed"
      }
      ],
      "upcoming": [
      {
      "id": 11,
      "record_id": 45,
      "name": "Healthcare Package Reverse Diabetes in 3 Days",
      "duration": "01-Apr-2019 to 03-Apr-2019",
      "status": "Upcoming"
      }
      ],
      "term_condition":"<p>lorem ipsumis the dummy text....."
      }
      }
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
                        ->where("is_cancelled", "!=", 1)
                        ->get();
                $cancelledPackages = UserBookingDetail::with([
                            "packageDetail" => function($query) {
                                $query->selectRaw(DB::raw('id, name, description, DATE_FORMAT(start_from, "%d-%m-%Y") as start_from, DATE_FORMAT(end_to, "%d-%m-%Y") as end_to'));
                            }
                        ])
//                        ->where("check_in", ">", date("Y-m-d H:i:s"))
                        ->where("user_id", $request->user_id)
                        ->where("is_cancelled", 1)
                        ->get();
                $completedArray = [];
                $i = 0;
                foreach ($completedPackages as $completedPackage) {
                    if ($completedPackage->packageDetail) {
                        $completedArray[$i]["id"] = $completedPackage->packageDetail->id;
                        $completedArray[$i]["name"] = $completedPackage->packageDetail->name;
                        $completedArray[$i]["duration"] = date("d-M-Y", strtotime($completedPackage->check_in)) . " to " . date("d-M-Y", strtotime($completedPackage->check_out));
                        $completedArray[$i]["status"] = "Completed";
                        $i++;
                    }
                }
                $data['complete'] = $completedArray;
                $upcomingArray = [];
                $j = 0;
                foreach ($upcomingPackages as $upcomingPackage) {
                    if ($upcomingPackage->packageDetail) {
                        $resort = Resort::find($upcomingPackage->resort_id);
                        $upcomingArray[$j]["id"] = $upcomingPackage->packageDetail->id;
                        $upcomingArray[$j]["record_id"] = $upcomingPackage->id;
                        $upcomingArray[$j]["name"] = $upcomingPackage->packageDetail->name;
                        $upcomingArray[$j]["duration"] = date("d-M-Y", strtotime($upcomingPackage->check_in)) . " to " . date("d-M-Y", strtotime($upcomingPackage->check_out));
                        $upcomingArray[$j]["status"] = "Upcoming";
                        $upcomingArray[$j]["term_condition"] = $resort ? $resort->cancel_term_condition != null ? $resort->cancel_term_condition : '' : '';
                        $j++;
                    }
                }
                $data['upcoming'] = $upcomingArray;
                $cancelledArray = [];
                $k = 0;
                foreach ($cancelledPackages as $cancelledPackage) {
                    if ($cancelledPackage->packageDetail) {
                        $cancelledArray[$k]["id"] = $cancelledPackage->packageDetail->id;
                        $cancelledArray[$k]["name"] = $cancelledPackage->packageDetail->name;
                        $cancelledArray[$k]["duration"] = date("d-M-Y", strtotime($cancelledPackage->check_in)) . " to " . date("d-M-Y", strtotime($cancelledPackage->check_out));
                        $cancelledArray[$k]["status"] = "Cancelled";
                        $k++;
                    }
                }
                $data['cancel'] = $cancelledArray;
                $data['term_condition'] = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>";
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
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostCancelHealthcareProgram
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} record_id Package record id*.
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
     * @apiError RecordIdMissing The record id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Record id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function cancelHealthcareProgram(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }
            if (!$request->record_id) {
                return $this->sendErrorResponse("record id missing", (object) []);
            }
            $userBookingDetail = UserBookingDetail::find($request->record_id);
            $userBookingDetail->is_cancelled = 1;
            $userBookingDetail->save();
            return $this->sendSuccessResponse("Healthcare package cancelled successsfully", (object) []);
        } catch (\Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage(), (object) []);
        }
    }

    /**
     * @api {post} /api/healthcare-booking  Healthcare booking
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostHealthcareProgramBooking
     * @apiGroup Healthcare Program
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} health_care_id health care id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Health care Package booked.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "Health care Package booked",
      "data": {}
      }
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
     * @apiError HealthcareIdMissing The healthcare id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Health care id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function booking(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }
            if (!$request->health_care_id) {
                return $this->sendErrorResponse("Health care id missing", (object) []);
            }
            $healthcareProgram = HealthcateProgram::find($request->health_care_id);
            if (!$healthcareProgram) {
                return $this->sendErrorResponse("Invalid healthcare package", (object) []);
            }

            $healthBooking = new HealthcareBooking();
            $healthBooking->user_id = $request->user_id;
            $healthBooking->health_care_id = $request->health_care_id;
            $healthBooking->start_from = $healthcareProgram->start_from;
            $healthBooking->end_to = $healthcareProgram->end_to;
            $healthBooking->save();

            return $this->sendSuccessResponse("Health care Package booked", (object) []);
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
