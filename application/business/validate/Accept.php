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

namespace app\business\validate;

use think\Validate;

class Accept extends Validate {

    protected $rule = [
        'id'                   => 'require',
        'ids'                  => 'require',
        'status'               => 'number|in:2,3',
        'page'                 => 'number|min:1',
        'per_page'             => 'number|min:1',
        'community_id'         => 'number|min:0',
        'data_time'            => 'dateFormat:Y-m-d',
        'create_time'          => 'require|array',
        'partition_time'          => 'require',
        'amount'               => 'require|number|min:1',
    ];
    
    
    protected $message = [
        'id.require'           => '参数错误id|-10001',
        'ids.require'          => '参数错误ids|-10002',
        'status.number'        => 'status必须是数字|-10003',
        'status.in'            => 'status不在取值范围内|-10004',
        'page.number'          => 'page必须是数字|-10003',
        'page.min'              => 'page不在取值范围内|-10004',
        'per_page.number'      => 'per_page必须是数字|-10003',
        'per_page.min'          => 'per_page不在取值范围内|-10004',
        'community_id.require' => 'community_id不能为空|-10004',
        'community_id.number'  => 'community_id必须是数字|-10003',
        'community_id.min'     => 'community_id不在取值范围内|-10004',
        'data_time.dateFormat' => 'data_time格式不正确|-10004',
        'create_time.require'  => 'create_time参数错误|-10004',
        'create_time.array'    => 'create_time格式不正确|-10004',
        'partition_time.require'  => '参数错误|-10004',
        'partition_time.date'    => '格式不正确|-10004',
        'amount.require'    => '设置金额不能为空|-10004',
        'amount.number'    => '格式不正确|-10004',
        'amount.min'    => '格式不正确|-10004',
    ];
    
     protected $scene = [
        'get_data'      =>  ['id'],
          //收款剩余列表
        'get_list'         =>  ['page','status','per_page','community_id','data_time'],
         //加入手动匹配
        'set_manual_match' =>  ['ids','create_time'],
         //更改会员接受资助的金额，从出局钱包中转入接受资助中
        'set_accepthelp_money' =>  ['ids','partition_time','amount'],
       
    ];

}
