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

class ResortController extends Controller {

    public function __construct(Resort $resort, ResortImage $resortImage, RoomType $roomType, ResortRoom $resortRoom, ResortRating $resortRating) {
        $this->resort = $resort;
        $this->resortImage = $resortImage;
        $this->roomType = $roomType;
        $this->resortRoom = $resortRoom;
        $this->resortRating = $resortRating;
    }

    public function getResortRooms(Request $request, $resort = 0, $type = 0) {
        $resortRooms = ResortRoom::where(["resort_id" => $resort, "room_type_id" => $type, "is_active" => 1])->get();
        return view('admin.resort.rooms', ['resortRooms' => $resortRooms]);
    }

}
