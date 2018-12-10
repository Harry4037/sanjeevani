<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class NotificationController extends Controller {

    public function index() {

        return view('admin.notification.index');
    }

    public function userList(Request $request) {
        $users = User::where("is_active", 1)->get();
        return view('admin.notification.user-list', [
            'users' => $users
        ]);
    }

    public function sendNotification(Request $request) {
        $usertype = $request->get('user_type');
        $notifyUser = $request->get('notify_user');
        $message = $request->get('message');
        if (!$usertype) {
            return $this->sendErrorResponse("Please select user type", (object) []);
        }
        if ($usertype == 2) {
            if ($notifyUser == null) {
                return $this->sendErrorResponse("Please select user's", (object) []);
            }
        }

        if ($usertype == 1) {
            $user = User::where("is_active", 1)->pluck("id");
            return $this->sendSuccessResponse("Notification send successfully", (object) []);
        } elseif ($usertype == 2) {
            $user = User::whereIn("id", $notifyUser)->pluck("id");
            return $this->sendSuccessResponse("Notification send successfully", (object) []);
        } else {
            return $this->sendErrorResponse("Something went be wrong", (object) []);
        }
    }

}
