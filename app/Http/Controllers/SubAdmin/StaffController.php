<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Resort;
use App\Models\UserBookingDetail;
use App\Models\StateMaster;
use App\Models\CityMaster;
use App\Models\Amenity;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller {

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
        return view('subadmin.staff.index', ['js' => $js, 'css' => $css]);
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
            $userBookingDetail = UserBookingDetail::where("resort_id", $request->get("subadminResort"))->pluck("user_id");
            if ($userBookingDetail) {
                $userIds = $userBookingDetail->toArray();
            } else {
                $userIds = [];
            }
            $query = $this->user->query();
            $query->where("user_type_id", "=", 2);
            $query->whereIn("id", $userIds);
            if ($searchKeyword) {
                $query->where(function($query) use($searchKeyword) {
                    $query->where("first_name", "LIKE", "%$searchKeyword%")->orWhere("email_id", "LIKE", "%$searchKeyword%")->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
                });
            }

            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $users = $query->take($limit)->offset($offset)->latest()->get();

            $i = 0;
            $usersArray = [];
            foreach ($users as $user) {
                $staffResort = UserBookingDetail::where("user_id", $user->id)->first();

                $usersArray[$i]['name'] = $user->user_name;
                $usersArray[$i]['email'] = $user->email_id;
                $usersArray[$i]['mobileno'] = $user->mobile_number;
                $duty_status = $user->is_push_on ? "checked" : '';
                $usersArray[$i]['is_push_on'] = "<label class='switch'><input  type='checkbox' class='duty_status' id=" . $user->id . " data-status=" . $user->is_push_on . " " . $duty_status . "><span class='slider round'></span></label>";
//                $usersArray[$i]['resort_name'] = isset($staffResort->resort->name) ? $staffResort->resort->name : 'N/A';
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $usersArray[$i]['view-deatil'] = '<a class="btn btn-info btn-xs" href="' . route('subadmin.staff.edit', ['id' => $user->id]) . '"><i class="fa fa-pencil"></i>Edit</a>';
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
            return view('subadmin.users.user-detail', ["user" => $user]);
        } catch (Exception $ex) {
            dd($e);
        }
    }

    public function addUser(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $userExist = User::where("mobile_number", $request->staff_mobile_no)
                        ->where("user_type_id", 2)
                        ->first();

                if ($userExist) {
                    return redirect()->route('subadmin.staff.add')->with('error', 'User already exists with this mobile number.');
                } else {
                    $name = explode(" ", $request->staff_name);

                    $user = $this->user;
                    if ($request->is_booking == "on") {
                        $user->is_booking = 1;
                    }
                    if ($request->is_service_authorise == "on") {
                        $user->is_service_authorise = 1;
                    }
                    if ($request->is_meal_authorise == "on") {
                        $user->is_meal_authorise = 1;
                    }
                    if (!empty($request->amenity_ids)) {
                        $user->authorise_amenities_id = implode("#", $request->amenity_ids);
                    }
                    $user->otp = 9999;
                    $user->password = bcrypt(9999);
                    $user->user_type_id = 2;
                    $user->user_name = $request->staff_name;
                    $user->first_name = isset($name[0]) ? $name[0] : '';
                    $user->last_name = isset($name[1]) ? $name[1] : '';
                    $user->mobile_number = $request->staff_mobile_no;
                    $user->email_id = $request->staff_email;
                    $user->address1 = $request->staff_address;
                    $user->city_id = $request->city;
                    $user->pincode = $request->pin_code;
                    $user->created_by = 1;
                    $user->updated_by = 1;
                    if ($request->hasFile("profile_pic")) {
                        $profile_pic = $request->file("profile_pic");
                        $profile = Storage::disk('public')->put('profile_pic', $profile_pic);
                        $profile_file_name = basename($profile);
                        $user->profile_pic_path = $profile_file_name;
                    }

                    if ($user->save()) {
                        $userBooking = new UserBookingDetail();
                        $userBooking->source_name = ' ';
                        $userBooking->source_id = ' ';
                        $userBooking->user_id = $user->id;
                        $userBooking->resort_id = $request->get("subadminResort");
                        $userBooking->package_id = 0;
                        $userBooking->save();
                        return redirect()->route('subadmin.staff.index')->with('status', 'Staff has been added successfully');
                    } else {
                        return redirect()->route('subadmin.staff.add')->with('error', 'Something went be wrong.');
                    }
                }
            }

            $css = [
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/iCheck/icheck.min.js',
            ];

            $amenities = Amenity::where(["resort_id" => $request->get("subadminResort"), "is_active" => 1])->get();
            $states = StateMaster::all();
            return view('subadmin.staff.add-user', [
                'css' => $css,
                'js' => $js,
                'amenities' => $amenities,
                'states' => $states,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.staff.index')->with('error', $ex->getMessage());
        }
    }

    public function editUser(Request $request, $id) {
        try {
            $user = User::find($id);
            $userBooking = UserBookingDetail::where("user_id", $id)->first();
            if ($request->isMethod("post")) {

                $name = explode(" ", $request->staff_name);

                if ($request->is_booking == "on") {
                    $user->is_booking = 1;
                } else {
                    $user->is_booking = 0;
                }
                if ($request->is_service_authorise == "on") {
                    $user->is_service_authorise = 1;
                } else {
                    $user->is_service_authorise = 0;
                }
                if ($request->is_meal_authorise == "on") {
                    $user->is_meal_authorise = 1;
                } else {
                    $user->is_meal_authorise = 0;
                }
                if (!empty($request->amenity_ids)) {
                    $user->authorise_amenities_id = implode("#", $request->amenity_ids);
                } else {
                    $user->authorise_amenities_id = "";
                }

//                $user->otp = 9999;
//                $user->password = bcrypt(9999);
                $user->user_name = $request->staff_name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
                $user->mobile_number = $request->staff_mobile_no;
                $user->email_id = $request->staff_email;
                $user->pincode = $request->pin_code;
                $user->created_by = 1;
                $user->updated_by = 1;
                if ($request->hasFile("profile_pic")) {
                    $profile_pic = $request->file("profile_pic");
                    $profile = Storage::disk('public')->put('profile_pic', $profile_pic);
                    $profile_file_name = basename($profile);
                    $user->profile_pic_path = $profile_file_name;
                }

                if ($user->save()) {
                    if (!$userBooking) {
                        $userBooking = UserBookingDetail::where("user_id", $user->id)->first();
                    }
                    $userBooking->source_name = ' ';
                    $userBooking->source_id = ' ';
                    $userBooking->user_id = $user->id;
                    $userBooking->resort_id = $request->get("subadminResort");
                    $userBooking->package_id = 0;
                    $userBooking->save();

                    return redirect()->route('subadmin.staff.index')->with('status', 'Staff has been updated successfully.');
                } else {
                    return redirect()->route('subadmin.staff.index', $id)->with('error', 'Something went be wrong.');
                }
            }

            $selectedCity = CityMaster::find($user->city_id);
            $userCites = [];
            if (isset($selectedCity->state->id)) {
                $userCites = CityMaster::where("state_id", $selectedCity->state->id)->get();
            }
            $selectedResortAmenities = [];
            if ($userBooking) {
                $selectedResortAmenities = Amenity::where(["is_active" => 1, "resort_id" => $userBooking->resort_id])->get();
            }
            $authoriseAmenity = explode("#", $user->authorise_amenities_id);
            $resorts = Resort::where("is_active", 1)->get();
            $states = StateMaster::all();
            $css = [
                "vendors/iCheck/skins/flat/green.css",
            ];
            $js = [
                'vendors/iCheck/icheck.min.js',
            ];
            return view('subadmin.staff.edit-user', [
                'css' => $css,
                'js' => $js,
                'states' => $states,
                'resorts' => $resorts,
                'user' => $user,
                'userBooking' => $userBooking,
                'selectedCity' => $selectedCity,
                'userCites' => $userCites,
                'selectedResortAmenities' => $selectedResortAmenities,
                'authoriseAmenity' => $authoriseAmenity,
                    ]
            );
        } catch (\Exception $ex) {
            return redirect()->route('subadmin.users.index')->with('error', $ex->getMessage());
        }
    }

    public function getAmenities(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $css = [
                    "vendors/iCheck/skins/flat/green.css",
                ];
                $js = [
                    "vendors/jquery/dist/jquery.min.js",
                    'vendors/iCheck/icheck.min.js',
                ];

                $resort_id = $request->get("resort_id");
                $amenities = Amenity::where(["resort_id" => $resort_id, "is_active" => 1])->get();
                return view("subadmin.staff.amenity-list", [
                    "amenities" => $amenities,
                    "css" => $css,
                    "js" => $js,
                ]);
            }
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function updateUserDutyStatus(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $user = $this->user->findOrFail($request->record_id);
                $user->is_push_on = $request->status;
                if ($user->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Duty Status updated successfully"]];
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

}
