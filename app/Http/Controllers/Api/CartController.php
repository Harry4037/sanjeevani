<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Cart;

class CartController extends Controller {

    /**
     * @api {post} /api/add-item-cart Add item to cart
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostAddItemCart
     * @apiGroup Order
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} type 1=>Meal item, 2=> Meal package Item.
     * @apiParam {String} meal_item_id Meal item id.
     * @apiParam {String} meal_package_id Meal Package Id.
     * @apiParam {String} quantity Quantity.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Item added to cart.
     * @apiSuccess {JSON}   data cart detail.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Item added to cart",
     *       "data": {
     *           "cart_count": 4
     *       }
     *   }
     * 
     * 
     * @apiError UserIdMissing The user id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "User id missing.",
     *  "data": {}
     * }
     * 
     * @apiError InvalidUser The user is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid user.",
     *  "data": {}
     * }
     * 
     * 
     * 
     * 
     */
    public function addCartItem(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->type) {
                return $this->sendErrorResponse("type missing.", (object) []);
            }
            if ($request->type == 1) {
                if (!$request->meal_item_id) {
                    return $this->sendErrorResponse("Meal item id missing.", (object) []);
                }
            }
            if ($request->type == 2) {
                if (!$request->meal_package_id) {
                    return $this->sendErrorResponse("Meal package id missing.", (object) []);
                }
            }

            if (!$request->quantity) {
                return $this->sendErrorResponse("quantity missing.", (object) []);
            }
            $cart = Cart::where(["user_id" => $request->user_id])
                    ->where(function($q) use($request) {
                        $q->where("meal_package_id", $request->meal_package_id)
                        ->orWhere("meal_item_id", $request->meal_item_id);
                    })
                    ->first();

            if ($cart) {
                $cart->quantity = $cart->quantity + $request->quantity;
            } else {
                $cart = new Cart();
                $cart->quantity = $request->quantity;
            }
            $cart->user_id = $request->user_id;
            $cart->meal_package_id = $request->meal_package_id ? $request->meal_package_id : 0;
            $cart->meal_item_id = $request->meal_item_id ? $request->meal_item_id : 0;
            if ($cart->save()) {
                $data['cart_count'] = Cart::where("user_id", $request->user_id)->count();
                return $this->sendSuccessResponse("Item added to cart", $data);
            } else {
                return $this->sendErrorResponse("Something went be wrong, Please try later", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
