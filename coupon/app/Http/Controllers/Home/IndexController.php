<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * 优惠券-首页
 * Date: 2017/10/16
 * Time: 11:33
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Base\BaseHomeController;
use App\Http\Model\Good;
use App\Http\Model\UserKeyWord;
use Illuminate\Http\Request;
use Validator;

class IndexController extends BaseHomeController{

    /**
     * 用户的热搜关键词
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchKeyWords(){
        $UserKeyWord = new UserKeyWord();
        $user_key_words = $UserKeyWord->where('status', $UserKeyWord::STATUS_NORMAL)->orderBy('number', 'desc')->limit($UserKeyWord::DEFAULT_PAGE_SIZE)->pluck('name');
        if ( $user_key_words->isEmpty() ){
            return response()->json(['error' => '当前暂无用户的热搜关键词'], 401);
        }
        return response()->json($user_key_words);
    }

    /**
     * 获取商品列表信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGoods(Request $request){

        $keywords = $request->input('keywords');

        $Good = new Good();
        if ( $keywords ){
            //记录用户输入的关键词信息
            $this->addRecordKeyWord($keywords);
            $good = $Good->where('name', 'like', '%'.$keywords.'%')->simplePaginate($Good::DEFAULT_PAGE_SIZE, ['id', 'name', 'image', 'price', 'coupon_value', 'month_safe_number']);
        }else{
            $good = $Good->simplePaginate($Good::DEFAULT_PAGE_SIZE, ['id', 'name', 'image', 'price', 'coupon_value', 'month_safe_number']);
        }
        if ( $good->isEmpty() ){
            return response()->json(['error' => '暂无数据'], 401);
        }
        return response()->json($good);
    }

    /**
     * 添加或者更新用户的关键词列表信息
     * @param $keywords
     * @return bool|int
     */
    private function addRecordKeyWord($keywords){
        //查询关键词信息
        $UserKeyWord = new UserKeyWord();
        $id = $UserKeyWord->where('name', $keywords)->value('id');
        if ( $id ){
            return $UserKeyWord->where('id', '=', $id)->increment('number');
        }
        return $UserKeyWord->insert(['name' => $keywords, 'created_at' => date('Y-m-d H:i:s', time()), 'updated_at' => date('Y-m-d H:i:s', time())]);
    }
}