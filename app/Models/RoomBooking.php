<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    protected $appends = [
        'room_type',
        'resort_room',
    ];
    
    public function getRoomTypeAttribute() {
        $roomType = RoomType::select('id','name')->find($this->room_type_id);
        return $roomType;
    }
    
    public function getResortRoomAttribute() {
        $resortRoom = ResortRoom::select('id','room_no')->find($this->resort_room_id);
        return $resortRoom;
    }
}
