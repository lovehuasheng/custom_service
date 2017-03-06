<?php
/**
 * 客服任务管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class SysWork extends  Base{

    //分配任务
    public function dispatch_work($data=[])
    {
        return model('SysWork','logic')->designate_work($data);
    }

    //获取用户的工作量
    public function get_work_num($data=[])
    {
        return model('SysWork','logic')->get_work_count($data);
    }

    //获取工作列表
    public function fetch_work_list($data=[])
    {
        return model('SysWork','logic')->get_works($data);
    }

    //同步客服任务到数据库
    public function write_to_db()
    {
        return model('member/SysWork','logic')->store_to_db();
    }
}
