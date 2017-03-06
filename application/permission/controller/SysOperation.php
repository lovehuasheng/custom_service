<?php
/**
 * 权限节点管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\permission\controller;
use app\common\controller\Base;

class SysOperation extends Base{

	//添加权限节点
	public function add_operation()
	{
		if(!$this->verify('SysOperation','add_operation'))
		{
			return $this->result;
		}
		return model('SysOperation', 'service')->create_operation($this->data);
	}

	//编辑权限节点
	public function update_operation()
	{
		if(!$this->verify('SysOperation','update_operation'))
		{
			return $this->result;
		}
		return model('SysOperation', 'service')->edit_operation($this->data);
	}

	//查看权限节点列表
	public function get_operation_list()
	{
		if(!$this->verify('SysOperation','get_operation_list'))
		{
			return $this->result;
		}
		return model('SysOperation','service')->fetch_operation_list($this->data);
	}

	//获取初始化菜单
	public function get_init_menu()
	{
		return model('SysOperation','service')->fetch_init_menu($this->data);
	}

	//获取子菜单
	public function get_sub_menu()
	{
		if(!$this->verify('SysOperation','get_sub_menu'))
		{
			return $this->result;
		}
		return model('SysOperation','service')->fetch_sub_menu($this->data);
	}

	//获取菜单列表
	public function get_menu_list()
	{

		return model('SysOperation','service')->fetch_menu_list($this->data);
	}



	//更新权限节点的状态,启用/禁用/
	public function set_operation_status()
	{
		if(!$this->verify('SysOperation','set_operation_status'))
		{
			return $this->result;
		}
		return model('SysOperation', 'service')->edit_operation_status($this->data);
	}

	//删除权限节点
	public function del_operation()
	{
		if(!$this->verify('SysOperation','del_operation'))
		{
			return $this->result;
		}
		//状态,删除的权限节点status为2 0-启用 1-禁用 2-删除
		$this->data['status'] = 2;
		return model('SysOperation', 'service')->edit_operation_status($this->data);
	}

	//查看回收站中的权限节点列表
	public function get_recycle_list()
	{
		return model('SysOperation','service')->get_deleted_operation($this->data);
	}

	//还原回收站中删除的权限节点
	public function restore_operation()
	{
		if(!$this->verify('SysOperation','restore_operation'))
		{
			return $this->result;
		}		
		return model('SysOperation','service')->recover_operation($this->data);
	}

	//获取权限节点详情
	public function get_operation_detail()
	{
		if(!$this->verify('SysOperation','get_operation_detail'))
		{
			return $this->result;
		}
		return model('SysOperation','service')->fetch_operation_detail($this->data);
	}
}
