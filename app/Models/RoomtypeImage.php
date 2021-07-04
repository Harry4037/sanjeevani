<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomtypeImage extends Model {

    public function getImageNameAttribute($name) {
        return asset('storage/room_images/' . $name);
    }

    public function getBannerImageUrlAttribute($name) {
        return asset('storage/room_images/' . $name);
    }

}
