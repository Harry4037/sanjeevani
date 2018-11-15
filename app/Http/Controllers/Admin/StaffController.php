<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.staff.index', ['js' => $js, 'css' => $css]);
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

            $query = $this->user->query();
            if ($searchKeyword) {
                $query->where("first_name", "LIKE", "%$searchKeyword%")->orWhere("email_id", "LIKE", "%$searchKeyword%")->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
            }
            $query->where("user_type_id", "=", 2);
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $users = $query->take($limit)->offset($offset)->latest()->get();

            $i = 0;
            $usersArray = [];
            foreach ($users as $user) {
                $staffResort = UserBookingDetail::where("user_id", $user->id)->first();

                $usersArray[$i]['name'] = $user->first_name . ' ' . $user->last_ame;
                $usersArray[$i]['email'] = $user->email_id;
                $usersArray[$i]['mobileno'] = $user->mobile_number;
                $usersArray[$i]['resort_name'] = isset($staffResort->resort->name) ? $staffResort->resort->name : 'N/A';
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $usersArray[$i]['view-deatil'] = '<a class="btn btn-info btn-xs" href="' . route('admin.staff.edit', ['id' => $user->id]) . '"><i class="fa fa-pencil"></i>Edit</a>';
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
            return view('admin.users.user-detail', ["user" => $user]);
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
                    return redirect()->route('admin.staff.index')->with('error', 'User already exists with thin mobile number');
                } else {
                    $name = explode(" ", $request->staff_name);

                    $user = $this->user;
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

                    if ($user->save()) {
                        $userBooking = new UserBookingDetail();
                        $userBooking->source_name = ' ';
                        $userBooking->source_id = ' ';
                        $userBooking->user_id = $user->id;
                        $userBooking->resort_id = $request->resort_id;
                        $userBooking->package_id = 0;
                        $userBooking->save();
                        return redirect()->route('admin.staff.index')->with('status', 'User has been added successfully');
                    }
                }
            }

            $resorts = Resort::where("is_active", 1)->get();
            $states = StateMaster::all();
            return view('admin.staff.add-user', [
                'resorts' => $resorts,
                'states' => $states,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.staff.index')->with('error', $ex->getMessage());
        }
    }

    public function editUser(Request $request, $id) {
        try {
            $user = User::find($id);
            $userBooking = UserBookingDetail::where("user_id", $id)->first();

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'staff_name' => 'bail|required',
                            'staff_mobile_no' => 'bail|required|numeric',
                            'staff_email' => 'bail|required|email',
                            'resort_id' => 'bail|required',
                            'staff_address' => 'bail|required',
                            'city' => 'bail|required',
                            'pin_code' => 'bail|required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.staff.index')->withErrors($validator);
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

            $selectedCity = CityMaster::find($user->city_id);
            $userCites = [];
            if (isset($selectedCity->state->id)) {
                $userCites = CityMaster::where("state_id", $selectedCity->state->id)->get();
            }
//            dd($selectedCity->toArray());
            $resorts = Resort::where("is_active", 1)->get();
            $states = StateMaster::all();
            return view('admin.staff.edit-user', [
                'states' => $states,
                'resorts' => $resorts,
                'user' => $user,
                'userBooking' => $userBooking,
                'selectedCity' => $selectedCity,
                'userCites' => $userCites,
                    ]
            );
        } catch (\Exception $ex) {
//            dd($ex);
            return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
        }
    }

}
