<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
//        $schedule->call(function () {
//            $tokens = DB::table('users')->where(["is_active" => 1, "user_type_id" => 3])
//                    ->where("device_token", "!=", NULL)
//                    ->orWhere("device_token", "!=", "")
//                    ->pluck("device_token");
//            if ($tokens) {
//                config(['fcm.http.server_key' => 'AAAAZDeprME:APA91bHyGVMy54RTPTZKyj-gsF5L31IsHP0efkEm4RorsITp-yH2Syh-ftIuuaIu2zm7zZpJZp_CBmY4B33yahx1uZWG570_z6bJ9OxnuX2_Zzh9NFwVbtYKANXRh7SpsQZPq328Y-Jj']);
//                config(['fcm.http.sender_id' => '430430596289']);
//
//
//                $optionBuilder = new OptionsBuilder();
//                $optionBuilder->setTimeToLive(60 * 20)
//                        ->setPriority('high');
//
//                $notificationBuilder = new PayloadNotificationBuilder("Reminder Push");
//                $notificationBuilder->setBody("Booking reminder notification.")
//                        ->setSound('soundn.mp3');
//
//                $dataBuilder = new PayloadDataBuilder();
//                $dataBuilder->addData([
//                    'title' => "Reminder Push",
//                    'message' => "Booking reminder notification.",
//                    "type" => 234,
//                    "user_type_id" => 3,
//                    "sound" => "soundn.mp3",
//                ]);
//
//                $option = $optionBuilder->build();
//                $notification = $notificationBuilder->build();
//                $data = $dataBuilder->build();
//
//                $token = "cj2GrsTHQlU:APA91bGw707gSY_IYpVY0_cYHm8GiBVslMc86er03xkNr8_ixiuyN95OmVH0ctLSv9JOjq5acIHjKnWfq_fx0yxw3KidSkSrVdHx2TWjFBzaJhwpt72B6IcB0UN24G_fBbsy3f4OPw-K";
//
//                $downstreamResponse = FCM::sendTo([$token], $option, $notification, $data);
//            }
//        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
