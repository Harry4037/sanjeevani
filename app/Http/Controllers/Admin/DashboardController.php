<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resort;
use App\Models\RoomType;
use App\Models\ResortRoom;
use App\Models\UserBookingDetail;

class DashboardController extends Controller {

    public function index() {
        $activeUser = User::where(["is_active" => 1, "user_type_id" => 3])->count();
        $activeStaff = User::where(["is_active" => 1, "user_type_id" => 2])->count();
        $inactiveUser = User::where(["is_active" => 0, "user_type_id" => 3])->count();
        $inactiveStaff = User::where(["is_active" => 0, "user_type_id" => 2])->count();

        $resorts = Resort::where("is_active", 1)->get();
        $roomTypes = RoomType::where("is_active", 1)->get();

        $css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
        ];

        return view('admin.dashboard.dashboard', [
            "activeUser" => $activeUser,
            "activeStaff" => $activeStaff,
            "inactiveUser" => $inactiveUser,
            "inactiveStaff" => $inactiveStaff,
            "resorts" => $resorts,
            "roomTypes" => $roomTypes,
            "js" => $js,
            "css" => $css
        ]);
    }

    public function inventoryDetail(Request $request) {
        //All rooms of the selecte resorts
        $rooms = ResortRoom::where(["resort_id" => $request->resort_id, "room_type_id" => $request->resort_room_id])->get();

        //All rooms who are booked for selected date range
        $check_in = date("Y-m-d H:s:i", strtotime($request->check_in_date));
        $check_out = date("Y-m-d H:s:i", strtotime($request->check_out_date));

        $roomIds = UserBookingDetail::where("resort_id", $request->resort_id)
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

        return view('admin.dashboard.inventory', [
            "rooms" => $rooms,
            "roomIds" => count($roomIds) > 0 ? $roomIds->toArray() : []
        ]);
    }

}
