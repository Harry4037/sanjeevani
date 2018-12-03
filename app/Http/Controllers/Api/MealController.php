<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\MealType;
use App\Models\MealItem;

class MealController extends Controller {

    /**
     * @api {get} /api/meal-listing  Category wise meal listing
     * @apiHeader {String} Accept application/json. 
     * @apiName GetMealList
     * @apiGroup Meal
     * 
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Meal list found.
     * @apiSuccess {JSON} data response.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Meal list found",
     *       "data": {
     *           "category_meal": [
     *               {
     *                   "id": 2,
     *                   "name": "Starters",
     *                   "menu_items": [
     *                       {
     *                           "id": 4,
     *                           "name": "Aloo tikki",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/XxV3OiCh3XC6Js2Q0MAsCLkjpBwnThd4J6L54XTG.jpeg",
     *                           "meal_type_id": 2,
     *                           "price": 500
     *                       },
     *                       {
     *                           "id": 5,
     *                           "name": "Chees puff",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/MDkVNWyReK39GTIu8gzEdTRcsyXNPrxgCIg4mfse.png",
     *                           "meal_type_id": 2,
     *                           "price": 1200
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 3,
     *                   "name": "Main Course",
     *                   "menu_items": [
     *                       {
     *                           "id": 6,
     *                           "name": "Dal Makkhni",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/iqbEho8dXoQ8TzasM6wSjdJAy4H7zs94ZtGHWiZw.jpeg",
     *                           "meal_type_id": 3,
     *                           "price": 200
     *                       },
     *                       {
     *                           "id": 7,
     *                           "name": "Dal Tadka",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/SdFRP8PvNOkvH7Ohb2fWjwVxYq9fqNrl2tib2WxC.png",
     *                           "meal_type_id": 3,
     *                           "price": 180
     *                       },
     *                       {
     *                           "id": 8,
     *                           "name": "Matar Paneer",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/SLbPjB8yDlzp5j0KDWkMThSGJ1aRbVrm5Xel06mK.jpeg",
     *                           "meal_type_id": 3,
     *                           "price": 550
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 4,
     *                   "name": "Breads",
     *                   "menu_items": [
     *                       {
     *                           "id": 9,
     *                           "name": "Tandoori roti",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/bAYr15Pu7XrODtdK1QHy7eqJMWpdPRVT0iGHuizR.jpeg",
     *                           "meal_type_id": 4,
     *                           "price": 10
     *                       },
     *                       {
     *                           "id": 10,
     *                           "name": "Tawa roti",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/JOkgivUsvPLzzl2iHrjPjEKeJeR5iAMK3b91rmaD.jpeg",
     *                           "meal_type_id": 4,
     *                           "price": 5
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 5,
     *                   "name": "Drinks",
     *                   "menu_items": [
     *                       {
     *                           "id": 11,
     *                           "name": "Sprite",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/UZxxbKeaBDydPIbME6Qi0RySAUqe7r23TvGCODtr.jpeg",
     *                           "meal_type_id": 5,
     *                           "price": 55
     *                       },
     *                       {
     *                           "id": 12,
     *                           "name": "Furti",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/LJpF4r1MOC20jKgFlUOp6CRX30WhlZD5zbqEkDq5.png",
     *                           "meal_type_id": 5,
     *                           "price": 60
     *                       }
     *                   ]
     *               }
     *           ]
     *       }
     *   }
     * 
     * @apiError ResortIdMissing The resort id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Resort id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function mealListing(Request $request) {
        if (!$request->resort_id) {
            return $this->sendErrorResponse("Resort id missing", (object) []);
        }
        $mealCategory = Mealtype::select('id', 'name')->whereHas('menuItems')->with([
                    'menuItems' => function ($query) use($request) {
                        $query->select('id', 'name', 'image_name as banner_image_url', 'meal_type_id', 'price')->where('resort_id', $request->resort_id);
                    }
                ])->get();

                
        $data['category_meal'] = $mealCategory;
        return $this->sendSuccessResponse("Meal list found", $data);
    }

}
