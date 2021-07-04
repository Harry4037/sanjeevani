<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthcateProgram extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getDescriptionAttribute($name) {
        return $name == null ? "" : $name;
    }

    public function healthcareImages() {
        return $this->hasMany('App\Models\HealthcateProgramImages', 'health_program_id');
    }

    public function healthcareDays() {
        return $this->hasMany('App\Models\HealthcateProgramDay', 'health_program_id');
    }

    public function resortDetail() {
        return $this->belongsTo('App\Models\Resort', 'resort_id');
    }

}
