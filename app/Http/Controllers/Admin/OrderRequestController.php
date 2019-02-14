<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\ServiceRequest;

class OrderRequestController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('admin.order-request.index', ['js' => $js, 'css' => $css]);
    }

    public function orderRequestList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = ServiceRequest::query();
            $query->with([
                'serviceDetail' => function($query) {
                    $query->withTrashed()->with("serviceTypeDetail")->select('id', 'name', 'type_id');
                }
            ])->with([
                'requestStatus' => function($query) {
                    $query->select('id')->userRequestStatus();
                }
            ])->with([
                'userDetail'
            ]);
            if ($searchKeyword) {
                $query->whereHas("serviceDetail", function($query) use($searchKeyword) {
                    $query->whereHas("serviceTypeDetail", function($query) use($searchKeyword) {
                        $query->where("name", "LIKE", "%$searchKeyword%");
                    })->orWhere("name", "LIKE", "%$searchKeyword%");
                })->orWhereHas("userDetail", function($query) use($searchKeyword) {
                    $query->where("user_name", "LIKE", "%$searchKeyword%");
                })->orWhere("resort_room_no", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $serviceRequests = $query->select('id', 'comment', 'service_id', 'request_status_id', 'user_id', 'resort_room_no')
                            ->take($limit)->offset($offset)->latest()->get();

            $dataArray = [];
            foreach ($serviceRequests as $key => $serviceRequest) {
                $dataArray[$key]['service_type'] = isset($serviceRequest->serviceDetail->serviceTypeDetail->name) ? $serviceRequest->serviceDetail->serviceTypeDetail->name : "";
                $dataArray[$key]['service_name'] = $serviceRequest->serviceDetail->name;
                $dataArray[$key]['customer_name'] = $serviceRequest->userDetail->user_name;
                $dataArray[$key]['room_no'] = $serviceRequest->resort_room_no;
                $dataArray[$key]['status'] = $serviceRequest->requestStatus->status;
                $dataArray[$key]['action'] = '<a href="' . route('admin.order-request.view', $serviceRequest->id) . '" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
            }

            $data['data'] = $dataArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function viewDetail(Request $request, $id) {
        if ($request->isMethod("post")) {
            $sRequest = ServiceRequest::find($id);
            if (!$sRequest) {
                return redirect()->route('admin.order-request.view')->with('error', 'Record Not found.');
            }
            $validator = Validator::make($request->all(), [
                        'seleted_status' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.order-request.view', $id)->withErrors($validator)->withInput();
            }
            $sRequest->request_status_id = $request->seleted_status;
            $sRequest->staff_comment = "Not resolved";
            $sRequest->save();
            return redirect()->route('admin.order-request.view', $id)->with("status", "Status updated successfully.");
        }

        $serviceRequest = ServiceRequest::select('id', 'comment', 'service_id', 'request_status_id', 'user_id', 'resort_room_no', 'accepted_by_id')
                        ->with([
                            'serviceDetail' => function($query) {
                                $query->select('id', 'name', 'type_id');
                            }
                        ])->with('acceptedBy')
                        ->with([
                            'requestStatus' => function($query) {
                                $query->select('id')->userRequestStatus();
                            }
                        ])->with([
                    'userDetail'
                ])->where("id", $id)->first();
        if (!$serviceRequest) {
            return redirect()->route('admin.order-request.index')->with('error', 'Record Not found.');
        }
        return view("admin.order-request.view_detail", [
            "serviceRequest" => $serviceRequest
        ]);
    }

}
