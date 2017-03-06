<?php
/**
 * 会员管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class UserInfo extends Base
{


  /**
   * 修改会员资料
   * @param  array  $params 包含更新条件和更新数据的数组/^[0-9a-zA-Z]{6,16}$/
   * @return array          包含响应消息的数组,若数组中的错误码为0,表示修改会员资料成功
   */
  public function modify_user_info($params=[])
  {   
     if(empty($params['name']) || empty($params['username']) || empty($params['phone'])){
         $this->error_code = 10002;
         $this->error_msg  = '会员账号,姓名或手机号码不能为空';
         return $this->result;
     }

      //要更新的会员信息
      $params['username'] = strtolower($params['username']);

      $params['username'] = str_replace(' ', '', $params['username']);
      
        //身份证或护照
        $t_arr = [1,2];
        if(empty($params['card_type']) || !in_array($params['card_type'], $t_arr)) {
            $params['card_type'] = 1;
            $card_type_field = 'card_id';
        }
        if($params['card_type'] == 1) {
            if(!empty($params['card_id'])){
                $patt = '/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X|x)$/';
                $card_preg = preg_match($patt,$params['card_id']);
                if(!$card_preg) {
                    $this->error_code = 666677;
                    $this->error_msg  = '身份证号码格式不正确';
                    return $this->result;
                }
            }
            $card_type_field = 'card_id';
        } else if($params['card_type'] == 2) {
            $card_type_field = 'passport';
        } 



      //管理员操作用户日志
      $sys_operate_user_log = [
          //用户id
          'user_id'         => intval($params['user_id']),
          //系统管理员id
          'sys_uid'         => session('user_auth.id'),
          //管理员姓名
          'sys_realname'    => session('user_auth.realname'),
          //操作类型 1-审核 2-编辑 3-通知
          'operation_type'  => 2,
          //创建时间
          'create_time'     => time(),
          //更新时间
          'update_time'     => time()
      ];
      
      $user_info = [
          //姓名
          'name'              => !empty($params['name']) ? trim($params['name']) : '',
          //用户名
          'username'          => !empty($params['username']) ? trim($params['username']) : '',
          //手机号码
          'phone'             => !empty($params['phone']) ? trim($params['phone']) : '',
          //电子邮件
          'email'             => !empty($params['email']) ? trim($params['email']) : '',
          //支付宝
          'alipay_account'    => !empty($params['alipay_account']) ? trim($params['alipay_account']) : '',
          //微信
          'weixin_account'    => !empty($params['weixin_account']) ? trim($params['weixin_account']) : '',
          //身份证 或 护照
          $card_type_field    => !empty($params['card_id']) ? trim($params['card_id']) : '',
          //开户银行
          'bank_name'         => !empty($params['bank_name']) ? trim($params['bank_name']) : '',
          //银行账户
          'bank_account'      => !empty($params['bank_account']) ? trim($params['bank_account']) : '',
          //操作员id
          'operator_id'       => session('user_auth.id'),
          //操作员姓名
          'operator_name'     => session('user_auth.realname'),
          //管理员更新时间
          'update_time'       => time()
      ];
      if($params['card_type'] == 1) {
          $user_info['passport'] = '';
      } else {
          $user_info['card_id'] = '';
      }

      //查询原来的用户资料
      $old_user_info = model('UserInfo')->get_by_uid($params['user_id'],['username','phone','alipay_account','weixin_account','bank_account','card_id','passport']);

     //有填写备注则插入备注信息
     if(!empty($params['remark']))
     {
        //备注记录
        $sys_remark = [
            //会员id
            'user_id' => $params['user_id'],
             //备注类型 1-封号备注 2-特权备注 3-编辑资料备注 4-转移推荐人备注
            'type_id' => 3,
            //系统管理员id
            'sys_uid' => session('user_auth.id'),
            //备注
            'remark'  => $params['remark']
        ];
     }

     $redis = \org\RedisLib::get_instance('sxh_default');
     //判断用户名是否有重复
     if(!empty($user_info['username']) && $old_user_info->username != $user_info['username'])
     {
        if($redis->sIsMember('sxh_user:username',$user_info['username']))
        {
          $this->error_code = 10002;
          $this->error_msg  = '用户名已存在';
          return $this->result;
        }
     }
     //判断手机号码是否有重复
     if(!empty($user_info['phone']) && $old_user_info->phone != $user_info['phone'])
     {
        if($redis->sIsMember('sxh_user_info:phone',$user_info['phone']))
        {
          $this->error_code = 10002;
          $this->error_msg  = '手机号码已存在';
          return $this->result;
        }
     }

     //判断支付宝是否有重复
     if(!empty($user_info['alipay_account']) && $old_user_info->alipay_account != $user_info['alipay_account'])
     {
        if($redis->sIsMember('sxh_user_info:alipay_account',$user_info['alipay_account']))
        {
          $this->error_code = 10003;
          $this->error_msg  = '支付宝账号已经存在';
          return $this->result;
        }
     }

     //判断微信账号是否有重复
     if(!empty($user_info['weixin_account']) && $old_user_info->weixin_account != $user_info['weixin_account'])
     {
        if($redis->sIsMember('sxh_user_info:weixin_account',$user_info['weixin_account']))
        {
          $this->error_code = 10004;
          $this->error_msg  = '微信已经存在';
          return $this->result;
        }
     }

      //判断银行卡是否有重复
      if(!empty($user_info['bank_account']) && $old_user_info->bank_account != $user_info['bank_account'])
      {
        if($redis->sIsMember('sxh_user_info:bank_account',$user_info['bank_account']))
        {
          $this->error_code = 10005;
          $this->error_msg  = '银行卡号已经存在';
          return $this->result;
        } 
      }

      //判断身份证号码是否有重复
      if(!empty($user_info['card_id']) && $old_user_info->card_id != $user_info['card_id'] && $old_user_info->passport != $user_info['card_id'])
      {
        if($redis->sIsMember('sxh_user_info:card_id',$user_info['card_id']))
        {
          $this->error_code = 10006;
          $this->error_msg  = '身份证号获或者护照号已经存在';
          return $this->result;
        } 
      }

    //开启事务
    \think\Db::startTrans();
      try{
        if(!empty($sys_remark))
        {
          //写入备注信息
          model('SysRemark')->add($sys_remark);
        }
        //更新用户资料
        model('UserInfo')->update_by_uid($params['user_id'],$user_info);

        if($old_user_info->username != $user_info['username'])
        {
          //同步更新用户表的用户名
          model('User')->update_by_id($params['user_id'],array('username'=>$user_info['username']));
          //同步更新用户关系表的用户名
          model('UserRelation')->update_by_uid($params['user_id'],array('username'=>$user_info['username']));
        }

        //提交事务
        \think\Db::commit();

        //用户新的用户名与之前的不同,同步更新用户名
        if($old_user_info->username != $user_info['username'])
        { 
           //更新redis中的用户名
            $redis->set('sxh_user:username:'.$old_user_info->username.':id','');
            $redis->set('sxh_user:id:'.$params['user_id'].':username','');
            $redis->set('sxh_user:username:'.$user_info['username'].':id',$params['user_id']);
            $redis->set('sxh_user:id:'.$params['user_id'].':username',$user_info['username']);
            /*保存集合信息*/
            $redis->sRem('sxh_user:username',$old_user_info->username);
            $redis->sAdd('sxh_user:username',$user_info['username']);
        }
        
        //用户新的手机号与之前的不同,同步更新用户手机号码
        if($old_user_info->phone != $user_info['phone'])
        { 
           //更新redis中的手机号码
           $redis->hset("sxh_userinfo:id:{$params['user_id']}",'phone',$user_info['phone']);
           //从redis中删除以前的手机号
           $redis->sRem('sxh_user_info:phone',$old_user_info->phone);
           //添加新的手机号码
           $redis->sAdd('sxh_user_info:phone',$user_info['phone']);
        }

        //用户新的支付宝账号与之前的不同,同步更新用户支付宝账号
        if($old_user_info->alipay_account != $user_info['alipay_account'])
        {
          //从redis中删除以前的支付宝
           $redis->sRem('sxh_user_info:alipay_account',$old_user_info->alipay_account);
           //添加新的支付宝
           $redis->sAdd('sxh_user_info:alipay_account',$user_info['alipay_account']);  
        }

        //用户新的微信与之前的不同,同步更新用户微信
        if($old_user_info->weixin_account != $user_info['weixin_account'])
        {
          //从redis中删除以前的微信
           $redis->sRem('sxh_user_info:weixin_account',$old_user_info->weixin_account);
           //添加新的微信
           $redis->sAdd('sxh_user_info:weixin_account',$user_info['weixin_account']);  
        }

        //用户新的银行卡与之前的不同,同步更新用户银行卡
        if($old_user_info->bank_account != $user_info['bank_account'])
        {
          //从redis中删除以前的银行卡
           $redis->sRem('sxh_user_info:bank_account',$old_user_info->bank_account);
           //添加新的银行卡
           $redis->sAdd('sxh_user_info:bank_account',$user_info['bank_account']);  
        }

        //用户新的身份证与之前的不同,同步更新用户身份证
        if($old_user_info->card_id != $user_info['card_id'])
        {
          //从redis中删除以前的身份证
           $redis->sRem('sxh_user_info:card_id',$old_user_info->card_id);
           //添加新的身份证
           $redis->sAdd('sxh_user_info:card_id',$user_info['card_id']);
        }

        //记录管理员操作会员的日志
        model('SysOperateUserLog')->add($sys_operate_user_log,$params['user_id']);

      } catch (\Exception $e) {
        // 回滚事务
        \think\Db::rollback();
        $this->error_code  = 81001;
        $this->error_msg   = '编辑会员资料失败,请稍后再试';
      }
     return $this->result;
  }


    /**
    * 获取会员详情
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取会员详情成功
    */
   public function acquire_user_info($params=[])
   {
      //要获取的字段
      $fields = [
        //会员账号
        'username',
        //姓名
        'name',
        //手机号
        'phone',
        //电子邮箱
        'email',
        //支付宝
        'alipay_account',
        //微信
        'weixin_account',
        //开户银行
        'bank_name',
        //银行账户
        'bank_account',
        //身份证号码
        'card_id',
        
        //护照
        'passport',
          
        //身份证正面
        'image_a',
        //身份证反面
        'image_b',
        //身份证全身
        'image_c'
      ];
      $user_info = model('UserInfo')->get_by_uid($params['user_id'],$fields);
      
      //身份证护照判断
      $user_info['card_type'] = 1;
      if(!empty($user_info['card_id']) && $user_info['card_id']!='null' && $user_info['card_id']!='NULL') {
          $user_info['card_type'] = 1;
      } else if(!empty($user_info['passport'])) {
          $user_info['card_id'] = $user_info['passport'];
          $user_info['card_type'] = 2;
      }
      unset($user_info['passport']);
      
      
      $this->body = empty($user_info) ? [] : $user_info;
      return $this->result;
   }  
    
   //转移推荐人
   public function modify_referee($params=[])
   {
      //查询字段
      $fields = [
        //会员账号
        'username',
        //会员真实姓名
        'name'
      ];

      $user_info_model = model('UserInfo');

      //查询推荐人是否存在
      $referee = $user_info_model->get_by_uid($params['referee_id'],$fields);

      if(!$referee)
      {
        $this->error_code = 500010;
        $this->error_msg  = '推荐人不存在';
        return $this->result;
      }

      //查询会员的原始推荐人
      $old_referee = $user_info_model->get_by_uid($params['user_id'],['referee_id']);

      if(!$old_referee)
      {
        $this->error_code = 500011;
        $this->error_msg  = '查询会员信息出错';
        return $this->result; 
      }

      //修改会员信息
      $user_info = [
           //推荐人id
          'referee_id'         => $params['referee_id'],
          //推荐人账号
          'referee'            => $referee->username,
          //推荐人姓名
          'referee_name'       => $referee->name,
          //管理员更新时间
          'admin_update_time'  => time(),
      ]; 

     //有填写备注则插入备注信息
     if(!empty($params['remark']))
     {
        //备注记录
        $sys_remark = [
            //会员id
            'user_id' => $params['user_id'],
            //备注类型 1-封号备注 2-特权备注 3-编辑资料备注 4-转移推荐人备注
            'type_id' => 4,
            //系统管理员id
            'sys_uid' => session('user_auth.id'),
            //备注
            'remark'  => $params['remark']
        ];
     }

    //转移推荐人的日志
    $modify_referee_log = [
          //数据
          'data' => [
            //要转移推荐人的用户id
            'userid' => $params['user_id'],
            //推荐人id
            'n_ref'  => $params['referee_id'],
            //旧的推荐人id
            'o_ref' => $old_referee->referee_id,
            //转移日期
            'update' => date("Y-m-d")
          ],
        //用户类型 0-个人 1-企业
        'user_type' => 0,

    ];

    //加入到redis队列
    add_to_queue('modify_referee',$modify_referee_log);

    //开启事务
     \think\Db::startTrans();
      try{
          if(!empty($sys_remark))
          {
            //写入备注信息
            model('SysRemark')->add($sys_remark);
          }
          $user_info_model->update_by_uid($params['user_id'],$user_info);
          // 提交事务
          \think\Db::commit();
        } catch (\Exception $e) {
          // 回滚事务
          \think\Db::rollback();
          $this->error_code  = 81001;
          $this->error_msg   = '操作失败,请稍后再试';
        }
      return $this->result;
   } 

    /**
    * 获取推荐人和隶属组
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取推荐人和隶属组成功
    */
   public function acquire_group_referee($params=[])
   {
      //要获取的字段
      $fields = [
          //推荐人账号
          'referee',
          //推荐人姓名
          'referee_name',
          //隶属组账号
          'group',
          //隶属组名称
          'group_name'
      ];
      //查询会员资料
      $user_info = model('UserInfo')->get_by_uid($params['user_id'],$fields);
      $this->body = empty($user_info) ? [] : $user_info;
      return $this->result;
   }

   //通过用户账号查询用户真实姓名
   public function acquire_real_name_by_username($params=[])
   {
      //要查询的字段
      $fields = [
          //用户真实姓名
          'name'
      ];
      $username = strtolower($params['username']);
      //查询用户信息
      $user_info  = model('UserInfo')->get_by_username($username,$fields);

      if(empty($user_info))
      {
        $this->error_code = 81002;
        $this->error_msg  = '用户不存在';
        return $this->result;
      }
      $this->body = $user_info;

      return $this->result;
   }
}