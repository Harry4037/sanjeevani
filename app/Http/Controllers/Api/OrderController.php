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
use App\Models\Resort;
use App\Models\User;
use App\Models\UserBookingDetail;

class OrderController extends Controller {

    /**
     * @api {post} /api/create-order Create Order
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json. 
     * @apiName PostCreateOrder
     * @apiGroup Order
     * 
     * @apiParam {String} user_id User id*.
     * @apiParam {String} resort_id Resort id*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Order create successfully.
     * @apiSuccess {JSON} data invoice Id.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
      {
      "status": true,
      "status_code": 200,
      "message": "We will serve your food soon.",
      "data": {
      "invoice_id": 1551681813,
      "total_amount": 53
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
     * @apiError ResortIdMissing The resort id was missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Resort id missing.",
     *  "data": {}
     * }
     * 
     * @apiError InvalidResort The resort is invalid.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *  "status": false,
     *  "message": "Invalid resort.",
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
            if (!$this->bookBeforeCheckInDate($request->user_id)) {
                return $this->sendErrorResponse("Sorry! You can not raised request before checkIn date or after checkout date.", (object) []);
            }
            if ($request->user_id != $request->user()->id) {
                return $this->sendErrorResponse("Unauthorized user.", (object) []);
            }
            if (!$request->resort_id) {
                return $this->sendErrorResponse("Resort id missing.", (object) []);
            }
            $resort = Resort::find($request->resort_id);
            if (!$resort) {
                return $this->sendErrorResponse("Invalid resort.", (object) []);
            }
            $user = User::with("userBookingDetail")->find($request->user_id);
            if ($user->is_active == 0) {
                return $this->sendInactiveAccountResponse();
            }
            $cartCount = Cart::where(["user_id" => $request->user_id])->count();
            $cartDataArray = [];
            if ($cartCount > 0) {
                $carts = Cart::where(["user_id" => $request->user_id])->get();
                $total = 0;
                $gst = 5;
                foreach ($carts as $key => $cart) {
                    if ($cart->meal_item_id > 0) {
                        $mealItem = MealItem::find($cart->meal_item_id);
                        $itemType = 1;
                        $cartDataArray[$key]['meal_item_id'] = $mealItem->id;
                        $cartDataArray[$key]['meal_package_id'] = 0;
                    } else {
                        $mealItem = MealPackage::find($cart->meal_package_id);
                        $itemType = 2;
                        $cartDataArray[$key]['meal_item_id'] = 0;
                        $cartDataArray[$key]['meal_package_id'] = $mealItem->id;
                    }
                    $cartDataArray[$key]['id'] = $cart->id;
                    $cartDataArray[$key]['item_name'] = $mealItem->name;
                    $cartDataArray[$key]['item_price'] = $mealItem->price;
                    $cartDataArray[$key]['quantity'] = $cart->quantity;
                    $total += ($mealItem->price * $cart->quantity);
                }

                $mealOrder = new MealOrder();
                $mealOrder->invoice_id = time();
                $mealOrder->resort_id = $request->resort_id;
                $mealOrder->booking_id = $user->userBookingDetail ? $user->userBookingDetail->id : 0;
                $mealOrder->user_id = $request->user_id;
                $mealOrder->resort_room_type = $user->userBookingDetail ? $user->userBookingDetail->room_type_name : "";
                $mealOrder->resort_room_no = $user->userBookingDetail ? $user->userBookingDetail->resort_room_no : "";
                $mealOrder->status = 1;
                $mealOrder->item_total_amount = $total;
                $mealOrder->gst_amount = $gst;
                $mealOrder->total_amount = $total + number_format(($total * ($gst / 100)), 0, '.', '');
                if ($mealOrder->save()) {
                    foreach ($cartDataArray as $cartData) {
                        $mealOrderItem = new MealOrderItem();
                        $mealOrderItem->meal_order_id = $mealOrder->id;
                        $mealOrderItem->meal_item_id = $cartData['meal_package_id'] == 0 ? $cartData['meal_item_id'] : $cartData['meal_package_id'];
                        $mealOrderItem->item_type = $itemType;
                        $mealOrderItem->meal_item_name = $cartData['item_name'];
                        $mealOrderItem->price = $cartData['item_price'];
                        $mealOrderItem->quantity = $cartData['quantity'];
                        $mealOrderItem->save();
                    }
                }
                $data['invoice_id'] = $mealOrder->invoice_id;
                $data['total_amount'] = $mealOrder->total_amount;
                Cart::where(["user_id" => $request->user_id])->delete();

                $resortUsers = UserBookingDetail::where("resort_id", $request->resort_id)->pluck("user_id");
                $this->generateNotification($request->user_id, "Meal Order", "You ordered meal with invoice# $mealOrder->invoice_id ", 4);
                if ($user->device_token) {
                    $this->androidPushNotification(3, "Meal Order", "You ordered meal with invoice# $mealOrder->invoice_id", $user->device_token, 4, $mealOrder->id, $this->notificationCount($user->id));
                }
                if ($resortUsers) {
                    $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2, "is_meal_authorise" => 1, "is_push_on" => 1])
                            ->whereIn("id", $resortUsers->toArray())
                            ->where("device_token", "!=", "")
                            ->pluck("device_token");

                    if (count($staffDeviceTokens) > 0) {
                        $this->androidPushNotification(2, "Meal Order", "Meal order raised from Room# " . $mealOrder->resort_room_no . " by " . $request->user()->user_name, $staffDeviceTokens->toArray(), 4, $mealOrder->id, 1);
                    }
                }
                return $this->sendSuccessResponse("We will serve your food soon.", $data);
            } else {
                Cart::where(["user_id" => $request->user_id])->delete();
                return $this->sendErrorResponse("Cart is empty", (object) []);
            }
        } catch (\Exception $ex) {
            dd($ex);
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
     *           "discount_price": "0",
     *           "discount_percentage": 0,
     *           "booking_detail": {
     *               "booking_amount": 1500,
     *               "booking_amount_type": "Outstanding",
     *               "booking_source": ""
     *               },
     *           "invoices": [
     *               {
     *                   "id": 5,
     *                   "invoice_id": "1544009535",
     *                   "status": "Completed",
     *                   "status_id": 4,
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
     *                   "status": "Completed",
     *                   "status_id": 4,
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
     *                   "status": "Completed",
     *                   "status_id": 4,
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
            $user = User::with("userBookingDetail")->find($request->user_id);
            if ($user->userBookingDetail == NULL) {
                $data['total_amount'] = 0;
                $data['paid_amount'] = 0;
                $data['outstanding_amount'] = 0;
                $data['invoices'] = [];
                $data['booking_detail'] = (object) [];
            } else {
                $user->load(['payments', 'mealOrders' => function($query) use($request, $user) {
                        $query->where(["resort_id" => $user->userBookingDetail->resort->id, "user_id" => $request->user_id, "booking_id" => $user->userBookingDetail->id])->accepted();
                    }]);

                $invoices = MealOrder::selectRaw(DB::raw('id, (CASE WHEN status="1" THEN "Pending" WHEN status="2" THEN "Accepted" WHEN status="3" THEN "Your approval needed" WHEN status="4" THEN "Completed" ELSE "Failed" END) as status, status as status_id, invoice_id, item_total_amount, gst_amount as gst_percentage, (total_amount - item_total_amount) as gst_amount, total_amount, DATE_FORMAT(created_at, "%d-%m-%Y") as created_on'))->where(["booking_id" => $user->userBookingDetail->id, "resort_id" => $user->userBookingDetail->resort->id, "user_id" => $request->user_id])
                                ->with([
                                    'orderItems' => function($query) {
                                        $query->select('id', 'meal_item_name', 'quantity', 'price', 'meal_order_id');
                                    }
                                ])
                                ->latest()->get();
                $total_amount = $user->mealOrders->sum('total_amount');
                if ($user->userBookingDetail->booking_amount_type == 2) {
                    $data['total_amount'] = $total_amount + $user->userBookingDetail->booking_amount;
                } else {
                    $data['total_amount'] = $total_amount;
                }
                $data['paid_amount'] = $user->payments->where("resort_id", $user->userBookingDetail->resort->id)->where("booking_id", $user->userBookingDetail->id)->sum('amount');
                $discountPrice = $data['total_amount'];
                if ($user->discount > 0) {
                    $discountPrice = number_format(($data['total_amount'] - ($data['total_amount'] * ($user->discount / 100))), 0, ".", "");
                }
//                if ($user->userBookingDetail->booking_amount_type == 2) {
//                    $data['outstanding_amount'] = ($discountPrice - $data['paid_amount']) + $user->userBookingDetail->booking_amount;
//                } else {
                $data['outstanding_amount'] = $discountPrice - $data['paid_amount'];
//                }
                $data['discount_price'] = number_format(($data['total_amount'] * ($user->discount / 100)), 0, ".", "");
                $data['discount_percentage'] = $user->discount;

                $data['booking_detail'] = [
                    'booking_amount' => $user->userBookingDetail->booking_amount,
                    'booking_amount_type' => $user->userBookingDetail->booking_amount_type == 1 ? "Prepaid" : "Outstanding",
                    'booking_source' => $user->userBookingDetail->booking_source ? $user->userBookingDetail->booking_source : '',
                ];

                $data['invoices'] = [];
                if ($invoices) {
                    $data['invoices'] = $invoices;
                }
            }
            // if ($invoices) {
            //     $data['invoices'] = $invoices;
            return $this->sendSuccessResponse("invoices list found.", $data);
            // } else {
            //     return $this->sendErrorResponse("invoices not found", (object) []);
            // }
        } catch (\Exception $ex) {
            return $this->administratorResponse();
        }
    }

}
