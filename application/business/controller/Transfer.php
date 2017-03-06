<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【提供资助】控制器
// +----------------------------------------------------------------------

namespace app\business\controller;
use app\common\controller\Base;

class Transfer extends Base{
    
	/**
	 * ajax  转接单记录
	 * @return
	 */
	public function  get_transfer(){ 
		$service = \think\Loader::model('Transfer', 'service');
		return $service->get_transfer($this->user_info);
	}
}