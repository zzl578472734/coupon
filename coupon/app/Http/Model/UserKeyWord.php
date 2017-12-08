<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserKeyWord extends Model
{
    const DEFAULT_PAGE_SIZE =  10;
    /**
     * 热搜关键词是否开启的状态
     */
    const STATUS_NORMAL = 1;
    const STATUS_AB_NORMAL = 0;
}
