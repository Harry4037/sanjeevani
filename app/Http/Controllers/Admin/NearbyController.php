<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\Resort;
use App\Models\ResortNearbyPlace;
use App\Models\NearbyPlaceImage;
use App\Models\StateMaster;
use App\Models\CityMaster;
use Illuminate\Validation\Rule;

class NearbyController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('admin.nearby.index', ['js' => $js, 'css' => $css]);
    }

    public function nearbyList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = ResortNearbyPlace::query();
            $query->with("resortDetail");
            if ($searchKeyword) {
                $query->whereHas("resortDetail", function($query) use($searchKeyword) {
                            $query->where("name", "LIKE", "%$searchKeyword%");
                        })->orWhere("name", "LIKE", "%$searchKeyword%")
                        ->orWhere("distance_from_resort", "LIKE", "%$searchKeyword%");
            }

            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $nearbys = $query->take($limit)->offset($offset)->latest()->get();
            $nearbyArray = [];
            foreach ($nearbys as $key => $nearby) {
                $nearbyArray[$key]['name'] = $nearby->name;
                $checked_status = $nearby->is_active ? "checked" : '';
                $nearbyArray[$key]['distance'] = $nearby->distance_from_resort;
                $nearbyArray[$key]['resort_name'] = $nearby->resortDetail ? $nearby->resortDetail->name : "";
                $nearbyArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='nearby_status' id=" . $nearby->id . " data-status=" . $nearby->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $nearbyArray[$key]['action'] = '<a href="' . route('admin.nearby.edit', $nearby->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $nearby->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }
            $data['data'] = $nearbyArray;
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'resort_id' => 'bail|required',
                            'place_name' => [
                                'bail',
                                'required',
                                Rule::unique('resort_nearby_places', 'name')->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->place_name, 'resort_id' => $request->resort_id])
                                                    ->whereNull('deleted_at');
                                        }),
                            ],
                            'distance' => 'bail|required',
                            'place_description' => 'bail|required',
                            'place_precaution' => 'bail|required',
                            'address' => 'bail|required',
                            'city' => 'bail|required',
                            'pin_code' => 'bail|required',
                            'latitude' => 'bail|required',
                            'longitude' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.nearby.add')->withErrors($validator)->withInput();
                }


                $place = new ResortNearbyPlace();
                $place->name = $request->place_name;
                $place->resort_id = $request->resort_id;
                $place->distance_from_resort = $request->distance;
                $place->description = $request->place_description;
                $place->precautions = $request->place_precaution;
                $place->address_1 = $request->address;
                $place->pincode = $request->pin_code;
                $place->city_id = $request->city;
                $place->latitude = $request->latitude;
                $place->longitude = $request->longitude;
                if ($place->save()) {
                    if ($request->nearby_images) {
                        foreach ($request->nearby_images as $tempImage) {
                            $resortImage = new NearbyPlaceImage();
                            $resortImage->nearby_place_id = $place->id;
                            $resortImage->name = $tempImage;
                            $resortImage->is_active = 1;
                            $resortImage->save();
                        }
                    }

                    return redirect()->route('admin.nearby.index')->with('status', 'Nearby place has been added successfully.');
                } else {
                    return redirect()->route('admin.nearby.add')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/datatables.net/js/jquery.dataTables.min.js',
                'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'vendors/dropzone/dist/dropzone.js',
            ];
            $states = StateMaster::all();
            $resorts = Resort::where("is_active", 1)->get();
            return view('admin.nearby.create-nearby', [
                'js' => $js,
                'css' => $css,
                'resorts' => $resorts,
                'states' => $states
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.nearby.index')->with('error', $ex->getMessage());
        }
    }

    public function uploadImages(Request $request) {

        $image = $request->file("file");
        $resort = Storage::disk('public')->put('nearby_images', $image);
        if ($resort) {
            $file_name = basename($resort);
            return ["status" => true, "id" => time(), "file_name" => $file_name];
        }
    }

    public function deleteImages(Request $request) {
        @unlink('storage/nearby_images/' . $request->record_val);
        return ['status' => true, "message" => "image deleted."];
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $nearby = ResortNearbyPlace::find($request->record_id);
                $nearby->is_active = $request->status;
                if ($nearby->save()) {
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

    public function editNearby(Request $request, $id) {
        try {
            $data = ResortNearbyPlace::find($id);
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'place_name' => [
                                'bail',
                                'required',
                                Rule::unique('resort_nearby_places', 'name')->ignore($id)->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->place_name, 'resort_id' => $request->resort_id])
                                                    ->whereNull('deleted_at');
                                        }),
                            ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.nearby.add')->withErrors($validator)->withInput();
                }

                $data->resort_id = $request->resort_id;
                $data->name = $request->place_name;
                $data->distance_from_resort = $request->distance;
                $data->description = $request->place_description;
                $data->precautions = $request->place_precaution;
                $data->address_1 = $request->address;
                $data->pincode = $request->pin_code;
                $data->city_id = $request->city;
                $data->latitude = $request->latitude;
                $data->longitude = $request->longitude;
                if ($data->save()) {
                    if ($request->nearby_images) {
                        foreach ($request->nearby_images as $tempImage) {
                            $resortImage = new NearbyPlaceImage();
                            $resortImage->nearby_place_id = $data->id;
                            $resortImage->name = $tempImage;
                            $resortImage->is_active = 1;
                            $resortImage->save();
                        }
                    }
                    return redirect()->route('admin.nearby.edit', $id)->with('status', 'Nearby place has been updated successfully.');
                }
            }

            $css = [
                "vendors/dropzone/dist/dropzone.css",
            ];
            $js = [
                'vendors/datatables.net/js/jquery.dataTables.min.js',
                'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'vendors/dropzone/dist/dropzone.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();
            $states = StateMaster::all();
            $selectedCity = CityMaster::find($data->city_id);
            $cities = CityMaster::where("state_id", $selectedCity->state_id)->get();
            $nearbyImages = NearbyPlaceImage::where("nearby_place_id", $data->id)->get();
            return view('admin.nearby.edit-nearby', [
                'css' => $css,
                'js' => $js,
                'data' => $data,
                'resorts' => $resorts,
                'states' => $states,
                'nearbyImages' => $nearbyImages,
                'selectedCity' => $selectedCity,
                'cities' => $cities,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.nearby.index', $id)->with('error', $ex->getMessage());
        }
    }

    public function deleteNearbyImage(Request $request) {
        try {
            $nearbyImage = NearbyPlaceImage::select('name as nearby_img')->find($request->record_id);
            @unlink('storage/nearby_images/' . $nearbyImage->nearby_img);
            NearbyPlaceImage::find($request->record_id)->delete();
            return ['status' => true, "message" => "image deleted."];
        } catch (\Exception $ex) {
            return ['status' => true, "message" => $ex->getMessage()];
        }
    }

    public function deleteNearby(Request $request) {
        $resortNearby = ResortNearbyPlace::find($request->id);
        if ($resortNearby->delete()) {
            return ['status' => true, "message" => "Nearby Place deleted."];
        } else {
            return ['status' => false, "message" => "Something went be wrong."];
        }
    }

}
