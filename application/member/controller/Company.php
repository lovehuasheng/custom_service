<?php
/**
 * 会员管理控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class Company extends Base{

	public function show_company_list()
	{
		return view(ROOT_PATH . 'templates/mywork_company_manager.html',[
                'group_name' => session('user_auth.group_name'),
                'realname'   => session('user_auth.realname')
        ]);	
	}
}
