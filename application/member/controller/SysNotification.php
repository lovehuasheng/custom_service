<?php
/**
 * 通知管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class SysNotification extends Base{

	//发送通知消息
	public function notify()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysNotification','notify'))
        {
            return $this->result;
        }
		return model('SysNotification', 'service')->send_notification($this->data);
	}


	//获取通知列表
	public function get_notification_list()
	{	
		//验证数据,不通过返回错误信息
        if(!$this->verify('SysNotification','get_notification_list'))
        {
            return $this->result;
        }
		return model('SysNotification', 'service')->fetch_notification_list($this->data);
	}
}
