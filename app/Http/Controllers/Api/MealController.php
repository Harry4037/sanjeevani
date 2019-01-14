<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\MealType;
use App\Models\MealItem;
use App\Models\MealPackage;
use App\Models\MealPackageItem;
use App\Models\Cart;

class MealController extends Controller {

    /**
     * @api {get} /api/meal-listing  Category wise meal listing
     * @apiHeader {String} Accept application/json. 
     * @apiName GetMealList
     * @apiGroup Meal
     * 
     * @apiParam {String} resort_id Resort id*.
     * @apiParam {String} user_id User id*.
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
     *           "meal_packages": [
     *               {
     *                   "id": 1,
     *                   "name": "Package 1",
     *                   "image_url": "http://127.0.0.1:8000/storage/meal_package_images/bJfZEM2qedVLzQSHaPNLCezULofRgDol14MEjak8.jpeg",
     *                   "price": 1100,
     *                   "quantity_count": 0,
     *                   "meal_items": [
     *                       {
     *                           "id": 1,
     *                           "name": "Aloo tikki",
     *                           "image_url": "http://127.0.0.1:8000/storage/meal_images/XxV3OiCh3XC6Js2Q0MAsCLkjpBwnThd4J6L54XTG.jpeg",
     *                           "price": 500
     *                       },
     *                       {
     *                           "id": 2,
     *                           "name": "Chees puff",
     *                           "image_url": "http://127.0.0.1:8000/storage/meal_images/MDkVNWyReK39GTIu8gzEdTRcsyXNPrxgCIg4mfse.png",
     *                           "price": 1200
     *                       },
     *                       {
     *                           "id": 3,
     *                           "name": "Furti",
     *                           "image_url": "http://127.0.0.1:8000/storage/meal_images/LJpF4r1MOC20jKgFlUOp6CRX30WhlZD5zbqEkDq5.png",
     *                           "price": 60
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 2,
     *                   "name": "Package 2",
     *                   "image_url": "http://127.0.0.1:8000/storage/meal_package_images/IMfrpkKB0EE4cSmWD848vD3VOjgf2Lp7JYMnKvJF.png",
     *                   "price": 850,
     *                   "quantity_count": 0,
     *                   "meal_items": [
     *                       {
     *                           "id": 4,
     *                           "name": "Dal Makkhni",
     *                           "image_url": "http://127.0.0.1:8000/storage/meal_images/iqbEho8dXoQ8TzasM6wSjdJAy4H7zs94ZtGHWiZw.jpeg",
     *                           "price": 200
     *                       },
     *                       {
     *                           "id": 5,
     *                           "name": "Dal Tadka",
     *                           "image_url": "http://127.0.0.1:8000/storage/meal_images/SdFRP8PvNOkvH7Ohb2fWjwVxYq9fqNrl2tib2WxC.png",
     *                           "price": 180
     *                       },
     *                       {
     *                           "id": 6,
     *                           "name": "Sprite",
     *                           "image_url": "http://127.0.0.1:8000/storage/meal_images/UZxxbKeaBDydPIbME6Qi0RySAUqe7r23TvGCODtr.jpeg",
     *                           "price": 55
     *                       }
     *                   ]
     *               }
     *           ],
     *           "category_meal": [
     *               {
     *                   "id": 2,
     *                   "name": "Starters",
     *                   "menu_items": [
     *                       {
     *                           "id": 4,
     *                           "name": "Aloo tikki",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/XxV3OiCh3XC6Js2Q0MAsCLkjpBwnThd4J6L54XTG.jpeg",
     *                           "price": 500,
     *                           "quantity_count": 4
     *                       },
     *                       {
     *                           "id": 5,
     *                           "name": "Chees puff",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/MDkVNWyReK39GTIu8gzEdTRcsyXNPrxgCIg4mfse.png",
     *                           "price": 1200,
     *                           "quantity_count": 1
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
     *                           "price": 200,
     *                           "quantity_count": 0
     *                       },
     *                       {
     *                           "id": 7,
     *                           "name": "Dal Tadka",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/SdFRP8PvNOkvH7Ohb2fWjwVxYq9fqNrl2tib2WxC.png",
     *                           "price": 180,
     *                           "quantity_count": 0
     *                       },
     *                       {
     *                           "id": 8,
     *                           "name": "Matar Paneer",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/SLbPjB8yDlzp5j0KDWkMThSGJ1aRbVrm5Xel06mK.jpeg",
     *                           "price": 550,
     *                           "quantity_count": 0
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
     *                           "price": 10,
     *                           "quantity_count": 0
     *                       },
     *                       {
     *                           "id": 10,
     *                           "name": "Tawa roti",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/JOkgivUsvPLzzl2iHrjPjEKeJeR5iAMK3b91rmaD.jpeg",
     *                           "price": 5,
     *                           "quantity_count": 0
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
     *                           "price": 55,
     *                           "quantity_count": 0
     *                       },
     *                       {
     *                           "id": 12,
     *                           "name": "Furti",
     *                           "banner_image_url": "http://127.0.0.1:8000/storage/meal_images/LJpF4r1MOC20jKgFlUOp6CRX30WhlZD5zbqEkDq5.png",
     *                           "price": 60,
     *                           "quantity_count": 0
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
     * @apiError UserIdMissing The user id is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User id missing.",
     *       "data": {}
     *   } 
     * 
     */
    public function mealListing(Request $request) {
        try {
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing", (object) []);
            }
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing", (object) []);
            }


