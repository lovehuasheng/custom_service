<?php
/**
 * 用户组管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\permission\validate;

use think\Validate;

class SysGroup extends Validate
{   

    //验证规则
    protected $rule = [
        'id'          => 'require|gt:0',
        'ids'         => ['require','regex' => '/^(\d+){1}$|^(\d+,){1,}\d+$/'],
        'group_name'  => 'require',
        'permissions' => ['regex' => '/^(\d+){0,1}$|^(\d+,){1,}\d+$/'],
        'pid'         => 'egt:0',
        'sort'        => 'egt:0',
        'status'      => 'in:0,1,2'
    ];
    
    //错误消息
    protected $message = [
        'id.require'          => '用户组id不能为空|40001',
        'id.gt'               => '用户组id必须大于0|40003',
        'ids.require'         => '用户组id不能为空|40004',
        'ids.regex'           => '用户组id格式不正确|40005',
        'group_name.require'  => '用户组名不能为空|40006',
        'permissions.regex'   => '用户组权限不正确|40008',
        'pid.egt'             => '父级组id必须大于等于0|40010',
        'sort.egt'            => '排序必须大于等于0|40012',
        'status.require'      => '状态不能为空|40014',
        'status.in'           => '状态不在给定范围内|40015',
        'secondary_password.require' => '二级密码不能为空|40016'
    ]; 

    //验证场景
    protected $scene = [
        //添加用户组
        'add_group'        => ['group_name','pid','sort','status'],
        //通过id修改记录
        'update_group'     => ['id','group_name','pid','sort','status'],
        //获取用户组列表
        'get_group_list'   => ['pid','status'=>'in:0,1'],
        //启用/禁用用户组
        'set_group_status' => ['ids','status' =>'require|in:0,1'],
        //删除用户组
        'del_group'        => ['ids','secondary_password'=>'require'],
        //还原用户组列表
        'restore_group'    => ['ids'],
        //设置用户组权限
        'set_group_permission' => ['id','permissions'],
        //获取用户组权限
        'get_group_permission' => ['id'],
    ];
   
}