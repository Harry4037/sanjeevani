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

        return $name ? asset('storage/profile_pic/' . $name) : asset("/img/no-image.jpg");
    }

    public function getEmailForPasswordReset() {
        return $this->email_id;
    }

    public function userHealthDetail() {
        return $this->hasOne('App\Models\UserhealthDetail', 'user_id');
    }

    public function userBookingDetail() {
        return $this->hasOne('App\Models\UserBookingDetail', 'user_id')->where("check_out", ">=", date("Y-m-d H:i:s"))
                        ->where("is_cancelled", "!=", 1)
                        ->orderBy("check_out", "ASC");
    }

    public function mealOrders() {
        return $this->hasMany('App\Models\MealOrder', 'user_id');
    }

    public function payments() {
        return $this->hasMany('App\Models\PaidAmount', 'user_id');
    }

    public function getUserTypeIdAttribute($value) {
        $booking = UserBookingDetail::where("check_out", ">=", date("Y-m-d H:i:s"))
                // ->where("check_in", "<=", date("Y-m-d H:i:s"))
                ->where("is_cancelled", "!=", 1)
                ->where("user_id", $this->id)
                ->orderBy("check_out", "ASC")
                ->first();

        if ($value == 3) {
            return $booking ? 3 : 4;
        } else {
            return $value;
        }
    }

    public function getFirstNameAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function getMidNameAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function getLastNameAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function getScreenNameAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function getUserNameAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function getEmailIdAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function getVoterIdAttribute($value) {
        return $value ? asset('storage/other_id/' . $value) : asset("/img/no-image.jpg");
    }

    public function getAadharIdAttribute($name) {
        return $name ? asset('storage/aadhar_id/' . $name) : null;
    }

    public function getOtherAadharIdAttribute($name) {
        return $name ? asset('storage/other_aadhar_id/' . $name) : null;
    }

    public function getAddress1Attribute($value) {
        return $value == null ? "" : $value;
    }

    public function getPincodeAttribute($value) {
        return $value == null ? "" : $value;
    }

    public function staff() {
        return $this->hasOne('App\Models\UserBookingDetail', 'user_id');
    }

}
