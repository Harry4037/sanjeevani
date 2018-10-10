<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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

        $js = [
            'vendors/datatables.net/js/jquery.dataTables.min.js',
            'js/admin/users.js'
        ];
        return view('admin.users.index', ['js' => $js]);
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

            $searchstring = implode(",", ['firstName', 'emailId', 'mobileNumber']);
            $query = $this->user->query();
            if ($searchKeyword) {
                $query->where("firstName", "LIKE", "%$searchKeyword%")->orWhere("emailId", "LIKE", "%$searchKeyword%");
            }
            $users = $query->get();
            $i = 0;
            $usersArray = [];
            foreach ($users as $user) {
                $usersArray[$i]['name'] = $user->firstName . ' ' . $user->lastName;
                $usersArray[$i]['email'] = $user->emailId;
                $usersArray[$i]['mobileno'] = $user->mobileNumber;
                $usersArray[$i]['action'] = '';
            }
            $data['recordsTotal'] = $this->user->count();
            $data['recordsFiltered'] = $this->user->count();
            $data['data'] = $usersArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
