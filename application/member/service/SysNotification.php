<?php
/**
 * 通知管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class SysNotification extends  Base{


    //发送通知
    public function send_notification($data=[])
    {
        return model('SysNotification','logic')->transmit_notification($data);
    }

    //获取通知列表
    public function fetch_notification_list($data=[])
    {
        return model('SysNotification','logic')->get_notifications($data);
    }
}
