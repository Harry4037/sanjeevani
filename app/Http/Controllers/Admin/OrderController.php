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

            $mealOrders = MealOrder::with([
                        "userDetail" => function($query) {
                            $query->select('id', 'user_name');
                        }
                    ])->get();

            $dataArray = [];
            foreach ($mealOrders as $key => $mealOrder) {
                $dataArray[$key]['user_name'] = isset($mealOrder->userDetail->user_name) ? $mealOrder->userDetail->user_name : "";
                $dataArray[$key]['invoice_id'] = $mealOrder->invoice_id;
                $dataArray[$key]['total_amount'] = $mealOrder->total_amount;
                $dataArray[$key]['status'] = $mealOrder->status ? "Confirmed" : "Pending";
            }
            $data['recordsTotal'] = count($mealOrders);
            $data['recordsFiltered'] = count($mealOrders);
            $data['data'] = $dataArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
