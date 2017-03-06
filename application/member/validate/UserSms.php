<?php
/**
 * 消息管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class UserSms extends Validate
{   

    //验证规则
    protected $rule = [
        'phone'        => 'require|is:mobile',
        'content'      => 'require',
        'extra_data'   => 'array'
    ];
    
    //错误消息
    protected $message = [
        'phone.require'    => '手机号码不能为空|60010',
        'phone.is'         => '手机号码格式不正确|60011',
        'content.require'  => '短信内容不能为空|60012',
        'extra_data.array' => '附加数据必须为数组|60013'
    ]; 

    //验证场景
    protected $scene = [
         //发送短信
        'send_sms'   => ['phone','content','extra_data'],
    ];
   
}