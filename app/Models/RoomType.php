<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getIconAttribute($name) {
        return asset('storage/room_icon/' . $name);
    }
    
    public function getImageAttribute($name) {
        return asset('storage/room_images/' . $name);
    }

}
