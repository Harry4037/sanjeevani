<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenityImage extends Model
{
    public function getImageNameAttribute($name) {
        return asset('storage/amenities_images/' . $name);
    }
}
