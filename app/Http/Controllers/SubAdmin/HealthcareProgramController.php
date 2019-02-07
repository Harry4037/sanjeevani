<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\StateMaster;
use App\Models\Resort;
use App\Models\HealthcateProgram;
use App\Models\HealthcateProgramDay;
use App\Models\HealthcateProgramImages;

class HealthcareProgramController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('subadmin.healthcare.index', ['js' => $js, 'css' => $css]);
    }

    public function healthcareList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = HealthcateProgram::query();
            $query->where("resort_id", $request->get("subadminResort"));
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $healthcarePackeges = $query->take($limit)->offset($offset)->latest()->get();
            $healthArray = [];
            foreach ($healthcarePackeges as $key => $healthcarePackege) {
                $image = HealthcateProgramImages::where("health_program_id", $healthcarePackege->id)->first();
                $healthImage = isset($image) ? $image->image_name : asset("img/no-image.jpg");
                $healthArray[$key]['image'] = '<img src=' . $healthImage . ' height=70 width=100 class="img-rounded">';
                $healthArray[$key]['name'] = $healthcarePackege->name;
                $checked_status = $healthcarePackege->is_active ? "checked" : '';
                $healthArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='health_status' id=" . $healthcarePackege->id . " data-status=" . $healthcarePackege->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $healthArray[$key]['action'] = '<a href="' . route('subadmin.healthcare.edit', $healthcarePackege->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $healthcarePackege->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $healthArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request) {

        try {
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'package_name' => 'bail|required',
                            'start_from' => 'bail|required',
                            'end_to' => 'bail|required',
                            'end_to' => 'bail|required',
                            'day_id' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('subadmin.healthcare.index')->withErrors($validator)->withInput();
                }
                $healthcare = new HealthcateProgram();

                $start_from = Carbon::parse($request->start_from);
                $end_to = Carbon::parse($request->end_to);
                $healthcare->resort_id = $request->get("subadminResort");
                $healthcare->name = $request->package_name;
                $healthcare->description = $request->package_description;
                $healthcare->start_from = $start_from->format('Y-m-d');
                $healthcare->end_to = $end_to->format('Y-m-d');

                if ($healthcare->save()) {
                    if ($request->healthcare_images) {
                        foreach ($request->healthcare_images as $tempImage) {
                            $healthcareImage = new HealthcateProgramImages();
                            $healthcareImage->image_name = $tempImage;
                            $healthcareImage->health_program_id = $healthcare->id;
                            $healthcareImage->save();
                        }
                    }
                    if ($request->day_description) {
                        foreach ($request->day_description as $key => $dayDescription) {
                            $healthcareDay = new HealthcateProgramDay();
                            $healthcareDay->health_program_id = $healthcare->id;
                            $healthcareDay->day = $key + 1;
                            $healthcareDay->description = $dayDescription;
                            $healthcareDay->save();
                        }
                    }


                    return redirect()->route('subadmin.healthcare.index')->with('status', 'Healthcare Package has been added successfully.');
                } else {
                    return redirect()->route('subadmin.healthcare.index')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                'vendors/bootstrap-daterangepicker/daterangepicker.css',
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/moment/min/moment.min.js',
                'vendors/bootstrap-daterangepicker/daterangepicker.js',
                'vendors/dropzone/dist/dropzone.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();
            return view('subadmin.healthcare.create', [
                'js' => $js,
                'css' => $css,
                'resorts' => $resorts,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.healthcare.index')->with('error', $ex->getMessage());
        }
    }

    public function uploadImages(Request $request) {
        $amenity_image = $request->file("file");
        $amenity = Storage::disk('public')->put('healthcare_images', $amenity_image);
        if ($amenity) {
            $amenity_file_name = basename($amenity);
            return ["status" => true, "id" => time(), "file_name" => $amenity_file_name];
        }
    }

    public function deleteImages(Request $request) {
        @unlink('storage/healthcare_images/' . $request->record_val);
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $amenity = HealthcateProgram::findOrFail($request->record_id);
                $amenity->is_active = $request->status;
                if ($amenity->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
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

    public function editHealthcare(Request $request) {
        $healthcare = HealthcateProgram::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'package_name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.healthcare.index')->withErrors($validator)->withInput();
            }

            $start_from = Carbon::parse($request->start_from);
            $end_to = Carbon::parse($request->end_to);
//            $healthcare->resort_id = $request->resort_id;
            $healthcare->name = $request->package_name;
            $healthcare->description = $request->package_description;
            $healthcare->start_from = $start_from->format('Y-m-d');
            $healthcare->end_to = $end_to->format('Y-m-d');

            if ($healthcare->save()) {
                if ($request->healthcare_images) {
                    foreach ($request->healthcare_images as $tempImage) {
                        $healthcareImage = new HealthcateProgramImages();
                        $healthcareImage->image_name = $tempImage;
                        $healthcareImage->health_program_id = $healthcare->id;
                        $healthcareImage->save();
                    }
                }
                if ($request->day_description) {
                    HealthcateProgramDay::where("health_program_id", $healthcare->id)->delete();
                    foreach ($request->day_description as $key => $dayDescription) {
                        $healthcareDay = new HealthcateProgramDay();
                        $healthcareDay->health_program_id = $healthcare->id;
                        $healthcareDay->day = $key + 1;
                        $healthcareDay->description = $dayDescription;
                        $healthcareDay->save();
                    }
                }


                return redirect()->route('subadmin.healthcare.index')->with('status', 'Healthcare Package has been updated successfully.');
            } else {
                return redirect()->route('subadmin.healthcare.index')->with('error', 'Something went be wrong.');
            }
        }
        $css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
            "vendors/dropzone/dist/dropzone.css",
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
            'vendors/dropzone/dist/dropzone.js',
        ];
        $resorts = Resort::where("is_active", 1)->get();
        $healthcareImages = HealthcateProgramImages::where("health_program_id", $healthcare->id)->get();
        $healthcareDays = HealthcateProgramDay::where("health_program_id", $healthcare->id)->get();
        return view('subadmin.healthcare.edit', [
            'css' => $css,
            'js' => $js,
            'resorts' => $resorts,
            'healthcareImages' => $healthcareImages,
            'healthcare' => $healthcare,
            'healthcareDays' => $healthcareDays,
        ]);
    }

    public function deleteHealthcareImage(Request $request) {
        try {
            $healthcareImage = HealthcateProgramImages::select('image_name as health_img')->find($request->record_id);
            @unlink('storage/healthcare_images/' . $healthcareImage->health_img);
            HealthcateProgramImages::find($request->record_id)->delete();
            return ["status" => true];
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteHealthcare(Request $request) {
        $amenity = HealthcateProgram::find($request->id);
        if ($amenity->delete()) {
            return ['status' => true, "message" => "Healthcare Program deleted succeffully."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

}
