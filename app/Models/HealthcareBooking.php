<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthcareBooking extends Model {

    public function userDetail() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function healthcarePackage() {
        return $this->belongsTo('App\Models\HealthcateProgram', 'health_care_id');
    }

}
