<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class offerImage extends Model {

    public function getImageNameAttribute($name) {
        return asset('storage/offer_images/' . $name);
    }
    public function getBannerImageUrlAttribute($name) {
        return asset('storage/offer_images/' . $name);
    }

}
