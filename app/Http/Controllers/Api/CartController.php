<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\MealItem;
use App\Models\MealPackage;

class CartController extends Controller {

    /**
     * @api {post} /api/add-item-cart Add item to cart
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostAddItemCart
     * @apiGroup Order
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} type 1=>Meal item, 2=> Meal package Item*.
     * @apiParam {String} meal_item_id Meal item id*.
     * @apiParam {String} meal_package_id Meal Package Id*.
     * @apiParam {String} quantity Quantity*.
     * @apiParam {String} flag Increment or add => 1, Decrement => 2*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Item added to cart.
     * @apiSuccess {JSON}   data cart detail.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "Item added to cart",
      "data": {
      "cart_count": 1,
      "quantity_count": "1"
      }
      }
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
     * @apiError typeMissing The type was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "type missing.",
     *  "data": {}
     * }
     * 
     * @apiError mealItemIdMissing The meal_item_id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Meal item id missing.",
     *  "data": {}
     * }
     * 
     * @apiError quantityMissing The quantity was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "quantity missing.",
     *  "data": {}
     * }
     * 
     * @apiError flagMissing The flag was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "flag missing.",
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
                $mealDetail = MealItem::find($request->meal_item_id);
                if (!$mealDetail) {
                    return $this->sendErrorResponse("Invalid meal id.", (object) []);
                }
            }
            if ($request->type == 2) {
                if (!$request->meal_package_id) {
                    return $this->sendErrorResponse("Meal package id missing.", (object) []);
                }
                $mealPackageDetail = MealPackage::find($request->meal_package_id);
                if (!$mealPackageDetail) {
                    return $this->sendErrorResponse("Invalid meal package id.", (object) []);
                }
            }
            if (!$request->quantity) {
                return $this->sendErrorResponse("quantity missing.", (object) []);
            }
            if (!$request->flag) {
                return $this->sendErrorResponse("flag missing.", (object) []);
            }

            $cart = Cart::where(["user_id" => $request->user_id])
                    ->where(function($q) use($request) {
                        $q->where("meal_package_id", $request->meal_package_id)
                        ->orWhere("meal_item_id", $request->meal_item_id);
                    })
                    ->first();
            $msg = '';
            if ($request->flag == 1) {
                $msg = "Item added to cart.";
            } else {
                $msg = "Item removed from cart.";
            }

            if ($cart) {
                if ($request->flag == 1) {
                    $cart->quantity = $cart->quantity + $request->quantity;
                } else {
                    if ($cart->quantity == 1) {
                        $cart->delete();
                        $data['cart_count'] = Cart::where("user_id", $request->user_id)->count();
                        $data['quantity_count'] = 0;
                        return $this->sendSuccessResponse($msg, $data);
                    }
                    $cart->quantity = $cart->quantity - $request->quantity;
                }
            } else {
                if ($request->flag == 2) {
                    $data['cart_count'] = Cart::where("user_id", $request->user_id)->count();
                    $data['quantity_count'] = 0;
                    return $this->sendErrorResponse("This item not found in cart.", $data);
                }
                $cart = new Cart();
                $cart->quantity = $request->quantity;
            }
            $cart->user_id = $request->user_id;
            $cart->meal_package_id = $request->meal_package_id ? $request->meal_package_id : 0;
            $cart->meal_item_id = $request->meal_item_id ? $request->meal_item_id : 0;
            if($request->type == 1){
                $cart->resort_id = $mealDetail->resort_id;
            }else{
                $cart->resort_id = $mealPackageDetail->resort_id;
            }
            if ($cart->save()) {
                $data['cart_count'] = Cart::where("user_id", $request->user_id)->count();
                $data['quantity_count'] = $cart->quantity;
                return $this->sendSuccessResponse($msg, $data);
            } else {
                return $this->sendErrorResponse("Something went be wrong, Please try later", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/my-cart My cart
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName GetMyCart
     * @apiGroup Order
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message my cart list.
     * @apiSuccess {JSON}   data cart detail.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "my cart list",
      "data": {
      "cart_items": [
      {
      "id": 218,
      "type": 1,
      "item_id": 69,
      "image_url": "http://127.0.0.1:1234/storage/meal_images/nRJmJEkN9VsB4zIfMljsdrZMoEg8FZIhLAAbtIT0.jpeg",
      "category": "N",
      "item_name": "Boiled Egg",
      "item_price": 50,
      "quantity": 1
      }
      ],
      "total_no_item": 1,
      "item_amount": 50,
      "gst": "3",
      "gst_percentage": "5%",
      "total_amount": "53"
      }
      }
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
    public function myCart(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }

            $carts = Cart::where(["user_id" => $request->user_id])
                    ->get();
            $cartDataArray = [];
            if ($carts->count() > 0) {
                $total = 0;
                $gst = 5;
                foreach ($carts as $key => $cart) {
                    if ($cart->meal_item_id > 0) {
                        $mealItem = MealItem::find($cart->meal_item_id);
                        $itemType = 1;
                    } else {
                        $mealItem = MealPackage::find($cart->meal_package_id);
                        $itemType = 2;
                    }
                    $cartDataArray['cart_items'][$key]['id'] = $cart->id;
                    $cartDataArray['cart_items'][$key]['type'] = $itemType;
                    $cartDataArray['cart_items'][$key]['item_id'] = $mealItem->id;
                    $cartDataArray['cart_items'][$key]['image_url'] = $mealItem->image_name;
                    $cartDataArray['cart_items'][$key]['category'] = $mealItem->category;
                    $cartDataArray['cart_items'][$key]['item_name'] = $mealItem->name;
                    $cartDataArray['cart_items'][$key]['item_price'] = $mealItem->price;
                    $cartDataArray['cart_items'][$key]['quantity'] = $cart->quantity;
                    $total += ($mealItem->price * $cart->quantity);
                }
                $cartDataArray['total_no_item'] = count($cartDataArray['cart_items']);
                $cartDataArray['item_amount'] = $total;
                $cartDataArray['gst'] = number_format($total * ($gst / 100), 0);
                $cartDataArray['gst_percentage'] = $gst . "%";
                $cartDataArray['total_amount'] = number_format($total + ($total * ($gst / 100)), 0);

                return $this->sendSuccessResponse("my cart list", $cartDataArray);
            } else {
                $cartDataArray['cart_items'] = [];
                $cartDataArray['total_no_item'] = 0;
                $cartDataArray['item_amount'] = 0;
                $cartDataArray['gst'] = 0;
                $cartDataArray['total_amount'] = 0;
                return $this->sendErrorResponse("empty cart", $cartDataArray);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
