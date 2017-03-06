<?php
/**
 * 客服任务管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class SysWork extends Validate
{   

    //验证规则
    protected $rule = [
        'sys_uid'   => 'require|gt:0',
        'user_ids'  => ['require','regex' => '/^(\d+){1}$|^(\d+,){1,}\d+$/'],
        'customname'  => 'require',
    ];
    
    //错误消息
    protected $message = [
        'sys_uid.require'   => '客服id不能为空|60013',
        'sys_uid.gt'        => '客服id必须大于0|60015',
        'user_ids.require'  => '会员id不能为空|60016',
        'user_ids.regex'    => '会员id格式错误|60017',
        'customname.require'  => '客服账号不能为空|60018'  
    ]; 

    //验证场景
    protected $scene = [        
        //指派任务
        'assign_work'  => ['customname'],
    ];
}