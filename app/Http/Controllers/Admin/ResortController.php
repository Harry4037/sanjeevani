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
            'js/admin/resorts.js'
        ];
        return view('admin.resort.index', ['js' => $js, 'css' => $css]);
    }

    public function resortList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');

            $query = $this->resort->query();
            $resorts = $query->get();
            $i = 0;
            $resortsArray = [];
            foreach ($resorts as $resort) {
                $resortsArray[$i]['name'] = $resort->name;
                $checked_status = $resort->is_active ? "checked" : '';
                $resortsArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='banner_status' id=" . $resort->id . " data-status=" . $resort->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $resortsArray[$i]['action'] = $resort->id;
                $i++;
            }
            $data['recordsTotal'] = $this->resort->count();
            $data['recordsFiltered'] = $this->resort->count();
            $data['data'] = $resortsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function create(Request $request) {

        if ($request->isMethod("post")) {
            $banner_image = $request->file("banner_image");
            $banner = Storage::disk('public')->put('Banner', $banner_image);
            $banner_file_name = basename($banner);

            $banner = $this->banner;
            $banner->name = $banner_file_name;
            $banner->is_active = $request->banner_status;
            $banner->created_by = 1;
            $banner->updated_by = 1;

            if ($banner->save()) {
                return redirect()->route('admin.banner.add')->with('status', 'Banner has been added successfully.');
            } else {
                return redirect()->route('admin.banner.add')->with('error', 'Something went be wrong.');
            }
        }
        $css = [
            "vendors/dropzone/dist/min/dropzone.min.css"
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'vendors/dropzone/dist/min/dropzone.min.js',
            'js/admin/resorts.js'
        ];
        $roomTypes = $this->roomType->all();
        return view('admin.resort.create-banner', ['js' => $js, 'css' => $css, 'roomTypes' => $roomTypes]);
    }

    public function uploadImages(Request $request) {
        $banner_image = $request->file("file");
        $banner = Storage::disk('public')->put('Resort', $banner_image);
        $banner_file_name = basename($banner);
        return $banner_file_name;
    }

    public function updateBannerStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $banner = $this->banner->findOrFail($request->record_id);
                $banner->is_active = $request->status;
                if ($banner->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
