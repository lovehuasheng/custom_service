<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【匹配详情】 验证层
// +----------------------------------------------------------------------

namespace app\business\validate;

use think\Validate;

class Matching extends Validate {

    protected $rule = [
        'id'                      => 'require|number|min:1',
        'ids'                     => 'require',
        'provide_id'              => 'require|number|min:1',
        'accept_id'               => 'require|number|min:1',
        'other_money'             => 'require',
        'other_user_id'           => 'require|number|min:1',
        'page'                    => 'number|min:1',
        'status'                  => 'number|in:0,1,2,3',
        'type'                    => 'require|number|in:1,2',
        'delayed_time'            => 'require|number|between:1,12',
        'search_type'             => 'number|min:1',
        'search_name'             => 'number|min:1',
        'match_times'             => 'require',
        'match_time'              => 'require',
        'search_date'             =>  'dateFormat:Y-m-d',
        'flag'                    => 'require|number|in:1,2',
        'other_username'          => 'require',
        'flags'                   => 'require|array',
        'other_id'                => 'require|number|min:1',
    ];
    
    
    protected $message = [
        'id.require'                  => 'id参数错误|-10001',
        'id.min'                      => 'id最小值也是1|-10001',
        'id.number'                   => 'id必须是数字|-10001',
        'ids.require'                 => 'ids参数错误|-10002',
        'provide_id.require'          => '提供表ID不能为空|-10005',
        'provide_id.number'           => 'provide_id必须是数字|-10013',
        'provide_id.min'              => 'provide_id最小值也是1|-10013',
        'accept_id.require'           => '接受资助表ID不能为空|-10006',
        'accept_id.number'            => 'accept_id必须是数字|-10013',
        'accept_id.min'               => 'accept_id最小值也是1|-10013',
        'other_money.require'         => '匹配金额不能为空|-10007',
        'other_user_id.require'       => '提供用户ID不能为空|-10008',
        'other_user_id.number'        => 'other_user_id必须是数字|-10013',
        'other_user_id.min'           => 'other_user_id最小值也是1|-10013',
        'status.number'               => 'status必须是数字|-10003',
        'status.in'                   => 'status不在取值范围内|-10004',
        'type.require'                => 'type不能为空|-10009',
        'type.in'                     => 'type不在取值范围内|-10010',
        'type.number'                 => 'type必须是数字|-10011',
        'delayed_time.require'        => 'delayed_time不能为空|-10012',
        'delayed_time.number'         => 'delayed_time必须是数字|-10013',
        'delayed_time.between'        => 'delayed_time必须是1-12之间|-10014',
        'page.number'                 => 'page必须是数字|-10013',
        'page.min'                    => 'page最小值也是1|-10013',
        'search_type.min'             => 'search_type不在取值范围内|-10010',
        'search_type.number'          => 'search_type必须是数字|-10011',
        'search_name.min'             => 'search_type不在取值范围内|-10010',
        'search_name.number'          => 'search_name必须是数字|-10011',
        'match_times.require'         => '匹配时间错误！|-10011',
        'match_time.require'          => '匹配时间错误！|-10011',
        'flag.require'                => 'flag不能为空|-10009',
        'flag.in'                     => 'flag不在取值范围内|-10010',
        'flags.require'               => 'flags不能为空|-10009',
        'flag.array'                  => 'flags不在取值范围内|-10010',
        'flag.number'                 => 'flag必须是数字|-10011',
        'other_username.require'      => 'other_username不能为空|-10011',
        'search_date.dateFormat'      => '时间格式不正确|-10011',
        'other_id.require'            => '挂单表的id 参数错误|-100012',
       
    ];
    
     protected $scene = [
         //列表数据
        'list_data'           =>  ['search_type','search_name','search_date','status'=>'number|in:0,2'],
        //手动匹配数据
        'add'                 =>  ['ids'],
        //还原
        'reduction'           =>  ['id','provide_id','accept_id','status'],
        //删除
        'destroy'             =>  ['id','match_times','type'],
         //延时
        'delayed'             =>  ['ids','delayed_time'],
         //超时列表
        'overtime'            =>  ['page','search_type','search_name'],
        // 转移订单到接单人
        'transfer'            =>  ['ids','other_username','flag'],
         //撤销假图
        'undo'                =>  ['id','match_times'],
         //撤单封号
        'disable_no'          =>  ['id','match_times','type','flags'],
         //收款
        'collections'          =>  ['id','flag','match_time'],
        //删除
        'del'          =>  ['ids','flag'],
       
    ];

}
