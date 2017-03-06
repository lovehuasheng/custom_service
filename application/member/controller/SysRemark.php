<?php
/**
 * 备注管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class SysRemark extends Base{


	//查看备注列表
	public function get_remark_list()
	{
		if(!$this->verify('SysRemark','get_remark_list'))
		{
			return $this->result;
		}
		return model('SysRemark','service')->fetch_remark_list($this->data);
	}
}
