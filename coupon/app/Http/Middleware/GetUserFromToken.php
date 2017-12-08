<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class GetUserFromToken
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
//        echo '<pre>';print_r($user = JWTAuth::parseToken()->authenticate());die;
        //验证token的合法性
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        }

        return $next($request);
    }
}
