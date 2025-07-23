<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class MerchantType
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
        if(auth()->guard('api_merchant')->user()){
            //check-status.......
            if ( !auth()->guard('api_merchant')->user()->active ){
                return Handle403(trans('api.not_status'));
            }
            if ( !auth()->guard('api_merchant')->user()->approve ){
                return Handle403(trans('api.Sorry_your_membership_wasnt_approved_by_Management'));
            }
            return $next($request);
        }

        return Handle403('نأسف ,ولكن غير مسموح لك بإستخدام هذه الموارد');
    }
}
