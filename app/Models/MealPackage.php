<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealPackage extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getImageNameAttribute($name) {
        return asset('storage/meal_package_images/' . $name);
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
