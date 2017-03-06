<?php
/**
 * 消息模板管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class SysMsgTpl extends Base{

    //添加消息模板
	public function add_msg_tpl()
	{
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('SysMsgTpl','add_msg_tpl'))   
    	{  
    	   return $this->result;
    	}
		return model('SysMsgTpl', 'service')->create_msg_tpl($this->data);
	}

	//查看消息模板列表
	public function get_msg_tpl_list()
	{
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('SysMsgTpl','get_msg_tpl_list'))   
    	{  
    	   return $this->result;
    	}
		return model('SysMsgTpl','service')->fetch_msg_tpl_list($this->data);
	}	

	//编辑消息模板
	public function update_msg_tpl()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysMsgTpl','update_msg_tpl'))
        {
            return $this->result;
        }
		return model('SysMsgTpl','service')->edit_msg_tpl($this->data);
	}	

	//启用/禁用消息模板 0-启用 1-禁用
	public function set_msg_tpl_status()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysMsgTpl','set_msg_tpl_status'))
        {
            return $this->result;
        }
		return model('SysMsgTpl','service')->edit_msg_tpl_status($this->data);
	}

	//删除消息模板
	public function del_msg_tpl()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysMsgTpl','del_msg_tpl'))
        {
            return $this->result;
        }
        //状态 0-启用 1-禁用 2-删除
        $this->data['status'] = 2;
		return model('SysMsgTpl','service')->edit_msg_tpl_status($this->data);
	}

    //查看回收站中的消息模板列表
	public function get_recycle_list()
	{	
        //状态 0-启用 1-禁用 2-删除
		return model('SysMsgTpl','service')->get_deleted_msg_tpl($this->data);
	}

	//还原回收站中删除的消息模板
	public function restore_msg_tpl()
	{	
		if(!$this->verify('SysMsgTpl','restore_msg_tpl'))
		{
			return $this->result;
		}
		return model('SysMsgTpl','service')->recover_msg_tpl($this->data);
	}

	//查询消息模板详情
	public function get_msg_tpl_detail()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysMsgTpl','get_msg_tpl_detail'))
        {
            return $this->result;
        }
		return model('SysMsgTpl','service')->fetch_msg_tpl_detail($this->data);
	}
}
