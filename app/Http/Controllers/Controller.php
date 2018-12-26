<?php

namespace App\Http\Controllers;

use App\Http\Helper\Common;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Common;

    public function sendSuccessResponse($message, $data) {
        return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => $message,
                    'data' => $data
        ]);
    }

    public function sendErrorResponse($message, $data, $statusCode = 404) {
        return response()->json([
                    'status' => false,
                    'status_code' => $statusCode,
                    'message' => $message,
                    'data' => $data
        ]);
    }

    public function administratorResponse() {
        return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'message' => "Something went be wrong. Please contact administrator.",
                    'data' => (object) []
        ]);
    }

    public function generateNotification($userId, $title, $message, $type) {
        $notification = new Notification();
        $notification->user_id = $userId;
        $notification->title = $title;
        $notification->message = $message;
        $notification->type = $type;
        if ($notification->save())
            return TRUE;
        else
            return FALSE;
    }

    public function androidPushNotification($userType, $title, $message, $token, $notificationType, $recordId) {
        if ($userType == '3') {
            //Fro customer
            config(['fcm.http.server_key' => 'AAAAZDeprME:APA91bHyGVMy54RTPTZKyj-gsF5L31IsHP0efkEm4RorsITp-yH2Syh-ftIuuaIu2zm7zZpJZp_CBmY4B33yahx1uZWG570_z6bJ9OxnuX2_Zzh9NFwVbtYKANXRh7SpsQZPq328Y-Jj']);
            config(['fcm.http.sender_id' => '430430596289']);
        } else {
            config(['fcm.http.server_key' => 'AAAAAcfmMHc:APA91bF7kuKBLEjxKWrXoBzvqrmTpQfb-Ajz3gyn28GAo2eHf_8ITB4D21ifAspou-CLjSPVgwnxSb-vCRQlwXQEIZzwFJjKxLxkfDUvN5wM1xjw8BjdkWQei0vjXMZ9O5FzD0G5ILB1']);
            config(['fcm.http.sender_id' => '7648718967']);
        }

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
                ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['title' => $title, 'message' => $message, 'type' => $notificationType, "record_id" => $recordId]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

//        $token = "dzwSVRui5ZE:APA91bEh4IJsSwrVOGyeYi4wCCEqzwcZJdPl2DlnhN86Mce9g7cGoYZp7wp_-ipdrwhXGCohRtebFI2Ufnprf4hz7z1WhvZiII48EKUE_JnvfZjvu20Eh9RD6u4QjW8OB3mHfPuC6_uE";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        return $downstreamResponse;
    }

}
