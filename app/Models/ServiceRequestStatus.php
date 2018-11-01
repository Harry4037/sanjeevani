<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceRequestStatus extends Model
{
    public function scopeUserRequestStatus($query){
        $query->addSelect(DB::raw("(CASE WHEN (request_status = 'New') THEN 'Pending' ELSE 'Accepted' END) as status"));
    }
}
