<?php
/**
 * 管理员操作会员日志
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class SysOperateUserLog extends  Base
{

   //获取日志列表
   public function fetch_log_list($user_id,$page)
   {
        $logic = \think\Loader::model('SysOperateUserLog','logic');

        return $logic->obtain_log_list($user_id,$page); 
   }

}
