<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【收入流水】 验证层
// +----------------------------------------------------------------------

namespace app\journal\validate;

use think\Validate;

class Income extends Validate {

    protected $rule = [
        'page'              => 'number|min:1',
        'user_id'           => 'number|min:1',
        'pid'               => 'number|min:1',
        'type'              => 'number|min:1',
        'cat_id'            => 'number|min:1',
        'id'                => 'require|number|min:1',
        'type'              => 'require|number|min:0',
    ];
    
    
    protected $message = [
        'user_id.number'     => 'user_id只能为数字|-10002',
        'user_id.min'        => 'user_id最小只能为1|-10002',
        'type.number'        => 'type只能为数字|-10002',
        'type.min'           => 'type最小只能为1|-10002',
        'pid.number'         => 'pid只能为数字|-10002',
        'pid.min'            => 'pid最小只能为1|-10002',
        'page.number'        => 'page只能为数字|-10002',
        'page.min'           => 'page最小只能为1|-10002',
        'cat_id.number'      => 'cat_id只能为数字|-10002',
        'cat_id.min'         => 'cat_id最小只能为1|-10002',
        'id.number'          => 'id只能为数字|-10002',
        'id.min'             => 'id最小只能为1|-10002',
        'id.require'         => 'id不能为空|-10002',
        'type.require'       => 'type不能为空|-10002',
        'type.number'        => 'type只能为数字|-10002',
        'type.min'           => 'type最小只能为0|-10002',
    ];
    
     protected $scene = [
        'get_list'      =>  ['page','user_id','type','pid','cat_id'],
        'destroy'       =>  ['id','type'],
       
    ];

}
