<?php
/**
 * 会员账户管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class UserAccount extends Model
{
   
  //分表规则
  protected $rule = [
    'type' => 'id',   // 分表方式,按user_id范围分表
    'expr'  => 1000000    // 每张表的记录数
  ];

  /**
    * 通过用户id查询用户账户列表
    * @param  int    $uid       用户id
    * @param  array  $fields   要查询的字段列表
    * @return mixed            成功返回当前模型的对象实例,失败返回null
  */
  public function get_by_uid($uid,$fields=['*'])
  {
    return $this->partition(['user_id'=>$uid],'user_id',$this->rule)->field($fields)->where('user_id',$uid)->limit(1)->find();
  }

  /**
    * 通过会员id更新会员账户
    * @param  int    $uid     会员id
    * @param  array  $data    要更新的数据
    * @return int             成功返回1,失败返回0
  */
  public function update_by_uid($uid,$data=[])
  {
    return $this->partition(['user_id' => $uid],'user_id',$this->rule)->where('user_id',$uid)->update($data);
  }
  
  /**
   * 修改善金币（jwf）
   * @param int $currency 加减的值
   * @param string|array $where 更新条件
   * @param int $type 0减  1加
   */
  public function updateInventedCurrency($user_id , $currency,$where,$type=0){
  	if($type==0){
  		return $this->partition(['user_id'=>$user_id] , 'user_id' , $this->rule)
  		->where($where)->setDec("invented_currency",$currency);
  	}else{
  		return $this->partition(['user_id'=>$user_id] , 'user_id' , $this->rule)
  		->where($where)->setInc("invented_currency",$currency);
  	}
  }
  
  /**
   * 修改个人用户的管理钱包(jwf)
   * @param int $money
   * @param array|string $where
   * @param number $type 0减  1加
   */
  public function updateManageWallet($user_id , $money,$where,$type=0){
  	if($type == 0){
  		return $this->partition(['user_id'=>$user_id] , 'user_id' , $this->rule)
  		->where($where)->setDec("manage_wallet",$money);
  	}else{
  		return $this->partition(['user_id'=>$user_id] , 'user_id' , $this->rule)
  		->where($where)->setInc("manage_wallet",$money);
  	}
  }
  
  /** 根据用户id 增加币
   * @param   $user_id        用户id
   * @param   $currency_type  币种
   * @param   $money          数量
   * @return  bool
   * @author  江雄杰
   * @time    2016-11-02
   */
  public function updateInc($user_id , $currency_type , $money) {
  	return $this->partition(['user_id'=>$user_id] , 'user_id' , $this->rule)
  	->where(['user_id'=>$user_id])->setInc($currency_type , $money);
  }
  
  /**
   * 库存钱包（jwf）
   * @param int $currency 加减的值
   * @param string|array $where 更新条件
   * @param int $type 0减  1加
   */
  public function updateCompanyInventedCurrency($user_id , $currency,$where,$type=0){
  	if($type==0){
  		return $this->partition(['id'=>$user_id] , 'id' , $this->rule)
  		->where($where)->setDec("company_invented_currency",$currency);
  	}else{
  		return $this->partition(['id'=>$user_id] , 'id' , $this->rule)
  		->where($where)->setInc("company_invented_currency",$currency);
  	}
  }
  
  public function updateCompanyWallet($user_id,$currency,$where,$type=0){
  	if($type==0){
  		return $this->partition(['id'=>$user_id] , 'id' , $this->rule)
  		->where($where)->setDec("company_wallet",$currency);
  	}else{
  		return $this->partition(['id'=>$user_id] , 'id' , $this->rule)
  		->where($where)->setInc("company_wallet",$currency);
  	}
  }

}
