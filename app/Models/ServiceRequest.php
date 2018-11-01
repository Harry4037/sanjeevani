<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceRequest extends Model
{
    public function serviceDetail(){
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
    public function questionDetail(){
        return $this->belongsTo('App\Models\Question', 'question_id');
    }
    public function requestStatus(){
        return $this->belongsTo('App\Models\ServiceRequestStatus', 'request_status_id');
    }
    
    public function acceptedBy(){
        return $this->belongsTo('App\Models\User', 'accepted_by_id');
    }
       
}
