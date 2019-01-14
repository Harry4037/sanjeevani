<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MealOrder;

class OrderController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('admin.order.index', ['js' => $js, 'css' => $css]);
    }

    public function orderList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = MealOrder::query();
            if ($searchKeyword) {
                $query->where("invoice_id", "LIKE", "%$searchKeyword%")
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
                } else {
                    $stat = "Rejected";
                }
                $dataArray[$key]['user_name'] = isset($mealOrder->userDetail->user_name) ? $mealOrder->userDetail->user_name : "";
                $dataArray[$key]['invoice_id'] = $mealOrder->invoice_id;
                $dataArray[$key]['total_amount'] = $mealOrder->total_amount;
                $dataArray[$key]['status'] = $stat;
            }

            $data['data'] = $dataArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
