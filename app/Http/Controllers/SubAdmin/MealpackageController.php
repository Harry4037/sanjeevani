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
            $mealCategories = Mealtype::select('id', 'name')->whereHas('menuItems', function($query) use($request) {
                        $query->where('resort_id', $request->get("subadminResort"));
                    })->with([
                        'menuItems' => function ($query) use($request) {
                            $query->select('id', 'name', 'category', 'image_name as banner_image_url', 'meal_type_id', 'price')->where('resort_id', $request->get("subadminResort"));
                        }
                    ])->get();
            return view('subadmin.meal-package.create', [
                'mealCategories' => $mealCategories,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.meal-package.index')->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $meal = MealPackage::findOrFail($request->record_id);
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

    public function editMealpackage(Request $request) {
        try {
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
                if ($request->hasFile("image_name")) {
                    $icon_image = $request->file("image_name");
                    $icon = Storage::disk('public')->put('meal_package_images', $icon_image);
                    $icon_file_name = basename($icon);
                    $data->image_name = $icon_file_name;
                }

                if ($data->save()) {
                    if ($request->meal_item) {
                        MealPackageItem::where("meal_package_id", $data->id)->delete();
                        foreach ($request->meal_item as $item) {
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

            $mealCategories = Mealtype::select('id', 'name')->whereHas('menuItems', function($query) use($request) {
                        $query->where('resort_id', $request->get("subadminResort"));
                    })->with([
                        'menuItems' => function ($query) use($request) {
                            $query->select('id', 'name', 'category', 'image_name as banner_image_url', 'meal_type_id', 'price')->where('resort_id', $request->get("subadminResort"));
                        }
                    ])->get();

            $packageItems = MealPackageItem::where("meal_package_id", $data->id)->pluck("meal_item_id")->toArray();
            $css = [
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/iCheck/icheck.min.js',
            ];
            return view('subadmin.meal-package.edit', [
                'mealCategories' => $mealCategories,
                'packageItems' => $packageItems,
                'data' => $data,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.meal-package.edit')->with('error', $ex->getMessage());
        }
    }

    public function deleteMealpackage(Request $request) {
        $meal = MealPackage::find($request->id);
        if ($meal->delete()) {
            return ['status' => true, "message" => "Pacakage deleted successfully."];
        } else {
            return ['status' => true, "message" => "Something went be wrong."];
        }
    }

}
