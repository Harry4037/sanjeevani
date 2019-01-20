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
        return view('subadmin.meal-category.index', ['js' => $js, 'css' => $css]);
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
                $mealtypeArray[$key]['action'] = '<a href="' . route('subadmin.meal-category.edit', $mealType->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $mealType->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $mealtypeArray;
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
                    return redirect()->route('subadmin.meal-category.index')->withErrors($validator)->withInput();
                }
                $mealType = new MealType();

                $mealType->name = $request->name;
                if ($mealType->save()) {
                    return redirect()->route('subadmin.meal-category.index')->with('status', 'Meal Category has been added successfully.');
                } else {
                    return redirect()->route('subadmin.meal-category.index')->with('error', 'Something went be wrong.');
                }
            }
            return view('subadmin.meal-category.create');
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.meal-category.index')->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $mealcategory = MealType::findOrFail($request->record_id);
                $mealcategory->is_active = $request->status;
                if ($mealcategory->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                } else {
                    return ['status' => false, "message" => "Somethig went be wrong."];
                }
            }
        } catch (\Exception $e) {
            return ['status' => false, "message" => $e->getMessage()];
        }
    }

    public function editMealcategory(Request $request) {
        $data = MealType::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.meal-category.index')->withErrors($validator)->withInput();
            }
            $data->name = $request->name;
            if ($data->save()) {
                return redirect()->route('subadmin.meal-category.index')->with('status', 'Meal category has been added successfully.');
            } else {
                return redirect()->route('subadmin.meal-category.index')->with('error', 'Something went be wrong.');
            }
        }

        return view('subadmin.meal-category.edit', [
            'data' => $data,
        ]);
    }

    public function deleteMealcategory(Request $request) {
        $mealCategory = MealType::find($request->id);
        if ($mealCategory->delete()) {
            return ['status' => true, "message" => "Meal category deleted successfully."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

}
