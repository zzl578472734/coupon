<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 20:46
 */

/**
 * 获取指定时间戳的格式化世家
 * @param string $time
 * @return false|string
 */
function get_time($time = ''){
    $time = $time ? $time : time();
    return date('Y-m-d H:i:s', $time);
}

/**
 * 自定义的打印函数
 * @param $data
 * @param $isPrint
 * @return bool
 */
function getPrint($data, $isPrint = true){
    if ( !$data ){
        return false;
    }
    if ( $isPrint ){
        echo '<pre>';print_r($data);echo '</pre>';exit();
    }
    echo '<pre>';var_dump($data);echo '</pre>';exit();
}