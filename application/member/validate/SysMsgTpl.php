<?php
/**
 * 消息模板管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class SysMsgTpl extends Validate
{   

    //验证规则
    protected $rule = [
        'id'        => 'require|gt:0',
        'title'     => 'require',
        'content'   => 'require',
        'status'    => 'in:0,1,2',
        'ids'       => ['require','regex' => '/^(\d+){1}$|^(\d+,){1,}\d+$/'],
    ];
    
    //错误消息
    protected $message = [
        'id.require'      => 'id不能为空|60010',
        'id.gt'           => 'id必须大于0|60011',
        'title.require'   => '标题不能为空|60012',
        'content.require' => '内容不能为空|60013',
        'status.require'  => '状态不能为空|60014',
        'status.in'       => '状态不在允许范围内|60015',
        'ids.require'     => 'id不能为空|60016',
        'ids.regex'       => 'id格式错误|60017'         
    ]; 

    //验证场景
    protected $scene = [
         //查看消息模板列表
        'get_msg_tpl_list'   => ['status'=>'in:0,1'],
         //添加消息模板
        'add_msg_tpl'      => ['title','content','status'], 
        //编辑消息模板
        'update_msg_tpl'     => ['id','title','content','status'],
        //启用/禁用消息模板
        'set_msg_tpl_status' => ['ids','status' => 'require|in:0,1'],
        //删除消息模板
        'del_msg_tpl'        => ['ids'],
        //获取消息模板详情 
        'get_msg_tpl_detail' => ['id'],
        //还原消息模板
        'restore_msg_tpl'    => ['ids']
    ];
   
}