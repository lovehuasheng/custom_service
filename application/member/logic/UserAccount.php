<?php
/**
 * 会员账户管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class UserAccount extends Base
{


    /**
     * 获取会员账户列表
     * @param  array  $params 包含查询条件的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取会员账户列表成功
     */
    public function get_accounts($params=[])
    {   

      //要获取的字段
      $fields = [
        //善种子
        'activate_currency',
        //善心币
        'guadan_currency',
        //善金币
        'invented_currency',
        //出局钱包
        'wallet_currency',
        //管理钱包
        'manage_wallet',
        //接单钱包
        'order_taking',
        //特困钱包
        'poor_wallet',
        //贫穷钱包
        'needy_wallet',
        //小康钱包
        'comfortably_wallet',
        //德善钱包
        'kind_wallet',
        //富人钱包
        'wealth_wallet'
      ];

      //账户列表
      $account_list = model('UserAccount')->get_by_uid($params['user_id'],$fields);
      //设置响应数据
      $this->body = empty($account_list) ? [] : $account_list;
      return $this->result;
    } 


    /**
     * 修改会员账户
     * @param  array  $params 包含更新条件和更新数据的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示修改会员账户成功
     */
    public function modify_account($params=[])
    {

      //判断账户类型
      switch ($params['account_type']) {
        case 1:
          //善种子
          $field = 'activate_currency';
          break;
        case 2:
          //善心币
          $field = 'guadan_currency';
          break;
        case 3:
          //善金币
          $field = 'invented_currency';
          break;
        case 4:
          //出局钱包
          $field = 'wallet_currency';
          break;
        case 5:
          //管理钱包
          $field = 'manage_wallet';
          break;
        case 6:
          //接单钱包
          $field = 'order_taking';
          break;
        case 7:
          //特困钱包
          $field = 'poor_wallet';
          break;
        case 8:
          //贫穷钱包
          $field = 'needy_wallet';
          break;
        case 9:
          //小康钱包
          $field = 'comfortably_wallet';
          break;
        case 10:
          //德善钱包
          $field = 'kind_wallet';
          break;
        case 11:
          //富人钱包
          $field = 'wealth_wallet';
          break;
        default:
          $field = '';
          break;
      }
      
      //判断操作类型
      switch ($params['operation_type']) {
        case 1:
          //增加账户金额
          $exp = "{$field}+{$params['sum']}";
          break;
        case 2:
          //减少账户金额
          $exp = "{$field}-{$params['sum']}";
        default:
          $exp = '';
          break;
      }

      //检查账户类型和操作类型是否合法
      if(!$field || !$exp)
      {
        $this->error_code = 70002;
        $this->error_msg  = '参数错误,请检查';
        return $this->result;
      }

      //要更新的数据
      $user_account[$field] = ['exp',$exp];

      if(!model('UserAccount')->update_by_uid($params['user_id'],$user_account))
      {
        $this->error_code = 70003;
        $this->error_msg  = '更新会员账户失败';
      }
      return $this->result;
    }


    //转币
    public function transfer_coin($params=[])
    { 

      //允许转币的类型
      $allow_coin_type = [
          //善种子
          1 => '善种子',
          //善心币
          2 => '善心币'
      ];

      //允许的操作类型
      $allow_operation_type = [
        //增加
        1,
        //减少
        2
      ];

      //币种
      $coin_type          = empty($params['coin_type']) ? 0 : intval($params['coin_type']);

      //操作类型
      $operation_type     = empty($params['operation_type']) ? 0 : intval($params['operation_type']);

      //接受人账户
      $username           = empty($params['username']) ? '' : trim($params['username']);

      //数量
      $num                = empty($params['num']) ? 0 : intval($params['num']);

      //二级密码
      $secondary_password = empty($params['secondary_password']) ? '' : trim($params['secondary_password']);

      //备注
      $remark             = empty($params['remark']) ? '' : trim($params['remark']); 

      //检查币种是否正确
      if($coin_type <=0 || !in_array($coin_type,array_keys($allow_coin_type)))
      {
          $this->error_code = 70004;
          $this->error_msg  = '请选选择正确的的币种';
          return $this->result;
      }

      //检测操作类型是否正确
      if($operation_type <=0 || !in_array($operation_type,$allow_operation_type))
      {
          $this->error_code = 70005;
          $this->error_msg  = '请选选择正确的操作类型';
          return $this->result;
      }

      //检查接受人账户是否为空
      if(empty($username))
      {
        $this->error_code = 70006;
        $this->error_msg  = '请填写接受账号';
        return $this->result;
      } 

      //最大数量
      $max_num = $coin_type == 1 ? config('max_seed') : config('max_coin');

      //检查转币数量是否在允许范围内
      if($num <=0 || $num > $max_num)
      {
        $this->error_code = 70007;
        $this->error_msg  = "数量不能小于等于0或者大于{$max_num}";
        return $this->result;
      }

      //检测二级密码
      if(empty($secondary_password))
      {
        $this->error_code = 70008;
        $this->error_msg  = '请填写二级密码';
        return $this->result;
      }

      $user_model = model('User');

      //检测接受人账号是否存在
      $user_id = $user_model->get_id_by_username($username);
  
      if(!$user_id)
      {
        $this->error_code = 70009;
        $this->error_msg  = '接收人账号不存在';
        return $this->result;
      }

      $map['id'] = session('user_auth.id');
      $user = model('user/SysUser')->get_user_info($map, 'secondary_password');
      //检测二级密码是否正确
      if($user['secondary_password'] != set_password(md5($secondary_password)))
      {
          $this->error_code = 70010;
          $this->error_msg = '二级密码错误!';
          return $this->result;
      }

      //善种子
      if($coin_type == 1)
      {
        $field = 'activate_currency';
      }
      else
      {
        //善心币
        $field = 'guadan_currency';
      }

      //超级管理员绑定的前端用户id
      $bind_uid = session('user_auth.bind_uid');

      $user_account_model = model('UserAccount');

      //获取超级管理员账户
      $super_account = $user_account_model->get_by_uid($bind_uid,[$field]);

      if(empty($super_account))
      {
          $this->error_code = 70013;
          $this->error_msg  = '获取超级管理员账户失败';
          return $this->result;
      }

      //获取接受转币人的账户
      $user_account = $user_account_model->get_by_uid($user_id,[$field]);

      if(empty($user_account))
      {
          $this->error_code = 70014;
          $this->error_msg  = '获取接受转币人账户失败';
          return $this->result;
      }

      //查询用户的手机号码
      $phone = model('UserInfo')->get_by_uid($user_id,['phone']);
      if(empty($phone))
      {
          $this->error_code = 70015;
          $this->error_msg  = '获取接受转币人资料失败';
          return $this->result;
      }

      $redis = \org\RedisLib::get_instance('sxh_default');

      //获取超级管理绑定的前端账号
      $super_username = $redis->get("sxh_user:id:{$bind_uid}:username");

      //超级管理员向接收人转币
      if($operation_type == 1)
      { 
          //如果超级管理员的账户的币种小于要转出的币种,则提示
          if($super_account->$field < $num)
          {
            $this->error_code = 70016;
            $this->error_msg  = $allow_coin_type[$coin_type] . '不足';
            return $this->result;
          }

        //增加接收人的币的数量
        $user_exp = "{$field}+{$num}";
        $user_data[$field] = ['exp',$user_exp];

        //减少超级管理员币的数量
        $super_exp = "{$field}-{$num}";
        $super_data[$field] = ['exp',$super_exp];

        //提示信息
        $tip = "成功为{$username}充值{$allow_coin_type[$coin_type]}{$num}个";
        
        //收入记录
        $income_log = [
          //数据
          'data' => [
              //类型
              'type'            => $coin_type,
              //社区id
              'cid'             => 0,
              //收益人id
              'user_id'         => $user_id,
              //收益人账号
              'username'        => $username,
              //收益数量
              'income'          => $num,
              //提成
              'earnings'        => 0,
              //来源id
              'pid'             => $bind_uid,
              //匹配id
              'cat_id'          => 0,
              //备注
              'info'            => $remark,
              //创建时间
              'create_time'     => time(),
              //状态
              'status'          => 0,
              //转出帐号
              'other_username'  => $super_username,
              //转出账号类型
              'rollout_user_type' => 1
          ],  
          //模型名称
          'model_name' => 'user_income',
        ];
        //支持记录
        $outgo_log = [
          //数据
          'data' => [
              //类型
              'type'          => $coin_type,
              //支出人id
              'user_id'       => $bind_uid,
              //支出人账号
              'username'      => $super_username,
              //支出数量
              'outgo'         => $num,
              //收益人id
              'pid'           => $user_id,
              //备注
              'info'          => $remark,
              //创建时间
              'create_time'   => time(),
              //状态
              'status'        => 0,
              //转入人账号
              'other_username'  => $username
          ],  
          //模型名称
          'model_name' => 'user_outgo',
        ];

        //操作日志
        $operation_msg =  "从{$super_username}向会员{$username}转入{$allow_coin_type[$coin_type]}{$num}个";
        $operation_log['data']['uid']             = session('user_auth.id');
        $operation_log['data']['username']        = session('user_auth.username');
        $operation_log['data']['realname']        = session('user_auth.realname');
        $operation_log['data']['type']            = 4;
        $operation_log['data']['remark']          = get_log_type_text(4,$operation_msg,'member/user_account/transfer_coin');
        $operation_log['data']['create_time']     = time();
        $operation_log['model_name']              = 'SysUserLog';

        /**发送给管理员的短信**/
        //管理员手机号码
        $sms[1]['phone']     = config('notify_phone');
        //短信内容
        $sms[1]['content']   = date("Y-m-d H:i:s") . "成功从您的账户扣除{$allow_coin_type[$coin_type]}{$num}个";
        //附加数据
        $sms[1]['extra_data']['user_id'] = $bind_uid;
        //短信标题
        $sms[1]['extra_data']['title'] = '转币通知';
        //ip地址
        $sms[1]['extra_data']['ip_address'] = ip2long(request()->ip());

        /**发送给会员的短信**/
        //会员手机号码
        $sms[2]['phone']     = $phone->phone;
        //短信内容
        $sms[2]['content']   = date("Y-m-d H:i:s") . "您的账户成功充值{$allow_coin_type[$coin_type]}{$num}个";
        //附加数据
        $sms[2]['extra_data']['user_id'] = $user_id;
        //短信标题
        $sms[2]['extra_data']['title'] = '转币通知';
        //ip地址
        $sms[2]['extra_data']['ip_address'] = ip2long(request()->ip());

      }
      else
      {
        //接受人的善种子/善心币数量小于0
        if($user_account->$field <= 0 )
        {
           $this->error_code = 700017;
           $this->error_msg  = "会员的{$allow_coin_type[$coin_type]}数量为0";
           return $this->result;
        }
        //扣除接收人的币
        if($num > $user_account->$field)
        {
          $num = $user_account->$field;
        }
        //减少接收人对应币的数量
        $user_exp = "{$field}-{$num}";
        $user_data[$field] = ['exp',$user_exp];

        //增加超级管理员对应币的数量
        $super_exp = "{$field}+{$num}";
        $super_data[$field] = ['exp',$super_exp];

        //提示
        $tip = "成功扣除{$username}{$allow_coin_type[$coin_type]}{$num}个";

        //收入记录
        $income_log = [
          //数据
          'data' => [
              //类型
              'type'          => $coin_type,
              //社区id
              'cid'           => 0,
              //收益人id
              'user_id'       => $bind_uid,
              //收益人账号
              'username'      => $super_username,
              //收益数量
              'income'        => $num,
              //提成
              'earnings'      => 0,
              //来源id
              'pid'           => $user_id,
              //匹配id
              'cat_id'        => 0,
              //备注
              'info'          => $remark,
              //转出人账号
              'other_username'  => $username,
              //创建时间
              'create_time'   => time(),
              //状态
              'status'        => 0
          ],  
          //模型名称
          'model_name' => 'user_income',
        ];

        //支持记录
        $outgo_log = [
          //数据
          'data' => [
              //类型
              'type'          => $coin_type,
              //支出人id
              'user_id'       => $user_id,
              //支出人账号
              'username'      => $username,
              //支出数量
              'outgo'         => $num,
              //收益人id
              'pid'           => $bind_uid,
              //收益账号
              'other_username' => $super_username,
              //备注
              'info'          => $remark,
              //创建时间
              'create_time'   => time(),
              //状态
              'status'        => 0,
              //转入账号类型
              'rollin_user_type'  => 1
          ],  
          //模型名称
          'model_name' => 'user_outgo',
        ];

        //操作日志
        $operation_msg =  "扣除会员{$username}{$allow_coin_type[$coin_type]}{$num}个";
        $operation_log['data']['uid']            = session('user_auth.id');
        $operation_log['data']['username']       = session('user_auth.username');
        $operation_log['data']['realname']       = session('user_auth.realname');
        $operation_log['data']['type']           = 4;
        $operation_log['data']['remark']         = get_log_type_text(4,$operation_msg,'member/user_account/transfer_coin');
        $operation_log['data']['create_time']    = time();
        $operation_log['model_name']             = 'SysUserLog';


        /**发送给管理员的短信**/
        //管理员手机号码
        $sms[1]['phone']     = config('notify_phone');
        //短信内容
        $sms[1]['content']   = date("Y-m-d H:i:s") . "成功从会员{$username}的账户扣除{$allow_coin_type[$coin_type]}{$num}个";
        //附加数据
        $sms[1]['extra_data']['user_id'] = $bind_uid;
        //短信标题
        $sms[1]['extra_data']['title'] = '转币通知';
        //ip地址
        $sms[1]['extra_data']['ip_address'] = ip2long(request()->ip());

        /**发送给会员的短信**/
        //会员手机号码
        $sms[2]['phone']     = $phone->phone;
        //短信内容
        $sms[2]['content']   = date("Y-m-d H:i:s") . "您的账户被扣除{$allow_coin_type[$coin_type]}{$num}个";
        //附加数据
        $sms[2]['extra_data']['user_id'] = $user_id;
        //短信标题
        $sms[2]['extra_data']['title'] = '转币通知';
        //ip地址
        $sms[2]['extra_data']['ip_address'] = ip2long(request()->ip());

      }

      //转账记录 
      $transfer_log = [
          //币种类型    1-善种子 2-善心币
          'coin_type'      => $coin_type,
          //数量
          'num'            => $num,
          //用户id
          'user_id'        => $user_id,
          //用户账号
          'username'       => $username,
          //操作类型 1-转入 2-转出
          'operation_type' => $operation_type,
           //操作人
          'operator_id'    => session('user_auth.id'),
          //操作人账号
          'operator_name'  => session('user_auth.username'),
          //备注
          'remark'         => $remark,
      ];

      //转账日志记录表
      $transfer_log_model = model('TransferLog');
      //启动事务
      \think\Db::startTrans();
      try{
          //更新接收人账户
          $user_account_model->update_by_uid($user_id,$user_data);
          //更新超级管理员账户
          $user_account_model->update_by_uid($bind_uid,$super_data);
          //写入转账日志
          $transfer_log_model->add($transfer_log);
         // 提交事务
         \think\Db::commit();

         //写入操作日志到队列中
         add_to_queue(config('log_queue'),$operation_log);
         //写入支出流水队列
         add_to_queue('sxh_user_running_water',$outgo_log);
         //写入收入流水队列
         add_to_queue('sxh_user_running_water',$income_log);
         //发送短信给管理员
         add_to_queue('sxh_user_sms',$sms[1]);
         //发送短信给会员
         add_to_queue('sxh_user_sms',$sms[2]);

         $this->error_code = 0;
         $this->error_msg  = $tip;
         return $this->result;

      } catch (\Exception $e) {
        // 回滚事务
        \think\Db::rollback();
        $this->error_code = 70016;
        $this->error_msg  = '操作失败,请稍后再试';
      }

  }
}