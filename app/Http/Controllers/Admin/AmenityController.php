<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\StateMaster;
use App\Models\Amenity;
use App\Models\AmenityImage;
use App\Models\Resort;
use App\Models\AmenityTimeSlot;

class AmenityController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.amenity.index', ['js' => $js, 'css' => $css]);
    }

    public function amenityList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Amenity::query();
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $amenities = $query->take($limit)->offset($offset)->latest()->get();
            $i = 0;
//            dd($amenities->toArray());
            $resortsArray = [];
            foreach ($amenities as $amenity) {
                $resort = Resort::find($amenity->resort_id);
                $image = AmenityImage::where("amenity_id", $amenity->id)->first();
                $resortImage = isset($image) ? $image->image_name : asset("img/no-image.jpg");
                $resortsArray[$i]['image'] = '<img src=' . $resortImage . ' height=70 width=100 class="img-rounded">';
                $resortsArray[$i]['name'] = $amenity->name;
                $checked_status = $amenity->is_active ? "checked" : '';
                $resortsArray[$i]['resort_name'] = $resort->name;
                $resortsArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='amenity_status' id=" . $amenity->id . " data-status=" . $amenity->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $resortsArray[$i]['action'] = '<a href="' . route('admin.amenity.edit', $amenity->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $amenity->id . '" ><i class="fa fa-trash"></i> Delete </a>';
                $i++;
            }

            $data['data'] = $resortsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function create(Request $request) {

        try {
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'amenity_name' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.amenity.index')->withErrors($validator)->withInput();
                }
                $amenity = new Amenity();

                $amenity->name = $request->amenity_name;
                $amenity->description = $request->amenity_description;
                $amenity->resort_id = $request->resort_id;
                $amenity->address = $request->address;
                if ($request->file("amenity_icon")) {
                    $amenity_icon = Storage::disk('public')->put('amenity_icon', $request->file("amenity_icon"));
                    if ($amenity_icon) {
                        $amenity_icon_name = basename($amenity_icon);
                        $amenity->icon = $amenity_icon_name;
                    }
                }
                if ($amenity->save()) {
                    if ($request->amenity_images) {
                        foreach ($request->amenity_images as $tempImage) {
                            $amenityImage = new AmenityImage();
                            $amenityImage->image_name = $tempImage;
                            $amenityImage->amenity_id = $amenity->id;
                            $amenityImage->save();
                        }
                    }
                    if ($request->from_time && $request->to_time) {
                        foreach ($request->from_time as $key => $fromTime) {
                            if ($fromTime && $request->to_time[$key] && $request->total_people[$key]) {
                                $from_time = Carbon::parse($fromTime);
                                $to_time = Carbon::parse($request->to_time[$key]);
                                $amenityTimeSlot = new AmenityTimeSlot();
                                $amenityTimeSlot->amenity_id = $amenity->id;
                                $amenityTimeSlot->from = $from_time->format("H:s:i");
                                $amenityTimeSlot->to = $to_time->format("H:s:i");
                                $amenityTimeSlot->allow_no_of_member = $request->total_people[$key];
                                $amenityTimeSlot->save();
                            }
                        }
                    }


                    return redirect()->route('admin.amenity.index')->with('status', 'Resort has been added successfully.');
                } else {
                    return redirect()->route('admin.amenity.index')->with('error', 'Something went be wrong.');
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
            return view('admin.amenity.create', [
                'js' => $js,
                'css' => $css,
                'resorts' => $resorts,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.amenity.index')->with('error', $ex->getMessage());
        }
    }

    public function uploadImages(Request $request) {
        $amenity_image = $request->file("file");
        $amenity = Storage::disk('public')->put('amenity_images', $amenity_image);
        if ($amenity) {
            $amenity_file_name = basename($amenity);
            return ["status" => true, "id" => time(), "file_name" => $amenity_file_name];
        }
    }

    public function deleteImages(Request $request) {
        $data = TempImages::find($request->record_id);
        if ($data) {
            $data->delete();
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $amenity = Amenity::findOrFail($request->record_id);
                $amenity->is_active = $request->status;
                if ($amenity->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editAmenity(Request $request) {
        $amenity = Amenity::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'amenity_name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.amenity.index')->withErrors($validator)->withInput();
            }
            $amenity->name = $request->amenity_name;
            $amenity->description = $request->amenity_description;
            $amenity->resort_id = $request->resort_id;
            $amenity->address = $request->address;
            if ($request->file("amenity_icon")) {
                $amenity_icon = Storage::disk('public')->put('amenity_icon', $request->file("amenity_icon"));
                if ($amenity_icon) {
                    $amenity_icon_name = basename($amenity_icon);
                    $amenity->icon = $amenity_icon_name;
                }
            }
            if ($amenity->save()) {
                if ($request->amenity_images) {
                    foreach ($request->amenity_images as $tempImage) {
                        $amenityImage = new AmenityImage();
                        $amenityImage->image_name = $tempImage;
                        $amenityImage->amenity_id = $amenity->id;
                        $amenityImage->save();
                    }
                }
                if ($request->from_time && $request->to_time) {
                    AmenityTimeSlot::where("amenity_id", $amenity->id)->delete();
                    foreach ($request->from_time as $key => $fromTime) {
                        if ($fromTime && $request->to_time[$key] && $request->total_people[$key]) {
                            $from_time = Carbon::parse($fromTime);
                            $to_time = Carbon::parse($request->to_time[$key]);
                            $amenityTimeSlot = new AmenityTimeSlot();
                            $amenityTimeSlot->amenity_id = $amenity->id;
                            $amenityTimeSlot->from = $from_time->format("H:s:i");
                            $amenityTimeSlot->to = $to_time->format("H:s:i");
                            $amenityTimeSlot->allow_no_of_member = $request->total_people[$key];
                            $amenityTimeSlot->save();
                        }
                    }
                }


                return redirect()->route('admin.amenity.index')->with('status', 'Resort has been added successfully.');
            } else {
                return redirect()->route('admin.amenity.index')->with('error', 'Something went be wrong.');
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
        $amenityImages = AmenityImage::where("amenity_id", $amenity->id)->get();
        $timeSlots = AmenityTimeSlot::where("amenity_id", $amenity->id)->get();
        return view('admin.amenity.edit', [
            'css' => $css,
            'js' => $js,
            'resorts' => $resorts,
            'amenityImages' => $amenityImages,
            'amenity' => $amenity,
            'timeSlots' => $timeSlots,
        ]);
    }

    public function deleteAmenityImage(Request $request) {
        try {
            $amenityImage = AmenityImage::select('image_name as amenity_img')->find($request->record_id);
            @unlink('storage/amenity_images/' . $amenityImage->amenity_img);
            AmenityImage::find($request->record_id)->delete();
            return ["status" => true];
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteTimeSlot(Request $request) {
        try {
            $slot = AmenityTimeSlot::find($request->record_id);
            if ($slot) {
                $slot->delete();
                return ["status" => true];
            } else {
                return ["status" => false];
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteAmenity(Request $request) {
        $amenity = Amenity::find($request->id);
        if ($amenity->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
