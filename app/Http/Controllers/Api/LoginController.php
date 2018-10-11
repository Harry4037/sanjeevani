<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class LoginController extends Controller {

    /**
     * @apiDescription This api is used to send OTP
     * @api {post} /api/user-login  User Login
     * @apiName send otp
     * @apiGroup Login
     *
     * @apiParam {phone_no} phone number User phone number.
     *
     * @apiSuccess {String} success true 
     * @apiSuccess {String}   message for the User.
     * @apiSuccess {JSON}   data object for the User.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
      "status": 1,
      "acessToken": {
      "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM4MmZkNDM4MzhlOTkzZGJmMjlkODE1YjcxMDgxZmQ1MTRlY2E5NWUxMjEzZjdkYjRhNmY4MjdmMGYzZTgzY2IzY2NlYzJlYzhkMzZiY2Q0In0.eyJhdWQiOiIyIiwianRpIjoiYzgyZmQ0MzgzOGU5OTNkYmYyOWQ4MTViNzEwODFmZDUxNGVjYTk1ZTEyMTNmN2RiNGE2ZjgyN2YwZjNlODNjYjNjY2VjMmVjOGQzNmJjZDQiLCJpYXQiOjE1MzEyMTIwOTYsIm5iZiI6MTUzMTIxMjA5NiwiZXhwIjoxNTYyNzQ4MDk2LCJzdWIiOiIxMiIsInNjb3BlcyI6W119.NAJ9rPgow6DP5r-tSpZlpY_puocGjSU60047RyQiWCf2LjAU_OMK2YnIHArQkW6p-8Xiv0qy44mpQLdqbzQtKC-g_7sD3lu9OgnWU5kGNooeAx1BVstBmAP63ZFBD9LOn-iXTgNZVpeMVLf82LXjFNR0wd1Q3XZhrPv_mrb7IDUZHRGwdgHUzeyI8Sqy-EGWDfynZx3wY43xfoizyT9s7WVkLwQD6yX4KEirUuQFtEqy3r-UDAi10pIElpxuQrL7N3L-0H-wb23qPFm3ELJrA4LZf3fPHiTACEYAwDbHCunl7dEehx08XM9G3xm4r68r8R3Ld0WoCxkgEW5ZDTLDSe0XVH-NEr_7iFmZh6cZuqMpxRXoDRXST0V-BlD7uJ_ZSROMPNn8XNUQaKbyTgLrtA_ZgruQCCJGU2mfSn1GdRNqyGek7OC9X2EUNgSBh0TYL0nT0uuCLUFLpGf7ncIeQSX9uSFbqQ4OfsjOmE162QPrtucqbutBVgPm_PoUBzowIKtyS2yp4x53YoKAvH9-pYyLcvxHeez7E9S-7YJ9mIx7EcMO6spOudly81DTYORm5XE9DHxPJTh-NaBLbgfS7cGwatOpkSQlDGJqYHcmQgBcIa7NsB8Q5MUlDz5L6DQdLHSDuO_o-5CUhnAdOkDeqNKXmY72EZxMMO-sXOGCwRg",
      "token": {
      "id": "c82fd43838e993dbf29d815b71081fd514eca95e1213f7db4a6f827f0f3e83cb3ccec2ec8d36bcd4",
      "user_id": 12,
      "client_id": 2,
      "name": "userToken",
      "scopes": [],
      "revoked": false,
      "created_at": "2018-07-10 08:41:36",
      "updated_at": "2018-07-10 08:41:36",
      "expires_at": "2019-07-10 08:41:36"
      }
      },
      "user": {
      "id": 12,
      "full_name": "Pratiraksha Agnihotri",
      "email": "pratiraksha_agnihotri@seologistics.com",
      "profile_pic": null,
      "password_reset_token": null,
      "type": "user",
      "slug": null,
      "token": "",
      "status": "1",
      "created_at": "2018-07-03 06:32:25",
      "updated_at": "2018-07-04 04:15:09"
      }
      }
     *  @apiVersion 1.0.0
     */
    public function sendOtp(Request $request) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                        'phone_no' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => false, 'message' => $validator->errors()];
            }

            $phoneNumber = $request->only('phone_no');
            $credentials['type'] = 'user';
            $credentials['status'] = '1';
            $user = User::where('mobileNumber', $phoneNumber)
                    ->first();
            // $remember=$request->input('remember')?true:false;
            if (empty($user)) {
                $user = new User();
                $user->salutationId = 0;
                $user->firstName = '';
                $user->lastName = '';
                $user->midName = '';
                $user->gender = 'M';
                $user->emailId = '';
                $user->alternateEmailId = '';
                $user->ScreenName = '';
                $user->dateOfJoining = date('y-m-d H:i');
                $user->dateOfBirth = date('y-m-d H:i');
                $user->profilePicPath = '';
                $user->mobileNumber = $phoneNumber;
                $user->otherContactNumber = $phoneNumber;
                $user->address1 = '';
                $user->address2 = '';
                $user->address3 = '';
                $user->pincode = '';
                $user->cityId = 0;
                $user->secuityQuestion = '';
                $user->secuityQuestionAnswer = '';
                $user->RefTimeZoneId = 0;
                $user->userTypeId = 2;
                $user->otherInfo = '';
                $user->designationId = 0;
                $user->departmentId = 0;
                $user->languageId = 0;
                $user->authorityId = 0;
                $user->userIdRA = 0;
                $user->isUserLoked = 0;
                $user->loginExpiryDate = data('y-m-d H:i');
                $user->isActive = 1;
                $user->domainId = 0;
                $user->domainId = 0;
                $user->save();
                return ['status' => true, 'message' => 'OTP send successfully.', 'data' => []];
                // return redirect()->intended($this->redirectTo);
            } else {
                return ['status' => false, 'message' => 'Moile number already exist.', 'data' => []];
            }
        }
    }

}
