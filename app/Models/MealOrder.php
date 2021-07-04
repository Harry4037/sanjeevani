<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealOrder extends Model {

	public function orderItems() {
		return $this->hasMany('App\Models\MealOrderItem', 'meal_order_id');
	}

	public function userDetail() {
		return $this->belongsTo('App\Models\User', 'user_id');
	}
        
	public function acceptedBy() {
		return $this->belongsTo('App\Models\User', 'accepted_by');
	}
        
	public function resortDetail() {
		return $this->belongsTo('App\Models\Resort', 'resort_id');
	}

	public function scopeAccepted($query)
	{
		return $query->where('status',4);
	}
}
