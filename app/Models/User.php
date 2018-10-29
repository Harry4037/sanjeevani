<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

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

    public function getEmailForPasswordReset() {
        return $this->email_id;
    }

//    public function routeNotificationFor($driver) {
//        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
//            return $this->{$method}();
//        }
//
//        switch ($driver) {
//            case 'database':
//                return $this->notifications();
//            case 'mail':
//                return $this->email_id;
//            case 'nexmo':
//                return $this->phone_number;
//        }
//    }
}
