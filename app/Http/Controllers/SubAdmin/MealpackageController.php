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
use App\Models\MealPackage;
use App\Models\MealPackageItem;

class MealpackageController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('subadmin.meal-package.index', ['js' => $js, 'css' => $css]);
    }

    public function mealpackageList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = MealPackage::query();
            $query->where("resort_id", $request->get("subadminResort"));
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $meals = $query->take($limit)->offset($offset)->latest()->get();
            $mealsArray = [];
            foreach ($meals as $key => $meal) {
                $resort = Resort::find($meal->resort_id);
                $mealImage = $meal->image_name ? $meal->image_name : asset("img/no-image.jpg");
                $mealsArray[$key]['image'] = '<img src=' . $mealImage . ' height=70 width=100 class="img-rounded">';
                $mealsArray[$key]['name'] = $meal->name;
                $checked_status = $meal->is_active ? "checked" : '';
                $mealsArray[$key]['resort_name'] = $resort->name;
                $mealsArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='meal_package_status' id=" . $meal->id . " data-status=" . $meal->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $mealsArray[$key]['action'] = '<a href="' . route('subadmin.meal-package.edit', $meal->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $meal->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $mealsArray;
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
                            'price' => 'bail|required',
                            'category' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('subadmin.meal-package.index')->withErrors($validator)->withInput();
                }
                $mealPackage = new MealPackage();

                $mealPackage->name = $request->name;
                $mealPackage->category = $request->category;
                $mealPackage->price = $request->price;
                $mealPackage->resort_id = $request->get("subadminResort");

                if ($request->hasFile("image_name")) {
                    $icon_image = $request->file("image_name");
                    $icon = Storage::disk('public')->put('meal_package_images', $icon_image);
                    $icon_file_name = basename($icon);
                    $mealPackage->image_name = $icon_file_name;
                }

                if ($mealPackage->save()) {
                    if ($request->meal_item) {
                        foreach ($request->meal_item as $item) {
                            $mealPackageItem = new MealPackageItem();
                            $mealPackageItem->meal_package_id = $mealPackage->id;
                            $mealPackageItem->meal_item_id = $item;
                            $mealPackageItem->save();
                        }
                    }
                    return redirect()->route('subadmin.meal-package.index')->with('status', 'Meal Package has been added successfully.');
                } else {
                    return redirect()->route('subadmin.meal-package.index')->with('error', 'Something went be wrong.');
                }
            }

            $css = [
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/iCheck/icheck.min.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();

            return view('subadmin.meal-package.create', [
                'resorts' => $resorts,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.meal-package.index')->with('error', $ex->getMessage());
        }
    }

    public function getResortMeal(Request $request) {
        $mealItems = MealItem::where(["is_active" => 1, "resort_id" => $request->record_id])->get();

        return view('subadmin.meal-package.meal-item', [
            'mealItems' => $mealItems,
        ]);
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $meal = MealPackage::findOrFail($request->record_id);
                $meal->is_active = $request->status;
                if ($meal->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editMealpackage(Request $request) {
        $data = MealPackage::find($request->id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                        'name' => 'bail|required',
                        'price' => 'bail|required',
                        'category' => 'bail|required',
                        
            ]);
            if ($validator->fails()) {
                return redirect()->route('subadmin.meal-package.index')->withErrors($validator)->withInput();
            }
            $data->name = $request->name;
            $data->category = $request->category;
            $data->price = $request->price;
//            $data->resort_id = $request->resort_id;
            if ($request->hasFile("image_name")) {
                $icon_image = $request->file("image_name");
                $icon = Storage::disk('public')->put('meal_package_images', $icon_image);
                $icon_file_name = basename($icon);
                $data->image_name = $icon_file_name;
            }

            if ($data->save()) {
                if ($request->meal_item) {
                    foreach ($request->meal_item as $item) {
                        MealPackageItem::where("meal_package_id", $data->id)->delete();
                        $mealPackageItem = new MealPackageItem();
                        $mealPackageItem->meal_package_id = $data->id;
                        $mealPackageItem->meal_item_id = $item;
                        $mealPackageItem->save();
                    }
                }

                return redirect()->route('subadmin.meal-package.index')->with('status', 'Package has been updated successfully.');
            } else {
                return redirect()->route('subadmin.meal-package.index')->with('error', 'Something went be wrong.');
            }
        }

        $resorts = Resort::where("is_active", 1)->get();
        $resortMeals = MealItem::where("resort_id", $data->resort_id)->get();
        return view('subadmin.meal-package.edit', [
            'resorts' => $resorts,
            'resortMeals' => $resortMeals,
            'data' => $data
        ]);
    }

    public function deleteMealpackage(Request $request) {
        $meal = MealPackage::find($request->id);
        if ($meal->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
