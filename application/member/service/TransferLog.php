<?php
/**
 * 转币记录管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class TransferLog extends  Base{


    //获取公告列表
    public function fetch_transfer_list($data=[])
    {
        return model('TransferLog','logic')->get_transfer($data);
    }
}
