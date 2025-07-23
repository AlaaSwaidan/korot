<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiController;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success'=> false, 'status' => 401,'message' => 'Token is Invalid','data'=>null], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success'=> false, 'status' => 401,'message' => 'Token is Expired','data'=>null], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                return response()->json(['success'=> false, 'status' => 401,'message' => 'Token is Blacklisted','data'=>null], 401);
            }else{
                return response()->json(['success'=> false, 'status' => 401,'message' => 'Authorization Token not found','data'=>null], 401);
            }
        }
        return $next($request);
    }
}
