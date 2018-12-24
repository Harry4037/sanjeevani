<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class OrderRequestController extends Controller {

    public function index() {
        $css = ['vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'];
        $js = ['vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'];

        return view('admin.order-request.index', ['js' => $js, 'css' => $css]);
    }

    public function orderRequestList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');

            $serviceRequests = ServiceRequest::select('id', 'comment', 'service_id', 'question_id', 'request_status_id', 'user_id')
                            ->take($limit)->offset($offset)
                            ->with([
                                'serviceDetail' => function($query) {
                                    $query->select('id', 'name', 'type_id');
                                }
                            ])->with([
                        'questionDetail' => function($query) {
                            $query->select('id', 'name');
                        }
                    ])->with([
                        'requestStatus' => function($query) {
                            $query->select('id')->userRequestStatus();
                        }
                    ])->with([
                        'userDetail'
                    ])->latest()->get();
            
            $dataArray = [];
            foreach ($serviceRequests as $key => $serviceRequest) {
                $dataArray[$key]['service_type'] = $serviceRequest->serviceDetail->serviceType->name;
                $dataArray[$key]['service_name'] = $serviceRequest->serviceDetail->name;
                $dataArray[$key]['customer_name'] = $serviceRequest->userDetail->user_name;
                $dataArray[$key]['room_no'] = $serviceRequest->userDetail->userBookingDetail->room_booking->resort_room == null ? "" : $serviceRequest->userDetail->userBookingDetail->room_booking->resort_room->room_no;
                $dataArray[$key]['status'] = $serviceRequest->requestStatus->status;
            }
            $data['recordsTotal'] = count($serviceRequests);
            $data['recordsFiltered'] = count($serviceRequests);
            $data['data'] = $dataArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function create(Request $request) {

        if ($request->isMethod("post")) {

            $place = new ResortNearbyPlace();
            $place->resort_id = $request->resort_id;
            $place->name = $request->place_name;
            $place->resort_id = $request->resort_id;
            $place->distance_from_resort = $request->distance;
            $place->description = $request->place_description;
            $place->precautions = $request->place_precaution;
            $place->address_1 = $request->address;
            $place->pincode = $request->pin_code;
            $place->city_id = $request->city;
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
        $resorts = Resort::where("is_active", 1)->get();
        return view('admin.nearby.create-nearby', ['js' => $js, 'css' => $css, 'resorts' => $resorts]);
    }

    public function uploadImages(Request $request) {

        $image = $request->file("file");
        $resort = Storage::disk('public')->put('Nearby', $image);
        if ($resort) {
            $file_name = basename($resort);
            return ["status" => true, "id" => time(), "file_name" => $file_name];
        }
    }

    public function deleteImages(Request $request) {
        $data = TempImages::find($request->record_id);
        if ($data) {
            $data->delete();
        }
    }

    public function updateStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $nearby = ResortNearbyPlace::findOrFail($request->record_id);
                $nearby->is_active = $request->status;
                if ($nearby->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function editNearby(Request $request, $id) {
        $data = ResortNearbyPlace::find($id);
        if ($request->isMethod("post")) {
            $data->resort_id = $request->resort_id;
            $data->name = $request->place_name;
            $data->distance_from_resort = $request->distance;
            $data->description = $request->place_description;
            $data->precautions = $request->place_precaution;
            $data->address_1 = $request->address;
            $data->pincode = $request->pin_code;
            $data->city_id = $request->city;
            if ($data->save()) {
                return redirect()->route('admin.nearby.edit', $id)->with('status', 'Nearby place has been updated successfully.');
            }
        }

        $resorts = Resort::where("is_active", 1)->get();
        return view('admin.nearby.edit-nearby', ['data' => $data, 'resorts' => $resorts]);
    }

}
