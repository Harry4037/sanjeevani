<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\Resort;
use App\Models\MealType;
use App\Models\MealItem;

class MealController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('subadmin.meal.index', ['js' => $js, 'css' => $css]);
    }

    public function mealList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = MealItem::query();
            $query->where("resort_id", $request->get("subadminResort"));
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $meals = $query->take($limit)->offset($offset)->latest()->get();
            $mealsArray = [];
            foreach ($meals as $key => $meal) {
                $mealImage = $meal->image_name ? $meal->image_name : asset("img/no-image.jpg");
                $mealsArray[$key]['image'] = '<img src=' . $mealImage . ' height=70 width=100 class="img-rounded">';
                $mealsArray[$key]['name'] = $meal->name;
                $checked_status = $meal->is_active ? "checked" : '';
                $mealsArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='meal_status' id=" . $meal->id . " data-status=" . $meal->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $mealsArray[$key]['action'] = '<a href="' . route('subadmin.meal.edit', $meal->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $meal->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $mealsArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request) {

        try {
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'meal_name' => 'bail|required',
                            'meal_price' => 'bail|required',
                            'meal_category_id' => 'bail|required',
                            'meal_type' => 'bail|required',
                            'meal_image' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('subadmin.meal.index')->withErrors($validator)->withInput();
                }
                $meal = new MealItem();

                $meal->resort_id = $request->get("subadminResort");
                $meal->name = $request->meal_name;
                $meal->meal_type_id = $request->meal_category_id;
                $meal->category = $request->meal_type;
                $meal->name = $request->meal_name;
                $meal->price = $request->meal_price;
                if ($request->hasFile("meal_image")) {
                    $icon_image = $request->file("meal_image");
                    $icon = Storage::disk('public')->put('meal_images', $icon_image);
                    $icon_file_name = basename($icon);
                    $meal->image_name = $icon_file_name;
                }

                if ($meal->save()) {
                    return redirect()->route('subadmin.meal.index')->with('status', 'Meal has been added successfully.');
                } else {
                    return redirect()->route('subadmin.meal.index')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                'vendors/bootstrap-daterangepicker/daterangepicker.css',
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/moment/min/moment.min.js',
                'vendors/bootstrap-daterangepicker/daterangepicker.js',
                'vendors/dropzone/dist/dropzone.js',
            ];
            $mealCategories = MealType::where("is_active", 1)->get();
            return view('subadmin.meal.create', [
                'js' => $js,
                'css' => $css,
                'mealCategories' => $mealCategories,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.meal.index')->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $meal = MealItem::findOrFail($request->record_id);
                $meal->is_active = $request->status;
                if ($meal->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
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

    public function editMeal(Request $request) {
        $data = MealItem::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'meal_name' => 'bail|required',
                        'meal_price' => 'bail|required',
                        'meal_category_id' => 'bail|required',
                        'meal_type' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.meal.index')->withErrors($validator)->withInput();
            }

            $data->name = $request->meal_name;
            $data->meal_type_id = $request->meal_category_id;
            $data->category = $request->meal_type;
            $data->name = $request->meal_name;
            $data->price = $request->meal_price;
            if ($request->hasFile("meal_image")) {
                $icon_image = $request->file("meal_image");
                $icon = Storage::disk('public')->put('meal_images', $icon_image);
                $icon_file_name = basename($icon);
                $data->image_name = $icon_file_name;
            }

            if ($data->save()) {
                return redirect()->route('subadmin.meal.edit', $data->id)->with('status', 'Meal has been updated successfully.');
            } else {
                return redirect()->route('subadmin.meal.index')->with('error', 'Something went be wrong.');
            }
        }
        $mealCategories = MealType::where("is_active", 1)->get();
        return view('subadmin.meal.edit', [
            'mealCategories' => $mealCategories,
            'data' => $data
        ]);
    }

    public function deleteMeal(Request $request) {
        $meal = MealItem::find($request->id);
        if ($meal->delete()) {
            return ['status' => true, "message" => "Meal deleted successfully."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

}
