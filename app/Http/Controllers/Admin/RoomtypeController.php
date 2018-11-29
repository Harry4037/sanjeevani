<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\RoomType;
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
            $data['recordsTotal'] = RoomType::count();
            $data['recordsFiltered'] = RoomType::count();
            $rooms = $query->take($limit)->offset($offset)->latest()->get();
            $roomsArray = [];
            foreach ($rooms as $key => $room) {

                $img = !empty($room->image) ? $room->image : asset('img/noimage.png');
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
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.room.add')->withErrors($validator)->withInput();
                }

                $room = new RoomType();
                $room->name = $request->name;
                $room->description = $request->description;

                if ($room->save()) {
                    if ($request->file("room_image")) {
                        $room_image = Storage::disk('public')->put('room_images', $request->file("room_image"));
                        if ($room_image) {
                            $room_image_name = basename($room_image);
                            $room->image = $room_image_name;
                            $room->save();
                        }
                    }


                    return redirect()->route('admin.room.index')->with('status', 'Room Type has been added successfully.');
                } else {
                    return redirect()->route('admin.room.add')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.room.create');
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
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editRoom(Request $request, $id) {
        try {
            $data = RoomType::find($id);
            if ($request->isMethod("post")) {

                $data->name = $request->name;
                $data->description = $request->description;
                if ($data->save()) {
                    if ($request->file("room_image")) {
                        $room_image = Storage::disk('public')->put('room_images', $request->file("room_image"));
                        if ($room_image) {
                            $room_image_name = basename($room_image);
                            $data->image = $room_image_name;
                            $data->save();
                        }
                    }
                    return redirect()->route('admin.room.edit', $id)->with('status', 'Romm Type has been updated successfully.');
                }
            }
            return view('admin.room.edit', [
                'data' => $data
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.room.index')->with('error', $ex->getMessage());
        }
    }

    public function deleteRoom(Request $request) {
        $room = RoomType::find($request->id);
        if ($room->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
