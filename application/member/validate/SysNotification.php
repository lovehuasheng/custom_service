<?php
/**
 * 通知管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class SysNotification extends Validate
{   

    //验证规则
    protected $rule = [
        'user_id'   => 'require|gt:0',
        'username'  => 'require',
        'ms_tpl_id' => 'require|gt:0',
        'phone'     => 'require|is:mobile',
        'content'   => 'require'
    ];
    
    //错误消息
    protected $message = [
        'user_id.require'   => '会员id不能为空|60010',
        'user_id.gt'        => '会员id必须大于0|60011',
        'username.require'  => '会员账号不能为空|60012',
        'ms_tpl_id.require' => '短息模板id不能为空|60013',
        'ms_tpl_id.gt'      => '短信模板id必须大于0|60014',
        'phone.require'     => '手机号码不能为空|60015',
        'phone.is'          => '手机号码格式不正确|60016',
        'content.require'   => '具体原因描述不能为空|60017'      
    ]; 

    //验证场景
    protected $scene = [
        //发送通知
        'notify'                => ['user_id','username','content','ms_tpl_id'=>'gt:0'],
        //获取通知列表
        'get_notification_list' => ['user_id'],
    ];
   
}