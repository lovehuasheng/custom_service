<?php
/**
 * 会员管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class Company extends Validate
{   

    //验证规则
    protected $rule = [
        'id'          => 'require|gt:0',
        'status'      => 'in:0,1,2',
        'verify'      => 'in:0,1,2',
        'flag'        => 'in:0,1',
        'is_transfer' => 'in:0,1',
        'is_withdraw' => 'in:0,1',
        'remark'      => 'require'
    ];
    
    //错误消息
    protected $message = [
        'id.require'          => '用户id不能为空|60001',
        'id.gt'               => '用户id必须大于0|60003',
        'status.require'      => '激活状态不能为空|60004',
        'status.in'           => '激活状态不在给定范围内|60006',
        'verify.require'      => '审核状态不能为空|60007',
        'verify.in'           => '审核状态不在给定范围内|60009',
        'flag.require'        => '上级能否激活不能为空|60010',
        'flag.in'             => '上级能否激活不在给定范围内|60012',
        'is_withdraw.require' => '接单权限不能为空|60013',
        'is_withdraw.in'      => '接单权限不在给定范围内|60015',
        'is_transfer.require' => '任意转币不能为空|60013',
        'is_transfer.in'      => '任意转币不在允许范围内|60015',
        'remark.require'      => '备注不能为空|60016'  
    ]; 

    //验证场景
    protected $scene = [
        //冻结/激活会员
        'update_active_status' => ['id','status'=>'require|in:1,2'],
        //修改会员的审核状态
        'update_audit_status'  => ['id','verify'=>'require|in:1,2'],
        //设置特权
        'set_privilege'        => ['id','is_transfer','remark'],
        //获取会员信息
        'get_user'             => ['id']
    ];
   
}