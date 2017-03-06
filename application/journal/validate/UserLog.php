<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【转单操作日志】 验证层
// +----------------------------------------------------------------------

namespace app\journal\validate;

use think\Validate;

class UserLog extends Validate {

    protected $rule = [
        'page'              => 'number|min:1',
        'uid'               => 'number|min:1',
    ];
    
    
    protected $message = [
        'uid.number'     => 'user_id只能为数字|-10002',
        'uid.min'        => 'user_id最小只能为1|-10002',
    ];
    
     protected $scene = [
        'get_list'      =>  ['page','uid'],
       
    ];

}
