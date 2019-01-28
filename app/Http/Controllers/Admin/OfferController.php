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
            $query->withTrashed()->with("resortDetail");
            if ($searchKeyword) {
                $query->whereHas("resortDetail", function($query) use($searchKeyword) {
                    $query->where("name", "LIKE", "%$searchKeyword%");
                })->orWhere("name", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $offers = $query->take($limit)->offset($offset)->latest()->get();
            $i = 0;
            $offerArray = [];
            foreach ($offers as $key => $offer) {
                $image = offerImage::where("offer_id", $offer->id)->first();
                $offerImage = isset($image) ? $image->image_name : asset("img/no-image.jpg");
                $offerArray[$key]['image'] = '<img src=' . $offerImage . ' height=70 width=100 class="img-rounded">';
                $offerArray[$key]['name'] = $offer->name;
                $checked_status = $offer->is_active ? "checked" : '';
                $offerArray[$key]['resort_name'] = isset($offer->resortDetail->name) ? $offer->resortDetail->name : "Generalized Offer";
                $offerArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='offer_status' id=" . $offer->id . " data-status=" . $offer->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $offerArray[$key]['action'] = '<a href="' . route('admin.offer.edit', $offer->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
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

    public function editOffer(Request $request) {
        $amenity = offer::find($request->id);
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

            $amenity->name = $request->offer_name;
            $amenity->description = $request->offer_description;
            $amenity->resort_id = $request->resort_id;
            $amenity->price = $request->price;
            $amenity->discount_percentage = $request->discount;
            $amenity->calculated_discount = (((int) $request->price) * ((int) $request->discount / 100));
            $amenity->valid_to = $request->valid_to;
            if ($amenity->save()) {
                if ($request->offer_images) {
                    foreach ($request->offer_images as $tempImage) {
                        $offerImage = new offerImage();
                        $offerImage->image_name = $tempImage;
                        $offerImage->offer_id = $amenity->id;
                        $offerImage->save();
                    }
                }
                return redirect()->route('admin.offer.index')->with('status', 'Offer has been updated successfully.');
            } else {
                return redirect()->route('admin.offer.index')->with('error', 'Something went be wrong.');
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
        $amenityImages = offerImage::where("offer_id", $amenity->id)->get();
        return view('admin.offer.edit', [
            'css' => $css,
            'js' => $js,
            'resorts' => $resorts,
            'amenityImages' => $amenityImages,
            'amenity' => $amenity,
        ]);
    }

    public function deleteOfferImage(Request $request) {
        try {
            $amenityImage = offerImage::select('image_name as amenity_img')->find($request->record_id);
            @unlink('storage/offer_images/' . $amenityImage->amenity_img);
            offerImage::find($request->record_id)->delete();
            return ["status" => true];
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteOffer(Request $request) {
        $amenity = offer::find($request->id);
        if ($amenity->delete()) {
            return ['status' => true];
        } else {
            return ['status' => true];
        }
    }

}
