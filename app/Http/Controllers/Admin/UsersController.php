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
use App\Models\BookingpeopleAccompany;
use App\Models\Resort;
use App\Models\RoomType;
use App\Models\ResortRoom;
use App\Models\UserhealthDetail;
use Validator;
use App\Models\HealthcateProgram;
use App\Models\UserMembership;

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

            $query = $this->user->query()->with(['payments', 'mealOrders' => function($query) {
                    $query->accepted();
                }]);
            $query->where("user_type_id", "=", 3);
            if ($searchKeyword) {
//                if ((!preg_match('/guest/i', $searchKeyword)) && (!preg_match('/customer/i', $searchKeyword))) {
                $query->where(function($query) use($searchKeyword) {
                    $query->where("first_name", "LIKE", "%$searchKeyword%")
                            ->orWhere("email_id", "LIKE", "%$searchKeyword%")
                            ->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
                });
//                }
            }

            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $users = $query->take($limit)->offset($offset)->latest()->get();

//            if ($searchKeyword) {
//                if (preg_match('/guest/i', $searchKeyword)) {
//                    $users = $users->filter(function ($users) {
//                        return $users->user_type_id == 4;
//                    });
//                } elseif (preg_match('/customer/i', $searchKeyword)) {
//                    $users = $users->filter(function ($users) {
//                        return $users->user_type_id == 3;
//                    });
//                }
//            }


            $usersArray = [];
            $i = 0;
            foreach ($users as $user) {
                $usersArray[$i]['name'] = $user->user_name;
                $usersArray[$i]['email'] = $user->email_id;
                $usersArray[$i]['mobileno'] = $user->mobile_number;
                $usersArray[$i]['user_type'] = $user->user_type_id == 3 ? "Customer" : "Guest";
                $usersArray[$i]['outstanding'] = number_format(($user->mealOrders->sum('total_amount') - $user->payments->sum('amount')), 2);
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                if ($user->user_type_id == 3) {
                    $usersArray[$i]['action'] = '<a class="btn btn-info btn-xs" href="' . route('admin.users.detail', ['id' => $user->id]) . '"><i class="fa fa-eye"></i>View</a>'
                            . '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                            . '<a href="' . route('admin.users.payments', $user->id) . '" class="btn btn-warning btn-xs"><i class="fa fa-dollar"></i> Payments </a>'
                            . '<a href="' . route('admin.users.booking', $user->id) . '" class="btn btn-primary btn-xs"><i class="fa fa-bed"></i> Bookings </a>';
                } else {
                    $usersArray[$i]['action'] = '<a class="btn btn-info btn-xs" href="' . route('admin.users.detail', ['id' => $user->id]) . '"><i class="fa fa-eye"></i>View</a>'
                            . '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                            . '<a href="' . route('admin.users.booking', $user->id) . '" class="btn btn-primary btn-xs"><i class="fa fa-bed"></i> Bookings </a>';
                }
                $i++;
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

    public function viewUser(Request $request, $id) {
        try {
            $user = $this->user->with([
                        "userBookingDetail" => function($query) {
                            $query->selectRaw(DB::raw('id, room_type_id, resort_room_id, user_id, source_id as booking_id, source_name, resort_id, package_id, DATE_FORMAT(check_in, "%d-%m-%Y") as check_in, DATE_FORMAT(check_in, "%r") as check_in_time, DATE_FORMAT(check_out, "%d-%m-%Y") as check_out, DATE_FORMAT(check_out, "%r") as check_out_time'));
                        }
                    ])->find($id);
//                    dd($user->toArray());
            $userHealth = UserhealthDetail::where("user_id", $id)->first();
            $userMembership = UserMembership::where("user_id", $id)->first();
            if ($user->userBookingDetail) {
                $bookingAccompany = BookingpeopleAccompany::where("booking_id", $user->userBookingDetail->id)->get();
            }
            return view('admin.users.user-detail', [
                "user" => $user,
                'userHealth' => $userHealth ? $userHealth : [],
                'userMembership' => $userMembership ? $userMembership : [],
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
                return redirect()->route('admin.users.add')->with('error', 'User already exists with this mobile number');
            } else {

                $validator = Validator::make($request->all(), [
                            'user_name' => 'bail|required',
                            'mobile_number' => 'bail|required|numeric',
                            'email_id' => 'bail|required|email',
//                            'is_diabeties' => 'bail|required',
//                            'is_ppa' => 'bail|required',
//                            'hba_1c' => 'bail|required',
//                            'fasting' => 'bail|required',
//                            'bp' => 'bail|required',
//                            'bp' => 'bail|required',
//                            'insullin_dependency' => 'bail|required',
//                            'medical_documents' => 'bail|required',
//                            'booking_source_name' => 'bail|required',
//                            'booking_source_id' => 'bail|required',
//                            'resort_id' => 'bail|required',
//                            'package_id' => 'bail|required',
//                            'resort_room_id' => 'bail|required',
//                            'check_in' => 'bail|required',
//                            'check_out' => 'bail|required',
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
                    $user->password = bcrypt(9999);
                    $user->email_id = $request->email_id;
                    $user->created_by = 1;
                    $user->updated_by = 1;

                    if ($user->save()) {
                        if (isset($request->is_medical_document) && ($request->is_medical_document == "on")) {
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
                        }

                        if (isset($request->is_booking_details) && ($request->is_booking_details == "on")) {
                            $roomType = RoomType::find($request->resort_room_type);
                            $room = ResortRoom::find($request->resort_room_id);
                            $userBooking = new UserBookingDetail();
                            $userBooking->source_name = $request->booking_source_name;
                            $userBooking->source_id = $request->booking_source_id;
                            $userBooking->user_id = $user->id;
                            $userBooking->resort_id = $request->resort_id;
                            $userBooking->package_id = $request->package_id;
                            $userBooking->room_type_id = $request->resort_room_type;
                            $userBooking->room_type_name = $roomType ? $roomType->name : "";
                            $userBooking->resort_room_id = $request->resort_room_id;
                            $userBooking->resort_room_no = $room ? $room->room_no : "";
                            $check_in_date = Carbon::parse($request->check_in);
                            $userBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
                            $check_out_date = Carbon::parse($request->check_out);
                            $userBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
                            $userBooking->check_in_pin = rand(1111, 9999);
                            $userBooking->check_out_pin = rand(1111, 9999);
                            if ($userBooking->save()) {
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
                        }

                        if (isset($request->is_membership_details) && ($request->is_membership_details == "on")) {
                            $userMembership = new UserMembership();

                            $userMembership->user_id = $user->id;
                            $userMembership->membership_id = $request->membership_id;
                            $membership_from = Carbon::parse($request->membership_from);
                            $userMembership->valid_from = $membership_from->format('Y-m-d H:i:s');
                            $membership_till = Carbon::parse($request->membership_till);
                            $userMembership->valid_till = $membership_till->format('Y-m-d H:i:s');
                            $userMembership->save();
                        }

                        $this->sendRegistration($user->mobile_number, $user->user_name);
                        return redirect()->route('admin.users.index')->with('status', 'User has been added successfully');
                    }
                } catch (\Exception $e) {
                    return redirect()->route('admin.users.index')->withErrors($e->getMessage())->withInput();
                }
            }
        }

        $css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
            "vendors/iCheck/skins/flat/green.css",
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/iCheck/icheck.min.js',
        ];
        $resorts = Resort::where("is_active", 1)->get();
        $roomTypes = \App\Models\RoomType::where("is_active", 1)->get();
        return view('admin.users.add-user', [
            'js' => $js,
            'css' => $css,
            'resorts' => $resorts,
            'roomTypes' => $roomTypes,
        ]);
    }

    public function editUser(Request $request, $id) {
        try {
            $user = User::find($id);
            $userBooking = UserBookingDetail::where("user_id", $id)->first();
            $userHealth = UserhealthDetail::where("user_id", $id)->first();
            $userMembership = UserMembership::where("user_id", $id)->first();
            $roomTypes = RoomType::where("is_active", 1)->get();
            if ($userBooking) {
                $bookingAccompany = BookingpeopleAccompany::where("booking_id", $userBooking->id)->get();
                $resortRooms = ResortRoom::where(["resort_id" => $userBooking->resort_id,
                            "room_type_id" => $userBooking->room_type_id
                        ])->get();
            }
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'user_name' => 'bail|required',
                            'mobile_number' => 'bail|required|numeric',
                            'email_id' => 'bail|required|email',
//                            'is_diabeties' => 'bail|required',
//                            'is_ppa' => 'bail|required',
//                            'hba_1c' => 'bail|required',
//                            'fasting' => 'bail|required',
//                            'bp' => 'bail|required',
//                            'bp' => 'bail|required',
//                            'insullin_dependency' => 'bail|required',
//                            'medical_documents' => 'bail|required',
//                    'booking_source_name' => 'bail|required',
//                    'booking_source_id' => 'bail|required',
//                    'resort_id' => 'bail|required',
//                    'package_id' => 'bail|required',
//                    'resort_room_id' => 'bail|required',
//                    'check_in' => 'bail|required',
//                    'check_out' => 'bail|required',
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
                    if (isset($request->is_medical_document) && ($request->is_medical_document == "on")) {
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
                    } else {
                        UserhealthDetail::where("user_id", $id)->delete();
                    }

                    if (isset($request->is_membership_details) && ($request->is_membership_details == "on")) {
                        if (!$userMembership) {
                            $userMembership = new UserMembership();
                        }

                        $userMembership->user_id = $user->id;
                        $userMembership->membership_id = $request->membership_id;
                        $membership_from = Carbon::parse($request->membership_from);
                        $userMembership->valid_from = $membership_from->format('Y-m-d H:i:s');
                        $membership_till = Carbon::parse($request->membership_till);
                        $userMembership->valid_till = $membership_till->format('Y-m-d H:i:s');
                        $userMembership->save();
                    } else {
                        UserMembership::where("user_id", $id)->delete();
                    }

                    return redirect()->route('admin.users.edit', $id)->with('status', 'User has been updated successfully');
//                    if ($userHealthDetail->save()) {
//                    $userBooking = UserBookingDetail::where("user_id", $user->id)->first();
//                    if (!$userBooking) {
//                        $userBooking = new UserBookingDetail();
//                    }
//                    $userBooking->source_name = $request->booking_source_name;
//                    $userBooking->source_id = $request->booking_source_id;
//                    $userBooking->user_id = $user->id;
//                    $userBooking->resort_id = $request->resort_id;
//                    $userBooking->package_id = $request->package_id;
//                    if ($userBooking->save()) {
//                        $roomBooking = RoomBooking::where("booking_id", $userBooking->id)->first();
//                        if (!$roomBooking) {
//                            $roomBooking = new RoomBooking();
//                        }
//                        $roomBooking->booking_id = $userBooking->id;
//                        $roomBooking->room_type_id = $request->resort_room_type;
//                        $roomBooking->resort_room_id = $request->resort_room_id;
//                        $check_in_date = Carbon::parse($request->check_in);
//                        $roomBooking->check_in = $check_in_date->format('Y-m-d H:i:s');
//                        $check_out_date = Carbon::parse($request->check_out);
//                        $roomBooking->check_out = $check_out_date->format('Y-m-d H:i:s');
//                        $roomBooking->save();
//                    }
                }
            }
            $css = [
                'vendors/bootstrap-daterangepicker/daterangepicker.css',
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/moment/min/moment.min.js',
                'vendors/bootstrap-daterangepicker/daterangepicker.js',
                'vendors/datatables.net/js/jquery.dataTables.min.js',
                'vendors/iCheck/icheck.min.js',
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
                'userHealth' => $userHealth ? $userHealth : [],
                'userMembership' => $userMembership ? $userMembership : [],
                'resortRooms' => isset($resortRooms) ? $resortRooms : [],
                'bookingAccompany' => isset($bookingAccompany) ? $bookingAccompany : [],
                'healcarePackages' => $healcarePackages,
                    ]
            );
        } catch (\Exception $ex) {
            return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
        }
    }

    public function viewPayments(User $user) {
        $user->load(['payments', 'mealOrders' => function($query) {
                $query->accepted();
            }]);

        $total = $user->mealOrders->sum('total_amount');
        $paid = $user->payments->sum('amount');
        $outstanding = $total - $paid;

        return view('admin.users.payments', compact('user', 'total', 'paid', 'outstanding'));
    }

    public function payOutstading(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                        'user_id' => 'required',
                        'amount' => 'required|numeric',
                            ], [
                        'user_id.required' => 'Required Parameters are missing'
            ]);

            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors()->all()[0], (object) [], 200);
            }

            $user = User::findOrFail($request->user_id);

            $user->payments()->create([
                'amount' => $request->amount
            ]);

            return $this->sendSuccessResponse("Payment Successfull.", (object) []);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), (object) [], 200);
        }
    }

    public function booking(Request $request, $user_id) {
        $user = User::find($user_id);
        $css = [
            'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.users.booking-list', [
            'js' => $js,
            'css' => $css,
            'user' => $user
        ]);
    }

    public function bookingList(Request $request, $user_id) {
        try {

            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = UserBookingDetail::query();
            $query->with(["packageDetail" => function($query) {
                    $query->withTrashed();
                }]);
            $query->with(["resortDetail" => function($query) {
                    $query->withTrashed();
                }]);
            $query->where("user_id", $user_id);
            if ($searchKeyword) {
                $query->where(function($query) use($searchKeyword) {
                    $query->whereHas("packageDetail", function($query) use($searchKeyword) {
                                $query->where("name", "LIKE", "%$searchKeyword%");
                            })->orWhereHas("resortDetail", function($query) use($searchKeyword) {
                                $query->where("name", "LIKE", "%$searchKeyword%");
                            })->orWhere("source_name", "LIKE", "%$searchKeyword%")
                            ->orWhere("source_id", "LIKE", "%$searchKeyword%")
                            ->orWhere("resort_room_no", "LIKE", "%$searchKeyword%");
                });
            }

            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $userBookingDetails = $query->get();
            $bookinDetailArray = [];
            foreach ($userBookingDetails as $i => $userBookingDetail) {
                $currentDataTime = strtotime(date("d-m-Y H:i:s"));
                $checkInTime = strtotime($userBookingDetail->check_in);
                $checkOutTime = strtotime($userBookingDetail->check_out);
                $stat = "";
                if ($userBookingDetail->is_cancelled == 1) {
                    $stat = "<span class='label label-danger'>Cancelled</span>";
                    $actionBtn = '';
                } else {
                    if ($currentDataTime > $checkOutTime) {
                        $stat = "<span class='label label-primary'>Completed</span>";
                    } elseif ($currentDataTime < $checkInTime) {
                        $stat = "<span class='label label-info'>Upcoming</span>";
                    } else {
                        $stat = "<span class='label label-success'>Current</span>";
                    }
                    $actionBtn = '<a href="' . route('admin.users.booking-edit', $userBookingDetail->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                            . '<a href="' . route('admin.users.booking-verify', $userBookingDetail->id) . '" class="btn btn-warning btn-xs"><i class="fa fa-check"></i> Verify</a>';
                }

                $bookinDetailArray[$i]["source_name"] = $userBookingDetail->source_name;
                $bookinDetailArray[$i]["source_id"] = $userBookingDetail->source_id;
                $bookinDetailArray[$i]["resort"] = isset($userBookingDetail->resortDetail->name) ? $userBookingDetail->resortDetail->name : "";
                $bookinDetailArray[$i]["package"] = isset($userBookingDetail->packageDetail->name) ? $userBookingDetail->packageDetail->name : "";
                $bookinDetailArray[$i]["check_in"] = isset($userBookingDetail->check_in) ? date("d-M-Y h:i A", strtotime($userBookingDetail->check_in)) : "";
                $bookinDetailArray[$i]["check_out"] = isset($userBookingDetail->check_out) ? date("d-M-Y h:i A", strtotime($userBookingDetail->check_out)) : "";
                $bookinDetailArray[$i]["room_no"] = isset($userBookingDetail->resort_room_no) ? $userBookingDetail->resort_room_no : "";
                $bookinDetailArray[$i]["status"] = $stat;
                $bookinDetailArray[$i]["action"] = $actionBtn;
            }
            $data["data"] = $bookinDetailArray;

            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function bookingCreate(Request $request, $user_id) {

        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
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
                return redirect()->route('admin.users.booking-create', $user_id)->withErrors($validator)->withInput();
            }

            $user = User::find($user_id);
            if (!$user) {
                return redirect()->route('admin.users.booking-create', $user_id)->withErrors("user not found.")->withInput();
            }
            $existingRecord = UserBookingDetail::where("check_in", "<=", date("Y-m-d H:i:s", strtotime($request->check_in)))
                    ->where("check_out", ">=", date("Y-m-d H:i:s", strtotime($request->check_out)))
                    ->where("user_id", $user_id)
                    ->first();
            if ($existingRecord) {
                return redirect()->route('admin.users.booking-create', $user_id)->withErrors("Booking already exist with these date's.")->withInput();
            }

            $roomType = RoomType::find($request->resort_room_type);
            $roomRoom = ResortRoom::find($request->resort_room_id);
            $UserBookingDetail = new UserBookingDetail();
            $UserBookingDetail->discount = $request->discount;
            $UserBookingDetail->source_name = $request->booking_source_name;
            $UserBookingDetail->source_id = $request->booking_source_id;
            $UserBookingDetail->user_id = $user->id;
            $UserBookingDetail->resort_id = $request->resort_id;
            $UserBookingDetail->package_id = $request->package_id;
            $UserBookingDetail->room_type_id = $request->resort_room_type;
            $UserBookingDetail->resort_room_id = $request->resort_room_id;
            $UserBookingDetail->resort_room_no = $roomRoom->room_no;
            $UserBookingDetail->room_type_name = $roomType->name;
            $check_in_date = Carbon::parse($request->check_in);
            $UserBookingDetail->check_in = $check_in_date->format('Y-m-d H:i:s');
            $check_out_date = Carbon::parse($request->check_out);
            $UserBookingDetail->check_out = $check_out_date->format('Y-m-d H:i:s');
            $UserBookingDetail->check_in_pin = rand(1111, 9999);
            $UserBookingDetail->check_out_pin = rand(1111, 9999);
            if ($UserBookingDetail->save()) {
                if (!empty($request->person_name) && !empty($request->person_age)) {
                    foreach ($request->person_name as $key => $person_name) {
                        if (!empty($person_name) && !empty($request->person_age[$key]) && !empty($request->person_type[$key])) {
                            $familyMember = new BookingpeopleAccompany();
                            $familyMember->person_name = $person_name ? $person_name : ' ';
                            $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                            $familyMember->person_type = $request->person_type[$key] ? $request->person_type[$key] : ' ';
                            $familyMember->booking_id = $UserBookingDetail->id;
                            $familyMember->save();
                        }
                    }
                }
                if ($user->device_token) {
                    $this->androidBookingPushNotification("Booking Created", "You booking created successfully", $user->device_token);
                }

                return redirect()->route('admin.users.booking', $user_id)->with('status', 'booking created successfully.');
            } else {
                return redirect()->route('admin.users.booking-create', $user_id)->withErrors("Something went be wrong.")->withInput();
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
        $resorts = Resort::where(["is_active" => 1])->get();
        $roomTypes = \App\Models\RoomType::where("is_active", 1)->get();

        return view('admin.users.booking-create', [
            'js' => $js,
            'css' => $css,
            "user_id" => $user_id,
            'resorts' => $resorts,
            'roomTypes' => $roomTypes,
        ]);
    }

    public function bookingEdit(Request $request, $id) {
        $data = UserBookingDetail::find($id);
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
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
                return redirect()->route('admin.users.booking-edit', $data->id)->withErrors($validator)->withInput();
            }
            $roomType = RoomType::find($request->resort_room_type);
            $roomRoom = ResortRoom::find($request->resort_room_id);

            $data->discount = $request->discount;
            $data->source_name = $request->booking_source_name;
            $data->source_id = $request->booking_source_id;
            $data->resort_id = $request->resort_id;
            $data->package_id = $request->package_id;
            $data->room_type_id = $request->resort_room_type;
            $data->resort_room_id = $request->resort_room_id;
            $data->resort_room_no = $roomRoom->room_no;
            $data->room_type_name = $roomType->name;
            $check_in_date = Carbon::parse($request->check_in);
            $data->check_in = $check_in_date->format('Y-m-d H:i:s');
            $check_out_date = Carbon::parse($request->check_out);
            $data->check_out = $check_out_date->format('Y-m-d H:i:s');
//            $data->check_in_pin = rand(1111, 9999);
//            $data->check_out_pin = rand(1111, 9999);
            if ($data->save()) {
                if (!empty($request->person_name) && !empty($request->person_age)) {
                    foreach ($request->person_name as $key => $person_name) {
                        if (!empty($person_name) && !empty($request->person_age[$key]) && !empty($request->person_type[$key])) {
                            if ($request->record_id[$key]) {
                                $familyMember = BookingpeopleAccompany::find($request->record_id[$key]);
                            } else {
                                $familyMember = new BookingpeopleAccompany();
                            }
                            $familyMember->person_name = $person_name ? $person_name : ' ';
                            $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                            $familyMember->person_type = $request->person_type[$key] ? $request->person_type[$key] : ' ';
                            $familyMember->booking_id = $data->id;
                            $familyMember->save();
                        }
                    }
                }
                return redirect()->route('admin.users.booking-edit', $data->id)->with('status', 'booking created successfully.');
            } else {
                return redirect()->route('admin.users.booking-edit', $data->id)->withErrors("Something went be wrong.")->withInput();
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
        $resorts = Resort::where(["is_active" => 1])->get();
        $roomTypes = \App\Models\RoomType::where("is_active", 1)->get();
        $resortRoom = ResortRoom::find($data->resort_room_id);
        $healcarePackages = HealthcateProgram::where(["resort_id" => $data->package_id, "is_active" => 1])->get();
        $BookingPeoples = BookingpeopleAccompany::where("booking_id", $data->id)->get();
        return view('admin.users.booking-edit', [
            'js' => $js,
            'css' => $css,
            'resorts' => $resorts,
            'roomTypes' => $roomTypes,
            'healcarePackages' => $healcarePackages,
            'resortRoom' => $resortRoom,
            'data' => $data,
            'BookingPeoples' => $BookingPeoples,
        ]);
    }

    public function verifyBooking(Request $request, $id) {
        $userBookingdetail = UserBookingDetail::find($id);
        $user = User::find($userBookingdetail->user_id);
        if ($request->isMethod("post")) {
            if ($request->check_in_pin == 1) {
                if ($userBookingdetail->check_in_pin == $request->pin) {
                    $userBookingdetail->is_verified_check_in_pin = 1;
                    $userBookingdetail->save();
                    return redirect()->route('admin.users.booking-verify', $id)->with('status', 'PIN Number Verified.');
                } else {
                    return redirect()->route('admin.users.booking-verify', $id)->with('error', 'Wrong PIN Number.');
                }
            } elseif ($request->check_in_out == 1) {
                if ($userBookingdetail->check_out_pin == $request->pin) {
                    $userBookingdetail->is_verified_check_out_pin = 1;
                    $userBookingdetail->save();
                    return redirect()->route('admin.users.booking-verify', $id)->with('status', 'PIN Number Verified.');
                } else {
                    return redirect()->route('admin.users.booking-verify', $id)->with('error', 'Wrong PIN Number.');
                }
            } else {
                return redirect()->route('admin.users.booking-verify', $id)->with('error', 'Something went be wrong.');
            }
            dd($request->all());
        }
        return view("admin.users.user-booking-detail", [
            "userBookingdetail" => $userBookingdetail ? $userBookingdetail : [],
            "user" => $user ? $user : [],
        ]);
    }

}
