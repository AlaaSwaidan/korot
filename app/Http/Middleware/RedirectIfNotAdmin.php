<?php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Support\Facades\Auth;
use Auth;

class RedirectIfNotAdmin
{
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     * @return mixed
//     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null $guard
     * @param  string $redirectTo
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $redirectTo = '/admin/login')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect($redirectTo);
        }

        Auth::shouldUse($guard);

        //check-status.......
        if ( !Auth::guard($guard)->user()->status ){
            Auth::logout();
            return redirect($redirectTo)->with('warning', 'تم إيقاف عضويتك من قبل الإدارة');
        }
        return $next($request);
    }
}
