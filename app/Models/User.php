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
//    protected $appends = [
//        'booking_detail',
//        'health_detail',
//        'user_role',
//    ];
//    
//    public function getUserRoleAttribute() {
//        $userType = UserType::find($this->user_type_id);
//        return $userType;
//    }
//    
//    public function getBookingDetailAttribute() {
//        $userBooking = UserBookingDetail::where("user_id", $this->id)->first();
//        return $userBooking;
//    }
//
//    public function getHealthDetailAttribute() {
//        $userHealth = UserhealthDetail::where("user_id", $this->id)->first();
//        return $userHealth;
//    }

    public function getEmailForPasswordReset() {
        return $this->email_id;
    }

    public function userHealthDetail(){
        return $this->hasOne('App\Models\UserhealthDetail', 'user_id'); 
    }
    
    public function userBookingDetail(){
        return $this->hasOne('App\Models\UserBookingDetail', 'user_id'); 
    }

}
