<?php
/**
 * 管理员操作会员信息模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class SysOperateUserLog extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   //分表规则
   protected $rule = [
    'type' => 'mod', // 分表方式
    'num'  => 10     // 分表数量
  ];



   /**
    * 添加一条操作日志
    * @param array  $data 日志数据
    * @param int $uid     会员id
    */
   public function add($data=[],$uid)
   {
      return $this->partition(['user_id' => $uid],'user_id',$this->rule)->insert($data);
   }

   /**
    * 通过会员id获取管理员操作该会员的记录日志列表
    * @param int $uid       会员id
    * @param array $fields 包含要查询字段的数组
    * @return mixed        成功返回当前模型的对象实例,失败返回null
    */
   public function get_list_by_uid($uid,$fields=['*'],$page=1,$per_page= 20,$order=['id'=>'desc'])
   {
      return $this->partition(['user_id'=>$uid],'user_id',$this->rule)->field($fields)->where('user_id',$uid)->order($order)->page($page,$per_page)->select();
   }
}
