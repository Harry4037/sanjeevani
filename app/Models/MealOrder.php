<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealOrder extends Model {

    public function orderItems() {
        return $this->hasMany('App\Models\MealOrderItem', 'meal_order_id');
    }

}
