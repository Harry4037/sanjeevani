<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class firebase {

    private $firebase;

    function __construct() {
        try {
            $request = new Request();
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . "/../../../public/firebase/rindex-customer-firebase-adminsdk-umchl-a68132a638.json");

            $this->firebase = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->create();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function login($user) {
        $user_id = "$user->id";
        $additionalClaims = ['username' => $user->user_name, 'email' => $user->email_id];
        $customToken = $this->firebase->getAuth()->createCustomToken($user_id, $additionalClaims);
        return (string) $customToken;
    }

}
