<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/12
 * Time: 17:34
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Model\Good;
use App\Jobs\importCouponExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends BaseAdminController{

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //获取请求当中的token
        return view('admin.index.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function test(Request $request){

        if ( $request->isMethod('post')){
            set_time_limit(0);

            $file = $request->file('coupon');

            //上传文件，并且保存客户端上传上来的文件名
            if ( !Storage::put($file->getClientOriginalName(), file_get_contents($file->getRealPath())) ){
                //文件上传失败
                return response()->json(['error' => '文件上传失败'], 404);
            }

            //定义文件的路径
            $path = storage_path('app').DIRECTORY_SEPARATOR.$file->getClientOriginalName();

            Excel::load($path)->chunk(50, function ($reader){

                foreach($reader as $sheet) {

                    $data = array_combine(array(
                        'goods_id', 'name', 'image', 'info_url', 'category_name', 'customer_url', 'price', 'month_safe_number', 'rate', 'discount', 'seller_platform', 'seller_id',
                        'store_name', 'platform_name', 'coupon_id', 'coupon_total_number', 'coupon_over_number', 'coupon_value', 'counpon_start_time', 'counpon_endtime', 'coupon_url', 'coupon_promote_url'
                    ), $sheet->toArray());
                    $this->dispatch(new importCouponExcel($data));
                }
            }); //分块读取文件

        }
        return view('admin.index.test');
    }

}