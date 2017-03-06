<?php
/**
 * 用户组管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\permission\controller;
use app\common\controller\Base;

class SysGroup extends Base{


	public function index()
	{
		return view(ROOT_PATH . 'templates/tream.html');	
	}

	public function show_group_list()
	{
		return view(ROOT_PATH . 'templates/setuser.html');
	}

	//添加用户组
	public function add_group()
	{	
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('SysGroup','add_group'))   
    	{  
    	   return $this->result;
    	}
		return model('SysGroup', 'service')->create_group($this->data);
	}

	//编辑用户组
	public function update_group()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysGroup','update_group'))
        {
            return $this->result;
        }
		return model('SysGroup', 'service')->edit_group($this->data);
	}

	//查看用户组列表
	public function get_group_list()
	{
		//验证数据,不通过则返回错误信息
        if(!$this->verify('SysGroup','get_group_list'))
        {
            return $this->result;
        }
		return model('SysGroup','service')->fetch_group_list($this->data);
	}

	//设置户组状态,启用/禁用
	public function set_group_status()
	{
		if(!$this->verify('SysGroup','set_group_status'))
		{
			return $this->result;
		}
		return model('SysGroup', 'service')->edit_group_status($this->data);
	}

	//删除用户组
	public function del_group()
	{
		if(!$this->verify('SysGroup','del_group'))
		{
			return $this->result;
		}
		//状态 0-启用 1-禁用 2-删除
		$this->data['status'] = 2;
		return model('SysGroup', 'service')->edit_group_status($this->data);
	}

	//查看回收站中的用户组列表
	public function get_recycle_list()
	{
		return model('SysGroup','service')->get_deleted_group($this->data);
	}

	//还原回收站中删除的用户组
	public function restore_group()
	{	
		if(!$this->verify('SysGroup','restore_group'))
		{
			return $this->result;
		}
		return model('SysGroup','service')->recover_group($this->data);
	}

	//设置用户组权限
	public function set_group_permission()
	{
		if(!$this->verify('SysGroup','set_group_permission'))
		{
			return $this->result;
		}
		return model('SysGroup','service')->setup_group_permission($this->data);
	}

	//获取用户组权限
	public function get_group_permission()
	{	
		if(!$this->verify('SysGroup','get_group_permission'))
		{
			return $this->result;
		}
		return model('SysGroup','service')->fetch_group_permission($this->data);
	}

	//获取用户组树
	public function get_group_tree()
	{
		return model('SysGroup','service')->fetch_group_tree();
	}
}
