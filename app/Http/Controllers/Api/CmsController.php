<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Cms;
use App\Models\SOS;
use App\Models\User;
use App\Models\UserBookingDetail;

class CmsController extends Controller {

    /**
     * @api {get} /api/terms-conditions  Terms & Conditions
     * @apiHeader {String} Accept application/json. 
     * @apiName GetTermCondition
     * @apiGroup CMS
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message term & condition found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *  {
     *      "status": true,
     *      "status_code": 200,
     *      "message": "term & condition found.",
     *      "data": "<h1>Terms &amp; Conditions</h1>\n\n<ul>\n\t<li>\n\t<p>Please read the following terms and conditions carefully as it sets out the terms of a legally binding agreement between you (the reader) and Business Standard Private Limited.</p>\n\t</li>\n</ul>\n\n<h2>1) Introduction</h2>\n\n<ul>\n\t<li>\n\t<p>This following sets out the terms and conditions on which you may use the content on&nbsp;<br />\n\t</li>\n</ul>\n\n<h2>2) Registration Access and Use</h2>\n\n<ul>\n\t<li>\n\t<p>We welcome users to register on our digital platforms. We offer the below mentioned registration services which may be subject to change in the future. All changes will be appended in the terms and conditions page and communicated to existing users by email.</p>\n\n\t<p>Registration services are offered for individual subscribers only. If multiple individuals propose to access the same account or for corporate accounts kindly contact or write in to us. Subscription rates will vary for multiple same time access.</p>\n\t</li>\n</ul>\n"
     *  }
     * 
     * 
     */
    public function termContidion(Request $request) {
        try {
            $cms = Cms::find(1);
            $data["content"] = $cms->content;
            return $this->sendSuccessResponse("term & condition found.", $data);
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/about-us  About us
     * @apiHeader {String} Accept application/json. 
     * @apiName GetAboutUs
     * @apiGroup CMS
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message about us found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "about us found.",
     *    "data": "<p><span >About Us</span></p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n"
     * }
     * 
     * 
     */
    public function aboutUs(Request $request) {
        try {
            $cms = Cms::find(2);
            $data["content"] = $cms->content;
            $data["last_updated"] = $cms->updated_at;
            return $this->sendSuccessResponse("about us found.", $data);
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/contact-us  Contact us
     * @apiHeader {String} Accept application/json. 
     * @apiName GetContactUs
     * @apiGroup CMS
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message contact us found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "status": true,
     *     "status_code": 200,
     *     "message": "contact us found.",
     *     "data": "<h3>55 SE. Mechanic St.</h3><br><p>Coventry,</p><br><p> RI 02816</p>"
     * }
     * 
     * 
     */
    public function contactUsDetail(Request $request) {
        try {
            $cms = Cms::find(3);
            $data["content"] = $cms->content;
            $data["phone_no_1"] = "1800 7300 7400";
            $data["phone_no_2"] = "9896543210";
            return $this->sendSuccessResponse("contact us found.", $data);
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {post} /api/submit-contact-us  Submit Contact us
     * @apiHeader {String} Accept application/json. 
     * @apiName PostSubmitContactUs
     * @apiGroup CMS
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} subject subject*.
     * @apiParam {String} message message*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Your message submmited successfully.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Your message submmited successfully.",
     *    "data": {}
     * }
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
     * @apiError SubjectMissing The subject is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Subject missing.",
     *       "data": {}
     *   } 
     * @apiError MessageMissing The Message is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Message missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function contactUsSubmit(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }
            if (!$request->subject) {
                return $this->sendErrorResponse("Subject missing", (object) []);
            }
            if (!$request->message) {
                return $this->sendErrorResponse("Message missing", (object) []);
            }
            return $this->sendSuccessResponse("Your message submitted successfully.", (object) []);
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {post} /api/sos  SOS
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostSOS
     * @apiGroup CMS
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} latitude Latitude*.
     * @apiParam {String} longitude Longitude*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Your emergency request submmited successfully.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Your emergency request submmited successfully.",
     *    "data": {}
     * }
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
     * @apiError LatitudeMissing The latitude is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Latitude missing.",
     *       "data": {}
     *   } 
     * @apiError LongitudeMissing The Longitude is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Longitude missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function sos(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }
            if (!$this->bookBeforeCheckInDate($request->user_id)) {
                return $this->sendErrorResponse("Sorry! You can not raise request before checkIn date or after checkout date.", (object) []);
            }
            if ($request->user()->id != $request->user_id) {
                return $this->sendErrorResponse("invalid user", (object) []);
            }
            if (!$request->latitude) {
                return $this->sendErrorResponse("Latitude missing", (object) []);
            }
            if (!$request->longitude) {
                return $this->sendErrorResponse("Longitude missing", (object) []);
            }
            if ($request->user()->user_type_id == 4) {
                return $this->sendInactiveAccountResponse();
            }
            $user = User::with("userBookingDetail")->find($request->user_id);
            $SOS = new SOS();
            $SOS->user_id = $request->user_id;
            $SOS->latitude = $request->latitude;
            $SOS->longitude = $request->longitude;
            $SOS->resort_name = isset($user->userBookingDetail->resort->name) ? $user->userBookingDetail->resort->name : "";
            $SOS->room_no = isset($user->userBookingDetail->room_detail->room_no) ? $user->userBookingDetail->room_detail->room_no : "";
            $SOS->room_type = isset($user->userBookingDetail->room_type_detail->name) ? $user->userBookingDetail->room_type_detail->name : "";
            $SOS->save();
            return $this->sendSuccessResponse("Your emergency request submitted successfully.", (object) []);
        } catch (\Exception $ex) {
//            dd($ex);
            return $this->administratorResponse();
        }
    }

}
