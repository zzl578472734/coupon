<?php

namespace App\Listeners;

use App\Events\ApiCall;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApiCallLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * 事件监听处理
     * @param  ApiCall  $event
     * @return void
     */
    public function handle(ApiCall $event)
    {
        //记录日志信息
        $this->recordLoger($event->request->all(), $event->request->getClientIp(), $event->request->url(), $event->request->fullUrl());
    }

    /**
     * 记录用户的信息
     * @param array $info 用户的请求信息
     * @param string $ip   用户的ip
     * @param string $url   用户请求的url
     * @param string $fullUrl   用户请求完整的url
     */
    private function recordLoger($info, $ip, $url, $fullUrl){
        logger(json_encode(array_merge($info, array('ip' => $ip, 'timestamp' => time(), 'url' => $url, 'fullurl' => $fullUrl))));
    }
}
