<?php
/**
 * 客服任务管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class SysWork extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   //分表规则
   protected $rule = [
    'type' => 'mod', // 分表方式
    'num'  => 10  // 分表数量
  ];


    //查询满足条件的记录数量
    public function get_count($sys_uid=0,$condition=[])
    {
      return $this->partition(['sys_uid' => $sys_uid],'sys_uid',$this->rule)->where($condition)->count();
    }

   /**
    * 批量新增任务
    */
   public function batch_add($data=[],$sys_uid=0)
   {
      return $this->partition(['sys_uid' => $sys_uid],'sys_uid',$this->rule)->insertAll($data);
   }

   //获取任务列表
   public function get_list($condition=[],$fields=['*'],$page=1,$per_page= 20,$order=['id'=>'desc'])
   {
      return $this->partition(['sys_uid' => $condition['sys_uid']],'sys_uid',$this->rule)->field($fields)->where($condition)->order($order)->page($page,$per_page)->select();
   }
	
   //更新任务
   public function update_status($sys_uid=0,$user_id=0,$status=0)
   {
    	 $data = [
    		'status' 		=> $status,
    		'update_time'	=> time()
    	 ];
    	 $condition = [
    		'sys_uid' => $sys_uid,
    		'user_id' => $user_id
    	 ];
  	  return $this->partition(['sys_uid' => $sys_uid],'sys_uid',$this->rule)->where($condition)->update($data); 
   }


   //添加一条任务
   public function add($data=[],$sys_uid)
   {
      return $this->partition(['sys_uid' => $sys_uid],'sys_uid',$this->rule)->insert($data);
   }
}
