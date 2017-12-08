<?php

namespace App\Jobs;

use App\Http\Model\Good;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class importCouponExcel implements ShouldQueue{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $excel;

    /**
     * importCouponExcel constructor.
     * @param $excel
     */
    public function __construct($excel){
        $this->excel = $excel;
    }

    /**
     * @param Good $Good
     */
    public function handle(Good $Good){
        $good = $Good->where('goods_id', $this->excel['goods_id'])->first();
        if ( !$good ){
            $this->excel['counpon_start_time'] = get_time(strtotime($this->excel['counpon_start_time']));
            $this->excel['counpon_endtime'] = get_time(strtotime($this->excel['counpon_endtime']));
            $this->excel['created_at'] = get_time();
            $Good->insert($this->excel);
        }
    }
}
