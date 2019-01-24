<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResortNearbyPlace extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
