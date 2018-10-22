<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller {

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Service $service) {
        $this->service = $service;
    }

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'js/admin/services.js'
        ];
        return view('admin.services.index', ['js' => $js, 'css' => $css]);
    }

    public function servicesList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');

            $query = $this->service->query();
            $services = $query->get();
            $i = 0;
            $servicesArray = [];
            foreach ($services as $service) {
                
                $servicesArray[$i]['name'] = $service->name;
                $servicesArray[$i]['type'] = $service->type;
                $checked_status = $service->is_active ? "checked" : '';
                $servicesArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='service_status' id=" . $service->id . " data-status=" . $service->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $i++;
            }
            $data['recordsTotal'] = $this->service->count();
            $data['recordsFiltered'] = $this->service->count();
            $data['data'] = $servicesArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function serviceAdd(Request $request) {

        if ($request->isMethod("post")) {
            
            $service = $this->service;
            $service->name = $request->service_name;
            $service->type = $request->service_type;
            $service->is_active = 1;
            $service->created_by = 1;
            $service->updated_by = 1;
            
            if($service->save()){
                return redirect()->route('admin.service.add')->with('status', 'Service has been added successfully.');
            }else{
                return redirect()->route('admin.service.add')->with('error', 'Something went be wrong.');
            }
        }
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'js/admin/services.js'
        ];
        return view('admin.services.add-service', ['js' => $js]);
    }

    public function updateServiceStatus(Request $request){
         try {
            if ($request->isMethod('post')) {
                $service = $this->service->findOrFail($request->record_id);
                $service->is_active = $request->status;
                if ($service->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }
    
}
