<?php
/**
 * 客服任务统计模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class SysWorkStatistic extends Model
{

   /**
    * 查询统计数据
    * @param  array  $condition 查询条件数组
    * @param  array  $fields    查询字段数组
    * @return array             结果集数组
    */   
   public function get_statistic($condition=[],$fields=['*'],$order=['day_date asc'])
   {
     return $this->field($fields)->where($condition)->order($order)->select();
   }

   /**
    * 更新审核未通过统计数据
    * @param  int    $sys_uid        客服id
    * @param  string $sys_uname      客服账号
    * @param  int    $create_date    审核日期
    * @return int                    失败返回0,成功返回受影响的行数
    */
   public function update_fail_num($sys_uid,$sys_uname,$create_date=0)
   {
      if(empty($create_date))
      {
         $create_date = date('Ymd');
      }
      $sql = "INSERT INTO {$this->getTable()}(sys_uid,sys_uname,fail_num,create_date)VALUES(:sys_uid,:sys_uname,:fail_num,:create_date)";
      $sql .= " ON DUPLICATE KEY UPDATE fail_num=fail_num+1";
      return $this->execute($sql,['sys_uid'=>$sys_uid,'sys_uname'=>$sys_uname,'fail_num'=>1,'create_date'=>$create_date]);
   }

   /**
    * 更新审核已通过统计数据
    * @param  int    $sys_uid        客服id
    * @param  string $sys_uname      客服账号
    * @param  int    $create_date    审核日期
    * @return int                    失败返回0,成功返回受影响的行数
    */
   public function update_success_num($sys_uid,$sys_uname,$fail_num=0,$create_date=0)
   {
      if(empty($create_date))
      {
         $create_date = date('Ymd');
      }

      $fail_num = intval($fail_num);

      if($fail_num == 0)
      {
        //一审通过
        $field = 'frist_verify';
      }
      else if($fail_num == 1)
      {
        //二审通过
        $field = 'tow_verify';
      }
      else
      {
        //三审及以上通过
        $field = 'three_verify';
      }

      $sql = "INSERT INTO {$this->getTable()}(sys_uid,sys_uname,success_num,create_date,{$field})VALUES(:sys_uid,:sys_uname,:success_num,:create_date,1)";
      $sql .= " ON DUPLICATE KEY UPDATE success_num=success_num+1,{$field}={$field}+1";
      return $this->execute($sql,['sys_uid'=>$sys_uid,'sys_uname'=>$sys_uname,'success_num'=>1,'create_date'=>$create_date]);
   }

  //增加工作量
  public function add($sys_uid,$sys_uname,$total_num,$create_date)
  {   
      //创建时间
      $create_time = time();

      //获取年
      $year_date   = intval(substr($create_date, 0,4));

      //获取月
      $month_date  = intval(substr($create_date, 4,2));

      //获取天
      $day_date    = intval(substr($create_date,6));

      $sql = "INSERT INTO {$this->getTable()}(sys_uid,sys_uname,total_num,create_date,create_time,year_date,month_date,day_date)VALUES(:sys_uid,:sys_uname,:total_num,:create_date,:create_time,:year_date,:month_date,:day_date)";
      $sql .= " ON DUPLICATE KEY UPDATE total_num=total_num+{$total_num}";

      return $this->execute($sql,['sys_uid'=>$sys_uid,'sys_uname'=>$sys_uname,'total_num'=>$total_num,'create_date'=>$create_date,'create_time'=>$create_time,'year_date'=>$year_date,'month_date'=>$month_date,'day_date'=>$day_date]);
   }

  //减少工作量
  public function dec($sys_uid,$total_num,$create_date)
  {
    $sql= "UPDATE {$this->getTable()} SET total_num=total_num-:total_num WHERE sys_uid=:sys_uid AND create_date=:create_date LIMIT 1";
    return $this->execute($sql,['total_num'=>$total_num,'sys_uid'=>$sys_uid,'create_date'=>$create_date]);
  }
  
  /**
   * 按天统计
   * @param type $arr
   * @return type
   */
  public function work_statistic_count(&$arr) {
      $sql = 'update '.$this->getTable();
      $end_sql                  =  '';
      $total_day_rank           =  '  set total_day_rank = case id ';
      $success_day_rank         =  '  end, success_day_rank = case id ';
      $work_time_day_rank       =  '  end, work_time_day_rank = case id ';
      foreach($arr as $v) {
          $total_day_rank      .= sprintf("WHEN %d THEN %d ", $v['id'], $v['total']); 
          $success_day_rank    .= sprintf("WHEN %d THEN %d ", $v['id'], $v['success']); 
          $work_time_day_rank  .= sprintf("WHEN %d THEN %d ", $v['id'], $v['work']); 
      }
     $ids                       = array_unique(array_column($arr, 'id'));
     $ids_where                 = implode(',', $ids);
     $end_sql                  .= 'END WHERE id IN ('.$ids_where.')';
   
     return  $this->execute($sql.$total_day_rank.$success_day_rank.$work_time_day_rank.$end_sql);
  }
  
  
  public function work_statistic_month_count(&$arr) {
      $sql = 'update '.$this->getTable();
      $end_sql                    =  '';
      $total_month_rank           =  '  set total_month_rank = case id ';
      $success_month_rank         =  '  end, success_month_rank = case id ';
      $work_time_month_rank       =  '  end, work_time_month_rank = case id ';
      foreach($arr as $v) {
          $total_month_rank      .= sprintf("WHEN %d THEN %d ", $v['id'], $v['total']); 
          $success_month_rank    .= sprintf("WHEN %d THEN %d ", $v['id'], $v['success']); 
          $work_time_month_rank  .= sprintf("WHEN %d THEN %d ", $v['id'], $v['work']); 
      }
     $ids                         = array_unique(array_column($arr, 'id'));
     $ids_where                   = implode(',', $ids);
     $end_sql                    .= 'END WHERE id IN ('.$ids_where.')';
     return  $this->execute($sql.$total_month_rank.$success_month_rank.$work_time_month_rank.$end_sql);
  }
}
