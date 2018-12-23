<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller {

    public function index() {
        $users = User::where("is_active", 1)->where('user_type_id',3)->get();
        return view('admin.booking.index', compact('users'));
    }

}
