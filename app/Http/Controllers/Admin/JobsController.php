<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resort;
use App\Models\ResortNearbyPlace;
use App\Models\NearbyPlaceImage;

class JobsController extends Controller {

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

            $i = 0;
            $nearbyArray = [];
            foreach ($nearbys as $nearby) {
                $resort = Resort::find($nearby->resort_id);
                $nearbyArray[$i]['name'] = $nearby->name;
                $checked_status = $nearby->is_active ? "checked" : '';
                $nearbyArray[$i]['distance'] = $nearby->distance_from_resort;
                $nearbyArray[$i]['resort_name'] = $resort->name;
                $nearbyArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='nearby_status' id=" . $nearby->id . " data-status=" . $nearby->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $nearbyArray[$i]['action'] = '<a href="' . route('admin.nearby.edit', $nearby->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
                $i++;
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
        $resorts = Resort::where("is_active", 1)->get();
        return view('admin.nearby.create-nearby', ['js' => $js, 'css' => $css, 'resorts' => $resorts]);
    }

    public function uploadImages(Request $request) {

        $image = $request->file("file");
        $resort = Storage::disk('public')->put('Nearby', $image);
        if ($resort) {
            $file_name = basename($resort);
            return ["status" => true, "id" => time(), "file_name" => $file_name];
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
                return redirect()->route('admin.nearby.edit', $id)->with('status', 'Nearby place has been updated successfully.');
            }
        }

        $resorts = Resort::where("is_active", 1)->get();
        return view('admin.nearby.edit-nearby', ['data' => $data, 'resorts' => $resorts]);
    }

}
