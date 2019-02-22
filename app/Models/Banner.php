<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {

    protected $table = 'banner';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getNameAttribute($name) {
        return asset('storage/banner_images/' . $name);
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
