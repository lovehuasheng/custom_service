<?php
/**
 * 消息模板管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class SysMsgTpl extends  Base{

    //添加消息模板
    public function create_msg_tpl($data=[])
    {
         return model('SysMsgTpl','logic')->append_msg_tpl($data);
    }

    //获取消息模板列表
    public function fetch_msg_tpl_list($data=[])
    {
        return model('SysMsgTpl','logic')->get_msg_tpls($data);
    }

    //编辑消息模板
    public function edit_msg_tpl($data=[])
    {
        return model('SysMsgTpl','logic')->modify_msg_tpl($data); 
    }

    //设置消息模板的状态 0-启用 1-禁用 2-删除
    public function  edit_msg_tpl_status($data=[])
    {
        return model('SysMsgTpl','logic')->modify_msg_tpl_status($data); 
    }

    //查看回收站中的消息模板列表
    public function get_deleted_msg_tpl($data=[])
    {
         return model('SysMsgTpl','logic')->get_destoryed_msg_tpl($data);
    }

    //还原回收站中的消息模板列表
    public function recover_msg_tpl($data=[])
    {
        return model('SysMsgTpl','logic')->revert_msg_tpl($data);
    }   

    //获取消息模板详情
    public function fetch_msg_tpl_detail($data=[])
    {
        return model('SysMsgTpl','logic')->acquire_msg_tpl_detail($data);   
    }
}
