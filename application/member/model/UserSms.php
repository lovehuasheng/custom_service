<?php
/**
 * 会员消息管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class UserSms extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   //分表规则
   protected $rule = [
    'type' => 'mod', // 分表方式
    'num'  => 10  // 分表数量
  ];


   /**
    * 写入新消息
    * @param array $data 消息数组
    * @return int       成功返回1,失败返回0
    */
   public function add($data=[])
   {
      return $this->partition(['phone' => $data['phone']],'phone',$this->rule)->insert($data);
   }
}
