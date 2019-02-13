<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\RoomType;
use App\Models\RoomtypeImage;
use Validator;

class RoomtypeController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.room.index', ['js' => $js, 'css' => $css]);
    }

    public function roomList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = RoomType::query();
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $rooms = $query->take($limit)->offset($offset)->latest()->get();
            $roomsArray = [];
            foreach ($rooms as $key => $room) {
                $roomImage = RoomtypeImage::where("roomtype_id", $room->id)->first();
                $img = !empty($roomImage->image_name) ? $roomImage->image_name : asset('img/noimage.png');
                $roomsArray[$key]['image'] = "<img class='img-rounded' width=80 height=70 src='" . $img . "'>";
                $roomsArray[$key]['name'] = $room->name;
                $checked_status = $room->is_active ? "checked" : '';
                $roomsArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='room_status' id=" . $room->id . " data-status=" . $room->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $roomsArray[$key]['action'] = '<a href="' . route('admin.room.edit', $room->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $room->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $roomsArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'name' => 'bail|required',
                            'room_icon' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.room.add')->withErrors($validator)->withInput();
                }

                $room = new RoomType();
                $room->name = $request->name;
                $room->description = $request->description;
                if ($request->file("room_icon")) {
                    $room_icon = Storage::disk('public')->put('room_icon', $request->file("room_icon"));
                    if ($room_icon) {
                        $room_icon_name = basename($room_icon);
                        $room->icon = $room_icon_name;
                    }
                }
                if ($room->save()) {
                    if ($request->room_images) {
                        foreach ($request->room_images as $tempImage) {
                            $roomImage = new RoomtypeImage();
                            $roomImage->roomtype_id = $room->id;
                            $roomImage->image_name = $tempImage;
                            $roomImage->is_active = 1;
                            $roomImage->save();
                        }
                    }
                    return redirect()->route('admin.room.index')->with('status', 'Room Type has been added successfully.');
                } else {
                    return redirect()->route('admin.room.add')->with('error', 'Something went be wrong.');
                }
            }
            $css = ["vendors/dropzone/dist/dropzone.css",];
            $js = ['vendors/dropzone/dist/dropzone.js',];
            return view('admin.room.create', [
                'js' => $js,
                'css' => $css
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.room.index')->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $room = RoomType::findOrFail($request->record_id);
                $room->is_active = $request->status;
                if ($room->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status updated successfully"]];
                } else {
                    return ['status' => false, 'message' => "Something went be wrong."];
                }
            } else {
                return ['status' => false, 'message' => "Method not allowed."];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function uploadImages(Request $request) {
        $room_image = $request->file("file");
        $room = Storage::disk('public')->put('room_images', $room_image);
        if ($room) {
            $room_file_name = basename($room);
            return ["status" => true, "id" => time(), "file_name" => $room_file_name];
        }
    }

    public function deleteImages(Request $request) {
        @unlink('storage/room_images/' . $request->record_val);
        return ["status" => true, "message" => "Image deleted."];
    }

    public function editRoom(Request $request, $id) {
        try {
            $data = RoomType::find($id);
            if ($request->isMethod("post")) {
                $data->name = $request->name;
                $data->description = $request->description;
                if ($request->file("room_icon")) {
                    $room_icon = Storage::disk('public')->put('room_icon', $request->file("room_icon"));
                    if ($room_icon) {
                        $room_icon_name = basename($room_icon);
                        $data->icon = $room_icon_name;
                    }
                }
                if ($data->save()) {
                    if ($request->room_images) {
                        foreach ($request->room_images as $tempImage) {
                            $roomImage = new RoomtypeImage();
                            $roomImage->roomtype_id = $data->id;
                            $roomImage->image_name = $tempImage;
                            $roomImage->is_active = 1;
                            $roomImage->save();
                        }
                    }
                    return redirect()->route('admin.room.edit', $id)->with('status', 'Room Type has been updated successfully.');
                }
            }
            $css = [
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/dropzone/dist/dropzone.js',
            ];
            $roomImages = RoomtypeImage::where("roomtype_id", $data->id)->get();

            return view('admin.room.edit', [
                'data' => $data,
                'css' => $css,
                'js' => $js,
                'roomImages' => $roomImages,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.room.index')->with('error', $ex->getMessage());
        }
    }

    public function deleteRoom(Request $request) {
        $room = RoomType::find($request->id);
        if ($room->delete()) {
            return ['status' => true, "message" => "Room type deleted successfully."];
        } else {
            return ['status' => false, "message" => "Something went bo wrong."];
        }
    }

    public function deleteRoomImage(Request $request) {
        try {
            $roomImage = RoomtypeImage::select('image_name as resort_img')->find($request->record_id);
            @unlink('storage/room_images/' . $roomImage->resort_img);
            RoomtypeImage::find($request->record_id)->delete();
            return ["status" => true, "message" => "Image deleted."];
        } catch (\Exception $ex) {
            return ["status" => false, "message" => $ex->getMessage()];
        }
    }

}
