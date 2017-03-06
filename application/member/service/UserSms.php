<?php
/**
 * 消息管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class UserSms extends  Base{

    /**
     * 将短信消息从redis中写入到mysql
     */
    public function write_to_db()
    {
        return model('member/UserSms','logic')->store_to_db();
    }

    public function transimt_sms($data=[])
    {
    	return model('member/UserSms','logic')->dispatch_sms($data);
    }
}
