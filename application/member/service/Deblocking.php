<?php
/**
 * 申请解封
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class Deblocking extends  Base{


    //获取申请解封列表
    public function fetch_apply_list($data=[])
    {
        return model('Deblocking','logic')->acquire_apply_list($data);
    }

    //获取申请解封详情
    public function fetch_apply_info($data=[])
    {
        return model('Deblocking','logic')->acquire_apply_info($data);
    }

    //更新解封信息
    public function edit_apply_info($data=[])
    {
        return model('Deblocking','logic')->modify_apply_info($data);
    }   
}
