<?php
/**
 * 会员信息管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class UserInfo extends Base{

	//查看会员详情
	public function get_user_info()
	{

		//检测是否是企业还是个人 0-个人 1-企业
		if(!isset($this->data['is_company']))
		{
			$is_company = 0;
		}
		else
		{
			$is_company = intval(trim($this->data['is_company']));

			if(!in_array($is_company,[0,1]))
			{
				$this->error_code = 10000;
				$this->error_msg  = 'is_company不在给定的范围内';
				return $this->result;
			}
		}

		//个人
		if($is_company == 0)
		{
			//验证类
			$verify_class 	= 'UserInfo';
			$service_model 	= 'UserInfo';
		}
		else
		{
			$verify_class  = 'CompanyInfo';
			$service_model = 'CompanyInfo'; 
		}

		if(!$this->verify($verify_class,'get_user_info'))
		{
			return $this->result;
		}
		return model($service_model,'service')->fetch_user_info($this->data);
	}

	//编辑会员信息
	public function update_user_info()
	{

	    //检测是否是企业还是个人 0-个人 1-企业
		if(!isset($this->data['is_company']))
		{
			$is_company = 0;
		}
		else
		{
			$is_company = intval(trim($this->data['is_company']));

			if(!in_array($is_company,[0,1]))
			{
				$this->error_code = 10000;
				$this->error_msg  = 'is_company不在给定的范围内';
				return $this->result;
			}
		}

		//个人
		if($is_company == 0)
		{
			//验证类
			$verify_class 	= 'UserInfo';
			$service_model 	= 'UserInfo';
		}
		else
		{
			$verify_class  = 'CompanyInfo';
			$service_model = 'CompanyInfo'; 
		}

		if(!$this->verify($verify_class,'update_user_info'))
		{
			return $this->result;
		}

		return model($service_model, 'service')->edit_user_info($this->data);
	}

	//转移推荐人
	public function transfer_referee()
	{
	    //检测是否是企业还是个人 0-个人 1-企业
		if(!isset($this->data['is_company']))
		{
			$is_company = 0;
		}
		else
		{
			$is_company = intval(trim($this->data['is_company']));

			if(!in_array($is_company,[0,1]))
			{
				$this->error_code = 10000;
				$this->error_msg  = 'is_company不在给定的范围内';
				return $this->result;
			}
		}

		//个人
		if($is_company == 0)
		{
			//验证类
			$verify_class 	= 'UserInfo';
			$service_model 	= 'UserInfo';
		}
		else
		{
			$verify_class  = 'CompanyInfo';
			$service_model = 'CompanyInfo'; 
		}

		if(!$this->verify($verify_class,'transfer_referee'))
		{
			return $this->result;
		}
		return model($service_model, 'service')->edit_referee($this->data);
	}

	//查看推荐人和隶属组
	public function get_group_referee()
	{
		if(!$this->verify('UserInfo','get_group_referee'))
		{
			return $this->result;
		}
		return model('UserInfo', 'service')->fetch_group_referee($this->data);
	}

	//通过会员账号获取其真实姓名
	public function get_real_name_by_username()
	{
		//用户名
		$username = trim($this->data['username']);
		if(empty($username))
		{
			$this->error_code = 10001;
			$this->error_msg  = '用户名不能为空';
			return $this->result;
		}

		return model('UserInfo', 'service')->fetch_real_name_by_username($this->data);
	}
}
