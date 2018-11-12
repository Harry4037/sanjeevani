<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
     public function amenityImages(){
        return $this->hasMany('App\Models\AmenityImage','amenity_id');
    }
}
