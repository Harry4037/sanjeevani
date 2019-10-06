<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MealOrder;
use Validator;

class OrderController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('subadmin.order.index', ['js' => $js, 'css' => $css]);
    }

    public function orderList(Request $request) {
        try {
            $o_status = $request->o_status;
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = MealOrder::query();
            if ($o_status) {
                $query->where("status", $o_status);
            }
            $query->with([
                "userDetail" => function($query) {
                    $query->select('id', 'user_name');
                }
            ]);
            $query->where("resort_id", $request->get("subadminResort"));

            if ($searchKeyword) {
                $query->whereHas("userDetail", function($query) use($searchKeyword) {
                            $query->where("user_name", "LIKE", "%$searchKeyword%");
                        })->orWhere("invoice_id", "LIKE", "%$searchKeyword%")
                        ->orWhere("resort_room_no", "LIKE", "%$searchKeyword%")
                        ->orWhere("total_amount", "LIKE", "%$searchKeyword%");
            }

            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $mealOrders = $query->with([
                        "userDetail" => function($query) {
                            $query->select('id', 'user_name');
                        }
                    ])->take($limit)->offset($offset)->latest()->get();

            $dataArray = [];
            $stat = "";
            foreach ($mealOrders as $key => $mealOrder) {
                if ($mealOrder->status == 1) {
                    $stat = "New";
                } elseif ($mealOrder->status == 2) {
                    $stat = "Accepted by staff";
                } elseif ($mealOrder->status == 3) {
                    $stat = "Under Approval";
                } elseif ($mealOrder->status == 4) {
                    $stat = "Completed";
                } elseif ($mealOrder->status == 5) {
                    $stat = "Rejected";
                } else {
                    $stat = "Closed";
                }
                $dataArray[$key]['user_name'] = isset($mealOrder->userDetail->user_name) ? $mealOrder->userDetail->user_name : "";
                $dataArray[$key]['invoice_id'] = $mealOrder->invoice_id;
                $dataArray[$key]['total_amount'] = $mealOrder->total_amount;
                $dataArray[$key]['status'] = $stat;
                $dataArray[$key]['action'] = '<a href="' . route('subadmin.order.view', $mealOrder->id) . '" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
            }

            $data['data'] = $dataArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function viewDetail(Request $request, $id) {
        if ($request->isMethod("post")) {
            $sRequest = MealOrder::find($id);
            if (!$sRequest) {
                return redirect()->route('subadmin.order.view', $id)->with('error', 'Record Not found.');
            }
            $validator = Validator::make($request->all(), [
                        'seleted_status' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.order.view', $id)->withErrors($validator)->withInput();
            }
            $sRequest->status = $request->seleted_status;
            $sRequest->staff_comment = "not available";
            $sRequest->save();
            return redirect()->route('subadmin.order.view', $id)->with("status", "Status updated successfully.");
        }

        $mealRequest = MealOrder::with([
                            'userDetail' => function($query) {
                                $query->select('id', 'user_name');
                            }
                        ])->with([
                            'acceptedBy' => function($query) {
                                $query->select('id', 'user_name');
                            }
                        ])->with(['resortDetail' => function($query) {
                                $query->withTrashed();
                            }])
                        ->with('orderItems')->where("id", $id)->first();
        if (!$mealRequest) {
            return redirect()->route('subadmin.order.index')->with('error', 'Record Not found.');
        }

        return view("subadmin.order.view_detail", [
            "mealRequest" => $mealRequest
        ]);
    }

}
