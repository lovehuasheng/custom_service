<?php
/**
 * 会员账户管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class UserRelation extends Model
{
   
  //分表规则
//  protected $rule = [
//    'type' => 'id',   // 分表方式,按user_id范围分表
//    'expr'  => 1000000    // 每张表的记录数
//  ];

  /**
    * 通过用户id查询用户账户列表
    * @param  int    $uid       用户id
    * @param  array  $fields   要查询的字段列表
    * @return mixed            成功返回当前模型的对象实例,失败返回null
  */
  public function get_by_uid($uid,$fields=['*'])
  {
    return $this->field($fields)->where('user_id',$uid)->find();
  }

  /**
    * 通过会员id更新会员账户
    * @param  int    $uid     会员id
    * @param  array  $data    要更新的数据
    * @return int             成功返回1,失败返回0
  */
  public function update_by_uid($uid,$data=[])
  {
    return $this->where('user_id',$uid)->update($data);
  }
  
  /** 根据条件获取一条relation信息
   * @param
   */
  public function getRelationOne($where , $field , $edi=0) {
  	$result = $this
  	//->partition(["edi"=>$edi],$this->field,$this->rule)
  	->where($where)->field($field)->find();
  	if($result != false) {
  		return $result;
  	}
  	return false;
  }
  
  
}
