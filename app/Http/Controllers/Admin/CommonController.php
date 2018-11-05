<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CityMaster;

class CommonController extends Controller {

    public function getCityList(Request $request, $id) {
        $cities = CityMaster::where(["is_active" => 1, "state_id" => $id])->get();
        return view('admin.common.city', [
            "cities" => $cities
        ]);
    }

}
