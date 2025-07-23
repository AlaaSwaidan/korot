<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();
        $session_id = session()->getId();


        if (Auth::guard('admin')->check()){
            if ($user->active_session_id == null){
                Session::getHandler()->destroy($user->active_session_id);
                $user->active_session_id = $session_id;
                $user->save();
            }else{
                if ($user->active_session_id && $user->active_session_id !== $session_id) {
                    Session::getHandler()->destroy($user->active_session_id);
                    $user->active_session_id = $session_id;
                    $user->save();
                }
            }

        }






        return $next($request);
    }
}
