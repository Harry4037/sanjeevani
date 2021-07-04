<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessages extends Model {

    public function senderDetail() {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }
    
    public function receiverDetail() {
        return $this->belongsTo('App\Models\User', 'receiver_id');
    }
}
