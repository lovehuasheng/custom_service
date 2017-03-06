<?php
/**
 * 会员管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class User extends Base
{

  /**
   * 获取会员信息
   * @param  array  $params 查询条件
   * @return array          会员信息数组
   */
  public function get_user($params=[])
  {
    //要获取的字段列表
    $fields = [
      //激活状态 0-未激活 1-已激活 2-已冻结
      'status',
      //审核状态 0-未审核 1-未通过 2-已通过
      'verify',
      //上级是否可以激活 0-可以激活 1-不可以激活
      'flag',
      //是否可以任意转币 0-不可以 1-可以
      'is_transfer',
      //是否是特困会员 0-不是 1-是
      'is_poor'
    ];
    $user = model('User')->get_by_id($params['id'],$fields);

    $this->body = $user;

    return $this->result;
  }

   /**
    * 查看会员列表
    * @param  array  $params  包含查询条件的数组
    * @return array           满足条件的会员列表
    */
   public function get_users($params=[])
   {
      //搜索条件
      $condition = [];

      //按激活状态查询 0-未激活 1-已激活 2-已冻结
      if(isset($params['status']) && trim($params['status']) != '' )
      {
        $condition['status'] = intval($params['status']);
      }

      //按审核状态查询 0-未审核 1-未通过 2-已通过
      if(isset($params['verify']) && trim($params['verify']) != '')
      { 
        $condition['verify'] = intval($params['verify']);
      }

      //按会员id查询
      if(!empty($params['user_id']))
      {
        $condition['user_id'] = intval($params['user_id']);
      }

      //按会员账号查询
      if(!empty($params['username']))
      {
        $condition['username'] = ['like','%'.trim($params['username']).'%'];
      }

      //按姓名查询
      if(!empty($params['name']))
      {
        $condition['name'] = ['like','%'.trim($params['name']).'%'];
      }
      if(!empty($params['phone'])){
          $condition['phone']          = ['like','%'.trim($params['phone']).'%'];
      }
      if(!empty($params['alipay_account']))
      {
          $condition['alipay_account'] = ['like','%'.trim($params['alipay_account']).'%'];
      }
      if(!empty($params['weixin_account']))
      {
          $condition['weixin_account'] = ['like','%'.trim($params['weixin_account']).'%'];
      }
      
      
      
      /*if(!empty($params['phone']) || !empty($params['alipay_account']) || !empty($params['weixin_account']) ){
	      //按手机号码查询
	      if(!empty($params['phone']))
	      {
	        $condition['phone']          = ['like','%'.trim($params['phone']).'%'];
	        $condition['alipay_account'] = ['like','%'.trim($params['phone']).'%'];
	        $condition['weixin_account'] = ['like','%'.trim($params['phone']).'%'];
	        $condition['logic']         = 'or'; 
	      
	      }else{
	      	
	      	//按支付宝查询
	      	if(!empty($params['alipay_account']))
	      	{
	      		$condition['alipay_account'] = ['like','%'.trim($params['alipay_account']).'%'];
	      	}
	      	
	      	//按微信查询
	      	if(!empty($params['weixin_account']))
	      	{
	      		$condition['weixin_account'] = ['like','%'.trim($params['weixin_account']).'%'];
	      	}
	      	
	      }
	
	     
      }*/

      //按开户银行查询
      if(!empty($params['bank_name']))
      {
        $condition['bank_name'] = ['like','%'.trim($params['bank_name']).'%'];
      }

      //按银行账号查询
      if(!empty($params['bank_account']))
      {
        $condition['bank_account'] = ['like','%'.trim($params['bank_account']).'%'];
      }

      //按身份证号查询
      if(!empty($params['card_id']))
      {
        $condition['card_id'] = ['like','%'.trim($params['card_id']).'%'];
      }

      //按资料已更新/未更新查询 0-未更新 1-已更新
      if(isset($params['update_status']) && trim($params['update_status']) != '')
      {
        $condition['update_status'] = intval($params['update_status']);
      }

      //按注册起始时间查询
      if(!empty($params['create_time_start']))
      {
        $condition['create_time'] = ['>=',strtotime($params['create_time_start'])];
      }

      //按注册截止时间查询
      if(!empty($params['create_time_end']))
      {

        $exp = ['<=',strtotime($params['create_time_end'])];

        if(!empty($condition['create_time']))
        {
          $condition['create_time'] = [$condition['create_time'],$exp,'AND']; 
        }
        else
        {
          $condition['create_time'] = $exp;
        }
      }

      //按资料更新起始时间查询
      if(!empty($params['update_time_start']))
      {
        $condition['update_time'] = ['>=',strtotime($params['update_time_start'])];
      }

      //按资料截止时间查询
      if(!empty($params['update_time_end']))
      {
        $exp = ['<=',strtotime($params['update_time_end'])];
        if(!empty($condition['update_time']))
        {
          $condition['update_time'] = [$condition['update_time'],$exp,'AND']; 
        }
        else
        {
          $condition['update_time'] = $exp;
        }
      }

      //按已分配未分配查询 0-未分配 1-已分配
      if(isset($params['is_assign']) && trim($params['is_assign']) != '')
      {
        // 0-未指派 1-已指派
        if(intval($params['is_assign']) == 0)
        {
          //未指派
          $condition['verify_uid'] = 0;
        }
        else
        {
          //已指派
          $condition['verify_uid'] = ['>',0];
        }
        unset($params['is_assign']);
      }

      //按分配日期查询
      if(!empty($params['assign_date']))
      {
        $condition['assign_date'] = date('Ymd',strtotime($params['assign_date']));
      }

      //按操作员名称查询
      if(!empty($params['verify_uname']))
      {
        $condition['verify_uname'] = trim($params['verify_uname']);
      }

      //默认按资料更新时间按降序排列
      $order = 'DESC';

      //排序规则 0-降序 1-升序
      if(isset($params['order']) && $params['order'] == 1)
      {
        $order = 'ASC';
      }

      //排序字段,默认按资料更新时间排序
      $order_field = 'update_time';

      //排序字段 create_time-注册时间 update_time-资料更新时间
      if(isset($params['order_field']) && trim($params['order_field']) == 'create_time')
      {
        $order_field = 'create_time';
      }

      //排序
      $sort_order = [$order_field=>$order];

      //获取页码
      if(!empty($params['page']))
      {
        
        $page = intval($params['page']);
      }

      //设置默认页码
      if(empty($page) || $page <=0)
      {
        $page = 1;
      }

      //设置每页记录数,默认为100条
      $per_page = config('member_page_total');

      //设置页码列表,默认为5页
      $page_list = config('page_list');

      if(session('user_auth.is_super'))
      {   
        //超级管理员
        return $this->get_super_work($condition,$page,$per_page,$page_list,$sort_order);
      }
      else
      { 
      	 
        //客服默认不显示审核已通过的会员
        if(!isset($params['verify']) || trim($params['verify']) == '')
        {
          $condition['verify'] = ['<',2];
        }
        //普通客服
        return $this->get_custom_work($condition,$page,$per_page,$page_list,$sort_order);
      }
   }

   /**
    * 获取客服的会员列表
    * @param  array  $condition 搜索条件
    * @return array             满足条件的会员列表
    */
   protected function get_custom_work($condition,$page,$per_page,$page_list,$sort_order)
   {

      //会员列表
      $user_list = [];

      //满足条件的会员总数
      $total     = 0;

      $user_info_model = model('UserInfo');

      //获取的字段列表
      $fields = [
          //会员id
          'user_id',
          //会员账号
          'username',
          //真实姓名
          'name',
          //激活状态
          'status',
          //审核状态
          'verify',
          //手机号码
          'phone',
          //操作员
          'verify_uname',
          //更新状态
          'update_status',        
           //更新时间
          'update_time',
          //注册时间
          'create_time'
        ];

      //当前登录的客服id
      $condition['verify_uid'] = session('user_auth.id');

      //审核客服默认显示当天的任务
      // if(!isset($condition['assign_date']) || trim($condition['assign_date']) == '')
      // {
      //     $condition['assign_date'] = date('Ymd');
      // }

      //查询满足条件的会员数量
      $total = $user_info_model->get_count($condition);

      if($total)
      {
        //查询当前客服对应的审核会员列表 
        $user_list = $user_info_model->get_list($condition,$fields,$page,$per_page,$sort_order);
      }

      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //返回结果
      $this->body = [
          'user_list' => $user_list,
          'pages'     => $pages,
          'total'     => $total
        ];

      return $this->result;
   }

   /**
    * 获取超级管理员的会员列表
    * @param  array $condition  搜索条件
    * @return array             满足条件的会员列表
    */
   protected function get_super_work($condition,$page,$per_page,$page_list,$sort_order)
   {
      //会员列表
      $user_list = [];

      //满足搜索条件的会员数量
      $total     = 0;

      $user_info_model = model('UserInfo');

      //获取的字段列表
      $fields = [
          //会员id
          'user_id',
          //会员账号
          'username',
          //真实姓名
          'name',
          //激活状态
          'status',
          //审核状态
          'verify',
          //手机号码
          'phone',
          //任务员
          'verify_uname',
          //操作员
          'operator_name',
          //更新状态
          'update_status',        
           //更新时间
          'update_time',
          //注册时间
          'create_time'
        ];
 

      //查询满足条件的会员总数
      $total = $user_info_model->get_count($condition);

      //将搜索条件存入session中
      session('assign_condition',$condition);

      if($total)
      {
        //有满足条件的会员,则查询出会员列表
        $user_list = $user_info_model->get_list($condition,$fields,$page,$per_page,$sort_order);
      }
      
      
      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //返回结果
      $this->body = [
          'user_list' => $user_list,
          'pages'     => $pages,
          'total'     => $total
        ];

      return $this->result;
   }

   /**
    * 改变会员的激活状态     0-未激活 1-已激活 2-已冻结
    * @param array $params 包含更新条件和更新数据的数组
    * @return array        包含响应消息的数组,若数组中的错误码为0,表示设置会员激活状态成功
    */
   public function modify_active_status($params=[])
   {
      //用户信息
      $user = [
        //激活状态 1-已激活 2-已冻结
        'status'            => $params['status'],
        //管理员更新时间
        'admin_update_time' => time()
      ];

      // if(isset($params['flag']))
      // {
      //    //上级是否可以激活 0-可以激活 1-不可以激活
      //   $user['flag'] = $params['flag'];
      // }

      //激活日志
      $activate_log = [
        //数据主体
        'data' => [
            //操作人id
            'operator_id'     => session('user_auth.id'),
            //操作人真实姓名
            'operator_name'   => session('user_auth.realname'),
            //操作类型 0-普通用户 1-管理用户
            'operator_type'   => 1,
            //会员类型 0-个人 1-企业
            'is_company'      => 0,
            //会员id
            'user_id'         => $params['id'],
            //会员账号
            'user_name'       => $params['username'],
             //激活状态 1-已激活 2-已冻结
            'activate_status' => $params['status'],
            //备注
            'remark'          => empty($params['remark']) ? '' : $params['remark']
        ],
        //模型名称
        'model_name' => 'ActivateLog',
      ];

      //有备注则写入备注记录
      if(!empty($params['remark']))
      {
          $sys_remark = [
            //会员id
            'user_id' => $params['id'],
            //备注类型 1-封号备注 2-特权备注 3-编辑资料备注 4-转移推荐人备注
            'type_id'  => 1, 
            //系统管理员id
            'sys_uid' => session('user_auth.id'),
            //备注
            'remark'  => $params['remark']
        ];
      }

      //激活日志加入到队列
      add_to_queue('',$activate_log);

      //开启事务
      \think\Db::startTrans();
      try{
          //备注不为空,则写入备注信息
          if(!empty($sys_remark))
          {
            //写入备注信息
            model('SysRemark')->add($sys_remark);
          }
          //更新用户激活状态
         $update_user =  model('User')->update_by_id($params['id'],$user);
         if($update_user){
         	//加入黑名单
         	//查看是否在黑名单中
         	$is_black = model('user/UserBlacklist')->get_user_info($params['id'],'id');
         	if($params['status'] == 2 ){   
         		if( ! $is_black){      		
         	       model('user/UserBlacklist')->set_blacklist_to_queue($params['id'],$params['remark']);
         		}
         	}else{
         	   if($is_black){
         	     model('user/UserBlacklist')->del($params['id']);
         	   }
         	}
         	 
         }
          // 提交事务
          \think\Db::commit();
      }catch (\Exception $e){
          // 回滚事务
          \think\Db::rollback();
          $this->error_code = 61000;
          $this->error_msg  = '修改用户激活状态失败';
      }
      return $this->result;
   }


   /**
    * 改变会员的审核状态 0-未审核 1-未通过 2-已通过
    * @param array $params 包含更新条件和更新数据的数组
    * @return array        包含响应消息的数组,若数组中的错误码为0,表示设置会员审核状态成功
    */
   public function modify_audit_status($params=[])
   {

      //更新用户信息
      $user = [
          'verify'              => 2,
          //客服/管理员操作时间
          'admin_update_time'   => time()
      ];

	    //写入审核日志
      $audit_log = [
        //数据主体
        'data' => [
            //操作人id
            'operator_id'   => session('user_auth.id'),
            //操作人真实姓名
            'operator_name' => session('user_auth.realname'),
            //会员id
            'user_id'       => $params['id'],
            //会员类型 0-个人 1-企业
            'is_company'    => 0,
            //会员账号
            'user_name'     => $params['username'],
            //审核状态 1-未通过 2-已通过
            'verify_status' => 2,
            //备注
            'remark'        => empty($params['remark']) ? '' : $params['remark'],
            //创建时间
            'create_time'   => time()
        ],
        //模型名称
		    'model_name' => 'VerifyLog',
      ];

      //管理员操作用户日志
      $sys_operate_user_log = [
          //用户id
          'user_id'         => intval($params['id']),
          //系统管理员id
          'sys_uid'         => session('user_auth.id'),
          //管理员姓名
          'sys_realname'    => session('user_auth.realname'),
          //操作类型 1-审核 2-编辑 3-通知
          'operation_type'  => 1,
          //创建时间
          'create_time'     => time(),
          //更新时间
          'update_time'     => time()
      ];

      //更新用户资料
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

      //查询会员手机号码
      $user_info = model('UserInfo')->get_by_uid($params['id'],['phone']);

      if(!$user_info)
      {
          $this->error_code = 20000;
          $this->error_msg  = '会员不存在';
          return $this->result;
      }

      //实例化redis
      $redis     = \org\RedisLib::get_instance();
      //存储会员审核失败数量的key
      $key       = "sxh_sys_work_statistic:user_id:{$params['id']}:fail_num";
      //获取当前会员的审核未通过数量
      $fail_num = $redis->get($key);

      //短信
      $sms = [
        //接收短息的会员手机号
        'phone' => $user_info->phone,
        //短信内容
        'content' => '您好，您的资料已经审核通过，通过后无法自行修改任何资料，如需修改请联系服务中心',
        //附加数据,写入数据库
        'extra_data' => [
              //会员id
              'user_id'     => $params['id'],
              //短信标题
              'title'       => '审核通知',
              //ip地址
              'ip_address'  => ip2long(request()->ip())
            ]
        ];

      //要查询的字段
      // $fields=[
      //   //主键
      //   'id'
      // ];

      //查询用户是否在黑名单中
      //$black_list = model('user/UserBlacklist')->get_user_info(['user_id'=>$params['id']],$fields);
      //开启事务
      \think\Db::startTrans();
      try{
        //更新用户的审核状态 
        model('User')->update_by_id($params['id'],$user);
        //更新会员资料
        model('UserInfo')->update_by_uid($params['id'],$new_user_info);
        //从黑名单中移除会员
        //if(!empty($black_list))
        //{
          model('user/UserBlacklist')->del_by_uid($params['id']);
        //}
        //超级管理员审核的会员,不计算在客服工作内
        // if(!session('user_auth.is_super'))
        // {
          //更新审核通过统计数据
          model('SysWorkStatistic')->update_success_num(session('user_auth.id'),session('user_auth.username'),$fail_num);
       // }
        //提交事务
        \think\Db::commit();
        //加入短信队列
        add_to_queue('sxh_user_sms',$sms);
        //将审核日志加入到日志队列
        add_to_queue('log_queue',$audit_log);
        //记录管理员操作用户的日志
        model('SysOperateUserLog')->add($sys_operate_user_log,$params['id']);

      }catch (\Exception $e) {
        // 回滚事务
        \think\Db::rollback();
        $this->error_code = 61001;
        $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
   }

   //修改会员特权
   public function modify_privilege($params=[])
   {
        //更新用户信息
        $new_user = [
            //是否开启任意转币 0-不可以 1-可以
            'is_transfer'       => empty($params['is_transfer']) ? 0 : 1 ,
            //是否是特困会员 0-不是 1-是
            'is_poor'           => empty($params['is_poor']) ? 0 : 1,
            //管理员更新时间
            'admin_update_time' => time(),
        ];

        //有备注则写入备注
        if(!empty($params['remark']))
        {
            //备注记录
           $sys_remark = [
               //会员id
              'user_id' => $params['id'],
               //备注类型 1-封号备注 2-特权备注 3-编辑资料备注 4-转移推荐
              'type_id' => 2,
              //系统管理员id
              'sys_uid' => session('user_auth.id'),
              //备注
              'remark'  => $params['remark']
            ];
        }

        //开启事务
        \think\Db::startTrans();
        try{ 
            if(!empty($sys_remark))
            {
              //写入备注信息
              model('SysRemark')->add($sys_remark);
            }
            //更新用户信息
            model('User')->update_by_id($params['id'],$new_user);
            // 提交事务
            \think\Db::commit(); 
        }catch (\Exception $e) {
          // 回滚事务
          \think\Db::rollback();
          $this->error_code = 61001;
          $this->error_msg  = '修改用户特权失败';
        }
        return $this->result;
   }


   //修改会员的密码/二级密码
   public function reset_passwrod_secondary($params=[])
   {  
      $new_user = [];
      
      $user_data = model("User")->get_by_id($params['user_id']);
      //兼容老数据（jwf）
      if(empty($user_data["security"])){
      	//密码
      	if(!empty($params['password']))
      	{
      		//获取随机密钥
      		$security = random_str();
      		//加密的密码
      		$password = md5($params['password']);
      	
      		$new_user = [ 'password' => $password ];
      	}
      	
      	//二级密码
      	if(!empty($params['secondary_password']))
      	{
      		$new_user['secondary_password'] = md5($params['secondary_password']);
      	}
      	
      }else{
	      //密码
	      if(!empty($params['password']))
	      { 
	        //获取随机密钥
	        $security = random_str();
	        //加密的密码
	        $password = set_member_password($params['password'],$security);
	
	        $new_user = [
	          'security' => $security,
	          'password' => $password
	        ];
	      }
	
	      //二级密码
	      if(!empty($params['secondary_password']))
	      {
	        $new_user['secondary_password'] = set_member_secondary_password($params['secondary_password']);
	      }
      }
      $rs = model('User')->update_by_id($params['user_id'],$new_user);

      if(!$rs)
      {
        $this->error_code = 61002;
        $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
   }
    
}