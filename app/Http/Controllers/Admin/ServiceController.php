<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Resort;
use App\Models\Question;
use App\Models\ServiceQuestionaire;
use Illuminate\Support\Facades\Storage;

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
                $stype = ServiceType::find($service->type_id);
                $servicesArray[$i]['name'] = $service->name;
                $servicesArray[$i]['type'] = $stype ? $stype->name : '';
                $checked_status = $service->is_active ? "checked" : '';
                $servicesArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='service_status' id=" . $service->id . " data-status=" . $service->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $servicesArray[$i]['action'] = '<a href="' . route('admin.service.edit', $service->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
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
            $icon_image = $request->file("service_icon");
            $icon = Storage::disk('public')->put('Service_icon', $icon_image);
            $icon_file_name = basename($icon);

            $service = new Service();
            $service->name = $request->service_name;
            $service->icon = $icon_file_name;
            $service->type_id = $request->service_type;
            $service->resort_id = $request->resort_id;
            $service->is_active = 1;
            $service->created_by = 1;
            $service->updated_by = 1;

            if ($service->save()) {
                if ($request->service_question) {
                    foreach ($request->service_question as $serviceQues) {
                        $serviceQuestion = new ServiceQuestionaire();
                        $serviceQuestion->service_id = $service->id;
                        $serviceQuestion->question_id = $serviceQues;
                        $serviceQuestion->is_active = 1;
                        $serviceQuestion->created_by = 1;
                        $serviceQuestion->updated_by = 1;
                        $serviceQuestion->save();
                    }
                }
                return redirect()->route('admin.service.index')->with('status', 'Service has been added successfully.');
            } else {
                return redirect()->route('admin.service.add')->with('error', 'Something went be wrong.');
            }
        }
        $css = [
            "vendors/iCheck/skins/flat/green.css",
        ];
        $js = [
            'vendors/iCheck/icheck.min.js',
        ];
        $serviceType = ServiceType::where("is_active", 1)->get();
        $resort = Resort::where("is_active", 1)->get();
        $question = Question::all();
        return view('admin.services.add-service', ['js' => $js, 'css' => $css, 'serviceType' => $serviceType, 'resort' => $resort, 'question' => $question]);
    }

    public function updateServiceStatus(Request $request) {
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

    public function edit(Request $request, $id) {

        $data = Service::find($id);
        if ($request->isMethod("post")) {
            if ($request->hasFile("service_icon")) {
                $icon_image = $request->file("service_icon");
                $icon = Storage::disk('public')->put('Service_icon', $icon_image);
                $icon_file_name = basename($icon);
                $data->icon = $icon_file_name;
            }
            $data->name = $request->service_name;
            $data->type_id = $request->service_type;
            $data->resort_id = $request->resort_id;

            if ($data->save()) {
                if ($request->service_question) {
                    ServiceQuestionaire::where("service_id", $data->id)->delete();
                    foreach ($request->service_question as $serviceQues) {
                        $serviceQuestion = new ServiceQuestionaire();
                        $serviceQuestion->service_id = $data->id;
                        $serviceQuestion->question_id = $serviceQues;
                        $serviceQuestion->is_active = 1;
                        $serviceQuestion->created_by = 1;
                        $serviceQuestion->updated_by = 1;
                        $serviceQuestion->save();
                    }
                }
                return redirect()->route('admin.service.edit', $id)->with('status', 'Service has been updated successfully.');
            } else {
                return redirect()->route('admin.service.add')->with('error', 'Something went be wrong.');
            }
        }

        $css = ["vendors/iCheck/skins/flat/green.css"];
        $js = ['vendors/iCheck/icheck.min.js'];
        $sTypes = ServiceType::where("is_active", 1)->get();
        $resorts = Resort::all();
        $questions = Question::where("is_active", 1)->get();
        $serviceQuestioner = ServiceQuestionaire::where("service_id", $id)->get();
        $qSArray = [];
        foreach ($serviceQuestioner as $serviceQues) {
            $qSArray[] = $serviceQues->question_id;
        }

        return view('admin.services.edit-service', [
            'js' => $js,
            'css' => $css,
            'data' => $data,
            'sTypes' => $sTypes,
            'resorts' => $resorts,
            'questions' => $questions,
            'qSArray' => $qSArray,
        ]);
    }

}
