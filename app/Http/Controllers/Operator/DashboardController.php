<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\firebase;

class DashboardController extends Controller {

    public function index() {

        return view('operator.dashboard.dashboard');
    }

}
