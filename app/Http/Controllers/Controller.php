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
use App\Models\UserBookingDetail;
use App\Models\OauthAccessToken;
use App\Models\User;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Common;

    public function notificationCount($userId) {
        $nCount = Notification::where(["user_id" => $userId, "is_view" => 0])->count();
        return $nCount;
    }

    public function bookBeforeCheckInDate($userId) {
        $booking = UserBookingDetail::where("check_in", "<=", date("Y-m-d H:i:s"))
                ->where("check_out", ">=", date("Y-m-d H:i:s"))
                ->where("user_id", $userId)
                ->orderBy("check_out", "ASC")
                ->first();
        return $booking ? true : false;
    }

    public function sendSuccessResponse($message, $data) {
        return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => $message,
                    'data' => $data
        ]);
    }

    public function sendInactiveAccountResponse() {
        return response()->json([
                    'status' => false,
                    'status_code' => 400,
                    'message' => "Your account has been In-active.Please contact to admin.",
                    'data' => (object) []
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

    public function androidPushNotification($userType, $title, $message, $token, $notificationType, $recordId, $userNotificationCount = 0, $statusType = 0) {

        if ($userType == '3') {
            //Fro customer
            config(['fcm.http.server_key' => 'AAAAZDeprME:APA91bHyGVMy54RTPTZKyj-gsF5L31IsHP0efkEm4RorsITp-yH2Syh-ftIuuaIu2zm7zZpJZp_CBmY4B33yahx1uZWG570_z6bJ9OxnuX2_Zzh9NFwVbtYKANXRh7SpsQZPq328Y-Jj']);
            config(['fcm.http.sender_id' => '430430596289']);
        } else {
            config(['fcm.http.server_key' => 'AAAAAcfmMHc:APA91bF7kuKBLEjxKWrXoBzvqrmTpQfb-Ajz3gyn28GAo2eHf_8ITB4D21ifAspou-CLjSPVgwnxSb-vCRQlwXQEIZzwFJjKxLxkfDUvN5wM1xjw8BjdkWQei0vjXMZ9O5FzD0G5ILB1']);
            config(['fcm.http.sender_id' => '7648718967']);
        }

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20)
                ->setPriority('high')
                ;

        $notificationBuilder = new PayloadNotificationBuilder($title);
        if ($userType == 3) {
            $notificationBuilder->setBody($message)
                    ->setSound('default')
                    ->setBadge($userNotificationCount)
                    ;
        } else {
            $notificationBuilder->setBody($message)
                    ->setSound('soundn.mp3')
                    ->setChannelId('RindexStaff')
                    ->setBadge($userNotificationCount)
                    ;
        }

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'title' => $title,
            'message' => $message,
            'type' => $notificationType,
            "record_id" => $recordId,
            "notification_count" => $userNotificationCount,
            "status_type" => $statusType,
            "sound" => "soundn.mp3",
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

//        $token = "dzwSVRui5ZE:APA91bEh4IJsSwrVOGyeYi4wCCEqzwcZJdPl2DlnhN86Mce9g7cGoYZp7wp_-ipdrwhXGCohRtebFI2Ufnprf4hz7z1WhvZiII48EKUE_JnvfZjvu20Eh9RD6u4QjW8OB3mHfPuC6_uE";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        return $downstreamResponse;
    }

    public function sendOtp($mobileNumber, $otp) {
        $url = 'http://sms.hybrid91.com/submitsms.jsp';
        $OTPMessage = "Dear Customer, your One Time Verification (OTP) code is " . $otp . ".";
        $fields = array(
//            'user' => 'Rizilian',
            'user' => 'Dintex',
//            'key' => '83529b3d8eXX',
            'key' => 'ffeac03584XX',
            'mobile' => "+91" . $mobileNumber,
            'message' => $OTPMessage,
//            'senderid' => 'RIZOTP',
            'senderid' => 'RINDEX',
            'accusage' => 1
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($ch);
        curl_close($ch);

        return true;
    }

    public function invalidateAllUsertokens($userId) {
        $userTokens = OauthAccessToken::where(["user_id" => $userId, "revoked" => 0])->get();
        if ($userTokens) {
            foreach ($userTokens as $userToken) {
                $userToken->revoked = 1;
                $userToken->save();
            }
        }
        return true;
    }

    public function cleanDeviceToken($deviceId, $userType) {
        User::where(['device_id' => $deviceId, "user_type_id" => $userType])->update(['device_token' => ""]);
        return true;
    }

    public function androidBookingPushNotification($title, $message, $token) {
        //Fro customer
        config(['fcm.http.server_key' => 'AAAAZDeprME:APA91bHyGVMy54RTPTZKyj-gsF5L31IsHP0efkEm4RorsITp-yH2Syh-ftIuuaIu2zm7zZpJZp_CBmY4B33yahx1uZWG570_z6bJ9OxnuX2_Zzh9NFwVbtYKANXRh7SpsQZPq328Y-Jj']);
        config(['fcm.http.sender_id' => '430430596289']);


        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20)
                ->setPriority('high')
                ;

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
                ->setSound('soundn.mp3')
                ;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'title' => $title,
            'message' => $message,
            "type" => 5,
            "user_type_id" => 3,
            "sound" => "soundn.mp3",
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

//        $token = "dzwSVRui5ZE:APA91bEh4IJsSwrVOGyeYi4wCCEqzwcZJdPl2DlnhN86Mce9g7cGoYZp7wp_-ipdrwhXGCohRtebFI2Ufnprf4hz7z1WhvZiII48EKUE_JnvfZjvu20Eh9RD6u4QjW8OB3mHfPuC6_uE";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        return $downstreamResponse;
    }

    public function sendRegistration($mobileNumber, $userName) {
        $url = 'http://sms.hybrid91.com/submitsms.jsp';
        $OTPMessage = "Dear $userName, You have to registered with us. Please download the our app (APP URL)/";
        $fields = array(
            'user' => 'Dintex',
            'key' => 'ffeac03584XX',
            'mobile' => "+91" . $mobileNumber,
            'message' => $OTPMessage,
            'senderid' => 'RINDEX',
            'accusage' => 1
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($ch);
        curl_close($ch);

        return true;
    }

}
