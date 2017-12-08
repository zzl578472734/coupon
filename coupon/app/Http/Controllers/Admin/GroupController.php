<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/15
 * Time: 21:02
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Model\Group;
use Illuminate\Http\Request;

class GroupController extends BaseAdminController{

    /**
     * 获取图片的分组信息
     * @return mixed
     */
    public function getList(){
        $Group = new Group();
        $groups = $Group->get(['id', 'name']);
        if ( $groups->isEmpty() ){
            return response()->json(['error' => '不存在分类信息'], 404);
        }
        return response()->json(['groups' => $groups]);
    }

}