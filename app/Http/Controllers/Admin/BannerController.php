<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use App\Models\Resort;

class BannerController extends Controller {

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Banner $banner) {
        $this->banner = $banner;
    }

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.banners.index', ['js' => $js, 'css' => $css]);
    }

    public function bannersList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');

            $query = $this->banner->query();
            $banners = $query->get();
            $i = 0;
            $bannersArray = [];
            foreach ($banners as $banner) {
                $resort = Resort::find($banner->resort_id);
                $bannersArray[$i]['banner'] = '<img height="100" width="200" src=' . $banner->name . '>';
                $bannersArray[$i]['resort_name'] = $resort->name;
                $checked_status = $banner->is_active ? "checked" : '';
                $bannersArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='banner_status' id=" . $banner->id . " data-status=" . $banner->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $i++;
            }
            $data['recordsTotal'] = $this->banner->count();
            $data['recordsFiltered'] = $this->banner->count();
            $data['data'] = $bannersArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function bannerAdd(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $banner_image = $request->file("banner_image");
                $banner = Storage::disk('public')->put('banner_images', $banner_image);
                $banner_file_name = basename($banner);

                $banner = $this->banner;
                $banner->name = $banner_file_name;
                $banner->resort_id = $request->resort_id;
                $banner->is_active = $request->banner_status;
                $banner->created_by = 1;
                $banner->updated_by = 1;

                if ($banner->save()) {
                    return redirect()->route('admin.banner.index')->with('status', 'Banner has been added successfully.');
                } else {
                    return redirect()->route('admin.banner.index')->with('error', 'Something went be wrong.');
                }
            }
            $js = [
                'vendors/datatables.net/js/jquery.dataTables.min.js',
                'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();
            return view('admin.banners.add-banner', [
                'js' => $js,
                'resorts' => $resorts,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.banner.index')->with('error', $ex->getMessage());
        }
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
