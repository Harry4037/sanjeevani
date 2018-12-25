<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserBookingDetail;
use App\Models\RoomBooking;
use App\Models\Resort;
use App\Models\HealthcateProgram;

class BookingController extends Controller {

    public function index() {
    	$css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        $users = User::where("is_active", 1)->where('user_type_id',3)->get();
        return view('admin.booking.index', ['js' => $js, 'css' => $css, "users" => $users]);
    }

    public function userBookings(Request $request, $user_id){
    	try{


    	$offset = $request->get('start') ? $request->get('start') : 0;
        $limit = $request->get('length');
        $searchKeyword = $request->get('search')['value'];

    	$query = UserBookingDetail::query();
    	$data['recordsTotal'] = $query->where("user_id", $user_id)->count();
        $data['recordsFiltered'] = $query->where("user_id", $user_id)->count();
    	$userBookingDetails = $query->where("user_id", $user_id)->get();
    	$bookinDetailArray = [];
    	foreach($userBookingDetails as $i => $userBookingDetail){  
    		$resort = Resort::find($userBookingDetail->resort_id);
    		$healthCareProgram = HealthcateProgram::find($userBookingDetail->package_id);
    		$roomBooking = RoomBooking::where("booking_id", $userBookingDetail->id)->first();
    		$currentDataTime = strtotime(date("d-m-Y H:i:s"));
    		$checkInTime = strtotime($roomBooking->check_in);
    		$checkOutTime = strtotime($roomBooking->check_out);
    		$stat = "";
    		if($checkInTime > $currentDataTime){
    			$stat = "Upcoming";
    		}elseif($checkInTime < $currentDataTime){
    			$stat = "Completed";
    		}else{
    			$stat = "Onging";
    		}
    		$bookinDetailArray[$i]["resort"] = isset($resort->name) ? $resort->name : "";
    		$bookinDetailArray[$i]["package"] = isset($healthCareProgram->name) ? $healthCareProgram->name : "";
    		$bookinDetailArray[$i]["check_in"] = isset($roomBooking->check_in) ? $roomBooking->check_in : "";
    		$bookinDetailArray[$i]["check_out"] = isset($roomBooking->check_out) ? $roomBooking->check_out : "";

    		$bookinDetailArray[$i]["status"] = $stat;

    	}
    	$data["data"] = $bookinDetailArray;

    	return $data;
    } catch (\Exception $e) {
            dd($e);
        }
    }

    public function createBooking(Request $request){
    	try{
    	if($request->isMethod("post")){
    		$validator = Validator::make($request->all(), [
                            'user' => 'bail|required',
                            'booking_source_name' => 'bail|required',
                            'booking_source_id' => 'bail|required',
                            'check_in' => 'bail|required',
                            'check_out' => 'bail|required',
                            'resort_id' => 'bail|required',
                            'resort_room_type' => 'bail|required',
                            'resort_room_id' => 'bail|required',
                            'package_id' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.booking.create')->withErrors($validator)->withInput();
                }

            $user = User::find($request->user);
            if(!$user){
            	return redirect()->route('admin.booking.create')->withErrors("user not found.")->withInput();
            }

            $UserBookingDetail = new UserBookingDetail();
            $UserBookingDetail->source_name = $request->booking_source_name;
            $UserBookingDetail->source_id = $request->booking_source_id;
            $UserBookingDetail->user_id = $user->id;
            $UserBookingDetail->resort_id = $request->resort_id;
            $UserBookingDetail->package_id = $request->package_id;
            if($UserBookingDetail->save()){
            	$RoomBooking = new RoomBooking();
            	$RoomBooking->booking_id = $UserBookingDetail->id;
            	$RoomBooking->room_type_id = $request->resort_room_type;
            	$RoomBooking->resort_room_id = $request->resort_room_id;
            	$check_in_date = Carbon::parse($request->check_in);
                $RoomBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
                $check_out_date = Carbon::parse($request->check_out);
                $RoomBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
            	$RoomBooking->save();
            	return redirect()->route('admin.booking.index')->with('status', 'booking created successfully.');
            }else{
            return redirect()->route('admin.booking.create')->withErrors("Something went be wrong.")->withInput();	
            }

    	}

    	$css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
            'vendors/datatables.net/js/jquery.dataTables.min.js',
        ];

		$users = User::where("is_active", 1)->where('user_type_id',3)->get();
    	$resorts = Resort::where(["is_active" => 1])->get();
    	$roomTypes = \App\Models\RoomType::where("is_active", 1)->get();
        $healcarePackages = HealthcateProgram::where("is_active", 1)->get();
    	return view("admin.booking.create", [
    		'js' => $js,
            'css' => $css,
            'resorts' => $resorts,
            'roomTypes' => $roomTypes,
            'healcarePackages' => $healcarePackages,
            "users" => $users
    	]);
    	    } catch (\Exception $e) {
            return redirect()->route('admin.booking.index')->with('error', $e->getMessage());
        }
    }
}
