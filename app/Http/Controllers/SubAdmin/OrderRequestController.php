<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Service;
use App\Models\UserBookingDetail;

class OrderRequestController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('subadmin.order-request.index', ['js' => $js, 'css' => $css]);
    }

    public function orderRequestList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = ServiceRequest::query();
            if ($oStatus) {
                $query->where("request_status_id", $oStatus);
            }
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
            $query->where("resort_id", $request->get("subadminResort"));
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
                            ->take($limit)->offset($offset)
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->withTrashed()->select('id', 'name', 'type_id');
                                }
                            ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->userRequestStatus();
                        }
                    ])->with([
                        'userDetail'
                    ])->latest()->get();

            $dataArray = [];
            foreach ($serviceRequests as $key => $serviceRequest) {
                $dataArray[$key]['service_type'] = $serviceRequest->serviceDetail->serviceType->name;
                $dataArray[$key]['service_name'] = $serviceRequest->serviceDetail->name;
                $dataArray[$key]['customer_name'] = $serviceRequest->userDetail->user_name;
                $dataArray[$key]['room_no'] = $serviceRequest->resort_room_no;
                $dataArray[$key]['status'] = $serviceRequest->requestStatus->status;
                $dataArray[$key]['action'] = '<a href="' . route('subadmin.order-request.view', $serviceRequest->id) . '" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
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
                return redirect()->route('subadmin.order-request.view')->with('error', 'Record Not found.');
            }
            $validator = Validator::make($request->all(), [
                        'seleted_status' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.order-request.view', $id)->withErrors($validator)->withInput();
            }
            $sRequest->request_status_id = $request->seleted_status;
            $sRequest->staff_comment = "Not resolved";
            $sRequest->save();
            if ($request->seleted_status == 1) {
                $resortUsers = UserBookingDetail::where("resort_id", $sRequest->resort_id)->pluck("user_id");
                $user = User::find($sRequest->user_id);
                $service = Service::withTrashed()->find($sRequest->service_id);
                $this->generateNotification($user->id, "Service Request", "Your " . $service->name . " request is re-opened by Admin", 1);
                if ($user->device_token) {
                    $this->androidPushNotification(3, "Service Request", "Your " . $service->name . " request is re-opened by Admin", $user->device_token, 1, $sRequest->service_id, $this->notificationCount($user->id));
                }

                if ($resortUsers) {
                    $staffDeviceTokens = User::where(["is_active" => 1, "user_type_id" => 2, "is_service_authorise" => 1, "is_push_on" => 1])
                            ->where("device_token", "!=", NULL)
                            ->whereIn("id", $resortUsers->toArray())
                            ->pluck("device_token");
                    if (count($staffDeviceTokens) > 0) {
                        $this->androidPushNotification(2, "Service Raised", "$service->name request raised from Room# " . $sRequest->resort_room_no . " by " . $user->user_name, $staffDeviceTokens->toArray(), 1, $service->id, 0, 1);
                    }
                }
            }
            if ($request->seleted_status == 6) {
                $user = User::find($sRequest->user_id);
                $service = Service::withTrashed()->find($sRequest->service_id);
                $this->generateNotification($user->id, "Service Opened", "Your " . $service->name . " request is opened by admin", 1);
                if ($user->device_token) {
                    $this->androidPushNotification(3, "Service Request", "Your " . $service->name . " request is closed by admin", $user->device_token, 1, $sRequest->service_id, $this->notificationCount($user->id));
                }
            }
            return redirect()->route('subadmin.order-request.view', $id)->with("status", "Status updated successfully.");
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
            return redirect()->route('subadmin.order-request.index')->with('error', 'Record Not found.');
        }

        return view("subadmin.order-request.view_detail", [
            "serviceRequest" => $serviceRequest
        ]);
    }

}
