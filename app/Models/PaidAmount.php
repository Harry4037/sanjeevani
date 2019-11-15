<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidAmount extends Model
{
	protected $fillable = ['amount','resort_id','booking_id'];
}
