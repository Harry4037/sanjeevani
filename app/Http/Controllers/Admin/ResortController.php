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
use App\Models\UserBookingDetail;
use Illuminate\Validation\Rule;

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
            $resortsArray = [];
            foreach ($resorts as $key => $resort) {
                $resortImage = $this->resortImage->where("resort_id", $resort->id)->first();
                $cityState = CityMaster::find($resort->city_id);
                $address = $resort->address_1 . ",<br>" . $cityState->city . ",<br>" . $cityState->state->state . ",<br>" . $resort->pincode;
                $img = !empty($resortImage) ? $resortImage->image_name : asset('img/noimage.png');
                $resortsArray[$key]['image'] = "<img class='img-rounded' width=80 height=70 src='" . $img . "'>";
                $resortsArray[$key]['name'] = $resort->name;
                $checked_status = $resort->is_active ? "checked" : '';
                $resortsArray[$key]['contact_no'] = $resort->contact_number;
                $resortsArray[$key]['address'] = $address;
                $resortsArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='resort_status' id=" . $resort->id . " data-status=" . $resort->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $resortsArray[$key]['action'] = '<a href="' . route('admin.resort.edit', $resort->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $resort->id . '" ><i class="fa fa-trash"></i> Delete </a>';
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
                            'resort_name' => [
                                'bail',
                                'required',
                                Rule::unique('resorts', 'name')->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->resort_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                            'contact_no' => 'bail|required',
                            'cancel_term_condition' => 'bail|required',
                            'address' => 'bail|required',
                            'pin_code' => 'bail|required|numeric',
                            'city' => 'bail|required|numeric',
                            'latitude' => 'bail|required',
                            'longitude' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.resort.add')->withErrors($validator)->withInput();
                }
                $resort = $this->resort;
                $resort->name = $request->resort_name;
                $resort->contact_number = $request->contact_no;
                $resort->cancel_term_condition = $request->cancel_term_condition;
                $resort->description = $request->resort_description;
                $resort->address_1 = $request->address;
                $resort->pincode = $request->pin_code;
                $resort->city_id = $request->city;
                $resort->latitude = $request->latitude;
                $resort->longitude = $request->longitude;
                $resort->amenities = $request->aminities ? implode("#", $request->aminities) : "";
                $resort->other_amenities = $request->other_amenities ? implode("#", $request->other_amenities) : "";
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
                        foreach ($request->room_type as $k => $room) {
                            $isExist = ResortRoom::where(["resort_id" => $resort->id, "room_no" => $request->room_no[$k]])->first();
                            if (!$isExist) {
                                $resortRoom = new ResortRoom();
                                $resortRoom->resort_id = $resort->id;
                                $resortRoom->room_type_id = $room;
                                $resortRoom->room_no = $request->room_no[$k];
                                $resortRoom->save();
                            }
                        }
                    }


                    return redirect()->route('admin.resort.index')->with('status', 'Resort has been added successfully.');
                } else {
                    return redirect()->route('admin.resort.add')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                "vendors/dropzone/dist/dropzone.css",
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/dropzone/dist/dropzone.js',
                'vendors/iCheck/icheck.min.js',
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
        @unlink('storage/resort_images/' . $request->record_val);
        return ["status" => true, "message" => "Image deleted."];
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $resort = $this->resort->findOrFail($request->record_id);
                $resort->is_active = $request->status;
                if ($resort->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status updated successfully"]];
                } else {
                    return ['status' => false, "message" => "Something went be wrong."];
                }
            } else {
                return ['status' => false, "message" => "Method not allowed."];
            }
        } catch (\Exception $e) {
            return ['status' => false, "message" => $e->getMessage()];
        }
    }

    public function editResort(Request $request, $id) {
        try {
            $data = $this->resort->find($id);
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'edit_resort_name' => [
                                'bail',
                                'required',
                                Rule::unique('resorts', 'name')->ignore($id)->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->edit_resort_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.resort.edit', $id)->withErrors($validator)->withInput();
                }

                $data->name = $request->edit_resort_name;
                $data->contact_number = $request->edit_contact_no;
                $data->cancel_term_condition = $request->cancel_term_condition;
                $data->description = $request->edit_resort_description;
                $data->address_1 = $request->edit_address;
                $data->pincode = $request->edit_pin_code;
                $data->city_id = $request->city;
                $data->latitude = $request->latitude;
                $data->longitude = $request->longitude;
                $data->amenities = $request->aminities ? implode("#", $request->aminities) : "";
                $data->other_amenities = $request->other_amenities ? implode("#", $request->other_amenities) : "";
                if ($data->save()) {
                    if ($request->room_type && $request->room_no) {
                        foreach ($request->room_type as $k => $room) {
                            if ($request->room_id[$k] > 0) {
                                $resortRoom = ResortRoom::find($request->room_id[$k]);
                            } else {
                                $resortRoom = new ResortRoom();
                            }
                            $resortRoom->resort_id = $data->id;
                            $resortRoom->room_type_id = $room;
                            $resortRoom->room_no = $request->room_no[$k];
                            $resortRoom->save();
                        }
                    }

                    if ($request->resort_images) {
//                        ResortImage::where("resort_id", $data->id)->delete();
                        foreach ($request->resort_images as $tempImage) {
                            $resortImage = new ResortImage();
                            $resortImage->resort_id = $data->id;
                            $resortImage->image_name = $tempImage;
                            $resortImage->is_active = 1;
                            $resortImage->save();
                        }
                    }

                    return redirect()->route('admin.resort.edit', $id)->with('status', 'Resort has been updated successfully.');
                }
            }

            $css = [
                "vendors/dropzone/dist/dropzone.css",
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/dropzone/dist/dropzone.js',
                'vendors/iCheck/icheck.min.js',
            ];
            $resortImages = ResortImage::where("resort_id", $data->id)->get();
            $dataRooms = $this->resortRoom->where("resort_id", $data->id)->get();
            $roomTypes = $this->roomType->where(["is_active" => 1, "resort_id" => $data->id])->get();
            $states = StateMaster::all();
            $selectedCity = CityMaster::find($data->city_id);
            $cities = CityMaster::where("state_id", $selectedCity->state_id)->get();
            return view('admin.resort.edit', [
                'data' => $data,
                'resortImages' => $resortImages,
                'dataRooms' => $dataRooms,
                'roomTypes' => $roomTypes,
                'states' => $states,
                'selectedCity' => $selectedCity,
                'cities' => $cities,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.resort.index')->with('error', $ex->getMessage());
        }
    }

    public function getResortRooms(Request $request) {
        try {
            $check_in = date("Y-m-d H:s:i", strtotime($request->check_in));
            $check_out = date("Y-m-d H:s:i", strtotime($request->check_out));
            $resort = $request->resort;

            $roomIds = UserBookingDetail::where("resort_id", $resort)
                    ->where(function($query) use($check_in, $check_out) {
                        $query->orWhere(function($query) use($check_in) {
                            $query->where("check_in", "<=", $check_in)
                            ->where("check_out", ">=", $check_in);
                        });
                        $query->orWhere(function($query) use($check_out) {
                            $query->where("check_in", "<", $check_out)
                            ->where("check_out", ">=", $check_out);
                        });
                        $query->orWhere(function($query) use($check_in, $check_out) {
                            $query->where("check_in", ">=", $check_in)
                            ->where("check_out", "<=", $check_out);
                        });
                    })
                    ->pluck("resort_room_id");

            $query = ResortRoom::query();
            $query->where(["resort_id" => $resort, "room_type_id" => $request->resort_room, "is_active" => 1]);
            if (!empty($roomIds)) {
                $query->whereNotIn("id", $roomIds);
            }

            $resortRooms = $query->get();
            return view('admin.resort.rooms', ['resortRooms' => $resortRooms]);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

    public function deleteRoom(Request $request) {
        try {
            $room = $this->resortRoom->find($request->record_id);
            if ($room->delete()) {
                return ["status" => true, "message" => "Room deleted."];
            } else {
                return ["status" => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ["status" => false, "message" => $ex->getMessage()];
        }
    }

    public function deleteResortImage(Request $request) {
        try {
            $resortImage = ResortImage::select('image_name as resort_img')->find($request->record_id);
            @unlink('storage/resort_images/' . $resortImage->resort_img);
            ResortImage::find($request->record_id)->delete();
            return ["status" => true, "message" => "Image deleted."];
        } catch (\Exception $ex) {
            return ["status" => false, "message" => $ex->getMessage()];
        }
    }

    public function deleteResort(Request $request) {
        $resort = Resort::find($request->id);
        if ($resort->is_default == 1) {
            $resort->delete();
            $firstResort = Resort::query()->first();
            $firstResort->is_default = 1;
            $firstResort->save();
            return ['status' => true, "message" => "Resort deleted."];
        }
        if ($resort->delete()) {
            return ['status' => true, "message" => "Resort deleted."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

    public function getResortHealthcare(Request $request, $id) {
        try {
            $healthcares = \App\Models\HealthcateProgram::where(["resort_id" => $id, "is_active" => 1])->get();
            return view('admin.resort.healthcare', ['healthcares' => $healthcares]);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

    public function validateRoomNo(Request $request) {
        $isExist = ResortRoom::where(["room_no" => implode("", $request->get("room_no")), "resort_id" => $request->get("resort")])->first();
        if ($isExist) {
            echo "false";
        } else {
            echo "true";
        }
        exit;
    }

}
