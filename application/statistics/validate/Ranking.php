<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【接受资助】 验证层
// +----------------------------------------------------------------------

namespace app\statistics\validate;

use think\Validate;

class Ranking extends Validate {

    protected $rule = [
        'flag'                                                      => 'require|min:1',
    ];
    
    
    protected $message = [
        'flag.require'                                              => '参数错误|-10001',
        'flag.min'                                                  => '参数错误|-10002',
    ];
    
     protected $scene = [
        'get_data'                                                  =>  ['flag'],
       
    ];

}
