<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\Cms;


class CmsController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.cms.index', ['js' => $js, 'css' => $css]);
    }

    public function cmsList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Cms::query();
            if ($searchKeyword) {
                $query->where("page_name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $cms = $query->take($limit)->offset($offset)->latest()->get();
            $cmsArray = [];
            foreach ($cms as $key => $cm) {
                $cmsArray[$key]['page_name'] = $cm->page_name;
                $cmsArray[$key]['action'] = '<a href="' . route('admin.cms.edit', $cm->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
            }

            $data['data'] = $cmsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editCms(Request $request) {
        $cms = Cms::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'content' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.cms.index')->withErrors($validator)->withInput();
            }
            $cms->content = $request->content;
            
            if ($cms->save()) {
                
                return redirect()->route('admin.cms.edit', $cms->id)->with('status', 'Page has been updated successfully.');
            } else {
                return redirect()->route('admin.activity.index')->with('error', 'Something went be wrong.');
            }
        }
        return view('admin.cms.edit', [
            'cms' => $cms,
        ]);
    }

}
