<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller {

    /**
     * @api {get} /api/notification-list Notification list
     * @apiHeader {String} Accept application/json.
     * @apiName GetNotificationList
     * @apiGroup Notification
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Notifications.
     * @apiSuccess {JSON}   data Json Array.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Notifications",
     *    "data": [
     *        {
     *            "id": 1,
     *            "title": "Lorem Ipsum",
     *            "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *            "type": 1,
     *            "date": "27-Nov-2018",
     *            "time": "05:00:00 AM"
     *        },
     *        {
     *            "id": 2,
     *            "title": "Lorem Ipsum",
     *            "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *            "type": 1,
     *            "date": "27-Nov-2018",
     *            "time": "05:00:00 AM"
     *        }
     *    ]
     * }
     * 
     * 
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *    "status": false,
     *    "status_code": 404,
     *    "message": "User id missing.",
     *    "data": {}
     * }
     * 
     * 
     */
    public function notificationList(Request $request) {
        if (!$request->user_id) {
            return $this->sendErrorResponse("User id missing.", (object) []);
        }
        $notifications = Notification::select(DB::raw('id, title, message, type, DATE_FORMAT(created_at, "%d-%b-%Y")  as date, DATE_FORMAT(created_at, "%r")  as time'))->where("user_id", $request->user_id)->latest()->get();
        if($notifications){
            foreach($notifications as $notification){
                $notification->is_view = 1;
                $notification->save();
            }
        }

        return $this->sendSuccessResponse("Notifications", $notifications);
    }

}
