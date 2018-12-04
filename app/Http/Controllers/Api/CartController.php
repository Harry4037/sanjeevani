<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Activity;
use App\Models\ActivityTimeSlot;
use App\Models\ActivityRequest;

class ActivityController extends Controller {


    public function addCartItem(Request $request) {
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort id missing", (object) []);
        }

    }

}
