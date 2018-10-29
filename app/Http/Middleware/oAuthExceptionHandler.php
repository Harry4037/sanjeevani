<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class oAuthExceptionHandler {

    public function handle($request, Closure $next) {
        try {
            $response = $next($request);

            if (isset($response->exception) && $response->exception) {
                throw $response->exception;
            }

            return $response;
        } catch (\Exception $e) {
            return response()->json(array(
            'status' => false,
            'status_code' => 401,
            'massage' => "Invalid token",
            'data' => (object) [],
            ));
        }
    }

}
