<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resort;
use App\Models\ResortNearbyPlace;
use App\Models\NearbyPlaceImage;
use App\Models\StateMaster;

class NearbyController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('admin.nearby.index', ['js' => $js, 'css' => $css]);
    }

    public function nearbyList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');

            $nearbys = ResortNearbyPlace::all();
            $nearbyArray = [];
            foreach ($nearbys as $key => $nearby) {
                $resort = Resort::find($nearby->resort_id);
                $nearbyArray[$key]['name'] = $nearby->name;
                $checked_status = $nearby->is_active ? "checked" : '';
                $nearbyArray[$key]['distance'] = $nearby->distance_from_resort;
                $nearbyArray[$key]['resort_name'] = $resort->name;
                $nearbyArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='nearby_status' id=" . $nearby->id . " data-status=" . $nearby->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $nearbyArray[$key]['action'] = '<a href="' . route('admin.nearby.edit', $nearby->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $nearby->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }
            $data['recordsTotal'] = ResortNearbyPlace::count();
            $data['recordsFiltered'] = ResortNearbyPlace::count();
            $data['data'] = $nearbyArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function create(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $place = new ResortNearbyPlace();
                $place->resort_id = $request->resort_id;
                $place->name = $request->place_name;
                $place->resort_id = $request->resort_id;
                $place->distance_from_resort = $request->distance;
                $place->description = $request->place_description;
                $place->precautions = $request->place_precaution;
                $place->address_1 = $request->address;
                $place->pincode = $request->pin_code;
                $place->city_id = $request->city;
                if ($place->save()) {
                    if ($request->nearby_images) {
                        foreach ($request->nearby_images as $tempImage) {
                            $resortImage = new NearbyPlaceImage();
                            $resortImage->nearby_place_id = $place->id;
                            $resortImage->name = $tempImage;
                            $resortImage->is_active = 1;
                            $resortImage->save();
                        }
                    }

                    return redirect()->route('admin.nearby.index')->with('status', 'Nearby place has been added successfully.');
                } else {
                    return redirect()->route('admin.nearby.add')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/datatables.net/js/jquery.dataTables.min.js',
                'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'vendors/dropzone/dist/dropzone.js',
            ];
            $states = StateMaster::all();
            $resorts = Resort::where("is_active", 1)->get();
            return view('admin.nearby.create-nearby', [
                'js' => $js,
                'css' => $css,
                'resorts' => $resorts,
                'states' => $states
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.nearby.index')->with('error', $ex->getMessage());
        }
    }

    public function uploadImages(Request $request) {

        $image = $request->file("file");
        $resort = Storage::disk('public')->put('nearby_images', $image);
        if ($resort) {
            $file_name = basename($resort);
            return ["status" => true, "id" => time(), "file_name" => $file_name];
        }
    }

    public function deleteImages(Request $request) {
        @unlink('storage/nearby_images/' . $request->record_val);
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $nearby = ResortNearbyPlace::findOrFail($request->record_id);
                $nearby->is_active = $request->status;
                if ($nearby->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editNearby(Request $request, $id) {
        try {
            $data = ResortNearbyPlace::find($id);
            if ($request->isMethod("post")) {
                $data->resort_id = $request->resort_id;
                $data->name = $request->place_name;
                $data->distance_from_resort = $request->distance;
                $data->description = $request->place_description;
                $data->precautions = $request->place_precaution;
                $data->address_1 = $request->address;
                $data->pincode = $request->pin_code;
                $data->city_id = $request->city;
                if ($data->save()) {
                    if ($request->nearby_images) {
                        foreach ($request->nearby_images as $tempImage) {
                            $resortImage = new NearbyPlaceImage();
                            $resortImage->nearby_place_id = $data->id;
                            $resortImage->name = $tempImage;
                            $resortImage->is_active = 1;
                            $resortImage->save();
                        }
                    }
                    return redirect()->route('admin.nearby.edit', $id)->with('status', 'Nearby place has been updated successfully.');
                }
            }

            $css = [
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/datatables.net/js/jquery.dataTables.min.js',
                'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'vendors/dropzone/dist/dropzone.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();
            $states = StateMaster::all();
            $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $data->id)->get();
            return view('admin.nearby.edit-nearby', [
                'css' => $css,
                'js' => $js,
                'data' => $data,
                'resorts' => $resorts,
                'states' => $states,
                'nearbyImages' => $nearbyImages,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.nearby.index', $id)->with('error', $ex->getMessage());
        }
    }

    public function deleteNearbyImage(Request $request) {
        try {
            $nearbyImage = NearbyPlaceImage::select('name as nearby_img')->find($request->record_id);
            @unlink('storage/nearby_images/' . $nearbyImage->nearby_img);
            NearbyPlaceImage::find($request->record_id)->delete();
            return ["status" => true];
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteNearby(Request $request) {
        $resortNearby = ResortNearbyPlace::find($request->id);
        if ($resortNearby->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