            //For meal packages
            if($request->resort_id == -1){
                $mealPackages = MealPackage::where(["is_active" => 1, "resort_id" => 1])->get();
            }else{
                $mealPackages = MealPackage::where(["is_active" => 1, "resort_id" => $request->resort_id])->get();
            }
            $packageData = [];
            if ($mealPackages) {
                foreach ($mealPackages as $key => $mealPackage) {
                    $userCartPackage = Cart::where(["user_id" => $request->user_id, "meal_package_id" => $mealPackage->id])->first();
                    $mealPackageItems = MealPackageItem::where(["meal_package_id" => $mealPackage->id])
                            ->with("mealItem")
                            ->get();
                    $packageData[$key]['id'] = $mealPackage->id;
                    $packageData[$key]['name'] = $mealPackage->name;
                    $packageData[$key]['image_url'] = $mealPackage->image_name;
                    $packageData[$key]['price'] = $mealPackage->price;
                    $packageData[$key]['quantity_count'] = isset($userCartPackage->quantity) && $userCartPackage->quantity ? $userCartPackage->quantity : 0;
                    if (count($mealPackageItems) > 0) {
                        foreach ($mealPackageItems as $k => $mealPackageItem) {
                            $packageData[$key]['meal_items'][$k]['id'] = $mealPackageItem->id;
                            $packageData[$key]['meal_items'][$k]['name'] = $mealPackageItem->mealItem->name;
                            $packageData[$key]['meal_items'][$k]['image_url'] = $mealPackageItem->mealItem->image_name;
                            $packageData[$key]['meal_items'][$k]['price'] = $mealPackageItem->mealItem->price;
                        }
                    } else {
                        $packageData[$key]['meal_items'] = [];
                    }
                }
            }

            $mealCategories = Mealtype::select('id', 'name')->whereHas('menuItems', function($query) use($request) {
                        $query->where('resort_id', $request->resort_id);
                    })->with([
                        'menuItems' => function ($query) use($request) {
                            $query->select('id', 'name', 'category', 'image_name as banner_image_url', 'meal_type_id', 'price')->where('resort_id', $request->resort_id);
                        }
                    ])->get();
            $mealCatData = [];
            if ($mealCategories) {
                foreach ($mealCategories as $m => $mealCategory) {
                    $mealCatData[$m]['id'] = $mealCategory->id;
                    $mealCatData[$m]['name'] = $mealCategory->name;
                    if ($mealCategory->menuItems) {
                        foreach ($mealCategory->menuItems as $j => $mitems) {
                            $userCart = Cart::where(["user_id" => $request->user_id, "meal_item_id" => $mitems->id])->first();
                            $mealCatData[$m]['menu_items'][$j]['id'] = $mitems->id;
                            $mealCatData[$m]['menu_items'][$j]['name'] = $mitems->name;
                            $mealCatData[$m]['menu_items'][$j]['category'] = $mitems->category;
                            $mealCatData[$m]['menu_items'][$j]['banner_image_url'] = $mitems->banner_image_url;
                            $mealCatData[$m]['menu_items'][$j]['price'] = $mitems->price;
                            $mealCatData[$m]['menu_items'][$j]['quantity_count'] = isset($userCart->quantity) && $userCart->quantity ? $userCart->quantity : 0;
                        }
                    } else {
                        $mealCatData[$m]['menu_items'] = [];
                    }
                }
            }

            $data['meal_packages'] = $packageData;
            $data['category_meal'] = $mealCatData;
            return $this->sendSuccessResponse("Meal list found", $data);
        } catch (Exception $ex) {
            return $this->sendSuccessResponse("Meal list found", $data);
        }
    }

}
