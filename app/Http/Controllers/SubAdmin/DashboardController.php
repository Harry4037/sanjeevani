<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserBookingDetail;
use App\Models\User;

class DashboardController extends Controller {

    public function index(Request $request) {
        $userBookingDetail = UserBookingDetail::where("resort_id", $request->get("subadminResort"))->pluck("user_id");
        if ($userBookingDetail) {
            $userIds = $userBookingDetail->toArray();
        } else {
            $userIds = [];
        }
        $activeUser = User::where(["is_active" => 1, "user_type_id" => 3])->whereIn("id", $userIds)->count();
        $activeStaff = User::where(["is_active" => 1, "user_type_id" => 2])->whereIn("id", $userIds)->count();
        $inactiveUser = User::where(["is_active" => 0, "user_type_id" => 3])->whereIn("id", $userIds)->count();
        $inactiveStaff = User::where(["is_active" => 0, "user_type_id" => 2])->whereIn("id", $userIds)->count();

        return view('subadmin.dashboard.dashboard', [
            "activeUser" => $activeUser,
            "activeStaff" => $activeStaff,
            "inactiveUser" => $inactiveUser,
            "inactiveStaff" => $inactiveStaff,
        ]);
    }

}
