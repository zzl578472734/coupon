<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/21
 * Time: 15:14
 */
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;

class BaseLogic extends Controller{

    /**
     * 全局的curl请求方法
     * @param $url
     * @param array $data
     * @return bool
     */
    public function httpRequest($url, $data = array()){
        if ( !$url ){
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TRANSFERTEXT, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ( $data ){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ( $error ){
            return response()->json(['error' => $error], 500);
        }
        return $result;
    }

}