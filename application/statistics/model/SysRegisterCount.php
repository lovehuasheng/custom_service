<?php
/**
 * 会员管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\statistics\model;
use app\common\model\Base;

class SysRegisterCount extends Base
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   
   /**
    * 列表数据
    * @param type $map
    * @param type $partition_time
    * @param type $fields
    * @param type $page
    * @param type $per_page
    * @param type $order
    * @return type
    */
    public function get_count_list($map=[],$fields=['*']) {
        return  $this->field($fields)->where($map)->select();

     }
     
    
}
