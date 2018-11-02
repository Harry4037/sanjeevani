<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

    protected $appends = [
        'service_type'
    ];

    public function getServiceTypeAttribute() {
        $serviceType = ServiceType::select('id', 'name')->find($this->type_id);
        return $serviceType;
    }

    public function getIconAttribute($name) {
        return asset('storage/Service_icon/' . $name);
    }

}
