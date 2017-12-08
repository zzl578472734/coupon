<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * 图片管理
 * Date: 2017/10/12
 * Time: 14:40
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Model\Group;
use App\Http\Model\Image;
use Illuminate\Http\Request;
use Validator;

class ImageController extends BaseAdminController{

    const IMAGE_CRAW_LIST_KEY = 'image-craw-list';
    const IMAGE_CRAW_SET_KEY = 'image-craw-set';

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('admin.image.index');
    }

    /**
     * 根据分类id获取当前分类线面的图片信息
     * @param Request $request
     * @return mixed
     */
    public function getListByGroupId(Request $request){
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|integer'
        ], [
            'required' => ':attribute为必填项',
            'integer' => ':attribute必须为整数',
        ]);
        if ( $validator->fails() ){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $group_id = $request->input('group_id');

        // 根据group_id获取图片的信息
        $Image = new Image();
        $images = $Image->where('group_id', '=', $group_id)->paginate(Image::DEFAULT_PAGE, ['id', 'name', 'src']);
        if ( $images->isEmpty() ){
            return response()->json(['error' => '当前分类的图片信息不存在'], 404);
        }
        return response()->json(['images' => $images]);
    }

    /**
     * 根据图片id获取图片信息
     * @param $id
     * @return mixed
     */
    public function show($id){
        $Image = new Image();
        $image = $Image->where('id', '=', $id)->first(['id', 'group_id', 'name', 'description', 'src']);
        if ( !$image ){
            return response()->json(['error' => '图片不存在'], 404);
        }
        return response()->json(['image' => $image]);
    }

    /**
     * 更新图片信息
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'bail|required|integer',
            'group_id' => 'bail|required|integer',
            'name' => 'bail|required',
            'description' => 'bail|required|max:50',
            'src' => 'bail|required|src',
        ], [
            'required' => ':attribute为必填项',
            'integer' => ':attribute必须为整数',
            'max' => ':attribute最长为:max',
        ], [
            'id' => '图片id',
            'group_id' => '图片分组id',
            'name' => '图片的名称',
            'description' => '图片的描述信息',
            'src' => '图片的存储路径',
        ]);
        if ( $validator->fails() ){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $data = $request->only(['name', 'description', 'src']);
        $search = $request->only(['id', 'group_id']);

        //判断当前的图片是否存在
        $Image = new Image();
        $image = $Image->where('id', '=', $search['id'])->first();
        if ( !$image ){
            return response()->json(['error' => '图片不存在'], 404);
        }
        $group = (new Group())->where('id', '=', $search['group_id'])->first();
        if ( !$group ){
            return response()->json(['error' => '图片的分类不存在'], 404);
        }

        //TODO 判断当前的图片保存的路径是否可读写
        if ( $Image->where('id', '=', $search['id'])->update(array_merge($data, ['group_id' => $search['group_id']])) ){
            return response()->json(['success' => 'ok']);
        }
        return response()->json(['error' => '图片更新失败'], 500);
    }

    /**
     * 上传图片
     * @param Request $request
     */
    public function upload(Request $request){}


    /**
     * 抓取图片(采用socket的方式)
     */
    public function download(){
        
    }


    /**
     * 抓取图片（临时方案）
     */
//    public function download(){
//        $CrawUrl =  new CrawUrl();
//        $crawUrl = $CrawUrl->where('is_craw', $CrawUrl::IS_CRAW_FALSE)->first();
//        if ( !$crawUrl ){
//            return response()->json(['error' => '暂无需要爬去的图片url'], 401);
//        }
//        if ( Redis::sismember(self::IMAGE_CRAW_SET_KEY, $crawUrl->url)){
//            return response()->json(['error' => '请缓一缓,图片抓取中...'], 401);
//        }
//        //php执行python代码，抓取图片信息
//
//        return response()->json(['error' => '图片抓取失败'], 500);
//    }

    /**
     * 抓取图片（长久方案）
     */
//    public function download(){
//        $CrawUrl =  new CrawUrl();
//        $crawUrl = $CrawUrl->where('is_craw', $CrawUrl::IS_CRAW_FALSE)->first();
//        if ( !$crawUrl ){
//            return response()->json(['error' => '暂无需要爬去的图片url'], 401);
//        }
//        if ( Redis::sismember(self::IMAGE_CRAW_SET_KEY, $crawUrl->url)){
//            return response()->json(['error' => '请缓一缓,图片抓取中...'], 401);
//        }
//        //发送爬取图片的消息和url
//        if ( Redis::lpush(self::IMAGE_CRAW_LIST_KEY, json_encode(array('time' => time(), 'url'  => $crawUrl->url)))){
//            Redis::sadd(self::IMAGE_CRAW_SET_KEY, $crawUrl->url);
//            return response()->json(['success' => '图片抓取中....']);
//        }
//        return response()->json(['error' => '图片抓取失败'], 500);
//    }

}