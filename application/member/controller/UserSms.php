<?php
/**
 * 消息管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;
class UserSms extends Base{

	//发送短信
	public function send_sms()
	{
		if(!$this->verify('UserSms','send_sms'))
		{
			return $this->result;
		}
		return model('UserSms','service')->transimt_sms($this->data);
	}
}
