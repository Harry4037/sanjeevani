<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceRequestStatus extends Model
{
    public function scopeUserRequestStatus($query){
        $query->addSelect(DB::raw("(CASE "
                . "WHEN (request_status = 'New') THEN 'Pending' "
                . "WHEN (request_status = 'Accepted') THEN 'In Progress' "
                . "WHEN (request_status = 'Under Approval') THEN 'Your Approval Needed' "
                . "ELSE 'Completed' END) as status"));
    }
    public function scopeStaffRequestStatus($query){
        $query->addSelect(DB::raw("(CASE "
                . "WHEN (request_status = 'New') THEN 'New' "
                . "WHEN (request_status = 'Accepted') THEN 'On going' "
                . "WHEN (request_status = 'Under Approval') THEN 'Under approval' "
                . "ELSE 'Completed' END) as status"));
    }
}
