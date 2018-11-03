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
                $usersArray[$i]['name'] = $user->first_name . ' ' . $user->last_ame;
                $usersArray[$i]['email'] = $user->email_id;
                $usersArray[$i]['mobileno'] = $user->mobile_number;
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$i]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $usersArray[$i]['view-deatil'] = '<a class="btn btn-info btn-xs" href="' . route('admin.staff.detail', ['id' => $user->id]) . '"><i class="fa fa-eye"></i>View</a>';
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
                    return redirect()->route('admin.staff.add')->with('error', 'User already exists with thin mobile number');
                } else {
                    $name = explode(" ", $request->staff_name);

                    $user = $this->user;
                    $user->user_type_id = 2;
                    $user->user_name = $request->staff_name;
                    $user->first_name = isset($name[0]) ? $name[0] : '';
                    $user->last_name = isset($name[1]) ? $name[1] : '';
                    $user->mobile_number = $request->staff_mobile_no;
                    $user->email_id = $request->staff_email;
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
                        return redirect()->route('admin.staff.add')->with('status', 'User has been added successfully');
                    }
                }
            }

            $resorts = Resort::where("is_active", 1)->get();
            return view('admin.staff.add-user', ['resorts' => $resorts]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.staff.add')->with('error', $ex->getMessage());
        }
    }

}
