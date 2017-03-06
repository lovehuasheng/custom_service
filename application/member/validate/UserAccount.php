<?php
/**
 * 会员账户管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class UserAccount extends Validate
{   

    //验证规则
    protected $rule = [
        'user_id'         => 'require|gt:0',
        'account_type'    => 'require|in:0,1,2,3,4,5,6,7,8,9,10,11',
        'operation_type'  => 'require|in:1,2',
        'sum'             => 'require|gt:0'
    ];
    
    //错误消息
    protected $message = [
        'user_id.require'          => '用户id不能为空|60001',
        'user_id.gt'               => '用户id必须大于0|60002',
        'account_type.require'     => '账户类型不能为空|60003',
        'account_type.in'          => '账户类型不在允许的范围内|60004',
        'operation_type.require'   => '操作类型不能为空|60005',
        'operation_type.in'        => '操作类型不在允许的范围内|60006',
        'sum.require'              => '操作数不能为空|60007',
        'sum.gt'                   => '操作数额必须大于0|60008'
    ]; 

    //验证场景
    protected $scene = [
        
        //获取账户
        'get_account_list' => ['user_id'],
        //更改账户
        'update_account'   => ['user_id','account_type','operation_type','sum']
    ];
   
}