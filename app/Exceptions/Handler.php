<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function unauthenticated($request, AuthenticationException $exception)
    {
        $guard = Arr::get($exception->guards(), 0);

        switch ($guard)
        {
            case 'admin':
                $login = 'admin.login';
                break;
            default:
                $login = 'website.login';
                break;
        }

        return redirect()->guest(route($login));
    }
    public function render($request, Throwable $e)
    {
        if (Str::contains($request->url(), 'api'))
        {

            if($e instanceof TokenInvalidException) return self::apiResponseUnAuth();

            elseif($e instanceof \BadMethodCallException) return self::setHandlerResponse($e);

            elseif($e instanceof NotFoundHttpException) return self::setHandlerResponse($e, [], 'Not Found',404);

            elseif ($e instanceof \ErrorException) return self::setHandlerResponse($e,null);

            elseif($e instanceof \Error) return self::setHandlerResponse($e,null);

            elseif ($e instanceof ModelNotFoundException) return self::setHandlerResponse($e,null);
        }
        $response= parent::render($request, $e);
        if ($response->status() === 419) {
            return back()->with([
                'warning' => trans('messages.The_page_expired'),
            ]);
        }
        /* to send all errors to email */
        if ($response->status() === 500 && App::environment('production'))
        {
            Mail::to('alaa.breamx@gmail.com')->send(new SendAdminMail(getFormattedException($exception),'Server Error '.$response->status()));
        }
        return $response;
    }
    private static function setHandlerResponse($e, $data = [], $message = '', $code = 500)
    {
        return response()->json([
            'data' => $data,
            'status'=>$code,
            'success' => false,
            'message' => $message == '' ? array($e->getMessage()) : $message
        ], $code);
    }
    private static function apiResponseUnAuth( $code = 401)
    {
        $error = 'Api token is missing or invalid';

        return response()->json(['success'=> false, 'status' => $code, 'message' => $error , 'data'=>null],$code);
    }
}
