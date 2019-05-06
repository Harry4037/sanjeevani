<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class LoginController extends Controller {

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/operator/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('operator');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        return $request->only($this->username(), 'password', 'user_type_id');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {

        if (Auth::guard('operator')->check()) {
            return redirect('/operator/dashboard');
        }
        return view('operator.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function validateLogin(Request $request) {
        $this->validate($request, [
            'email_id' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username() {
        return 'email_id';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request) {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $request->merge(["user_type_id" => 5]);
//        $user = User::where('email_id', $request->get('email_id'))->first();
        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Logout user
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('operator.login');
    }

    public function profile(Request $request) {
        try {
            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'profile_pic' => 'bail|max:1000|mimes:jpeg,jpg,png',
                                ], [
                            'profile_pic.max' => 'Image not more than 1000 kb.',
                            'profile_pic.mimes' => 'Only jpeg,jpg,png images are allowed.',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.profile')->withErrors($validator)->withInput();
                }

                $user = User::find($request->get('record_id'));
                $user->user_name = $request->get("user_name");
                $user->email_id = $request->get("email_id");
                if ($request->hasFile("profile_pic")) {
                    $profile_pic = $request->file("profile_pic");
                    $profile = Storage::disk('public')->put('profile_pic', $profile_pic);
                    $profile_file_name = basename($profile);
                    $user->profile_pic_path = $profile_file_name;
                }
                $user->save();
                return redirect()->route('admin.profile')->with('status', 'Profile has been updated successfully.');
            }
            return view('admin.profile.index');
        } catch (\Exception $ex) {
            return redirect()->route('admin.profile')->with('error', $ex->getMessage());
        }
    }

    public function changePassword(Request $request) {
        if ($request->isMethod("post")) {
            $user = User::find($request->get('record_id'));
            if (Hash::check($request->get("old_password"), $user->password)) {
                $user->password = bcrypt($request->get("new_password"));
                $user->save();
                return redirect()->route('admin.change-password')->with('status', 'Password has been updated successfully.');
            } else {
                return redirect()->route('admin.change-password')->with('error', 'Old password incorrect.');
            }
        }
        return view('admin.profile.change-password');
    }

//    public function test(){
//        $this->androidPushNotification(2, "asdas", "adasd", "sadsadsadsadsa", 1, 1);
//        die;
//    }
}
