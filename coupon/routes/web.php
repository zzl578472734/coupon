<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/index/index');
});

/**
 * 后台相关路由
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin' ], function (){
    /**
     * 后台登陆模块
     */
    Route::group(['prefix' => 'login'], function (){

        Route::get('index', 'LoginController@index');
        Route::post('login', 'LoginController@login');

    });
});

// 这边定义了中间件组
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['api']], function (){

    /**
     * 后台首页模块
     */
    Route::group(['prefix' => 'index'], function (){

        Route::get('index', 'IndexController@index');
        Route::match(['get', 'post'],'test', 'IndexController@test');
    });

    /**
     * 后台的图片分类信息
     */
    Route::group(['prefix' => 'group'], function (){

        Route::get('getList', 'GroupController@getList');
    });

    /**
     * 后台的图片模块
     */
    Route::group(['prefix' => 'image'], function (){

        Route::get('index', 'ImageController@index');
        Route::get('getListByGroupId', 'ImageController@getListByGroupId');     //根据分类id获取图片信息
        Route::get('show/{id}', 'ImageController@show');                        //根据图片id获取图片信息

        Route::get('download', 'ImageController@download');                    //图片下载
        Route::post('upload', 'ImageController@upload');                        //图片上传
    });

});

/**
 * 优惠券模块
 */
Route::group(['namespace' => 'Home'], function (){
    /**
     * 首页模块
     */
    Route::group(['prefix' => 'index'], function (){

        Route::get('getSearchKeyWords', 'IndexController@getSearchKeyWords');           //获取用户的热搜关键词
        Route::get('getGoods', 'IndexController@getGoods');                             //获取商品信息
    });
});