<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenityImage extends Model {

    public function getImageNameAttribute($name) {
        return $name ? asset('storage/amenity_images/' . $name) : null;
    }

    public function getBannerImageUrlAttribute($name) {
        return asset('storage/amenity_images/' . $name);
    }

}
