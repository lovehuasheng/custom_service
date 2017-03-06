<?php
/**
 * 企业管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class Company extends  Base{


    /**
     * 获取会员列表
     */
    public function fetch_user_list($data=[])
    {
        return model('Company','logic')->get_users($data);
    }

    /**
     *设置会员激活状态 0-未激活 1-已激活 2-已冻结
     */
    public function edit_active_status($data=[])
    {
        return model('Company','logic')->modify_active_status($data);
    }

    /**
     * 设置会员的审核状态 0-未审核 1-未通过 2-已通过
     */
    public function edit_audit_status($data=[])
    {
        return model('Company','logic')->modify_audit_status($data);
    }

    //设置会员特权
    public function edit_privilege($data=[])
    {
        return model('Company','logic')->modify_privilege($data);
    }

    //获取会员信息
    public function get_user($data=[])
    {
        return model('Company','logic')->get_user($data);
    }
}
