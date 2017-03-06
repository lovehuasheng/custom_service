<?php
/**
 * 会员账户管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;


class UserIncome extends Model
{
   
   protected function initialize() {
      //分表规则
        $this->rule = [
            'type' => 'quarter', // 分表方式,按月分表
            'expr' => 3     // 按3月一张表分
        ];
        //分表数据
        $this->info = [
            'now_time' =>  $_SERVER['REQUEST_TIME']  
        ];
        $this->info_field = 'now_time';
      
    }
   
  
  /** 插入收入明细数据
   * @param   $where  条件
   * @param   $data   插入的数据信息
   * @return  int
   * @author  江雄杰
   * @time    2016-10-15
   */
 
  public function saveData($data) {
  	
  	$data['id'] = \org\RedisLib::get_instance()->getUserIncomeId(1);
  
  	return  $this->partition($this->info,$this->info_field,$this->rule)
  	->insert($data); 
  }

  
}
