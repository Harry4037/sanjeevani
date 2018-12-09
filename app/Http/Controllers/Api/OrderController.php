<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\MealItem;
use App\Models\MealPackage;
use App\Models\MealOrder;
use App\Models\MealOrderItem;

class OrderController extends Controller {

    /**
     * @api {post} /api/create-order Create Order
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostCreateOrder
     * @apiGroup Order
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Order create successfully.
     * @apiSuccess {JSON} data invoice Id.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Order created succeffully.",
     *    "data": {
     *        "invoice_id": 1544009691,
     *        "total_amount": 1175
     *    }
     * }
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
     */
    public function submitOrder(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            $carts = Cart::where(["user_id" => $request->user_id])->get();
            $cartDataArray = [];
            if ($carts) {
                $total = 0;
                $gst = 0;
                foreach ($carts as $key => $cart) {
                    if ($cart->meal_item_id > 0) {
                        $mealItem = MealItem::find($cart->meal_item_id);
                        $itemType = 1;
                    } else {
                        $mealItem = MealPackage::find($cart->meal_package_id);
                        $itemType = 2;
                    }
                    $cartDataArray[$key]['id'] = $cart->id;
                    $cartDataArray[$key]['item_name'] = $mealItem->name;
                    $cartDataArray[$key]['item_price'] = $mealItem->price;
                    $cartDataArray[$key]['quantity'] = $cart->quantity;
                    $total += ($mealItem->price * $cart->quantity);
                }

                $mealOrder = new MealOrder();
                $mealOrder->invoice_id = time();
                $mealOrder->user_id = $request->user_id;
                $mealOrder->item_total_amount = $total;
                $mealOrder->gst_amount = $gst;
                $mealOrder->total_amount = $total - $gst;
                if ($mealOrder->save()) {
                    foreach ($cartDataArray as $cartData) {
                        $mealOrderItem = new MealOrderItem();
                        $mealOrderItem->meal_order_id = $mealOrder->id;
                        $mealOrderItem->meal_item_name = $cartData['item_name'];
                        $mealOrderItem->price = $cartData['item_price'];
                        $mealOrderItem->quantity = $cartData['quantity'];
                        $mealOrderItem->save();
                    }
                }
                $data['invoice_id'] = $mealOrder->invoice_id;
                $data['total_amount'] = $mealOrder->total_amount;
                Cart::where(["user_id" => $request->user_id])->delete();
                return $this->sendSuccessResponse("Order created succeffully.", $data);
            } else {
                Cart::where(["user_id" => $request->user_id])->delete();
                return $this->sendErrorResponse("Cart is empty", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

    /**
     * @api {get} /api/invoice-list-detail Invoice listing & details
     * @apiHeader {String} Accept application/json. 
     * @apiName GetInvoiceListDetail
     * @apiGroup Order
     * 
     * @apiParam {String} user_id User id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message invoices list found.
     * @apiSuccess {JSON} data invoice detail.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Order created succeffully.",
     *       "data": {
     *           "total_amount": 0,
     *           "outstanding_amount": 0,
     *           "paid_amount": 0,
     *           "invoices": [
     *               {
     *                   "id": 5,
     *                   "invoice_id": "1544009535",
     *                   "item_total_amount": 1175,
     *                   "gst_amount": 0,
     *                   "total_amount": 1175,
     *                   "created_on": "05-12-2018",
     *                   "order_items": [
     *                       {
     *                           "id": 13,
     *                           "meal_item_name": "Pepsi",
     *                           "quantity": 2,
     *                           "price": 55,
     *                           "meal_order_id": 5
     *                       },
     *                       {
     *                           "id": 14,
     *                           "meal_item_name": "Panner",
     *                           "quantity": 3,
     *                           "price": 120,
     *                           "meal_order_id": 5
     *                       },
     *                       {
     *                           "id": 15,
     *                           "meal_item_name": "test",
     *                           "quantity": 3,
     *                           "price": 1000,
     *                           "meal_order_id": 5
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 6,
     *                   "invoice_id": "1544009626",
     *                   "item_total_amount": 1175,
     *                   "gst_amount": 0,
     *                   "total_amount": 1175,
     *                   "created_on": "05-12-2018",
     *                   "order_items": [
     *                       {
     *                           "id": 16,
     *                           "meal_item_name": "Pepsi",
     *                           "quantity": 2,
     *                           "price": 55,
     *                           "meal_order_id": 6
     *                       },
     *                       {
     *                           "id": 17,
     *                           "meal_item_name": "Panner",
     *                           "quantity": 3,
     *                           "price": 120,
     *                           "meal_order_id": 6
     *                       },
     *                       {
     *                           "id": 18,
     *                           "meal_item_name": "test",
     *                           "quantity": 3,
     *                           "price": 1000,
     *                           "meal_order_id": 6
     *                       }
     *                   ]
     *               },
     *               {
     *                   "id": 7,
     *                   "invoice_id": "1544009691",
     *                   "item_total_amount": 1175,
     *                   "gst_amount": 0,
     *                   "total_amount": 1175,
     *                   "created_on": "05-12-2018",
     *                   "order_items": [
     *                       {
     *                           "id": 19,
     *                           "meal_item_name": "Pepsi",
     *                           "quantity": 2,
     *                           "price": 55,
     *                           "meal_order_id": 7
     *                       },
     *                       {
     *                           "id": 20,
     *                           "meal_item_name": "Panner",
     *                           "quantity": 3,
     *                           "price": 120,
     *                           "meal_order_id": 7
     *                       },
     *                       {
     *                           "id": 21,
     *                           "meal_item_name": "test",
     *                           "quantity": 3,
     *                           "price": 1000,
     *                           "meal_order_id": 7
     *                       }
     *                   ]
     *               }
     *           ]
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
     * 
     * 
     */
    public function invoiceListDetail(Request $request) {
        try {
            if (!$request->user_id) {
                return $this->sendErrorResponse("User id missing.", (object) []);
            }

            $invoices = MealOrder::selectRaw(DB::raw('id, invoice_id, item_total_amount, gst_amount, total_amount, DATE_FORMAT(created_at, "%d-%m-%Y") as created_on'))->where(["user_id" => $request->user_id])
                    ->with([
                        'orderItems' => function($query) {
                            $query->select('id', 'meal_item_name', 'quantity', 'price', 'meal_order_id');
                        }
                    ])
                    ->get();
            $data['total_amount'] = 0;
            $data['outstanding_amount'] = 0;
            $data['paid_amount'] = 0;
            $data['invoices'] = [];
            if ($invoices) {
                $data['invoices'] = $invoices;
                return $this->sendSuccessResponse("invoices list found.", $data);
            } else {
                return $this->sendErrorResponse("invoices not found", (object) []);
            }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
