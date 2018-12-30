<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBookingDetail;

class RedirectIfSubAdminAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin') {

        if (!Auth::guard('subadmin')->check()) {
            return redirect('/sub-admin');
        } elseif (Auth::guard('subadmin')->check()) {
            $userDetail = UserBookingDetail::where("user_id", Auth::guard('subadmin')->user()->id)->first();
            $request->merge(["subadminResort" => $userDetail ? $userDetail->resort_id : 0]);
        } else {
            $request->merge(["subadminResort" => 0]);
        }

        return $next($request);
    }

}
