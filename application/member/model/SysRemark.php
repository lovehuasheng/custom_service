<?php
/**
 * 备注管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class SysRemark extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;


    public function getCreateTimeAttr($value)
    {
       return date('Y-m-d H:i:s',$value);
    }


    public function getCreateTimeTextAttr($value,$data)
    {
       return date('Y-m-d H:i:s',$data['create_time']);
    }

    /**
    * 添加备注
    * @param array $data 备注信息
    * @return int       成功返回1,失败返回0
    */
   public function add($data=[])
   {
      return $this->data($data)->allowField(true)->save();
   }

    /**
     * 查询备注列表,分页查询
     * @param array $condition 包含查询条件的数组
     * @param array $fields    包含要获取的字段数组
     * @param int   $page      当前页码
     * @param int   $per_page  每页显示的记录数
     * @param array $order     包含排序条件的数组
     * @return mixed           成功返回包含当前模型对象的二维数组,失败返回null
     */
    public function get_list($condition=[],$fields='[*]',$page=1,$per_page= 20,$order=['id'=>'desc']) 
    {
        return $this->field($fields)->where($condition)->order($order)->page($page,$per_page)->select();
    }


    /**
     * 一次性查询所有的备注列表,不带分页
     * @param  array  $condition 条件数组
     * @param  array  $fields   要查询的字段列表
     * @param  array  $order    排序数组
     * @return array            返回满足条件的记录数组
     */
    public function get_all($condition=[],$fields=['*'],$order=['id'=>'desc'])
    {
      return $this->field($fields)->where($condition)->order($order)->select();
    }


    //根据条件获取备注列表
    public function get_by_attr($condition=[],$fields=['*'],$limit=1,$order=['id'=>'desc'])
    {
      //不限制取出的记录条数
      if(empty($limit)){
        return $this->field($fields)->where($condition)->order($order)->select();
      }
      
      return $this->field($fields)->where($condition)->order($order)->limit($limit)->select();
    }
}
