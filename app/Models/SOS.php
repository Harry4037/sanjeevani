<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SOS extends Model {

    protected $table = 's_o_s';

    public function userDetail() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
