<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/12
 * Time: 11:00
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends BaseAdminController{

    /**
     * 登录模块首页
     * @return mixed
     */
    public function index(){
        return view('admin.login.index');
    }

    /**
     * 用户登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request){
        $data = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($data)) {
                return response()->json(['error' => '账户信息错误'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => '创建token失败'], 500);
        }
        return response()->json(['token' => $token]);
    }
}