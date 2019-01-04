<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceRequestStatus extends Model
{
    public function scopeUserRequestStatus($query){
        $query->addSelect(DB::raw("(CASE "
                . "WHEN (id = '1') THEN 'Pending' "
                . "WHEN (id = '2') THEN 'Accepted' "
                . "WHEN (id = '3') THEN 'Your Approval Needed' "
                . "WHEN (id = '4') THEN 'Completed' "
                . "ELSE 'Not Resolve' END) as status"));
    }
    public function scopeStaffRequestStatus($query){
        $query->addSelect(DB::raw("(CASE "
                . "WHEN (id = '1') THEN 'New' "
                . "WHEN (id = '2') THEN 'On going' "
                . "WHEN (id = '3') THEN 'Under approval' "
                . "WHEN (id = '4') THEN 'Completed' "
                . "ELSE 'Not Resolve' END) as status"));
    }
}
