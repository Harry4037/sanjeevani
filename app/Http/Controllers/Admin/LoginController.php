<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserBookingDetail;
use Validator;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;

class LoginController extends Controller {

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

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
        return Auth::guard('admin');
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

        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
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
        $request->merge(["user_type_id" => 1]);
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
        return redirect()->route('admin.login');
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
            $validator = Validator::make($request->all(), [
                        'new_password' => 'bail|required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/',
                            ], [
                        'new_password.regex' => "New password must be minimum six character, One numeric digit, One special character, One uppercase and One lowercase letter."
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.change-password')->withErrors($validator);
            }

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

    public function test() {
        $next2days = date('Y-m-d H:i:s', strtotime("+2 days"));
        $next2days24Hour = date('Y-m-d H:i:s', strtotime("+24 hours", strtotime($next2days)));

        $userBookings = UserBookingDetail::whereBetween("check_in", [$next2days, $next2days24Hour])->get();
//        dd($userBookings);
        foreach ($userBookings as $userBooking) {
            $user = User::find($userBooking->user_id);
//                if ($user->device_token) {
            config(['fcm.http.server_key' => 'AAAAZDeprME:APA91bHyGVMy54RTPTZKyj-gsF5L31IsHP0efkEm4RorsITp-yH2Syh-ftIuuaIu2zm7zZpJZp_CBmY4B33yahx1uZWG570_z6bJ9OxnuX2_Zzh9NFwVbtYKANXRh7SpsQZPq328Y-Jj']);
            config(['fcm.http.sender_id' => '430430596289']);


            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20)
                    ->setPriority('high');

            $notificationBuilder = new PayloadNotificationBuilder("Reminder Notification");
            $notificationBuilder->setBody("You upcoming booking date is " . date("d-m-Y", strtotime($userBooking->check_in)))
                    ->setSound('soundn.mp3');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
                'title' => "Reminder Notification",
                'message' => "You upcoming booking date is " . date("d-m-Y", strtotime($userBooking->check_in)),
                "type" => 234,
                "user_type_id" => 3,
                "sound" => "soundn.mp3",
            ]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $token = "cj2GrsTHQlU:APA91bGw707gSY_IYpVY0_cYHm8GiBVslMc86er03xkNr8_ixiuyN95OmVH0ctLSv9JOjq5acIHjKnWfq_fx0yxw3KidSkSrVdHx2TWjFBzaJhwpt72B6IcB0UN24G_fBbsy3f4OPw-K";

            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        }
//            }
        dd("success");
    }

}
