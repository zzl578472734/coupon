<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * 爬取的url
 * Date: 2017/10/21
 * Time: 13:01
 */
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CrawUrl extends Model{

    /**
     * 是否爬取过过的url
     */
    const IS_CRAW_TRUE = 1;
    const IS_CRAW_FALSE = 0;
}