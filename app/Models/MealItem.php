<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealItem extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getImageNameAttribute($name) {
        return asset('storage/meal_images/' . $name);
    }

    public function getBannerImageUrlAttribute($name) {
        return asset('storage/meal_images/' . $name);
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
