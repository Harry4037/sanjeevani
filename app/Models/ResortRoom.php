<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResortRoom extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    public function roomType(){
        return $this->belongsTo('App\Models\RoomType','room_type_id');
    }
}
