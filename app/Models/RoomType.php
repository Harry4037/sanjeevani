<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model {

    public function getIconAttribute($name) {
        return asset('storage/room_type_icon/' . $name);
    }

}
