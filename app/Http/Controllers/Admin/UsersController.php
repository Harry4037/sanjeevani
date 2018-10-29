<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Routing\Route;
use Carbon\Carbon;
use App\Models\UserBookingDetail;
use App\Models\RoomBooking;
use App\Models\BookingpeopleAccompany;
use App\Models\Resort;
use App\Models\RoomType;
use App\Models\ResortRoom;

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

            $query = $this->user->query();
            if ($searchKeyword) {
                $query->where("first_name", "LIKE", "%$searchKeyword%")->orWhere("email_id", "LIKE", "%$searchKeyword%")->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
            }
            $query->where("user_type_id", "!=", 1);
            $users = $query->get();
            $i = 0;
            $usersArray = [];
            foreach ($users as $user) {
                $usersArray[$i]['name'] = $user->first_name . ' ' . $user->last_ame;
                $usersArray[$i]['email'] = $user->email_id;
                $usersArray[$i]['mobileno'] = $user->mobile_number;
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $usersArray[$i]['action'] = '<a class="btn btn-info btn-xs" href="' . route('admin.users.detail', ['id' => $user->id]) . '"><i class="fa fa-eye"></i>View</a><a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';
                $i++;
            }
            $data['recordsTotal'] = $this->user->count();
            $data['recordsFiltered'] = $this->user->count();
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

        if ($request->isMethod("post")) {
            $userExist = User::where("mobile_number", $request->mobile_number)
                    ->where("user_type_id", 3)
                    ->first();
            if ($userExist) {
                return redirect()->route('admin.users.add')->with('error', 'User already exists with thin mobile number');
            } else {
                $name = explode(" ", $request->user_name);

                $user = $this->user;
                $user->user_type_id = 3;
                $user->user_name = $request->user_name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
                $user->mobile_number = $request->mobile_number;
                $user->email_id = $request->email_id;
                $user->created_by = 1;
                $user->updated_by = 1;

                if ($user->save()) {
                    $userBooking = new UserBookingDetail();
                    $userBooking->source_name = $request->booking_source_name;
                    $userBooking->source_id = $request->booking_source_id;
                    $userBooking->user_id = $user->id;
                    $userBooking->resort_id = $request->resort_id;
                    $userBooking->package_id = $request->package_id;
                    if ($userBooking->save()) {
                        $roomBooking = new RoomBooking();
                        $roomBooking->booking_id = $userBooking->id;
                        $roomBooking->room_type_id = $request->resort_room_type;
                        $roomBooking->resort_room_id = $request->resort_room_id;
                        $check_in_date = Carbon::parse($request->check_in);
                        $roomBooking->check_in = $check_in_date->format('Y-m-d');
                        $check_out_date = Carbon::parse($request->check_out);
                        $roomBooking->check_out = $check_out_date->format('Y-m-d');
                        $roomBooking->save();
                        if (!empty($request->person_name) && !empty($request->person_age)) {
                            $i = 0;
                            foreach ($request->person_name as $person_name) {
                                $familyMember = new BookingpeopleAccompany();
                                $familyMember->person_name = $person_name ? $person_name : ' ';
                                $familyMember->person_age = $request->person_age[$i] ? $request->person_age[$i] : ' ';
                                $familyMember->booking_id = $userBooking->id;
                                $familyMember->save();
                                $i++;
                            }
                        }
                    }

                    return redirect()->route('admin.users.add')->with('status', 'User has been added successfully');
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
        return view('admin.users.add-user', ['js' => $js, 'css' => $css, 'resorts' => $resorts, 'roomTypes' => $roomTypes]);
    }

    public function editUser(Request $request, $id) {
        $user = User::find($id);
        $userBooking = UserBookingDetail::where("user_id", $id)->first();
        $roomTypes = RoomType::where("is_active", 1)->get();
        if($userBooking){
            $roomBooking = RoomBooking::where("booking_id", $userBooking->id)->first();
            $bookingAccompany = BookingpeopleAccompany::where("booking_id", $userBooking->id)->get();
            $resortRooms = ResortRoom::where(["resort_id" => $userBooking->resort_id, "room_type_id" => $roomBooking->room_type_id])->get();
        }
        if ($request->isMethod("post")) {
                $name = explode(" ", $request->user_name);

                $user->user_name = $request->user_name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
                $user->mobile_number = $request->mobile_number;
                $user->email_id = $request->email_id;
                $user->created_by = 1;
                $user->updated_by = 1;

                if ($user->save()) {
                    $userBooking = UserBookingDetail::where("user_id", $user->id)->first();
                    if(!$userBooking){
                        $userBooking = new UserBookingDetail();
                    }
                    $userBooking->source_name = $request->booking_source_name;
                    $userBooking->source_id = $request->booking_source_id;
                    $userBooking->user_id = $user->id;
                    $userBooking->resort_id = $request->resort_id;
                    $userBooking->package_id = $request->package_id;
                    if ($userBooking->save()) {
                        $roomBooking = RoomBooking::where("booking_id", $userBooking->id)->first();
                        if(!$roomBooking){
                            $roomBooking = new RoomBooking();
                        }
                        $roomBooking->booking_id = $userBooking->id;
                        $roomBooking->room_type_id = $request->resort_room_type;
                        $roomBooking->resort_room_id = $request->resort_room_id;
                        $check_in_date = Carbon::parse($request->check_in);
                        $roomBooking->check_in = $check_in_date->format('Y-m-d');
                        $check_out_date = Carbon::parse($request->check_out);
                        $roomBooking->check_out = $check_out_date->format('Y-m-d');
                        $roomBooking->save();
                        
                        if (!empty($request->person_name) && !empty($request->person_age)) {
                            BookingpeopleAccompany::where("booking_id", $userBooking->id)->delete();
                            $i = 0;
                            foreach ($request->person_name as $person_name) {
                                $familyMember = new BookingpeopleAccompany();
                                $familyMember->person_name = $person_name ? $person_name : ' ';
                                $familyMember->person_age = $request->person_age[$i] ? $request->person_age[$i] : ' ';
                                $familyMember->booking_id = $userBooking->id;
                                $familyMember->save();
                                $i++;
                            }
                        }
                    }

                    return redirect()->route('admin.users.edit', $id)->with('status', 'User has been updated successfully');
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
        return view('admin.users.edit-user', [
            'js' => $js,
            'css' => $css,
            'resorts' => $resorts,
            'roomTypes' => $roomTypes,
            'user' => $user,
            'userBooking' => $userBooking,
            'resortRooms' => isset($resortRooms) ? $resortRooms : [],
            'roomBooking' => isset($roomBooking) ? $roomBooking : [],
            'bookingAccompany' => isset($bookingAccompany) ? $bookingAccompany : [],
            
                ]
        );
    }

}
