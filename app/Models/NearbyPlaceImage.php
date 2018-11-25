<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NearbyPlaceImage extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

     public function getNameAttribute($name){
        return asset('storage/nearby_images/'.$name);
    }
}
