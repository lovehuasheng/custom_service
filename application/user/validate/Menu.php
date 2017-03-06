<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【菜单管理】 验证层
// +----------------------------------------------------------------------

namespace app\user\validate;

use think\Validate;

class Menu extends Validate {

    protected $rule = [
        'name'            => 'require',
        'href'            => 'require',
        'group'           => 'require',
        'id'              => 'require',
        'ids'             => 'require',
        'status'          => 'number|in:2,3',
    ];
    
    
    protected $message = [
        'name.require'   => '菜单名不能为空|-20001',
        'href.require'   => '链接不能为空|-20002',
        'group.require'  => '菜单组不能为空|-20003',
        'id.require'     => '参数错误id|-20004',
        'ids.require'    => '参数错误ids|-20005',
        'status.number'  => 'status必须是数字|-20006',
        'status.in'      => 'status不在取值范围内|-20007',
    ];
    
     protected $scene = [
        //添加数据
        'add'           =>  ['name','href','group'],
        //修改数据
        'edit'          =>  ['id','name','href','group'],
        //获得单条数据
        'get_data'      =>  ['id'],
        //启用/禁用
        'disable'       =>  ['ids','status'=>'number|in:0,1'],
        //删除/还原
        'destroy'       =>  ['ids','status'=>'number|in:2,3'],
       
    ];

}
