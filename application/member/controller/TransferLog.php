<?php
/**
 * 转币记录控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class TransferLog extends Base{
	
	public function show_transfer_list()
	{
		return view(ROOT_PATH . 'templates/inquiry.html');
	}


	//查看新闻列表
	public function get_transfer_list()
	{
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('TransferLog','get_transfer_list'))
    	{  
    	   return $this->result;
    	}
		return model('TransferLog','service')->fetch_transfer_list($this->data);
	}	
}
