<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBookingDetail extends Model {

    protected $appends = [
        'room_booking',
        'bookingpeople_accompany',
        'resort',
    ];

    public function getResortAttribute() {
        $resort = Resort::find($this->resort_id);
        return $resort;
    }
    
    public function getRoomBookingAttribute() {
        $roomBooking = RoomBooking::where("booking_id", $this->id)->first();
        return $roomBooking;
    }
    
    public function getBookingpeopleAccompanyAttribute() {
        $userPeopleBooking = BookingpeopleAccompany::where("booking_id", $this->id)->get();
        return $userPeopleBooking;
    }

}
