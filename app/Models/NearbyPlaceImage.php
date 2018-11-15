<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NearbyPlaceImage extends Model
{
     public function getNameAttribute($name){
        return asset('storage/nearby_images/'.$name);
    }
}
