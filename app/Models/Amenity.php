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

}
