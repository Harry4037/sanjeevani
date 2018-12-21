<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthcateProgramDay extends Model {

    public function getDescriptionAttribute($name) {
        return $name == null ? "" : $name;
    }

}
