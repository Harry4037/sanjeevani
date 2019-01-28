<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\SOS;
use App\Models\User;


class SOSController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.sos.index', ['js' => $js, 'css' => $css]);
    }

    public function sosList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = SOS::query();
            $query->with("userDetail");
            if ($searchKeyword) {
                $query->whereHas("userDetail", function($query) use($searchKeyword) {
                    $query->where("user_name", "LIKE", "%$searchKeyword%");
                })->orWhere("latitude", "LIKE", "%$searchKeyword%")
                    ->orWhere("longitude", "LIKE", "%$searchKeyword%")
                    ->orWhere("resort_name", "LIKE", "%$searchKeyword%")
                    ->orWhere("room_type", "LIKE", "%$searchKeyword%")
                    ->orWhere("room_no", "LIKE", "%$searchKeyword%")
                ;
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $sos = $query->take($limit)->offset($offset)->latest()->get();
            $sosArray = [];
            foreach ($sos as $key => $so) {
                $mapUrl = "<a target='_blank' class='btn btn-warning btn-xs' href='http://maps.google.com/maps?q=".$so->latitude.",".$so->longitude."'><i class='fa fa-map'></i> View</a>";
                $sosArray[$key]['user_name'] = isset($so->userDetail->user_name) ? $so->userDetail->user_name : "";
                $sosArray[$key]['resort_name'] = $so->resort_name;
                $sosArray[$key]['room_type'] = $so->room_type;
                $sosArray[$key]['room_no'] = $so->room_no;
                $sosArray[$key]['latitude'] = $so->latitude;
                $sosArray[$key]['longitude'] = $so->longitude;
                $sosArray[$key]['action'] = $mapUrl;
                // '<a href="' . route('admin.sos.view', $so->id) . '" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
            }

            $data['data'] = $sosArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editCms(Request $request) {
        $cms = Cms::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'content' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.cms.index')->withErrors($validator)->withInput();
            }
            $cms->content = $request->content;
            
            if ($cms->save()) {
                
                return redirect()->route('admin.cms.edit', $cms->id)->with('status', 'Paget has been update successfully.');
            } else {
                return redirect()->route('admin.activity.index')->with('error', 'Something went be wrong.');
            }
        }
        return view('admin.cms.edit', [
            'cms' => $cms,
        ]);
    }

}
