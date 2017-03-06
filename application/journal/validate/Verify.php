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

class Verify extends Validate {

    protected $rule = [
        'page'              => 'number|min:1',
        'uid'           => 'number|min:1',
        'username'       => 'number|min:1',
        'primary_id'        => 'number|min:1',
        'provide_id'        => 'number|min:1',
        'verify_status'        => 'number|min:0',
    ];
    
    
    protected $message = [
        'id.require'         => '参数错误id|-10001',
        'ids.require'        => '参数错误ids|-10002',
        'user_id.number'     => 'user_id只能为数字|-10002',
        'user_id.min'        => 'user_id最小只能为1|-10002',
        'operator_id.number' => 'operator_id只能为数字|-10002',
        'operator_id.min'    => 'operator_id最小只能为1|-10002',
        'primary_id.number'  => 'operator_id只能为数字|-10002',
        'primary_id.min'     => 'operator_id最小只能为1|-10002',
        'provide_id.number'  => 'provide_id只能为数字|-10002',
        'provide_id.min'     => 'provide_id最小只能为1|-10002',
        'verify_status.min'  => 'verify_status只能为数字|-10002',
        'verify_status.min'  => 'verify_status最小只能为1|-10002',
    ];
    
     protected $scene = [
        'get_list'      =>  ['page','user_id','operator_id','primary_id','verify_status'],
       
    ];

}
