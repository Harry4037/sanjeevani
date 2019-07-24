<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Resort;
use App\Models\Question;
use App\Models\ServiceQuestionaire;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Validation\Rule;

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
            "vendors/iCheck/skins/flat/green.css",
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'vendors/iCheck/icheck.min.js',
        ];
        return view('subadmin.services.index', ['js' => $js, 'css' => $css]);
    }

    public function servicesList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = $this->service->query();
            $query->with("serviceTypeDetail");
            $query->where("resort_id", $request->get("subadminResort"));
            if ($searchKeyword) {
                $query->whereHas("serviceTypeDetail", function($query) use($searchKeyword) {
                    $query->where("name", "LIKE", "%$searchKeyword%");
                })->orWhere("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $services = $query->take($limit)->offset($offset)->latest()->get();
            $i = 0;
            $servicesArray = [];
            foreach ($services as $service) {
                $stype = ServiceType::find($service->type_id);
                $servicesArray[$i]['icon'] = '<img width=50 height=50 src=' . $service->icon . ' >';
                $servicesArray[$i]['name'] = $service->name;
                $servicesArray[$i]['type'] = $stype ? $stype->name : '';
                $checked_status = $service->is_active ? "checked" : '';
                $servicesArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='service_status' id=" . $service->id . " data-status=" . $service->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $servicesArray[$i]['action'] = '<a href="' . route('subadmin.service.edit', $service->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $service->id . '" ><i class="fa fa-trash"></i> Delete </a>';
                $i++;
            }
            $data['data'] = $servicesArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function serviceAdd(Request $request) {

        if ($request->isMethod("post")) {

            $validator = Validator::make($request->all(), [
                        'service_name' => [
                            'bail',
                            'required',
                            Rule::unique('services', 'name')->where(function ($query) use($request) {
                                        return $query->where(['name' => $request->service_name, 'resort_id' => $request->get("subadminResort")]);
                                    }),
                        ],
                        'service_type' => 'bail|required',
                        'service_icon' => 'bail|required|max:1000|mimes:jpeg,jpg,png|dimensions:width<500,height<500',
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.service.add')->withErrors($validator)->withInput();
            }

            $service = new Service();
            if ($request->hasFile("service_icon")) {
                $icon_image = $request->file("service_icon");
                $icon = Storage::disk('public')->put('Service_icon', $icon_image);
                $icon_file_name = basename($icon);
                $service->icon = $icon_file_name;
            }

            $service->name = $request->service_name;
            $service->type_id = $request->service_type;
            $service->resort_id = $request->get("subadminResort");
            $service->is_active = 1;
            $service->created_by = 1;
            $service->updated_by = 1;

            if ($service->save()) {
                if ($request->question) {
                    foreach ($request->question as $serviceQues) {
                        $serviceQuestion = new ServiceQuestionaire();
                        $serviceQuestion->service_id = $service->id;
                        $serviceQuestion->question = $serviceQues;
                        $serviceQuestion->is_active = 1;
                        $serviceQuestion->created_by = 1;
                        $serviceQuestion->updated_by = 1;
                        $serviceQuestion->save();
                    }
                }
                return redirect()->route('subadmin.service.index')->with('status', 'Service has been added successfully.');
            } else {
                return redirect()->route('subadmin.service.add')->with('error', 'Something went be wrong.');
            }
        }
        $serviceType = ServiceType::where("is_active", 1)->get();
        return view('subadmin.services.add-service', [
            'serviceType' => $serviceType
        ]);
    }

    public function updateServiceStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $service = $this->service->findOrFail($request->record_id);
                $service->is_active = $request->status;
                if ($service->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status updated successfully"]];
                } else {
                    return ['status' => false, "message" => "Something went be wrong."];
                }
            } else {
                return ['status' => false, "message" => "Method not allowed."];
            }
            return [];
        } catch (\Exception $e) {
            return ['status' => false, "message" => $e->getMessage()];
        }
    }

    public function edit(Request $request, $id) {

        $data = Service::find($id);
        if ($request->isMethod("post")) {

            $validator = Validator::make($request->all(), [
                        'service_name' => [
                            'bail',
                            'required',
                            Rule::unique('services', 'name')->ignore($id)->where(function ($query) use($request) {
                                        return $query->where(['name' => $request->service_name, 'resort_id' => $request->get("subadminResort")]);
                                    }),
                        ],
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.service.edit', $id)->withErrors($validator)->withInput();
            }

            if ($request->hasFile("service_icon")) {
                $icon_image = $request->file("service_icon");
                $icon = Storage::disk('public')->put('Service_icon', $icon_image);
                $icon_file_name = basename($icon);
                $data->icon = $icon_file_name;
            }
            $data->name = $request->service_name;
            $data->type_id = $request->service_type;

            if ($data->save()) {
                if ($request->question) {
                    ServiceQuestionaire::where("service_id", $data->id)->delete();
                    foreach ($request->question as $serviceQues) {
                        $serviceQuestion = new ServiceQuestionaire();
                        $serviceQuestion->service_id = $data->id;
                        $serviceQuestion->question = $serviceQues;
                        $serviceQuestion->is_active = 1;
                        $serviceQuestion->created_by = 1;
                        $serviceQuestion->updated_by = 1;
                        $serviceQuestion->save();
                    }
                }
                return redirect()->route('subadmin.service.edit', $id)->with('status', 'Service has been updated successfully.');
            } else {
                return redirect()->route('subadmin.service.index')->with('error', 'Something went be wrong.');
            }
        }

        $sTypes = ServiceType::where("is_active", 1)->get();
        $serviceQuestions = ServiceQuestionaire::where("service_id", $data->id)->get();

        return view('subadmin.services.edit-service', [
            'data' => $data,
            'sTypes' => $sTypes,
            'serviceQuestions' => $serviceQuestions,
        ]);
    }

    public function deleteService(Request $request) {
        $service = Service::find($request->id);
        if ($service->delete()) {
            return ['status' => true, "message" => "Service deleted successfully."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

}
