<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortImage extends Model
{
    
    public function getImageNameAttribute($name){
        return asset('storage/Resort/'.$name);
    }
    
    public function getBannerImageUrlAttribute($name){
        return asset('storage/Resort/'.$name);
    }

}
