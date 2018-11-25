<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserBookingDetail extends Model {

    protected $appends = [
        'resort',
        'room_booking',
        'bookingpeople_accompany',
    ];

    public function getResortAttribute() {
        $resort = Resort::select('id', 'name', 'description', 'contact_number', 'address_1')->where("id", $this->resort_id)
                ->first();
        return $resort;
    }
    public function getRoomBookingAttribute() {
        $roomBooking = RoomBooking::select(DB::raw('id, DATE_FORMAT(check_in, "%d-%m-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%m-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time, room_type_id, resort_room_id'))->where("booking_id", $this->id)
                ->first();
        return $roomBooking;
    }

    public function getBookingpeopleAccompanyAttribute() {
        $userPeopleBooking = BookingpeopleAccompany::select('id', 'person_name', 'person_age', 'person_type')->where("booking_id", $this->id)->get();
        return $userPeopleBooking;
    }

}
