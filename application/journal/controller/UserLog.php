<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【客服操作日志】控制器
// +----------------------------------------------------------------------

namespace app\journal\controller;

use app\common\controller\Base;

class UserLog extends Base {

    public function get_list() {
        $service = \think\Loader::model('UserLog', 'service');
        return $service->get_list($this->user_info);
    }

}
