<?php
/**
 * 备注管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class SysRemark extends  Base{


    /**
     * 获取备注列表
     */
    public function fetch_remark_list($data=[])
    {
        return model('SysRemark','logic')->get_remarks($data);
    }
}
