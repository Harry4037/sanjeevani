<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model{
    protected $table = 'banner';

    public function getNameAttribute($name){
        return asset('storage/banner_images/'.$name);
    }
}
