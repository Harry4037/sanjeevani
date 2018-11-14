<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\RoomType;
use App\Models\ResortRoom;
use App\Models\ResortRating;
use App\Models\StateMaster;
use App\Models\CityMaster;
use Validator;

class ResortController extends Controller {

    public function __construct(Resort $resort, ResortImage $resortImage, RoomType $roomType, ResortRoom $resortRoom, ResortRating $resortRating) {
        $this->resort = $resort;
        $this->resortImage = $resortImage;
        $this->roomType = $roomType;
        $this->resortRoom = $resortRoom;
        $this->resortRating = $resortRating;
    }

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.resort.index', ['js' => $js, 'css' => $css]);
    }

    public function resortList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = $this->resort->query();
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%")
                        ->orWhere("contact_number", "LIKE", "%$searchKeyword%")
                        ->orWhere("address_1", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $this->resort->count();
            $data['recordsFiltered'] = $this->resort->count();
            $resorts = $query->take($limit)->offset($offset)->latest()->get();
            $i = 0;
            $resortsArray = [];
            foreach ($resorts as $resort) {
                $resortImage = $this->resortImage->where("resort_id", $resort->id)->first();
                $cityState = CityMaster::find($resort->city_id)->first();
                $address = $resort->address_1 . ",<br>" . $cityState->city . ",<br>" . $cityState->state->state . ",<br>" . $resort->pincode;
                $img = !empty($resortImage) ? $resortImage->image_name : asset('img/noimage.png');
                $resortsArray[$i]['image'] = "<img width=80 height=70 src='" . $img . "'>";
                $resortsArray[$i]['name'] = $resort->name;
                $checked_status = $resort->is_active ? "checked" : '';
                $resortsArray[$i]['contact_no'] = $resort->contact_number;
                $resortsArray[$i]['address'] = $address;
                $resortsArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='resort_status' id=" . $resort->id . " data-status=" . $resort->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $resortsArray[$i]['action'] = '<a href="' . route('admin.resort.edit', $resort->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a><a href="' . route('admin.resort.edit', $resort->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Update Images </a>';
                $i++;
            }

            $data['data'] = $resortsArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request) {
        try {
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'resort_name' => 'bail|required',
                            'contact_no' => 'bail|required',
                            'address' => 'bail|required',
                            'pin_code' => 'bail|required|numeric',
                            'city' => 'bail|required|numeric',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.resort.add')->withErrors($validator)->withInput();
                }

                $resort = $this->resort;
                $resort->name = $request->resort_name;
                $resort->contact_number = $request->contact_no;
                $resort->description = $request->resort_description;
                $resort->address_1 = $request->address;
                $resort->pincode = $request->pin_code;
                $resort->city_id = $request->city;
                if ($resort->save()) {
                    if ($request->resort_images) {
                        foreach ($request->resort_images as $tempImage) {
                            $resortImage = new ResortImage();
                            $resortImage->resort_id = $resort->id;
                            $resortImage->image_name = $tempImage;
                            $resortImage->is_active = 1;
                            $resortImage->save();
                        }
                    }
                    if ($request->room_type && $request->room_no) {
                        $i = 0;
                        foreach ($request->room_type as $room) {
                            $resortRoom = new ResortRoom();
                            $resortRoom->resort_id = $resort->id;
                            $resortRoom->room_type_id = $room;
                            $resortRoom->room_no = $request->room_no[$i];
                            $resortRoom->save();
                            $i++;
                        }
                    }


                    return redirect()->route('admin.resort.index')->with('status', 'Resort has been added successfully.');
                } else {
                    return redirect()->route('admin.resort.add')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/dropzone/dist/dropzone.js',
            ];
            $roomTypes = $this->roomType->all();
            $states = StateMaster::all();
            return view('admin.resort.create', [
                'js' => $js,
                'css' => $css,
                'roomTypes' => $roomTypes,
                'states' => $states,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.resort.index')->with('error', $ex->getMessage());
        }
    }

    public function uploadImages(Request $request) {
        $resort_image = $request->file("file");
        $resort = Storage::disk('public')->put('resort_images', $resort_image);
        if ($resort) {
            $resort_file_name = basename($resort);
            return ["status" => true, "id" => time(), "file_name" => $resort_file_name];
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
