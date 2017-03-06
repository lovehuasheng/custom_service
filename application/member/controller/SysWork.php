<?php
/**
 * 客服任务管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class SysWork extends Base{

	//首页
	public function index()
	{
        return view(ROOT_PATH . 'templates/common.html',[
                'group_name' => session('user_auth.group_name'),
                'realname'   => session('user_auth.realname')
        ]);		
	}

	//超级管理员
	public function super()
	{ 	
		if(session('user_auth.is_super'))
		{
		    //超级管理员
			return view(ROOT_PATH . 'templates/mywork_chaojiguanliyuan.html');	
		}

		//用户工作区面板
		$panel_type = session('user_auth.panel_type');
	
		switch ($panel_type) {
			case 1:
				//企业审核客服面板
				$tpl = ROOT_PATH . 'templates/enterprise_edition.html';
				break;
			case 2:
				//超级管理员面板
				$tpl = ROOT_PATH . 'templates/mywork_chaojiguanliyuan.html';
				break;
			default:
				//个人审核客服面板
				$tpl = ROOT_PATH . 'templates/work.html';
				break;
		}
		
		return view($tpl);
	}

	//任务指派
	public function assign_work()
	{
		if(!$this->verify('SysWork','assign_work'))
		{
			return $this->result;	
		}
		return model('SysWork', 'service')->dispatch_work($this->data);
	}	


	//获取当前用户的工作量
	public function get_workload()
	{
		return model('SysWork','service')->get_work_num($this->data);
	}

	//获取任务列表
	public function get_work_list()
	{
		if(!$this->verify('SysWork','get_work_list'))
		{
			return $this->result;	
		}
		return model('SysWork','service')->fetch_work_list($this->data);
	}
}
