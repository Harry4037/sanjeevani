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
use App\Models\Cart;

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

                if (preg_match('/guest/i', $searchKeyword)) {
                    $users = $query->latest()->get();

                    $users = $users->filter(function ($users) {
                        return $users->user_type_id == 4;
                    });

                    $data['recordsTotal'] = count($users);
                    $data['recordsFiltered'] = count($users);

                    $users = $users->slice($offset, $limit);
                } elseif (preg_match('/customer/i', $searchKeyword)) {
                    $users = $query->latest()->get();
                    $users = $users->filter(function ($users) {
                        return $users->user_type_id == 3;
                    });

                    $data['recordsTotal'] = count($users);
                    $data['recordsFiltered'] = count($users);
                    $users = $users->slice($offset, $limit);
                } else {
                    $query->where(function($query) use($searchKeyword) {
                        $query->where("first_name", "LIKE", "%$searchKeyword%")
                                ->orWhere("email_id", "LIKE", "%$searchKeyword%")
                                ->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
                    });

                    $data['recordsTotal'] = $query->count();
                    $data['recordsFiltered'] = $query->count();
                    $users = $query->take($limit)->offset($offset)->latest()->get();
                }
            } else {
                $data['recordsTotal'] = $query->count();
                $data['recordsFiltered'] = $query->count();
                $users = $query->take($limit)->offset($offset)->latest()->get();
            }

            $usersArray = [];
            $i = 0;
            foreach ($users as $user) {
                $usersArray[$i]['name'] = $user->user_name;
                $usersArray[$i]['email'] = $user->email_id;
                $usersArray[$i]['mobileno'] = $user->mobile_number;
                $usersArray[$i]['user_type'] = $user->user_type_id == 3 ? "Customer" : "Guest";
//                $usersArray[$i]['outstanding'] = number_format(($user->mealOrders->sum('total_amount') - $user->payments->sum('amount')), 2);
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
                    $user->discount = $request->discount;
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
                                if (!empty($request->person_name) && !empty($request->person_age)) {

                                    foreach ($request->person_name as $key => $person_name) {
                                        if (!empty($person_name) && !empty($request->person_age[$key])) {
                                            $familyMember = new BookingpeopleAccompany();
                                            $familyMember->person_name = $person_name ? $person_name : ' ';
                                            $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                                            $familyMember->person_type = $request->person_age[$key] > 17 ? "Adult" : "Child";
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
                $user->discount = $request->discount;
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

    public function viewPayments(Request $request, User $user) {
        if ($request->isMethod("post")) {
            $user->load(['payments', 'mealOrders' => function($query) use($request, $user) {
                    $query->where(["user_id" => $user->id, "resort_id" => $request->resort_id])->accepted();
                }]);
            $resort = Resort::find($request->resort_id);
            $total = $user->mealOrders->sum('total_amount');
            $paid = $user->payments->where("resort_id", $request->resort_id)->sum('amount');
            $discountPrice = $total;
            if ($user->discount > 0) {
                $discountPrice = number_format(($total - ($total * ($user->discount / 100))), 0, ".", "");
            }
            $outstanding = $discountPrice - $paid;



            return view('admin.users.payments', compact('resort', 'user', 'total', 'paid', 'outstanding', 'discountPrice'));
        } else {
            $userResort = UserBookingDetail::where("user_booking_details.user_id", $user->id)
                    ->join("resorts", "user_booking_details.resort_id", "=", "resorts.id")
                    ->where("resorts.deleted_at", null)
                    ->pluck('resorts.name', 'resorts.id')
                    ->all();
            return view('admin.users.resort-payments', compact('userResort', 'user'));
        }
    }

    public function payOutstading(Request $request) {
        try {
//            dd($request->all());
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
                'amount' => $request->amount,
                'resort_id' => $request->resort_id,
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
            $userBookingDetails = $query->take($limit)->offset($offset)->latest()->get();
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
                        $actionBtn = '<a href="' . route('admin.users.booking-edit', $userBookingDetail->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
                    } elseif ($currentDataTime < $checkInTime) {
                        $stat = "<span class='label label-info'>Upcoming</span>";
                        $actionBtn = '<a href="' . route('admin.users.booking-edit', $userBookingDetail->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                                . '<a href="' . route('admin.users.booking-verify', $userBookingDetail->id) . '" class="btn btn-warning btn-xs"><i class="fa fa-check"></i> Verify</a>';
                    } else {
                        $stat = "<span class='label label-success'>Current</span>";
                        $actionBtn = '<a href="' . route('admin.users.booking-edit', $userBookingDetail->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'
                                . '<a href="' . route('admin.users.booking-verify', $userBookingDetail->id) . '" class="btn btn-warning btn-xs"><i class="fa fa-check"></i> Verify</a>';
                        $actionBtn .= '<a href="' . route('admin.users.early-checkout', $userBookingDetail->id) . '" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Early Checkout</a>';
                    }
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

            $existingBookingCount = $this->checkUserbookingExist($request->check_in, $request->check_out, $user_id, $request->resort_id);

//            $existingRecord = UserBookingDetail::where("check_in", "<=", date("Y-m-d H:i:s", strtotime($request->check_in)))
//                    ->where("check_out", ">=", date("Y-m-d H:i:s", strtotime($request->check_out)))
//                    ->where("user_id", $user_id)
//                    ->first();

            if ($existingBookingCount > 0) {
                return redirect()->route('admin.users.booking-create', $user_id)->withErrors("Booking already exist with these date's.")->withInput();
            }

            $roomType = RoomType::find($request->resort_room_type);
            $roomRoom = ResortRoom::find($request->resort_room_id);
            $UserBookingDetail = new UserBookingDetail();
//            $UserBookingDetail->discount = $request->discount;
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
                        if (!empty($person_name) && !empty($request->person_age[$key])) {
                            $familyMember = new BookingpeopleAccompany();
                            $familyMember->person_name = $person_name ? $person_name : ' ';
                            $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                            $familyMember->person_type = $request->person_age[$key] > 17 ? "Adult" : "Child";
                            $familyMember->booking_id = $UserBookingDetail->id;
                            $familyMember->save();
                        }
                    }
                }
                $this->generateNotification($user->id, "Booking Created", "Your booking created successfully", 5);
                if ($user->device_token) {
                    $this->androidBookingPushNotification("Booking Created", "Your booking created successfully", $user->device_token, $this->notificationCount($user->id));
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
            $user = User::find($data->user_id);

            $roomType = RoomType::find($request->resort_room_type);
            $roomRoom = ResortRoom::find($request->resort_room_id);
            $msg = "Your";
            $flag = FALSE;
            $current_check_in_date = Carbon::parse($data->check_in);
            $current_check_out_date = Carbon::parse($data->check_out);
            $check_in_date = Carbon::parse($request->check_in);
            $check_out_date = Carbon::parse($request->check_out);

            $msgArray = [];
            if ($request->booking_source_name != $data->source_name) {
                $msgArray[] = " source name";
            }
            if ($request->booking_source_id != $data->source_id) {
                $msgArray[] = " source ID";
            }
            if ($data->resort_room_id != $request->resort_room_id) {
                $flag = TRUE;
                $msgArray[] = " room number";
            }
            if (!$current_check_in_date->eq($check_in_date)) {
                $msgArray[] = " check In date";
            }
            if (!$current_check_out_date->eq($check_out_date)) {
                $msgArray[] = " check Out date";
            }
            if ($data->package_id != $request->package_id) {
                $msgArray[] = " health packege";
            }
            if (empty($msgArray)) {
                $msgStr = implode(",", $msgArray);
                $msg .= $msgStr . ' has been updated.';
            } else {
                $msg = '';
            }


//            if ($data->room_type_name != $roomRoom->room_no) {
//                $msg = "Your room number updated successfully.";
//                $flag = TRUE;
//            } else {
//                $msg = "Your booking updated successfully.";
//                $flag = FALSE;
//            }

            if ($request->resort_id != $data->resort_id) {
                Cart::where("user_id", $data->user_id)->delete();
            }
//            $data->discount = $request->discount;
            $data->source_name = $request->booking_source_name;
            $data->source_id = $request->booking_source_id;
            $data->resort_id = $request->resort_id;
            $data->package_id = $request->package_id;
            $data->room_type_id = $request->resort_room_type;
            $data->resort_room_id = $request->resort_room_id;
            $data->resort_room_no = $roomRoom->room_no;
            $data->room_type_name = $roomType->name;

            $data->check_in = $check_in_date->format('Y-m-d H:i:s');

            $data->check_out = $check_out_date->format('Y-m-d H:i:s');
//            $data->check_in_pin = rand(1111, 9999);
//            $data->check_out_pin = rand(1111, 9999);
            if ($data->save()) {
                if (!empty($request->person_name) && !empty($request->person_age)) {
                    foreach ($request->person_name as $key => $person_name) {
                        if (!empty($person_name) && !empty($request->person_age[$key])) {
                            if ($request->record_id[$key]) {
                                $familyMember = BookingpeopleAccompany::find($request->record_id[$key]);
                            } else {
                                $familyMember = new BookingpeopleAccompany();
                            }
                            $familyMember->person_name = $person_name ? $person_name : ' ';
                            $familyMember->person_age = $request->person_age[$key] ? $request->person_age[$key] : ' ';
                            $familyMember->person_type = $request->person_age[$key] > 17 ? "Adult" : "Child";
                            $familyMember->booking_id = $data->id;
                            $familyMember->save();
                        }
                    }
                }

                if ($user->device_token && (strlen($msg) > 0)) {
                    $this->generateNotification($user->id, "Booking Updated", $msg, 5);
                    if ($flag) {
                        $this->androidPushNotification(3, "Booking Updated", $msg, $user->device_token, 123, 0);
                    } else {
                        $this->androidBookingPushNotification("Booking Updated", $msg, $user->device_token, $this->notificationCount($user->id));
                    }
                }
                return redirect()->route('admin.users.booking-edit', $data->id)->with('status', "Booking has been updated successfully.");
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
        $currentDataTime = strtotime(date("d-m-Y H:i:s"));
        $checkInTime = strtotime($data->check_in);
        $checkOutTime = strtotime($data->check_out);
        $flag = true;
        if ($currentDataTime > $checkOutTime) {
            $flag = false;
        } elseif ($currentDataTime < $checkInTime) {
            $flag = true;
        } else {
            $flag = false;
        }
        $resorts = Resort::where(["is_active" => 1])->get();
        $roomTypes = \App\Models\RoomType::where(["resort_id" => $data->resort_id, "is_active" => 1])->get();
        $resortRoom = ResortRoom::find($data->resort_room_id);
        $healcarePackages = HealthcateProgram::where(["resort_id" => $data->resort_id, "is_active" => 1])->get();
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
            'flag' => $flag,
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

    public function earlyCheckout(Request $request, $id) {
        $userBookingdetail = UserBookingDetail::find($id);
        $user = User::find($userBookingdetail->user_id);
        if ($request->isMethod("post")) {
            $userBookingdetail->check_out = $request->early_checkout;
            $userBookingdetail->save();
            if ($user->device_token) {
//                $msg ="You checkout new checkout date is ".$request->early_checkout;
                $msg = "Ohh! It seems you checked out early. Your checked out date is " . $request->early_checkout;
                $this->generateNotification($user->id, "Booking Updated", $msg, 7);
                $this->androidPushNotification(3, "Early Checkout", $msg, $user->device_token, 111, 0, $this->notificationCount($user->id));
//                $this->androidBookingPushNotification("Early Checkout", $msg, $user->device_token, $this->notificationCount($user->id));
            }
            return redirect()->route('admin.users.early-checkout', $id)->with('status', 'Checkout date updated.');
        }

        $css = [
            'vendors/bootstrap-daterangepicker/daterangepicker.css',
        ];
        $js = [
            'vendors/moment/min/moment.min.js',
            'vendors/bootstrap-daterangepicker/daterangepicker.js',
        ];
        return view("admin.users.user-early-checkout", [
            "userBookingdetail" => $userBookingdetail ? $userBookingdetail : [],
            "user" => $user ? $user : [],
            "css" => $css,
            "js" => $js
        ]);
    }

}
