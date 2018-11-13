<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resort extends Model {
    
    public function resortImages(){
        return $this->hasMany('App\Models\ResortImage','resort_id');
    }
    public function resortRooms(){
        return $this->hasMany('App\Models\ResortRoom','resort_id');
    }
    public function resortAmenities(){
        return $this->hasMany('App\Models\Amenity','resort_id');
    }
    public function resortNearByPlaces(){
        return $this->hasMany('App\Models\ResortNearbyPlace','resort_id');
    }

}
