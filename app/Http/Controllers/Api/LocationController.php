<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use App\Models\CountryMaster;

class LocationController extends Controller {

    /**
     * @api {get} /api/country-list  Country list
     * @apiHeader {String} Accept application/json. 
     * @apiName GetCountryList
     * @apiGroup Master Api
     * 
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Country list.
     * @apiSuccess {JSON} data [].
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
        {
            "status": true,
            "status_code": 200,
            "message": "country list",
            "data": {
                "countries": [
                    {
                        "id": 1,
                        "conutry": "India",
                        "calling_code": "+91",
                        "created_by": "0",
                        "updated_by": "0",
                        "is_active": 1,
                        "created_at": null,
                        "updated_at": null
                    },
                    {
                        "id": 2,
                        "conutry": "USA",
                        "calling_code": "+1",
                        "created_by": "0",
                        "updated_by": "0",
                        "is_active": 1,
                        "created_at": null,
                        "updated_at": null
                    }
                ]
            }
        }
     * 
     * 
     * 
     */
    public function countrylist(Request $request) {
        try {
            $data['countries'] = CountryMaster::all();
            return $this->sendSuccessResponse("country list", $data);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), (object) []);
        }
    }

}
