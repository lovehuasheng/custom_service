<?php
/**
 * 会员管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\statistics\model;
use app\common\model\Base;

class SysUserLoginLog extends Base
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
    public function get_list($map=[],$partition_time,$fields=['*'],$page=1,$per_page= 20,$order=['id desc']) {
        $this->get_month_submeter($partition_time);
        return  $this->partition($this->info,$this->info_field,$this->rule)->field($fields)->where($map)->order($order)->page($page,$per_page)->select();

     }
     
     /**
      * 总条数
      * @param type $map
      * @param type $partition_time
      * @return type
      */
     public function get_count($map=[],$partition_time) {
        $this->get_month_submeter($partition_time);
        return  $this->partition($this->info,$this->info_field,$this->rule)->where($map)->count();

     }
}
