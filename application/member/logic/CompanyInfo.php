<?php
/**
 * 会员管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class CompanyInfo extends Base
{


  /**
   * 修改会员资料
   * @param  array  $params 包含更新条件和更新数据的数组
   * @return array          包含响应消息的数组,若数组中的错误码为0,表示修改会员资料成功
   */
  public function modify_user_info($params=[])
  {   

      //要更新的会员信息
      $user_info = [
          //会员姓名
          'company_name'           => !empty($params['company_name']) ? $params['company_name'] : '',
          //营业执照号码
          'business_license'       => !empty($params['business_license']) ? $params['business_license'] : '',
          //法人姓名
          'legal_person'           => !empty($params['legal_person']) ? $params['legal_person'] : '',
          //手机号码
          'mobile'                 => !empty($params['mobile']) ? $params['mobile'] : '',
          //邮箱
          'email'                  => !empty($params['email']) ? $params['email'] : '',
          //法人支付宝
          'legal_alipay_account'   => !empty($params['legal_alipay_account']) ? $params['legal_alipay_account'] : '',
          //企业支付宝
          'company_alipay_account' => !empty($params['company_alipay_account']) ? $params['company_alipay_account'] : '',
          //法人银行账号
          'legal_bank_account'     => !empty($params['legal_bank_account']) ? $params['legal_bank_account'] : '',
          //法人账户开户行
          'legal_bank_name'        => !empty($params['legal_bank_name']) ? $params['legal_bank_name'] : '',
          //公司对公账户
          'public_bank_account'    => !empty($params['public_bank_account']) ? $params['public_bank_account'] : '',
          //公司账户开户行
          'public_bank_name'       => !empty($params['public_bank_name']) ? $params['public_bank_name'] : '',
          //管理员更新时间
          'update_time' => time(),//管理员更新时间,更改为用户资料更新时间
      ];

     //有填写备注则插入备注信息
     if(!empty($params['remark']))
     {
        //备注记录
        $sys_remark = [
            //会员id
            'user_id' => $params['company_id'],
            //备注类型 1-封号备注 2-特权备注 3-编辑资料备注 4-转移推荐人备注
            'type_id' => 3,
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
        //企业不需要保存在redis上面，直接读表
//        $redis = \org\RedisLib::get_instance('sxh_default');
//        $key = "sxh_userinfo:id:".$params['user_id'];
//        $redis->hset($key,'phone',$user_info['phone']);
        
        //修改公司资料
        model('CompanyInfo')->update_by_uid($params['company_id'],$user_info);
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
        //公司名称
        'company_name',
        //营业执照号码
        'business_license',
        //法人姓名
        'legal_person',
        //手机号码
        'mobile',
        //邮箱
        'email',
        //法人支付宝
        'legal_alipay_account',
        //企业支付宝
        'company_alipay_account',
        //法人银行账户
        'legal_bank_account',
         //法人银行开户行
        'legal_bank_name',
        //公司对公账户
        'public_bank_account',
        //对公账户开户行
        'public_bank_name',
        //身份证正面
        'legal_idcard_front',
        //身份证反面
        'legal_idcard_back',
        //手持身份证
        'legal_img',
        //营业执照
        'business_license_img'

      ];
      //获取企业资料
      $user_info = model('CompanyInfo')->get_by_uid($params['company_id'],$fields);
      //设置响应结果
      $this->body = empty($user_info) ? [] : $user_info;
      //返回响应结果
      return $this->result;
   }  
    
   //转移推荐人
   public function modify_referee($params=[])
   {
      //查询字段
      $fields = [
        //会员id
        'company_id',
        //会员账号
        'username',
        //会员类型
        'business_type'
      ];

      $company_info_model = model('CompanyInfo');

      //查询推荐人是否存在
      $referee = $company_info_model->get_by_uid($params['business_center_id'],$fields);
      if(!$referee || !$referee->business_type)
      {
        $this->error_code = 500010;
        $this->error_msg  = '商务中心不存在';
        return $this->result;
      }

      //修改会员信息
      $user_info = [
          //商务中心账号
          'business_center_account'  => $referee->username,
          //商务中心id
          'business_center_id'       => $params['business_center_id'],
          //管理员更新时间
          'admin_update_time'  => time(),
      ]; 

     //有填写备注则插入备注信息
     if(!empty($params['remark']))
     {
        //备注记录
        $sys_remark = [
            //会员id
            'user_id' => $params['company_id'],
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
            'user_id' => $params['company_id'],
            //推荐人id
            'referee_id'  => $params['business_center_id'],
            //转移日期
            'update_time' => time()
          ],
        //用户类型 0-个人 1-企业
        'user_type' => 1,
    ];

    //加入到redis队列
    add_to_queue('modify_referee',$modify_referee_log);

      //开启事务
     \think\Db::startTrans();
      try{
        if(!empty($sys_remark))
        {
          //添加转移商务中心的备注信息
          model('SysRemark')->add($sys_remark);
        }
        //修改企业资料
        $company_info_model->update_by_uid($params['company_id'],$user_info);
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

}