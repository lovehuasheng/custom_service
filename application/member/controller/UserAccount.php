<?php
/**
 * 会员账户管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;
class UserAccount extends Base{

	//显示转币页面
	public function show_transfer_coin()
	{
		return view(ROOT_PATH . 'templates/zhuanbi.html');
	}

	//查看会员账户列表
	public function get_account_list()
	{
		if(!$this->verify('UserAccount','get_account_list'))
		{
			return $this->result;
		}
		return model('UserAccount','service')->fetch_account_list($this->data);
	}
	
	//编辑会员账户
	public function update_account()
	{
		if(!$this->verify('UserAccount','update_account'))
		{
			return $this->result;
		}
		return model('UserAccount','service')->edit_account($this->data);
	}

	//转币
	public function transfer_coin()
	{
		return model('UserAccount','service')->transfer_coin($this->data);
	}

	//查询超级管理员剩余的善种子,善心币
	public function get_super_account()
	{
		$this->data = [
			'user_id' => session('user_auth.bind_uid')
		];
		return model('UserAccount','service')->get_super_account($this->data);
	}
}
