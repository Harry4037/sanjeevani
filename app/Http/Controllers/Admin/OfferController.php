<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use App\Models\Resort;
use App\Models\offer;
use App\Models\offerImage;

class OfferController extends Controller {

    public function index() {
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.offer.index', ['js' => $js, 'css' => $css]);
    }

    public function offerList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = offer::query();
            if ($searchKeyword) {
                $query->where("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $offers = $query->take($limit)->offset($offset)->latest()->get();
            $i = 0;
//            dd($amenities->toArray());
            $offerArray = [];
            foreach ($offers as $key => $offer) {
                $resort = Resort::find($offer->resort_id);
                $image = offerImage::where("offer_id", $offer->id)->first();
                $offerImage = isset($image) ? $image->image_name : asset("img/no-image.jpg");
                $offerArray[$key]['image'] = '<img src=' . $offerImage . ' height=70 width=100 class="img-rounded">';
                $offerArray[$key]['name'] = $offer->name;
                $checked_status = $offer->is_active ? "checked" : '';
                $offerArray[$key]['resort_name'] = $resort->name;
                $offerArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='amenity_status' id=" . $offer->id . " data-status=" . $offer->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $offerArray[$key]['action'] = '<a href="' . route('admin.activity.edit', $offer->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $offer->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $offerArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function create(Request $request) {

        try {
            if ($request->isMethod("post")) {

                $validator = Validator::make($request->all(), [
                            'offer_name' => 'bail|required',
                            'price' => 'bail|required',
                            'discount' => 'bail|required',
                            'valid_to' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.offer.index')->withErrors($validator)->withInput();
                }
                $offer = new Offer();

                $offer->name = $request->offer_name;
                $offer->description = $request->offer_description;
                $offer->resort_id = $request->resort_id;
                $offer->price = $request->price;
                $offer->discount_percentage = $request->discount;
                $offer->calculated_discount = (((int) $request->price) * ((int) $request->discount / 100));
                $offer->valid_to = $request->valid_to;
                if ($offer->save()) {
                    if ($request->offer_images) {
                        foreach ($request->offer_images as $tempImage) {
                            $offerImage = new offerImage();
                            $offerImage->image_name = $tempImage;
                            $offerImage->offer_id = $offer->id;
                            $offerImage->save();
                        }
                    }
                    return redirect()->route('admin.offer.index')->with('status', 'Offer has been added successfully.');
                } else {
                    return redirect()->route('admin.offer.index')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                'vendors/bootstrap-daterangepicker/daterangepicker.css',
                "vendors/dropzone/dist/dropzone.css",
                "https://cdn.quilljs.com/1.0.0/quill.snow.css",
            ];
            $js = [
                'vendors/moment/min/moment.min.js',
                'vendors/bootstrap-daterangepicker/daterangepicker.js',
                'vendors/dropzone/dist/dropzone.js',
                'https://cdn.quilljs.com/1.0.0/quill.js',
            ];
            $resorts = Resort::where("is_active", 1)->get();
            return view('admin.offer.create', [
                'js' => $js,
                'css' => $css,
                'resorts' => $resorts,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.offer.index')->with('error', $ex->getMessage());
        }
    }

    public function uploadImages(Request $request) {
        $offer_image = $request->file("file");
        $offer = Storage::disk('public')->put('offer_images', $offer_image);
        if ($offer) {
            $offer_file_name = basename($offer);
            return ["status" => true, "id" => time(), "file_name" => $offer_file_name];
        }
    }

    public function deleteImages(Request $request) {
        @unlink('storage/offer_images/' . $request->record_val);
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $offer = offer::findOrFail($request->record_id);
                $offer->is_active = $request->status;
                if ($offer->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editActivity(Request $request) {
        $amenity = Activity::find($request->id);
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
        $css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
            "vendors/dropzone/dist/dropzone.css",
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
            'vendors/dropzone/dist/dropzone.js',
        ];
        $resorts = Resort::where("is_active", 1)->get();
        $amenityImages = ActivityImage::where("amenity_id", $amenity->id)->get();
        $timeSlots = ActivityTimeSlot::where("amenity_id", $amenity->id)->get();
        return view('admin.activity.edit', [
            'css' => $css,
            'js' => $js,
            'resorts' => $resorts,
            'amenityImages' => $amenityImages,
            'amenity' => $amenity,
            'timeSlots' => $timeSlots,
        ]);
    }

    public function deleteActivityImage(Request $request) {
        try {
            $amenityImage = ActivityImage::select('image_name as amenity_img')->find($request->record_id);
            @unlink('storage/activity_images/' . $amenityImage->amenity_img);
            ActivityImage::find($request->record_id)->delete();
            return ["status" => true];
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteTimeSlot(Request $request) {
        try {
            $slot = ActivityTimeSlot::find($request->record_id);
            if ($slot) {
                $slot->delete();
                return ["status" => true];
            } else {
                return ["status" => false];
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteActivity(Request $request) {
        $amenity = Activity::find($request->id);
        if ($amenity->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
