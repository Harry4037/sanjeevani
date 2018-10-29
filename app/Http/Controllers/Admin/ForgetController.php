<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class ForgetController extends Controller {

    /**
     * Where to redirect after send reset link
     * 
     * @var String 
     */
    protected $redirectTo = '/admin/login#signup';

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request) {
//        $dd = Mail::send("emails.message", [], function($message){
//           $message->to("om@mailinator.com", "jhon 007")->subject("tttttt"); 
//        });
//        
//        
//        dd($dd);
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
                $request->only('email_id')
        );

        return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($request, $response) : $this->sendResetLinkFailedResponse($request, $response);
    }
   
    protected function validateEmail(Request $request) {
        $this->validate($request, ['email_id' => 'required|email']);
    }

}
