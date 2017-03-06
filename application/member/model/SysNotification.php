<?php
/**
 * 通知管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class SysNotification extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   //分表规则
   protected $rule = [
    'type' => 'mod',  //分表方式按取模分表
    'num'  => 10     //分表数量
  ];


    public function getCreateTimeAttr($value)
    {
       return date('Y-m-d H:i:s',$value);
    }

    public function getCreateTimeTextAttr($value,$data)
    {
       return date('Y-m-d H:i:s',$data['create_time']);
    }

    /**
    * 通过会员id获取通知列表
    * @param int   $uid       会员uid
    * @param array $fields   包含要查询字段的数组
    * @return mixed          成功返回当前模型的对象实例,失败返回null
    */
    public function get_by_uid($uid,$fields=['*'],$order=['id'=>'desc'])
    {
      return $this->partition(['user_id'=>$uid],'user_id',$this->rule)->field($fields)->where('user_id',$uid)->order($order)->select();
    } 

   /**
    * 写入新通知
    * @param array $data 通知数组
    * @return int       成功返回1,失败返回0
    */
   public function add($data=[])
   {
      return $this->partition(['user_id' => $data['user_id']],'user_id',$this->rule)->insert($data);
   }
}
