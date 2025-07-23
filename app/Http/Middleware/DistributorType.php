<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class DistributorType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->guard('api_distributor')->user()){
            //check-status.......
            if ( !auth()->guard('api_distributor')->user()->active ){
                return Handle403(trans('api.not_status'));
            }
            return $next($request);
        }

        return Handle403('نأسف ,ولكن غير مسموح لك بإستخدام هذه الموارد');
    }
}
