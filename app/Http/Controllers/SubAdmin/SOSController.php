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
        return view('subadmin.sos.index', ['js' => $js, 'css' => $css]);
    }

    public function sosList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = SOS::query();
            if ($searchKeyword) {
                $query->where("latitude", "LIKE", "%$searchKeyword%")
                        ->orWhere("longitude", "LIKE", "%$searchKeyword%")
                        ->orWhere("resort_name", "LIKE", "%$searchKeyword%")
                        ->orWhere("room_type", "LIKE", "%$searchKeyword%")
                        ->orWhere("room_no", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $sos = $query->take($limit)->offset($offset)->latest()->get();
            $sosArray = [];
            foreach ($sos as $key => $so) {
                $mapUrl = "<a target='_blank' class='btn btn-warning btn-xs' href='http://maps.google.com/maps?q=" . $so->latitude . "," . $so->longitude . "'><i class='fa fa-map'></i> View</a>";
                $user = User::find($so->user_id);
                $sosArray[$key]['user_name'] = $user ? $user->user_name : "";
                $sosArray[$key]['longitude'] = $so->longitude;
                $sosArray[$key]['latitude'] = $so->latitude;
                $sosArray[$key]['action'] = $mapUrl;
            }

            $data['data'] = $sosArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
