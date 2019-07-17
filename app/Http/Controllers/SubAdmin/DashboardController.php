<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserBookingDetail;
use App\Models\User;
use App\Models\RoomType;
use App\Models\ResortRoom;

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

        $roomTypes = RoomType::where(["resort_id" => $request->get("subadminResort"), "is_active" => 1])->get();

        $css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
        ];
        return view('subadmin.dashboard.dashboard', [
            "activeUser" => $activeUser,
            "activeStaff" => $activeStaff,
            "inactiveUser" => $inactiveUser,
            "inactiveStaff" => $inactiveStaff,
            "roomTypes" => $roomTypes,
            "js" => $js,
            "css" => $css
        ]);
    }

    public function inventoryDetail(Request $request) {
        //All rooms of the selecte resorts
        $rooms = ResortRoom::where(["resort_id" => $request->get("subadminResort"), "room_type_id" => $request->resort_room_id])->get();

        //All rooms who are booked for selected date range
        $check_in = date("Y-m-d H:s:i", strtotime($request->check_in_date));
        $check_out = date("Y-m-d H:s:i", strtotime($request->check_out_date));

        $roomIds = UserBookingDetail::where("resort_id", $request->get("subadminResort"))
                ->where(function($query) use($check_in, $check_out) {
                    $query->orWhere(function($query) use($check_in) {
                        $query->where("check_in", "<=", $check_in)
                        ->where("check_out", ">=", $check_in);
                    });
                    $query->orWhere(function($query) use($check_out) {
                        $query->where("check_in", "<", $check_out)
                        ->where("check_out", ">=", $check_out);
                    });
                    $query->orWhere(function($query) use($check_in, $check_out) {
                        $query->where("check_in", ">=", $check_in)
                        ->where("check_out", "<=", $check_out);
                    });
                })
                ->pluck("resort_room_id");

        return view('subadmin.dashboard.inventory', [
            "rooms" => $rooms,
            "roomIds" => count($roomIds) > 0 ? $roomIds->toArray() : []
        ]);
    }

}
