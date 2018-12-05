<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPackageItem extends Model {

    public function mealItem() {
        return $this->belongsTo('App\Models\MealItem', 'meal_item_id');
    }

}
