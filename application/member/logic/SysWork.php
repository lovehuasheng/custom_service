<?php
/**
 * 客服任务管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class SysWork extends Base
{

  /**
   * 任务指派
   */
  public function designate_work($params=[])
  {

    //检测指派日期是否正确
    if(!empty($params['assign_date']) && !strtotime($params['assign_date']))
    {
      $this->error_code = 3999;
      $this->error_msg  = '日期格式不正确';
      return $this->result;
    } 

    //客服任务
    $user_ids = [];

    //成功指派任务数量
    $success_num = 0;
    //总的任务量
    $total_num   = 0;
    //指派失败的任务数量
    $fail_num    = 0;

    //指派日期
    $assign_date = !empty($params['assign_date']) ? date('Ymd',strtotime($params['assign_date'])) : date('Ymd');

    //指派模式 0-普通指派 1-全部指派
    $assign_mode = !empty($params['assign_mode']) ? intval($params['assign_mode']) : 0;

    //检测指派模式是否正确
    if(!in_array($assign_mode,[0,1]))
    {
        $this->error_code = 4000;
        $this->error_msg  = '请选择正确的指派模式';
        return $this->result;
    }

    //会员类型 0-个人 1-企业  默认为0
    $is_company = !empty($params['is_company']) ? intval($params['is_company']) : 0;

    //检测会员类型是否正确
    if(!in_array($is_company,[0,1]))
    {
        $this->error_code = 4000;
        $this->error_msg  = '请选择正确的会员类型';
        return $this->result;
    } 

    //个人指派还是企业指派
    $func = $is_company == 0 ? 'designate_person_work' : 'designate_company_work';

    $result = $this->$func($assign_mode,$params,$assign_date);

    if(isset($result['errorCode']) && $result['errorCode'] != 0 )
    { 
      $this->error_code = $result['errorCode'];
      $this->error_msg  = $result['errorMsg'];
    }
    else
    {
        $this->error_code = 0;
        $this->error_msg  = "本次总共指派{$result['total_num']}个会员给客服{$params['customname']},成功{$result['success_num']}个,失败{$result['fail_num']}个";
    }

    return $this->result;
  }

  //获取当前用户的工作量
  public function get_work_count($params=[])
  {
    
     if(!empty($params['create_date']) && !strtotime($params['create_date']))
     {
        $this->error_code = 3999;
        $this->error_msg  = '日期格式不正确';
        return $this->result;
     }
      //当前登录客服的id
      $sys_uid = session('user_auth.id');

      //日期
      $create_date = !empty($params['create_date']) ? date('Ymd',strtotime($params['create_date'])) : date('Ymd');

      //查询条件
      $condition=[
        //客服id
        'sys_uid'       => $sys_uid,
        //日期
        'create_date'   => $create_date
      ];

      //查询字段
      $fields=[
        //任务总数
        'total_num',
        //审核通过数量
        'success_num',
        //审核未通过数量
        'fail_num'
      ];

      //初始化工作量
      $total_num = $completed_num = $unfinished_num = 0;

      $statistic = model('SysWorkStatistic')->get_statistic($condition,$fields);

      if(!empty($statistic))
      {
          //今日任务总数
          $total_num      =  $statistic[0]->total_num;
          //已完成的任务数,包括审核未通过和审核已通过
          $completed_num  = $statistic[0]->success_num + $statistic[0]->fail_num;
          //未完成任务
          $unfinished_num = $total_num - $completed_num;
      }

      $this->body = [
        //总工作量
        'total_num'       => $total_num,
        //已完成工作量
        'completed_num'   => $completed_num,
        //未完成的工作量
        'unfinished_num'  => $unfinished_num
      ];
      return $this->result;
  }

  //指派个人
  protected function designate_person_work($assign_mode,$params=[],$assign_date)
  {
    //成功指派任务数量
    $success_num    = 0;
    //总的任务量
    $total_num      = 0;
    //指派失败的任务数量
    $fail_num       = 0;
    //指派的会员id列表
    $user_ids       = [];
    //按表分组之后的会员id列表
    $groups = [];

    //普通指派模式
    if($assign_mode == 0)
    {
      //检测指派的会员是否为空
      if(empty($params['user_ids']))
      {
        $this->error_code = 4001;
        $this->error_msg  = '请选择要指派的会员';
        return $this->result;
      }
      else if(!preg_match('/^(\d+){1}$|^(\d+,){1,}\d+$/',$params['user_ids']))
      {
        //检测指派的会员格式是否正确
        $this->error_code = 4002;
        $this->error_msg  = '请正确选择要指派的会员';
        return $this->result;
      }
    }

    //检测客服是否存在
    $sys_user = model('user/SysUser')->get_user_info(['username'=>$params['customname']],['id','realname','status']);

    if(!$sys_user)
    {
      $this->error_code = 4003;
      $this->error_msg  = '该客服不存在';
      return $this->result;
    }

    if($sys_user['status'] != 0){
      $this->error_code = 4004;
      $this->error_msg  = '该客服已经被删除或者禁用';
      return $this->result;
    }
    
    //会员资料模型
    $user_info_model = model("member/UserInfo");

    //工作统计模型
    $sys_work_statistic_model = model('member/SysWorkStatistic');

    //普通指派模式
    if($assign_mode == 0)
    {
        $user_ids = explode(',', $params['user_ids']);
    }
    else
    {
        //指派条件
        $condition = session('?assign_condition') ? session('assign_condition') : [];
        //起始页码
        $page = 1;
        //最大指派数量
        $per_page   = config('max_assign_num');

        //查询满足条件的会员
        $users = $user_info_model->get_list($condition,['user_id','status','verify'],$page,$per_page);

        //获取所有的会员id
        foreach ($users as $user) {

          //未激活的会员禁止分派给客服
          if($user['status'] == 0){

           $this->error_code = 4005;

           $this->error_msg  = '存在未激活账号，请重新选择数据';

           return $this->result;
          }

          //已冻结的会员禁止分配给客服
          if($user['status'] == 2){

            $this->error_code = 4006;

            $this->error_msg  = '存在已冻结的账号，请重新选择数据';

            return $this->result;
          }

          //已通过审核的会员禁止分配给客服
          if($user['verify'] == 2 ){

            $this->error_code = 4007;
            $this->error_msg  = '存在已审核账号，请重新选择数据';
            return $this->result;
          } 

          array_push($user_ids, $user['user_id']);
        }
    }

    //按照表id,对用户进行分组
    foreach($user_ids as $user_id)
    {     
        //总任务量
        $total_num ++;
        //获取当前会员所属的表
        $table_id                          = $user_info_model->get_table_id($user_id);
        //把会员按所在的表分组
        $groups[$table_id]['user_ids'][]   = $user_id;
        //统计每个分组会员的数量
        $groups[$table_id]['total']        = empty($groups[$table_id]['total']) ? 1 : $groups[$table_id]['total']+1;

    }

    //分配客服的信息
    $new_user_info = [
        //审核客服id
        'verify_uid'    => $sys_user['id'],
        //审核客服姓名
        'verify_uname'  => $sys_user['realname'],
        //指派日期
        'assign_date'   => $assign_date
    ];


    //按表分组批量绑定会员与客服
    foreach($groups as $key => $value)
    {
      //更新条件
      $criteria['user_id'] = ['in',$value['user_ids']];

      if($user_info_model->update_by_attr($criteria,$new_user_info,$key))
      {    
           //成功的数量
           $success_num += $value['total'];
      }

    }

    //失败数量
    $fail_num = $total_num - $success_num;

    return ['total_num'=>$total_num,'success_num'=>$success_num,'fail_num'=>$fail_num];
  }

  //指派企业
  protected function designate_company_work($assign_mode,$params=[],$assign_date)
  {
    //成功指派任务数量
    $success_num = 0;
    //总的任务量
    $total_num   = 0;
    //指派失败的任务数量
    $fail_num    = 0;
    //指派的会员id列表
    $user_ids    = [];

    //普通指派模式
    if($assign_mode == 0)
    {
      //检测指派的会员是否为空
      if(empty($params['user_ids']))
      {
        $this->error_code = 4001;
        $this->error_msg  = '请选择要指派的企业会员';
        return $this->result;
      }
      else if(!preg_match('/^(\d+){1}$|^(\d+,){1,}\d+$/',$params['user_ids']))
      {
        //检测指派的会员格式是否正确
        $this->error_code = 4002;
        $this->error_msg  = '请正确选择要指派的会员';
        return $this->result;
      }
    }

    //检测客服是否存在
    $sys_user = model('user/SysUser')->get_user_info(['username'=>$params['customname']],['id','realname','status']);

    //客服不存在
    if(!$sys_user)
    {
      $this->error_code = 4003;
      $this->error_msg  = '客服不存在';
      return $this->result;
    }


    if($sys_user['status'] !=0){

      $this->error_code = 4004;
      $this->error_msg  = '该客服已经被删除或者禁用';
      return $this->result;
    }
    
    //用户资料模型
    $company_info_model = model("member/CompanyInfo");

    //工作统计模型
    $sys_work_statistic_model = model('member/SysWorkStatistic');

    //普通指派模式
    if($assign_mode == 0)
    {
        $user_ids = explode(',', $params['user_ids']);
    }
    else
    {
        //指派条件
        $condition = session('?company_assign_condition') ? session('company_assign_condition') : [];
        //起始页码
        $page = 1;
        //最大指派数量
        $per_page   = config('max_assign_num');
        //查询满足条件的会员
        $users = $company_info_model->get_list($condition,['company_id','status','verify'],$page,$per_page);
        //获取所有的会员id
        foreach ($users as $user) 
        {
          //未激活的会员禁止分派给客服
          if($user['status'] == 0){

           $this->error_code = 4005;

           $this->error_msg  = '存在未激活账号，请重新选择数据';

           return $this->result;
          }


          //已冻结的会员禁止分配给客服
          if($user['status'] == 2){

            $this->error_code = 4006;

            $this->error_msg  = '存在已冻结的账号，请重新选择数据';

            return $this->result;
          }

          //已通过审核的会员禁止分配给客服
          if($user['verify'] == 2 ){

            $this->error_code = 4007;
            $this->error_msg  = '存在已审核账号，请重新选择数据';
            return $this->result;
          } 

          array_push($user_ids, $user->company_id);
        }
    }

    //分配客服的信息
    $new_user_info = [
        //审核客服id
        'verify_uid'    => $sys_user['id'],
        //审核客服姓名
        'verify_uname'  => $sys_user['realname'],
        //指派日期
        'assign_date'   => $assign_date
    ];

    //任务总数
    $total_num = count($user_ids);

    //要更新的企业会员id
    $criteria['company_id'] = ['in',$user_ids];


    try{

        //分配企业会员给指定的客服
        $company_info_model->update_by_attr($criteria,$new_user_info);

        $success_num = $total_num;

        $fail_num    = $total_num - $success_num;

        return ['total_num'=>$total_num,'success_num'=>$success_num,'fail_num'=>$fail_num];

    }catch (\Exception $e){

       $this->error_code = 5000;

       $this->error_msg  = '操作失败,请请稍后再试';

       return $this->result;
    }

  }
}