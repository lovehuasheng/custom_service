<?php
/**
 * 申请解封
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class Deblocking extends Base{


	//显示申请解封页面
	public function index()
	{
		return view(ROOT_PATH . 'templates/application_remove.html');
	}
    
    //查看申请列表
	public function get_apply_list()
	{
		return model('Deblocking','service')->fetch_apply_list($this->data);
	}


	//查看申请详情
	public function get_apply_info()
	{

		return model('Deblocking','service')->fetch_apply_info($this->data);
	}

	//编辑申请信息
	public function update_apply_info()
	{
		return model('Deblocking', 'service')->edit_apply_info($this->data);
	}

}
