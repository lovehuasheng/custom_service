<?php
/**
 * 通知管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class SysNotification extends Base
{

  /**
   * 发送消息
   * @param  array  $params  包含要发送消息的数组
   * @return array           包含响应消息的数组,若数组中的错误码为0,表示发送消息表成功
   */
  public function transmit_notification($params=[])
  {  
     //判断是个人还是企业 0-个人 1-企业
     $is_company = isset($params['is_company']) ? intval($params['is_company']) : 0;

     if(!in_array($is_company,[0,1]))
     {
        $this->error_code = 60000;
        $this->error_msg  = 'is_company不正确';
     }

     if($is_company == 0)
     {
        //个人用户资料模型
        $user_info_model_name = 'UserInfo';
        //个人用户信息模型
        $user_model_name      = 'User';
        //会员真实姓名
        $name                 = 'name';
        //会员手机号码
        $phone                = 'phone';
     }
     else
     {
        //企业用户资料模型
        $user_info_model_name = 'CompanyInfo';
        //企业用户信息模型
        $user_model_name      = 'Company';
        //法人姓名
        $name                 = 'legal_person';
        //会员手机号码
        $phone                = 'mobile';
     }

      //查询会员信息
      $user_info = model($user_info_model_name)->get_by_uid($params['user_id'],[$name,$phone]);

      if(!$user_info)
      {
          $this->error_code = 91000;
          $this->error_msg  = '会员不存在';
          return $this->result;
      }

      //判断是否需要发送短信
      if(!empty($params['ms_tpl_id']))
      {
        //消息模板模型
        $sys_msg_tpl_model = model('SysMsgTpl');

        //根据短信模板id,获取短信标题和内容
        $fields = [
          //模板标题
          'title',
          //模板内容
          'content',
          //模板状态
          'status'
        ];
        //查询消息模板信息
        $sys_msg_tpl = $sys_msg_tpl_model->get_by_id($params['ms_tpl_id'],$fields);

        //消息模板不存在
        if(!$sys_msg_tpl)
        {
            $this->error_code = 91000;
            $this->error_msg  = '消息模板不存在';
            return $this->result;
        }

        //消息模板被禁用或者删除
        if($sys_msg_tpl->status != 0 )
        {
          $this->error_code = 91001;
          $this->error_msg  = '消息模板被禁用或者删除';
          return $this->result;
        }

        //短信消息
        $sms = [
            //接收短息的会员手机号
            'phone'      => $user_info->$phone,
            //短信内容
            'content'    => $sys_msg_tpl->content,
            //写入数据库的数据
            'extra_data' => [
              //接收短息会员id
              'user_id'    => $params['user_id'],
              //标题
              'title'      => $sys_msg_tpl->title,
              //发送短信的ip地址
              'ip_address' =>  ip2long(request()->ip()),
            ]
        ];
        //发送短信
        //model('UserSms','logic')->dispatch_sms($sms);
      }

     //审核通知
     $audit_msg = [
        //接收通知的会员id
        'user_id'      => $params['user_id'],
        //管理员id
        'admin_id'     => session('user_auth.id'),
        //通知内容
        'attend'      => $params['content'],
        //发送时间
        'create_time'  => time(),
        //更新时间
        'update_time'  => time(),
     ];

    //更新后的用户资料
    $new_user_info = [
        //客服审核之后将用户的资料更新状态重置为0  0-没有更新 1-有更新
        'update_status'       => 0,
        //操作员id
        'operator_id'         => session('user_auth.id'),
        //操作员姓名
        'operator_name'       => session('user_auth.realname'),
        //管理员更新时间
        'admin_update_time'   => time()
     ];


      //管理员操作用户日志
      $sys_operate_user_log = [
          //用户id
          'user_id'         => intval($params['user_id']),
          //系统管理员id
          'sys_uid'         => session('user_auth.id'),
          //管理员姓名
          'sys_realname'    => session('user_auth.realname'),
          //操作类型 1-审核 2-编辑 3-通知
          'operation_type'  => 3,
          //创建时间
          'create_time'     => time(),
          //更新时间
          'update_time'     => time()
      ];
      
      //开启事务
      \think\Db::startTrans();
      try{

          //更新会员的黑名小信息
          //model('user/UserBlacklist')->add_to_blacklist($params['user_id'],$user_info->$name,$params['content']);
          //有填写通知,则添加审核通知
          model('UserAuitMsg')->add($audit_msg);
          //更新会员的审核状态为未通过 0-未审核 1-未通过 2-已通过
          model($user_model_name)->update_by_id($params['user_id'],['verify'=>1]);
          //审核过后重置会员的资料更新状态为未更新 0-没有更新 1-有更新
          model($user_info_model_name)->update_by_uid($params['user_id'],$new_user_info);
          //超级管理员审核的会员,不计算在客服工作内
          //if(!session('user_auth.is_super'))
          //{
            //更新审核未通过的统计数据
            model('SysWorkStatistic')->update_fail_num(session('user_auth.id'),session('user_auth.username'));
          //}
          // 提交事务
          \think\Db::commit(); 

          //实例化redis
          $redis     = \org\RedisLib::get_instance();
          //存储会员审核失败数量的key
          $key       = "sxh_sys_work_statistic:user_id:{$params['user_id']}:fail_num";
          //审核未通过数量+1
          $redis->incr($key);
          //发送短信
          if(!empty($sms)){
              //加入短信队列
              add_to_queue('sxh_user_sms',$sms);
          }
          //记录管理员操作会员的日志
          model('SysOperateUserLog')->add($sys_operate_user_log,$params['user_id']);

        }catch (\Exception $e) {
          //回滚事务
          \think\Db::rollback();
          $this->error_code = 91001;
          $this->error_msg  = '操作失败,请稍后再试';
        }
	     return $this->result;
  }

  /**
   * 获取消息列表列表
   * @param  array  $params 包含查询条件的数组
   * @return arry           包含响应消息的数组,若数组中的错误码为0,表示获取消息列表成功
   */
  public function get_notifications($params=[])
  {
      //要获取的字段
      $fields = [
        //通知内容
        'attend',
        //通知时间
        'create_time'
      ];
      //根据会员id获取对应的审核通知记录
      $sys_notifications = model('UserAuitMsg')->get_by_uid($params['user_id'],$fields,100);
      //设置响应消息
      $this->body = empty($sys_notifications) ? [] : $sys_notifications;
      return $this->result;
  }

}