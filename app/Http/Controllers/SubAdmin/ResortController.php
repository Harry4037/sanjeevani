<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\RoomType;
use App\Models\ResortRoom;
use App\Models\ResortRating;
use App\Models\StateMaster;
use App\Models\CityMaster;
use Validator;
use App\Models\UserBookingDetail;

class ResortController extends Controller {

    public function __construct(Resort $resort, ResortImage $resortImage, RoomType $roomType, ResortRoom $resortRoom, ResortRating $resortRating) {
        $this->resort = $resort;
        $this->resortImage = $resortImage;
        $this->roomType = $roomType;
        $this->resortRoom = $resortRoom;
        $this->resortRating = $resortRating;
    }

    public function getResortRooms(Request $request) {
        try {
            $check_in = date("Y-m-d H:s:i", strtotime($request->check_in));
            $check_out = date("Y-m-d H:s:i", strtotime($request->check_out));
            $resort = $request->resort;

            $roomIds = UserBookingDetail::where("resort_id", $resort)
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

            $resortRooms = ResortRoom::where(["resort_id" => $resort, "room_type_id" => $request->resort_room, "is_active" => 1])
                    ->whereNotIn("id", $roomIds)
                    ->get();
            return view('admin.resort.rooms', ['resortRooms' => $resortRooms]);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

}
