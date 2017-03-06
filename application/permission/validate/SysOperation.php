<?php
/**
 * 权限节点管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\permission\validate;

use think\Validate;

class SysOperation extends Validate
{   

    //验证规则
    protected $rule = [
        'id'          => 'require|gt:0',
        'ids'         => ['require','regex' => '/^(\d+){1}$|^(\d+,){1,}\d+$/'],
        'name'        => 'require',
        'operation'   => 'require',
        'group'       => 'require',
        'sort'        => 'egt:0',
        'status'      => 'in:0,1,2',
    ];
    
    //错误消息
    protected $message = [
        'id.require'          => '权限节点id不能为空|50001',
        'id.gt'               => '权限节点id必须大于0|50003',
        'ids.require'         => '权限节点id不能为空|50004',
        'ids.regex'           => '权限节点id格式不正确|50005',
        'name.require'        => '权限节点名不能为空|50006',
        'operation.require'   => '操作方法不能为空|50008',
        'group.require'       => '权限节点组名不能为空|50010',
        'sort.egt'           => '排序必须大于等于0|50013',
        'status.require'     => '状态不能为空|50015',
        'status.in'          => '状态不在给定范围内|50016',
    ]; 

    //验证场景
    protected $scene = [
        //添加权限节点
        'add_operation'         => ['name','operation','group','sort','status'],
        //更新权限节点信息
        'update_operation'      => ['id','name','operation','group','sort','status'],
        //查看权限列表
        'get_operation_list'    => ['status'=>'in:0,1'],
        //启用/禁用权限节点
        'set_operation_status'  => ['ids','status'=>'require|in:0,1'],
        //删除权限节点
        'del_operation'         => ['ids'],
        //还原回收站       
        'restore_operation'     => ['ids'],     
		//获取权限节点详情
		'get_operation_detail'  => ['id'],
		//获取子菜单
		'get_sub_menu'			=> ['id'],
    ];
   
}