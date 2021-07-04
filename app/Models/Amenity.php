<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function amenityImages() {
        return $this->hasMany('App\Models\AmenityImage', 'amenity_id');
    }

    public function getIconAttribute($name) {
        return $name ? asset('storage/amenity_icon/' . $name) : null;
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
