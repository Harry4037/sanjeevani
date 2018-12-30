<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\MealType;

class MealcategoryController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.meal-category.index', ['js' => $js, 'css' => $css]);
    }

    public function categoryList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = MealType::query();
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $mealTypes = $query->take($limit)->offset($offset)->latest()->get();

            $mealtypeArray = [];
            foreach ($mealTypes as $key => $mealType) {
                $mealtypeArray[$key]['name'] = $mealType->name;
                $checked_status = $mealType->is_active ? "checked" : '';
                $mealtypeArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='mealcategory_status' id=" . $mealType->id . " data-status=" . $mealType->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $mealtypeArray[$key]['action'] = '<a href="' . route('admin.meal-category.edit', $mealType->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $mealType->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $mealtypeArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function create(Request $request) {

        try {
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'name' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.meal-category.index')->withErrors($validator)->withInput();
                }
                $mealType = new MealType();

                $mealType->name = $request->name;
                if ($mealType->save()) {
                    return redirect()->route('admin.meal-category.index')->with('status', 'Meal Category has been added successfully.');
                } else {
                    return redirect()->route('admin.meal-category.index')->with('error', 'Something went be wrong.');
                }
            }
            return view('admin.meal-category.create');
        } catch (\Exception $ex) {
            return redirect()->route('admin.meal-category.index')->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $mealcategory = MealType::findOrFail($request->record_id);
                $mealcategory->is_active = $request->status;
                if ($mealcategory->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editMealcategory(Request $request) {
        $data = MealType::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.meal-category.index')->withErrors($validator)->withInput();
            }
            $data->name = $request->name;
            if ($data->save()) {
                return redirect()->route('admin.meal-category.index')->with('status', 'Meal category has been added successfully.');
            } else {
                return redirect()->route('admin.meal-category.index')->with('error', 'Something went be wrong.');
            }
        }

        return view('admin.meal-category.edit', [
            'data' => $data,
        ]);
    }

    public function deleteMealcategory(Request $request) {
        $mealCategory = MealType::find($request->id);
        if ($mealCategory->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
