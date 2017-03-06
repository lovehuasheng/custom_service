<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【转单操作日志】服务层
// +----------------------------------------------------------------------

namespace app\journal\service;

use app\common\service\Base;

class Operation extends Base {

   
    public function get_list($user_info) {
        //验证字段合法性
        if($this->verify('Operation','get_list') != true) {
            $this->ajax_return();
        }
        //实例化
        $logic = \think\Loader::model('Operation', 'logic');
        return $logic->get_list($this->data['id'],$user_info);
    }

}
