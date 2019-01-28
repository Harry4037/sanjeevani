<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class offer extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getDescriptionAttribute($name) {
        return $name == null ? "" : $name;
    }

    public function offerImages() {
        return $this->hasMany('App\Models\offerImage', 'offer_id');
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
