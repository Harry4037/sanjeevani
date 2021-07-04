<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
            //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if (\Request::segment(1) == "api") {
            if ($exception instanceof AuthenticationException) {
                return response()->json([
                            'status' => false,
                            'status_code' => 401,
                            'massage' => "Invalid token",
                            'data' => (object) [],
                ]);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                            'success' => false,
                            'status_code' => 400,
                            'message' => 'Method is not allowed for this requeste.',
                            'data' => (object) [],
                ]);
            }

            return response()->json([
                        'success' => false,
                        'status_code' => 400,
                        'message' => $exception->getMessage(),
                        'data' => (object) [],
            ]);
        }


//        dd($exception);

        return parent::render($request, $exception);
    }

}
