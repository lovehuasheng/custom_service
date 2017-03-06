<?php
/**
 * 会员管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class User extends Base{


	//查看会员列表
	public function get_user_list()
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
			$service_model 	= 'User';
		}
		else
		{
			$verify_class  = 'CompanyInfo';
			$service_model = 'Company'; 
		}

		if(!$this->verify($verify_class,'get_user_list'))
		{
			return $this->result;
		}

		return model($service_model,'service')->fetch_user_list($this->data);
	}


	//激活/冻结会员
	public function update_active_status()
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
			$verify_class 	= 'User';
			$service_model 	= 'User';
		}
		else
		{
			$verify_class  = 'Company';
			$service_model = 'Company'; 
		}

		if(!$this->verify($verify_class,'update_active_status'))
		{
			return $this->result;
		}

		return model($service_model, 'service')->edit_active_status($this->data);
	}
	
	//设置会员审核状态
	public function update_audit_status()
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
			$verify_class 	= 'User';
			$service_model 	= 'User';
		}
		else
		{
			$verify_class  = 'Company';
			$service_model = 'Company'; 
		}


		if(!$this->verify($verify_class,'update_audit_status'))
		{
			return $this->result;
		}

		return model($service_model, 'service')->edit_audit_status($this->data);
	}

	//设置会员特权
	public function set_privilege()
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
			$verify_class 	= 'User';
			$service_model 	= 'User';
		}
		else
		{
			$verify_class  = 'Company';
			$service_model = 'Company'; 
		}


		if(!$this->verify($verify_class,'set_privilege'))
		{
			return $this->result;
		}
		return model($service_model, 'service')->edit_privilege($this->data);
	}

	//获取会员信息
	public function get_user()
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
			$verify_class 	= 'User';
			$service_model 	= 'User';
		}
		else
		{
			$verify_class  = 'Company';
			$service_model = 'Company'; 
		}

		if(!$this->verify($verify_class,'get_user'))
		{
			return $this->result;
		}

		return model($service_model, 'service')->get_user($this->data);
	}

	//重置用户的密码/二级密码
	public function reset_passwrod_secondary()
	{	
		//会员id
		$user_id  = empty($this->data['user_id']) ? 0 : intval($this->data['user_id']);
		//密码
		$password = empty($this->data['password']) ? '' : trim($this->data['password']);
		//二级密码
		$secondary_password = empty($this->data['secondary_password']) ? '' : trim($this->data['secondary_password']);

		//检测会员id是否正确
		if($user_id <=0)
		{
			$this->error_code = 10001;
			$this->error_msg  = '会员id错误';
			return $this->result;
		}

		//检测二级密码或者新密码是否为空
		if(empty($password) && empty($secondary_password))
		{
			$this->error_code = 10002;
			$this->error_msg  = '密码或者二级密码至少有一个不能为空';
			return $this->result;
		}

		$this->data = [
			'user_id'  => $user_id,
			'password' => $password,
			'secondary_password' => $secondary_password
		];

		return model('User', 'service')->reset_passwrod_secondary($this->data);
	}
	
}
