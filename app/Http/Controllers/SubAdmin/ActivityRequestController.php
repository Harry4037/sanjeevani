<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\ActivityRequest;
use Carbon\Carbon;

class ActivityRequestController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('subadmin.activity-request.index', ['js' => $js, 'css' => $css]);
    }

    public function activityRequestList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = ActivityRequest::query();
             $query->where("resort_id", $request->get("subadminResort"));
            if ($searchKeyword) {
                $query->where("activity_name", "LIKE", "%$searchKeyword%")
                        ;
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();

            $amenityRequests = $query
                            ->with([
                                'userDetail'
                            ])->take($limit)->offset($offset)->latest()->get();

            $dataArray = [];
            foreach ($amenityRequests as $key => $serviceRequest) {
                $booking  = Carbon::parse($serviceRequest->booking_date);
                $from  = Carbon::parse($serviceRequest->from);
                $to  = Carbon::parse($serviceRequest->to);
                $dataArray[$key]['user_name'] = isset($serviceRequest->userDetail) ? $serviceRequest->userDetail->user_name : "";
                $dataArray[$key]['activity_name'] = $serviceRequest->amenity_name;
                $dataArray[$key]['booking_date'] = $booking->format('d-M-Y');
                $dataArray[$key]['from'] = $from->format("h:i A");
                $dataArray[$key]['to'] = $to->format("h:i A");
            }

            $data['data'] = $dataArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
