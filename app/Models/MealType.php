<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealType extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function menuItems()
    {
        return $this->hasMany('App\Models\MealItem','meal_type_id');
    }

}
