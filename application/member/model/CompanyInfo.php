<?php
/**
 * 会员信息管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class CompanyInfo extends Model
{
   //开启自动写入时间戳
   //protected $autoWriteTimestamp = true;



    public function getLegalIdcardFrontAttr($value)
    {
      return empty($value) ? '' : getQiNiuPic($value);
    }

    public function getLegalIdcardBackAttr($value)
    {
      return empty($value) ? '' : getQiNiuPic($value);
    }

    public function getLegalImgAttr($value)
    {
      return empty($value) ? '' : getQiNiuPic($value);
    }

    public function getBusinessLicenseImgAttr($value)
    {
      return empty($value) ? '' : getQiNiuPic($value);
    }

   /**
    * 通过会员id更新会员信息
    * @param int $uid    会员id
    * @param array $data 包含更新数据的数组
    * @return int        成功返回1,失败返回0
    */
   public function update_by_uid($uid,$data=[])
   {
     return $this->allowField(true)->isUpdate(true)->save($data,['company_id'=>$uid]);
   }

   /**
    * 通过会员id获取会员信息
    * @param int $uid       会员id
    * @param array $fields 包含要查询字段的数组
    * @return mixed        成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_uid($uid,$fields=['*'])
   {
      return $this->field($fields)->where('company_id',$uid)->limit(1)->find();
   }


  /**
    * 通过账号查找会员信息
    * @param  string $name   会员账号
    * @param  array  $fields 要查询的字段数组
    * @return mixed          成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_username($username,$fields=['*'])
   {
      $redis = \org\RedisLib::get_instance('sxh_default');
      //通过会员账号获取会员对应的id
      $key   ="sxh_user:username:{$username}:id";
      //获取会员id
      $user_id    = $redis->get($key);
      if(!$user_id)
      {
        return null;
      }
      //通过id查询会员信息
      return $this->get_by_uid($user_id,$fields);
   }

    /**
     * 查询会员信息列表
     * @param array $condition 包含查询条件的数组
     * @param array $fields    包含要获取的字段数组
     * @param int   $page      当前页码
     * @param int   $per_page  每页显示的记录数
     * @param array $order     包含排序条件的数组
     * @return mixed           成功返回包含当前模型对象的二维数组,失败返回null
     */
    public function get_list($condition=[],$fields=['*'],$page=1,$per_page= 20,$order=['company_id'=>'desc']) 
    {
        return $this->field($fields)->where($condition)->order($order)->page($page,$per_page)->select();
    }



    /**
     * 统计满足条件的记录
     * @param array $condition 包含查询条件的数组
     * @return int             返回满足查询条件的记录数
     */
    public function get_count($condition=[])
    {
        return $this->where($condition)->count();
    }

    //根据属性查找数据
    public function get_by_attr($condition=[],$fields=['*'],$order=[],$limit=1)
    {
      return $this->field($fields)->where($condition)->order($order)->limit($limit)->select();
    }

    //根据条件更新数据
    public function update_by_attr($condition=[],$data=[])
    {
      return $this->where($condition)->update($data);
    }

}
