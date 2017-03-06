<?php
/**
 * 消息发送api控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\api\controller;
use app\common\controller\Api;

class UserSms extends Api{

	//发送短信
	public function send_sms()
	{
		if(!$this->verify('member/UserSms','send_sms'))
		{
			return $this->result;
		}
		return model('member/UserSms','service')->transimt_sms($this->data);
	}
}
