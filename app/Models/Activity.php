<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function activityImages() {
        return $this->hasMany('App\Models\ActivityImage', 'amenity_id');
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
