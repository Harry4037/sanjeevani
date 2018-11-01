<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortRoom extends Model
{
    public function roomType(){
        return $this->belongsTo('App\Models\RoomType','room_type_id');
    }
}
