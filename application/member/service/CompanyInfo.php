<?php
/**
 * 企业信息管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class CompanyInfo extends  Base{

    //更新会员详细信息
    public function edit_user_info($data=[])
    {
        return model('CompanyInfo','logic')->modify_user_info($data); 
    }

    //获取会员详情
    public function fetch_user_info($data=[])
    {
        return model('CompanyInfo','logic')->acquire_user_info($data); 
    }

    //转移推荐人
    public function edit_referee($data=[])
    {
        return model('CompanyInfo','logic')->modify_referee($data);
    }

    //查看推荐人和隶属组
    public function fetch_group_referee($data=[])
    {
        return model('CompanyInfo','logic')->acquire_group_referee($data);
    }
}
