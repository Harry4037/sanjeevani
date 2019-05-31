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
use App\Models\Amenity;
use App\Models\MenuStructure;
use App\Models\AuthorityMenuMapping;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller {

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
        return view('admin.operator.index', [
            'js' => $js,
            'css' => $css
        ]);
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

            $query = User::query();
            $query->where("user_type_id", "=", 6);
            if ($searchKeyword) {
                $query->where(function($query) use($searchKeyword) {
                    $query->where("user_name", "LIKE", "%$searchKeyword%")->orWhere("email_id", "LIKE", "%$searchKeyword%");
                });
            }

            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $users = $query->take($limit)->offset($offset)->latest()->get();

            $usersArray = [];
            foreach ($users as $key => $user) {
//                $staffResort = UserBookingDetail::where("user_id", $user->id)->first();

                $usersArray[$key]['name'] = $user->user_name;
                $usersArray[$key]['email'] = $user->email_id;
//                $usersArray[$key]['resort_name'] = isset($staffResort->resort->name) ? $staffResort->resort->name : 'N/A';
//                $checked_status = $user->is_active ? "checked" : '';
//                $usersArray[$key]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                $usersArray[$key]['view-deatil'] = '<a class="btn btn-info btn-xs" href="' . route('admin.operator.edit', ['id' => $user->id]) . '"><i class="fa fa-pencil"></i>Edit</a>'
                        . '<a class="btn btn-primary btn-xs" href="' . route('admin.operator.change-password', ['id' => $user->id]) . '"><i class="fa fa-pencil"></i>Change Password</a>';
            }

            $data['data'] = $usersArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function addUser(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $existingUser = User::where(["email_id" => $request->email, "user_type_id" => 6])->first();
                if ($existingUser) {
                    return redirect()->route('admin.operator.add')->with('error', 'Operator already exist with this email Id.');
                }
                $user = new User();
                $name = explode(" ", $request->name);
                $user->password = bcrypt($request->password);
                $user->user_type_id = 6;
                $user->user_name = $request->name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
                $user->email_id = $request->email;
                $user->created_by = 1;
                $user->updated_by = 1;

                if ($user->save()) {

                    return redirect()->route('admin.operator.index')->with('status', 'Operator has been created successfully.');
                } else {
                    return redirect()->route('admin.operator.add')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.operator.add-user');
        } catch (\Exception $ex) {
            return redirect()->route('admin.operator.index')->with('error', $ex->getMessage());
        }
    }

    public function editUser(Request $request, $id) {
        try {
            $user = User::find($id);

            if ($request->isMethod("post")) {
                $existingUser = User::where(["email_id" => $request->email, "user_type_id" => 6])->first();
                if ($existingUser) {
                    return redirect()->route('admin.operator.edit', $user->id)->with('error', 'Operator already exist with this email Id.');
                }
                $name = explode(" ", $request->name);
                $user->user_name = $request->name;
                $user->first_name = isset($name[0]) ? $name[0] : '';
                $user->last_name = isset($name[1]) ? $name[1] : '';
                $user->email_id = $request->email;
                $user->created_by = 1;
                $user->updated_by = 1;

                if ($user->save()) {
                    return redirect()->route('admin.operator.edit', $user->id)->with('status', 'Operator has been updated successfully.');
                } else {
                    return redirect()->route('admin.operator.edit', $user->id)->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.operator.edit-user', ["user" => $user]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.operator.index')->with('error', $ex->getMessage());
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
                $user = User::findOrFail($request->record_id);
                $user->is_active = $request->status;
                if ($user->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status updated successfully"]];
                } else {
                    return ['status' => false, 'message' => "Something went be wrong."];
                }
            } else {
                return ['status' => false, 'message' => "Method not allowed."];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function changePassword(Request $request, $id) {
        $user = User::find($id);
        if ($request->isMethod("post")) {
            if (Hash::check($request->get("old_password"), $user->password)) {
                $user->password = bcrypt($request->get("new_password"));
                $user->save();
                return redirect()->route('admin.operator.change-password', $user->id)->with('status', 'Password has been updated successfully.');
            } else {
                return redirect()->route('admin.operator.change-password', $user->id)->with('error', 'Old password incorrect.');
            }
        }
        return view('admin.operator.change-password', [
            "user" => $user,
        ]);
    }

}
