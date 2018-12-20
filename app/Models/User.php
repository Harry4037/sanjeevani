<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable {

    use HasApiTokens,
    Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'user_type_id',
        'email_id',
        'mobile_number',
        'otp',
        'password',
    ];

    public function getProfilePicPathAttribute($name) {
        return asset('storage/profile_pic/' . $name);
    }

    public function getEmailForPasswordReset() {
        return $this->email_id;
    }

    public function userHealthDetail() {
        return $this->hasOne('App\Models\UserhealthDetail', 'user_id');
    }

    public function userBookingDetail() {
        return $this->hasOne('App\Models\UserBookingDetail', 'user_id');
    }

    public function mealOrders() {
        return $this->hasMany('App\Models\MealOrder', 'user_id');
    }

    public function payments() {
        return $this->hasMany('App\Models\PaidAmount', 'user_id');
    }

    public function getUserTypeIdAttribute($value) {
        if ($value == 3) {
            return $this->userBookingDetail ? 3 : 4;
        } else {
            return $value;
        }
    }

}
