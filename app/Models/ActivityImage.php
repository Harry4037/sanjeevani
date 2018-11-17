<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityImage extends Model {

    public function getImageNameAttribute($name) {
        return asset('storage/activity_images/' . $name);
    }

}
