<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\MealType;
use App\Models\Resort;
use Illuminate\Validation\Rule;

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

            $query = MealType::query()->with('resort');
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $mealTypes = $query->take($limit)->offset($offset)->latest()->get();

            $mealtypeArray = [];
            foreach ($mealTypes as $key => $mealType) {
                $mealtypeArray[$key]['name'] = $mealType->name;
                $mealtypeArray[$key]['resort_name'] = $mealType->resort ? $mealType->resort->name : '';
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
                            'name' => [
                                'bail',
                                'required',
                                Rule::unique('meal_types')->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->name, 'resort_id' => $request->resort_id])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.meal-category.add')->withErrors($validator)->withInput();
                }

                $existMeal = MealType::where(["name" => $request->name])->first();
                if ($existMeal) {
                    return redirect()->route('admin.meal-category.add')->with('error', 'Meal category already exist with these details.')->withInput();
                }
                $mealType = new MealType();

                $mealType->name = $request->name;
                $mealType->resort_id = $request->resort_id;
                if ($mealType->save()) {
                    return redirect()->route('admin.meal-category.index')->with('status', 'Meal Category has been added successfully.');
                } else {
                    return redirect()->route('admin.meal-category.index')->with('error', 'Something went be wrong.');
                }
            }
            $resorts = Resort::where("is_active", 1)->get();
            return view('admin.meal-category.create', [
                'resorts' => $resorts
            ]);
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

    public function editMealcategory(Request $request) {
        $data = MealType::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'name' => [
                            'bail',
                            'required',
                            Rule::unique('meal_types')->ignore($request->id)->where(function ($query) use($request) {
                                        return $query->where(['name' => $request->name, 'resort_id' => $request->resort_id])
                                                        ->whereNull('deleted_at');
                                    }),
                        ],
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.meal-category.edit', $data->id)->withErrors($validator)->withInput();
            }
            $data->name = $request->name;
            $data->resort_id = $request->resort_id;
            if ($data->save()) {
                return redirect()->route('admin.meal-category.index')->with('status', 'Meal category has been updated successfully.');
            } else {
                return redirect()->route('admin.meal-category.index')->with('error', 'Something went be wrong.');
            }
        }
        $resorts = Resort::where("is_active", 1)->get();
        return view('admin.meal-category.edit', [
            'data' => $data,
            'resorts' => $resorts,
        ]);
    }

    public function deleteMealcategory(Request $request) {
        $mealCategory = MealType::find($request->id);
        if ($mealCategory->delete()) {
            return ['status' => true, "message" => "Meal category deleted."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

    public function getResortMealCategory(Request $request, $id) {
        $categories = MealType::where(["is_active" => 1, "resort_id" => $id])->get();
        return view('admin.meal-category.resort-category', [
            'categories' => $categories
        ]);
    }

}
