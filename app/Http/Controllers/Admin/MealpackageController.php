<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.meal-package.index', ['js' => $js, 'css' => $css]);
    }

    public function mealpackageList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = MealPackage::query();
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
                $mealsArray[$key]['action'] = '<a href="' . route('admin.meal-package.edit', $meal->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
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
                            'resort_id' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.meal-package.index')->withErrors($validator)->withInput();
                }
                $mealPackage = new MealPackage();

                $mealPackage->name = $request->name;
                $mealPackage->category = $request->category;
                $mealPackage->price = $request->price;
                $mealPackage->resort_id = $request->resort_id;

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
                    return redirect()->route('admin.meal-package.index')->with('status', 'Meal Package has been added successfully.');
                } else {
                    return redirect()->route('admin.meal-package.index')->with('error', 'Something went be wrong.');
                }
            }

            $css = [
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/iCheck/icheck.min.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();

            return view('admin.meal-package.create', [
                'resorts' => $resorts,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.meal-package.index')->with('error', $ex->getMessage());
        }
    }

    public function getResortMeal(Request $request) {
        $mealItems = MealItem::where(["is_active" => 1, "resort_id" => $request->record_id])->get();

        return view('admin.meal-package.meal-item', [
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
                        'amenity_name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.activity.index')->withErrors($validator)->withInput();
            }
            $amenity->name = $request->amenity_name;
            $amenity->description = $request->amenity_description;
            $amenity->resort_id = $request->resort_id;
            if ($amenity->save()) {
                if ($request->amenity_images) {
                    foreach ($request->amenity_images as $tempImage) {
                        $amenityImage = new ActivityImage();
                        $amenityImage->image_name = $tempImage;
                        $amenityImage->amenity_id = $amenity->id;
                        $amenityImage->save();
                    }
                }
                if ($request->from_time && $request->to_time) {
                    ActivityTimeSlot::where("amenity_id", $amenity->id)->delete();
                    foreach ($request->from_time as $key => $fromTime) {
                        $from_time = Carbon::parse($fromTime);
                        $to_time = Carbon::parse($request->to_time[$key]);
                        $amenityTimeSlot = new ActivityTimeSlot();
                        $amenityTimeSlot->amenity_id = $amenity->id;
                        $amenityTimeSlot->from = $from_time->format("H:s:i");
                        $amenityTimeSlot->to = $to_time->format("H:s:i");
                        $amenityTimeSlot->allow_no_of_member = $request->total_people[$key];
                        $amenityTimeSlot->save();
                    }
                }


                return redirect()->route('admin.activity.index')->with('status', 'Activity has been added successfully.');
            } else {
                return redirect()->route('admin.activity.index')->with('error', 'Something went be wrong.');
            }
        }
        $resorts = Resort::where("is_active", 1)->get();

        return view('admin.meal.edit', [
            'resorts' => $resorts,
            'mealCategories' => $mealCategories,
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
