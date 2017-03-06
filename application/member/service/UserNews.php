<?php
/**
 * 公告管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class UserNews extends  Base{

    //添加公告
    public function create_news($data=[])
    {
         return model('UserNews','logic')->append_news($data);
    }

    //获取公告列表
    public function fetch_news_list($data=[])
    {
        return model('UserNews','logic')->get_news($data);
    }

    //编辑公告
    public function edit_news($data=[])
    {
        return model('UserNews','logic')->modify_news($data); 
    }

    public function remove_news($data=[])
    {
        return model('UserNews','logic')->destroy_news($data);    
    } 

    //获取公告详情
    public function fetch_news_detail($data=[])
    {
        return model('UserNews','logic')->acquire_news_detail($data);   
    }
}
