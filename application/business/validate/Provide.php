<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【提供资助】 验证层
// +----------------------------------------------------------------------

namespace app\business\validate;

use think\Validate;

class Provide extends Validate {

    protected $rule = [
        'id'                   => 'require',
        'ids'                  => 'require',
        'status'               => 'number|in:2,3',
        'page'                 => 'number|min:1',
        'per_page'             => 'number|min:1',
        'community_id'         => 'number|min:0',
        'data_time'            => 'dateFormat:Y-m-d',
        'create_time'          => 'require|array',
        'partition_time'       => 'require',
    ];
    
    
    protected $message = [
        'id.require'           => '参数错误id|-10001',
        'ids.require'          => '参数错误ids|-10002',
      //  'ids.is'               => '参数错误|-10002',
        'status.number'        => 'status必须是数字|-10003',
        'status.in'            => 'status不在取值范围内|-10004',
        'page.number'          => 'page必须是数字|-10003',
        'page.in'              => 'page不在取值范围内|-10004',
        'per_page.number'      => 'per_page必须是数字|-10003',
        'per_page.in'          => 'per_page不在取值范围内|-10004',
        'community_id.require' => 'community_id不能为空|-10004',
        'community_id.number'  => 'community_id必须是数字|-10003',
        'community_id.min'     => 'community_id不在取值范围内|-10004',
        'data_time.dateFormat' => 'data_time格式不正确|-10004',
        'create_time.require'  => '参数错误create_time|-10001',
        'create_time.array'    => '参数格式不正确create_time|-10001',
         'partition_time.require'  => '参数错误|-10004',
        'partition_time.date'    => '格式不正确|-10004',
    ];
    
     protected $scene = [
        //获得单条数据
        'get_data'         =>  ['id'],
        //删除/还原
        'destroy'          =>  ['ids','partition_time'],
         //打款剩余列表
        'get_list'         =>  ['page','status','per_page','community_id','data_time'],
         //加入手动匹配
        'set_manual_match' =>  ['ids','create_time'],
       
    ];

}
