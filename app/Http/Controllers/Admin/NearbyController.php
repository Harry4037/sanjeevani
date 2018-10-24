<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resort;
use App\Models\ResortNearbyPlace;


class NearbyController extends Controller {

    public function index($id) {
        $resort = Resort::find($id);
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'js/admin/nearby.js'
        ];
        return view('admin.nearby.index', ['js' => $js, 'css' => $css, 'resort' => $resort]);
    }

    public function nearbyList(Request $request, $id) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            
            $nearbys = ResortNearbyPlace::where("resort_id", $id)->get();

            $i = 0;
            $nearbyArray = [];
            foreach ($nearbys as $nearby) {
                $nearbyArray[$i]['name'] = $nearby->name;
                $checked_status = $nearby->is_active ? "checked" : '';
                $nearbyArray[$i]['distance'] = $nearby->distance_from_resort;
                $nearbyArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='resort_status' id=" . $nearby->id . " data-status=" . $nearby->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $nearbyArray[$i]['action'] = '';
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

            $resort = $this->resort;
            $resort->name = $request->resort_name;
            $resort->contact_number = $request->contact_no;
            $resort->description = $request->resort_description;
            $resort->address_1 = $request->address;
            $resort->pincode = $request->pin_code;
            // $resort->name = $request->state;
            // $resort->name = $request->district;
            $resort->city_id = $request->city;
            if ($resort->save()) {
                if ($request->room_types) {
                    foreach ($request->room_types as $room) {
                        $resortRoom = new ResortRoom();
                        $resortRoom->resort_id = $resort->id;
                        $resortRoom->room_type_id = $room;
                        $resortRoom->save();
                    }
                }

                $tempImages = TempImages::all();
                if ($tempImages) {
                    foreach ($tempImages as $tempImage) {
                        $resortImage = new ResortImage();
                        $resortImage->resort_id = $resort->id;
                        $resortImage->image_name = $tempImage->name;
                        $resortImage->is_active = 1;
                        $resortImage->save();
                        $tempImage->delete();
                    }
                }

                return redirect()->route('admin.resort.index')->with('status', 'Resort has been added successfully.');
            } else {
                return redirect()->route('admin.resort.add')->with('error', 'Something went be wrong.');
            }
        }
        $css = [
            "vendors/iCheck/skins/flat/green.css",
            "vendors/dropzone/dist/dropzone.css",
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'vendors/iCheck/icheck.min.js',
            'vendors/dropzone/dist/dropzone.js',
            'js/admin/resorts.js'
        ];
        $roomTypes = $this->roomType->all();
        return view('admin.resort.create-banner', ['js' => $js, 'css' => $css, 'roomTypes' => $roomTypes]);
    }

    public function uploadImages(Request $request) {

        $resort_image = $request->file("file");
        $resort = Storage::disk('public')->put('Resort', $resort_image);
        if ($resort) {
            $resort_file_name = basename($resort);
            $tempImage = new TempImages();
            $tempImage->name = $resort_file_name;
            $tempImage->save();

            return ["status" => true, "id" => $tempImage->id];
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
                $resort = $this->resort->findOrFail($request->record_id);
                $resort->is_active = $request->status;
                if ($resort->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editResort(Request $request, $id) {
        $data = $this->resort->find($id);
        if($request->isMethod("post")){
            $data->name = $request->edit_resort_name;
            $data->contact_number = $request->edit_contact_no;
            $data->description = $request->edit_resort_description;
            $data->address_1 = $request->edit_address;
            $data->pincode = $request->edit_pin_code;
            $data->city_id = $request->edit_city;
            if($data->save()){
                if ($request->edit_room_types) {
                    ResortRoom::where("resort_id", $data->id)->delete();
                    foreach ($request->edit_room_types as $room) {
                        $resortRoom = new ResortRoom();
                        $resortRoom->resort_id = $data->id;
                        $resortRoom->room_type_id = $room;
                        $resortRoom->save();
                    }
                }
               return redirect()->route('admin.resort.edit', $id)->with('status', 'Resort has been updated successfully.'); 
            }
        }
        
        
        $dataRooms  = $this->resortRoom->where("resort_id", $data->id)->get();
        $roomArray = [];
        foreach($dataRooms as $dataRoom){
            $roomArray[] = $dataRoom->room_type_id;
        }
        $roomTypes = $this->roomType->all();
        $css = [
            "vendors/iCheck/skins/flat/green.css"
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'vendors/iCheck/icheck.min.js',
            'vendors/dropzone/dist/dropzone.js',
            'js/admin/resorts.js'
        ];
        return view('admin.resort.edit-banner', ['js' => $js, 'css' => $css, 'data' => $data, 'roomArray'  => $roomArray, 'roomTypes' => $roomTypes]);
    }

}
