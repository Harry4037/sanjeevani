<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserhealthDetail extends Model
{
    public function getMedicalDocumentsAttribute($name){
        return asset('storage/medical_document/'.$name);
    }
}
