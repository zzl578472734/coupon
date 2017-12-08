<?php

namespace App\Http\Middleware;

use App\Events\ApiCall;
use Closure;

class ApiBegin
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
        //这里注册事件，当api被调用的时候，记录日志信息
        event(new ApiCall($request));

        return $next($request);
    }
}
