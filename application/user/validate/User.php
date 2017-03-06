<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服用户管理验证层
// +----------------------------------------------------------------------

namespace app\user\validate;

use think\Validate;

class User extends Validate {

    protected $rule = [
        'id'                 => 'require',
        'ids'                => 'require',
        'username'           => 'require|regex:/[^\x80-\xff]/|length:6,16|unique:sys_user',
        'password'           => 'require|regex:/[^\x80-\xff]/|length:6,16',
        'secondary_password' => 'require|regex:/[^\x80-\xff]/|length:6,16',
        'pwd'                => 'require|regex:/[^\x80-\xff]/|length:6,16',
        'realname'           => 'require',
        'mobile'             => 'require|unique:sys_user|is:mobile',
        'email'              => 'require|regex:/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/|unique:sys_user',
        'status'             => 'number|in:2,3',
        'remark'             => 'require',
        'group_id'           => 'require|number|min:1',
        'code'               => 'require|number',
        'type'               => 'require|number|min:1',
    ];
    
    
    protected $message = [
        'id.require'          => '用户ID不能为空|-20004',
        'ids.require'         => '用户ID不能为空|-20005',
        'username.require'    => '用户名不能为空|-20008',
        'username.regex'      => '用户名不能包含中文|-20009',
        'username.length'     => '用户名必需在6-16个字符之间|-20010',
        'username.unique'     => '用户名已存在|-20011',
        'password.require'    => '密码不能为空|-20012',  
        'password.regex'      => '密码不能包含中文|-20013',
        'password.length'     => '密码必需在6-16个字符之间|-20014',
        'secondary_password.require' => '二级密码不能为空|-20015',
        'secondary_password.regex' => '密码不能包含中文|-20016',
        'secondary_password.length' => '密码必需在6-16个字符之间|-20016',
        'pwd.require'         => '二级密码不能为空|-20015',
        'pwd.regex'           => '密码不能包含中文|-20016',
        'pwd.length'          => '密码必需在6-16个字符之间|-20016',
        'realname.require'    => '真实姓名不能为空|-20017',
        'mobile.require'      => '手机号码不能为空|-20018',
        'mobile.unique'       => '此手机号码已存在|-20019',
        'mobile.is'           => '手机号码格式不正确|-20020',
        'email.require'       => '邮箱不能为空|-20021',
        'email.unique'        => '此邮箱已存在|-20022',
        'email.regex'         => '邮箱格式不正确|-20023',
        'status.require'      => 'status不能为空|-20024',
        'status.number'       => 'status必须是数字|-20024',
        'status.in'           => 'status不在取值范围内|-20025',
        'remark.require'      => 'remark不能为空|-20025',
        'group_id.require'    => 'group_id不能为空|-20025',
        'group_id.number'     => 'group_id必须是数字|-20025',
        'group_id.min'        => 'group_id最小值为1|-20025',
        'code.require'        => 'code不能为空|-20025',
        'code.number'         => 'code必须是数字|-20025',
        'type.require'        => 'type不能为空|-20025',
        'type.number'         => 'type必须是数字|-20025',
        'type.min'            => 'type最小值为1|-20025',
        
    ];
    
    
    protected $scene = [
        //添加数据
        'add'           =>  ['username','password','realname','mobile'],
        //修改数据
        'edit'          =>  ['id','username'=>'require|regex:/[^\x80-\xff]/|length:6,16','password'=>'regex:/[^\x80-\xff]/|length:6,16','realname','remark','group_id'],
        //获得单条数据
        'get_data'      =>  ['id'],
        //短信发送
        'sent_tel_sms'  =>  ['type'],
        //启用/禁用
        'disable'       =>  ['ids','status'=>'require|number|in:0,1','pwd'],
        //删除/还原
        'destroy'       =>  ['ids','status'=>'number|in:2,3'],
        //修改密码
        'set_password'  =>  ['password','code'],
        //修改二级密码
        'set_secondary_password'  =>  ['code','secondary_password'],
        'set_user_realname'  =>  ['code','realname'],
         //登录
         'login'        =>  ['username'=>'require|regex:/[^\x80-\xff]/|length:6,16','password'=>'require|regex:/[^\x80-\xff]/|length:6,16'],
         //发送短信
         'send_verify'  =>  ['username'=>'require|regex:/[^\x80-\xff]/|length:6,16'],
    ];

}
