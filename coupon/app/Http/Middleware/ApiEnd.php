<?php

namespace App\Http\Middleware;

use Closure;

class ApiEnd
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
        $response = $next($request);

//        记录返回的结果日志信息
        return $response;
    }
}
