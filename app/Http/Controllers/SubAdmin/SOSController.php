<?php

namespace App\Http\Controllers\SubAdmin;

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
            // if ($searchKeyword) {
            //     $query->where("content", "LIKE", "%$searchKeyword%");
            // }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $sos = $query->take($limit)->offset($offset)->latest()->get();
            $sosArray = [];
            foreach ($sos as $key => $so) {
                $user = User::find($so->id);
                $sosArray[$key]['user_name'] = $user->user_name;
                $sosArray[$key]['longitude'] = $so->longitude;
                $sosArray[$key]['latitude'] = $so->latitude;
                $sosArray[$key]['action'] = '';
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
