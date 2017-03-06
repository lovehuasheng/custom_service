<?php
/**
 * 会员信息管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class UserInfo extends Validate
{   

    //验证规则
    protected $rule = [
        'user_id'           => 'require|number|gt:0',    
        'email'             => 'email',
    //    'phone'             => 'is:mobile',
//        'card_id'           => ['regex' => '/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X|x)$/'],
        'status'            => 'in:0,1,2',
        'verify'            => 'in:0,1,2',
        'create_time_start' => 'date',
        'create_time_end'   => 'date',
        'update_time_start' => 'date',
        'update_time_end'   => 'date',
        'referee_id'        => 'gt:0',
    ];
    
    //错误消息
    protected $message = [
        'user_id.require'        => '会员id不能为空|60001',
        'user_id.gt'             => '会员id必须大于0|60002',
        'user_id.number'         => '会员id必须为整数|60003',
        'username.require'       => '会员账号不能为空|60004',
        'name.require'           => '会员姓名不能为空|60006',
        'email.require'          => '会员电子邮件不能为空|60008',
        'email.email'            => '会员电子邮件格式不正确|60009',
//        'phone.require'          => '会员手机号码不能为空|60010',
//        'phone.is'               => '会员手机号码格式不正确|60011',
        'alipay_account.require' => '会员支付宝账号不能为空|60012',
        'weixin_account.require' => '会员微信账号不能为空|60014',
        'bank_name.require'      => '会员开户银行不能为空|60015',
        'bank_account.require'   => '会员银行账号不能为空|60016',
//        'card_id.require'        => '会员身份证或护照不能为空|60017',
//        'card_id.regex'          => '会员身份证号码不正确|60018',
        'status.in'              => '激活状态不在给定范围内|60019',
        'verify.in'              => '审核状态不在给定范围内|60020',
        'create_time_start'      => '注册起始时间格式不正确|60021',
        'create_time_end'        => '注册截至时间格式不正确|60022',
        'update_time_start'      => '资料更新起始时间格式不正确|60023',
        'update_time_end'        => '资料更新截至时间格式不正确|60024',
        'referee_id.gt'          => '推荐人id必须大于0|60025',
        'referee_id.require'     => '推荐人id不能为为空|60026'
    ]; 

    //验证场景
    protected $scene = [
		//获取用户列表
		'get_user_list'    => ['user_id' => 'number|gt:0','email','phone','card_id','status','verify','create_time_start','create_time_end','update_time_start','update_time_end'],
        //查看用户详情
        'get_user_info'    => ['user_id'],
        //更新用户信息
        'update_user_info' => ['user_id','phone','email','card_id'],
        //转移推荐人
        'transfer_referee' => ['user_id','referee_id'=>'require|gt:0'],
        //查看推荐人和隶属组
        'get_group_referee' => ['user_id'],
        //获取用户的真实姓名 
        'get_name'          => ['username'=>'require'],
    ];
   
}