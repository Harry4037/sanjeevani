<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Routing\Route;
use Carbon\Carbon;
use App\Models\UserBookingDetail;
use App\Models\RoomBooking;
use App\Models\BookingpeopleAccompany;
use App\Models\Resort;
use App\Models\RoomType;
use App\Models\ResortRoom;
use App\Models\UserhealthDetail;
use Validator;
use App\Models\HealthcateProgram;

class UsersController extends Controller {

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Index Page
     *
     * @param Request $request [handle request]
     * @return pages
     */
    public function index() {

        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.users.index', ['js' => $js, 'css' => $css]);
    }

    /**
     * Users Listing
     *
     * @param Request $request [handle request]
     * @return pages
     */
    public function usersList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];
//            dd($request->get('order'));
            $query = $this->user->query();
            if ($searchKeyword) {
                $query->where("first_name", "LIKE", "%$searchKeyword%")->orWhere("email_id", "LIKE", "%$searchKeyword%")->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
            }
            $query->where("user_type_id", "=", 3);
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $users = $query->take($limit)->offset($offset)->latest()->get();
            $usersArray = [];
            foreach ($users as $key => $user) {
                $usersArray[$key]['name'] = $user->first_name . ' ' . $user->last_ame;
                $usersArray[$key]['email'] = $user->email_id;
                $usersArray[$key]['mobileno'] = $user->mobile_number;
                $usersArray[$key]['user_type'] = $user->user_type_id == 3 ? "Customer" : "Guest";
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                if ($user->user_type_id == 3) {
                    $usersArray[$key]['action'] = '<a class="btn btn-info btn-xs" href="' . route('admin.users.detail', ['id' => $user->id]) . '"><i class="fa fa-eye"></i>View</a><a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
                } else {
                    $usersArray[$key]['action'] = '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
                }
            }
            $data['data'] = $usersArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * [updateUserStatus Update user status]
     * @param  Request $request    [INPUT from web]
     * @param  [INTEGER]  $status [user status either 1 or 0]
     * @return [json]          [e.g  {status:true,data:{status:1 or 0}}]
     */
    public function updateUserStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $user = $this->user->findOrFail($request->record_id);
                $user->is_active = $request->status;
                if ($user->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status update successfully"]];
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function viewUser(Request $request, $id) {
        try {
            $user = $this->user->find($id);
            $userBooking = UserBookingDetail::where("user_id", $id)->first();
            $userHealth = UserhealthDetail::where("user_id", $id)->first();
            if ($userBooking) {
                $roomBooking = RoomBooking::where("booking_id", $userBooking->id)->first();
                $bookingAccompany = BookingpeopleAccompany::where("booking_id", $userBooking->id)->get();
                $resortRooms = ResortRoom::where(["resort_id" => $userBooking->resort_id, "room_type_id" => $roomBooking->room_type_id])->get();
            }
            return view('admin.users.user-detail', [
                "user" => $user,
                'userBooking' => $userBooking,
                'userHealth' => $userHealth,
                'resortRooms' => isset($resortRooms) ? $resortRooms : [],
                'roomBooking' => isset($roomBooking) ? $roomBooking : [],
                'bookingAccompany' => isset($bookingAccompany) ? $bookingAccompany : [],
            ]);
        } catch (Exception $ex) {
            return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
        }
    }

    public function addUser(Request $request) {

        if ($request->isMethod("post")) {
            $userExist = User::where("mobile_number", $request->mobile_number)
                    ->where("user_type_id", 3)
                    ->first();
            if ($userExist) {
                return redirect()->route('admin.users.add')->with('error', 'User already exists with thin mobile number');
            } else {

                $validator = Validator::make($request->all(), [
                            'user_name' => 'bail|required',
                            'mobile_number' => 'bail|required|numeric',
                            'email_id' => 'bail|required|email',
                            'is_diabeties' => 'bail|required',
                            'is_ppa' => 'bail|required',
                            'hba_1c' => 'bail|required',
                            'fasting' => 'bail|required',
                            'bp' => 'bail|required',
                            'bp' => 'bail|required',
                            'insullin_dependency' => 'bail|required',
                            'medical_documents' => 'bail|required',
                            'booking_source_name' => 'bail|required',
                            'booking_source_id' => 'bail|required',
                            'resort_id' => 'bail|required',
                            'package_id' => 'bail|required',
                            'resort_room_id' => 'bail|required',
                            'check_in' => 'bail|required',
                            'check_out' => 'bail|required',
//                            'banner_image' => 'bail|required|max:1000|mimes:jpeg,jpg,png|dimensions:width=1769,height=416',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.users.add')->withErrors($validator)->withInput();
                }
                try {
                    $name = explode(" ", $request->user_name);

                    $user = $this->user;
                    $user->user_type_id = 3;
                    $user->user_name = $request->user_name;
                    $user->first_name = isset($name[0]) ? $name[0] : '';
                    $user->last_name = isset($name[1]) ? $name[1] : '';
                    $user->mobile_number = $request->mobile_number;
                    $user->otp = 9999;
                    $user->email_id = $request->email_id;
                    $user->created_by = 1;
                    $user->updated_by = 1;

                    if ($user->save()) {
                        $doc_file_name = '';
                        if ($request->hasFile("medical_documents")) {
                            $medical_documents = $request->file("medical_documents");
                            $medical_doc = Storage::disk('public')->put('medical_document', $medical_documents);
                            $doc_file_name = basename($medical_doc);
                        }

                        $userHealthDetail = new UserhealthDetail();
                        $userHealthDetail->is_diabeties = $request->is_diabeties;
                        $userHealthDetail->is_ppa = $request->is_ppa;
                        $userHealthDetail->hba_1c = $request->hba_1c;
                        $userHealthDetail->fasting = $request->fasting;
                        $userHealthDetail->bp = $request->bp;
                        $userHealthDetail->insullin_dependency = $request->insullin_dependency;
                        $userHealthDetail->medical_documents = $doc_file_name;
                        $userHealthDetail->user_id = $user->id;
                        $userHealthDetail->save();

                        $userBooking = new UserBookingDetail();
                        $userBooking->source_name = $request->booking_source_name;
                        $userBooking->source_id = $request->booking_source_id;
                        $userBooking->user_id = $user->id;
                        $userBooking->resort_id = $request->resort_id;
                        $userBooking->package_id = $request->package_id;
                        if ($userBooking->save()) {
                            $roomBooking = new RoomBooking();
                            $roomBooking->booking_id = $userBooking->id;
                            $roomBooking->room_type_id = $request->package_id;
                            $roomBooking->resort_room_id = $request->resort_room_id;
                            $check_in_date = Carbon::parse($request->check_in);
                            $roomBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
                            $check_out_date = Carbon::parse($request->check_out);
                            $roomBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
                            $roomBooking->save();
                            if (!empty($request->person_name) && !empty($request->person_age) && !empty($request->person_type)) {

                                foreach ($request->person_name as $key => $person_name) {
                                    if (!empty($person_name) && !empty($request->person_age[$key]) && !empty($request->person_type[$key])) {
                                        $familyMember = new BookingpeopleAccompany();
                                        $familyMember->person_name = $person_name ? $person_name : ' ';
                                        $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                                        $familyMember->person_type = $request->person_type[$key] ? $request->person_type[$key] : ' ';
                                        $familyMember->booking_id = $userBooking->id;
                                        $familyMember->save();
                                    }
                                }
                            }
                        }

                        return redirect()->route('admin.users.index')->with('status', 'User has been added successfully');
                    }
                } catch (\Exception $e) {
                    return redirect()->route('admin.users.index')->withErrors($e->getMessage())->withInput();
                }
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
        $resorts = Resort::where("is_active", 1)->get();
        $roomTypes = \App\Models\RoomType::where("is_active", 1)->get();
        $healcarePackages = HealthcateProgram::where("is_active", 1)->get();
        return view('admin.users.add-user', [
            'js' => $js,
            'css' => $css,
            'resorts' => $resorts,
            'roomTypes' => $roomTypes,
            'healcarePackages' => $healcarePackages,
        ]);
    }

    public function editUser(Request $request, $id) {
        try {
            $user = User::find($id);
            $userBooking = UserBookingDetail::where("user_id", $id)->first();
            $userHealth = UserhealthDetail::where("user_id", $id)->first();
            $roomTypes = RoomType::where("is_active", 1)->get();
            if ($userBooking) {
//                dd($userBooking->toArray());
                $roomBooking = RoomBooking::where("booking_id", $userBooking->id)->first();
                $bookingAccompany = BookingpeopleAccompany::where("booking_id", $userBooking->id)->get();
                $resortRooms = ResortRoom::where(["resort_id" => $userBooking->resort_id,
                            "room_type_id" => $roomBooking->room_type_id
                        ])->get();
            }
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'user_name' => 'bail|required',
                            'mobile_number' => 'bail|required|numeric',
                            'email_id' => 'bail|required|email',
                            'is_diabeties' => 'bail|required',
                            'is_ppa' => 'bail|required',
                            'hba_1c' => 'bail|required',
                            'fasting' => 'bail|required',
                            'bp' => 'bail|required',
                            'bp' => 'bail|required',
                            'insullin_dependency' => 'bail|required',
//                            'medical_documents' => 'bail|required',
                            'booking_source_name' => 'bail|required',
                            'booking_source_id' => 'bail|required',
                            'resort_id' => 'bail|required',
                            'package_id' => 'bail|required',
                            'resort_room_id' => 'bail|required',
                            'check_in' => 'bail|required',
                            'check_out' => 'bail|required',
//                            'banner_image' => 'bail|required|max:1000|mimes:jpeg,jpg,png|dimensions:width=1769,height=416',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.users.edit', $id)->withErrors($validator);
                }

                $name = explode(" ", $request->user_name);

                $user->user_name = $request->user_name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
                $user->mobile_number = $request->mobile_number;
                $user->email_id = $request->email_id;
                $user->created_by = 1;
                $user->updated_by = 1;

                if ($user->save()) {

                    $doc_file_name = '';
                    if ($request->hasFile("medical_documents")) {
                        $medical_documents = $request->file("medical_documents");
                        $medical_doc = Storage::disk('public')->put('medical_document', $medical_documents);
                        $doc_file_name = basename($medical_doc);
                    }
                    $userHealthDetail = UserhealthDetail::where("user_id", $user->id)->first();
                    if (!$userHealthDetail) {
                        $userHealthDetail = new UserhealthDetail();
                    }
                    $userHealthDetail->is_diabeties = $request->is_diabeties;
                    $userHealthDetail->is_ppa = $request->is_ppa;
                    $userHealthDetail->hba_1c = $request->hba_1c;
                    $userHealthDetail->fasting = $request->fasting;
                    $userHealthDetail->bp = $request->bp;
                    $userHealthDetail->insullin_dependency = $request->insullin_dependency;
                    $userHealthDetail->medical_documents = $doc_file_name;
                    $userHealthDetail->user_id = $user->id;
                    $userHealthDetail->save();

                    $userBooking = UserBookingDetail::where("user_id", $user->id)->first();
                    if (!$userBooking) {
                        $userBooking = new UserBookingDetail();
                    }
                    $userBooking->source_name = $request->booking_source_name;
                    $userBooking->source_id = $request->booking_source_id;
                    $userBooking->user_id = $user->id;
                    $userBooking->resort_id = $request->resort_id;
                    $userBooking->package_id = $request->package_id;
                    if ($userBooking->save()) {
                        $roomBooking = RoomBooking::where("booking_id", $userBooking->id)->first();
                        if (!$roomBooking) {
                            $roomBooking = new RoomBooking();
                        }
                        $roomBooking->booking_id = $userBooking->id;
                        $roomBooking->room_type_id = $request->resort_room_type;
                        $roomBooking->resort_room_id = $request->resort_room_id;
                        $check_in_date = Carbon::parse($request->check_in);
                        $roomBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
                        $check_out_date = Carbon::parse($request->check_out);
                        $roomBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
                        $roomBooking->save();

                        if (!empty($request->person_name) && !empty($request->person_age)) {
                            BookingpeopleAccompany::where("booking_id", $userBooking->id)->delete();

                            foreach ($request->person_name as $key => $person_name) {
                                if (!empty($person_name) && !empty($request->person_age[$key]) && !empty($request->person_type[$key])) {
                                    $familyMember = new BookingpeopleAccompany();
                                    $familyMember->person_name = $person_name ? $person_name : ' ';
                                    $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                                    $familyMember->person_type = $request->person_type[$key] ? $request->person_type[$key] : ' ';
                                    $familyMember->booking_id = $userBooking->id;
                                    $familyMember->save();
                                }
                            }
                        }

                        return redirect()->route('admin.users.edit', $id)->with('status', 'User has been updated successfully');
                    }
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
            $resorts = Resort::where("is_active", 1)->get();
            $healcarePackages = HealthcateProgram::where("is_active", 1)->get();
            return view('admin.users.edit-user', [
                'js' => $js,
                'css' => $css,
                'resorts' => $resorts,
                'roomTypes' => $roomTypes,
                'user' => $user,
                'userBooking' => $userBooking,
                'userHealth' => $userHealth,
                'resortRooms' => isset($resortRooms) ? $resortRooms : [],
                'roomBooking' => isset($roomBooking) ? $roomBooking : [],
                'bookingAccompany' => isset($bookingAccompany) ? $bookingAccompany : [],
                'healcarePackages' => $healcarePackages,
                    ]
            );
        } catch (\Exception $ex) {
            return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
        }
    }

}
