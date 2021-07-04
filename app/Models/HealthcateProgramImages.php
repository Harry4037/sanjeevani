<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthcateProgramImages extends Model {

    public function getImageNameAttribute($name) {
        return asset('storage/healthcare_images/' . $name);
    }

    public function getBannerImageUrlAttribute($name) {
        return asset('storage/healthcare_images/' . $name);
    }

}
