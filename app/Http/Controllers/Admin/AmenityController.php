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
            dd($resorts->toArray());
            $resortsArray = [];
            foreach ($amenities as $amenity) {
                $resort = Resort::find($amenity->resort_id);
                $cityState = CityMaster::find($resort->city_id)->first();
                $address = $resort->address_1 . ",<br>" . $cityState->city . ",<br>" . $cityState->state->state . ",<br>" . $resort->pincode;
                $img = !empty($resortImage) ? $resortImage->image_name : asset('img/noimage.png');
                $resortsArray[$i]['image'] = "<img width=80 height=70 src='" . $img . "'>";
                $resortsArray[$i]['name'] = $resort->name;
                $checked_status = $resort->is_active ? "checked" : '';
                $resortsArray[$i]['contact_no'] = $resort->contact_number;
                $resortsArray[$i]['address'] = $address;
                $resortsArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='resort_status' id=" . $resort->id . " data-status=" . $resort->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $resortsArray[$i]['action'] = '<a href="' . route('admin.resort.edit', $resort->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
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
        try {
            $data = $this->resort->find($id);
            if ($request->isMethod("post")) {
                $data->name = $request->edit_resort_name;
                $data->contact_number = $request->edit_contact_no;
                $data->description = $request->edit_resort_description;
                $data->address_1 = $request->edit_address;
                $data->pincode = $request->edit_pin_code;
                $data->city_id = $request->city;
                if ($data->save()) {
                    if ($request->room_type && $request->room_no) {
                        ResortRoom::where("resort_id", $data->id)->delete();
                        $i = 0;
                        foreach ($request->room_type as $room) {
                            $resortRoom = new ResortRoom();
                            $resortRoom->resort_id = $data->id;
                            $resortRoom->room_type_id = $room;
                            $resortRoom->room_no = $request->room_no[$i];
                            $resortRoom->save();
                            $i++;
                        }
                    }

                    return redirect()->route('admin.resort.edit', $id)->with('status', 'Resort has been updated successfully.');
                }
            }


            $dataRooms = $this->resortRoom->where("resort_id", $data->id)->get();
            $roomTypes = $this->roomType->all();
            $states = StateMaster::all();
            $selectedCity = CityMaster::find($data->city_id);
            $cities = CityMaster::where("state_id", $selectedCity->state_id)->get();
            return view('admin.resort.edit', [
                'data' => $data,
                'dataRooms' => $dataRooms,
                'roomTypes' => $roomTypes,
                'states' => $states,
                'selectedCity' => $selectedCity,
                'cities' => $cities,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.resort.edit', $id)->with('error', $ex->getMessage());
        }
    }

    public function getResortRooms(Request $request, $resort = 0, $type = 0) {
        $resortRooms = ResortRoom::where(["resort_id" => $resort, "room_type_id" => $type, "is_active" => 1])->get();
        return view('admin.resort.rooms', [ 'resortRooms' => $resortRooms]);
    }

    public function deleteRoom(Request $request) {
        try {
            $room = $this->resortRoom->find($request->record_id);
            if ($room) {
                $room->delete();
                return ["status" => true];
            } else {
                return ["status" => false];
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

}
