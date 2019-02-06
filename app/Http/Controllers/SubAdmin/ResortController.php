<?php

namespace App\Http\Controllers\SubAdmin;

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

class ResortController extends Controller {

    public function __construct(Resort $resort, ResortImage $resortImage, RoomType $roomType, ResortRoom $resortRoom, ResortRating $resortRating) {
        $this->resort = $resort;
        $this->resortImage = $resortImage;
        $this->roomType = $roomType;
        $this->resortRoom = $resortRoom;
        $this->resortRating = $resortRating;
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

            $resortRooms = ResortRoom::where(["resort_id" => $resort, "room_type_id" => $request->resort_room, "is_active" => 1])
                    ->whereNotIn("id", $roomIds)
                    ->get();
            return view('admin.resort.rooms', ['resortRooms' => $resortRooms]);
        } catch (\Exception $ex) {
            dd($ex);
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
                $data->latitude = $request->latitude;
                $data->longitude = $request->longitude;
                $data->amenities = implode("#", $request->aminities);
                $data->other_amenities = implode("#", $request->other_amenities);
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

                    return redirect()->route('subadmin.resort.edit', $id)->with('status', 'Resort has been updated successfully.');
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
            $roomTypes = $this->roomType->where("is_active", 1)->get();
            $states = StateMaster::all();
            $selectedCity = CityMaster::find($data->city_id);
            $cities = CityMaster::where("state_id", $selectedCity->state_id)->get();
            return view('subadmin.resort.edit', [
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
            return redirect()->route('subadmin.dashboard')->with('error', $ex->getMessage());
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

    public function deleteImages(Request $request) {
        @unlink('storage/resort_images/' . $request->record_val);
        return ["status" => true, "message" => "Image deleted."];
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

}
