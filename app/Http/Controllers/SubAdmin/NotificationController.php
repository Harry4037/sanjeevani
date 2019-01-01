<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller {

    public function index() {
        $users = User::where("is_active", 1)->where('user_type_id','!=',1)->get();
        return view('subadmin.notification.index', compact('users'));
    }

    public function sendNotification(Request $request) {
        $validator = Validator::make($request->all(),[
            'title'   =>  'required',
            'message'   =>  'required',
            'notify_user'   =>  'required_if:user_type,2',
            'user_type'   =>  'required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors()->all()[0], (object) [],200);
        }

        $tokens = User::where("is_active", 1)
        ->where('user_type_id','!=',1)
        ->where("device_token",'!=',null)
        ->when($request->user_type == 2,function($query) use($request){
            return $query->whereIn('id',$request->notify_user);
        })
        ->pluck("device_token")->toArray();

        if (count($tokens)) {
            $this->androidPushNotification(3, $request->title, $request->message, $tokens,123,0);
        }

        return $this->sendSuccessResponse("Notification send successfully", (object) [],200);
    }


}
