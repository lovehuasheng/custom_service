<?php
/**
 * 管理员操作会员日志
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class SysOperateUserLog extends Base{


	//查看日志列表
	public function get_log_list()
	{
		//用户id
		$user_id = empty($this->data['user_id']) ? 0 : intval($this->data['user_id']);
		//页码
		$page    = empty($this->data['page']) ? 1 : intval($this->data['page']);

		//判断用户id是否合法
		if($user_id <=0)		
		{
			$this->error_code = 52000;
			$this->error_msg  = '参数错误';
			return $this->result;
		}

		if($page <= 0)
		{
			$this->error_code = 52001;
			$this->error_msg  = '请输入正确的页码';
			return $this->result;	
		}

		$service = \think\Loader::model('SysOperateUserLog','service');

		return $service->fetch_log_list($user_id,$page);
	}	
}
