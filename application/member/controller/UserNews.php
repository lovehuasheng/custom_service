<?php
/**
 * 会员公告控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;

class UserNews extends Base{
	
	public function index()
	{
		return view(ROOT_PATH . 'templates/notice.html');
	}

	//发布新闻
	public function add_news()
	{
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('UserNews','add_news'))   
    	{  
    	   return $this->result;
    	}
    	//公告分类 1-系统公告 2-审核公告,后台发布公告默认为系统公告
    	$this->data['classify_id'] = 1;

		return model('UserNews', 'service')->create_news($this->data);
	}

	//查看新闻列表
	public function get_news_list()
	{
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('UserNews','get_news_list'))
    	{  
    	   return $this->result;
    	}

    	//公告分类 1-系统公告 2-审核公告,后台发布公告默认为系统公告
    	$this->data['classify_id'] = 1;
		return model('UserNews','service')->fetch_news_list($this->data);
	}	

	//编辑消息模板
	public function update_news()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('UserNews','update_news'))
        {
            return $this->result;
        }

        $this->data['classify_id'] = 1;
		return model('UserNews','service')->edit_news($this->data);
	}	


	//删除公告
	public function del_news()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('UserNews','del_news'))
        {
            return $this->result;
        }

		return model('UserNews','service')->remove_news($this->data);
	}


	//查询公告详情
	public function get_news_detail()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('UserNews','get_news_detail'))
        {
            return $this->result;
        }
		return model('UserNews','service')->fetch_news_detail($this->data);
	}

}
