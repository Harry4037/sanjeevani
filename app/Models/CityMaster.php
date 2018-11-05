<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityMaster extends Model {

    protected $table = 'city_master';
    protected $appends = [
        'state',
    ];

    public function getStateAttribute() {
        $state = StateMaster::find($this->state_id);
        return $state;
    }

}
