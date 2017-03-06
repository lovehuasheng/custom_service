<?php
/**
 * 公告管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class Deblocking extends Model
{
   
   protected $table = 'sxh_user_deblocking';

    /**
    * 添加数据
    * @param array $data 公告数组
    * @return int        成功返回1,失败返回0
    */
   public function add($data=[])
   {
      return $this->data($data)->allowField(true)->save();
   }

   /**
    * 通过id更新
    * @param int   $id     要更新的公告id
    * @param array $data   包含更新数据的数组
    * @return int          成功返回1,失败返回0
    */
   public function update_by_id($id,$data=[])
   {
      return $this->allowField(true)->isUpdate(true)->save($data,['id'=>$id]);
   }

   /**
    * 通过主键获取一条记录
    * @param int   $id       要查询的公告id
    * @param array $fields   包含要查询字段的数组
    * @return mixed          成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_id($id,$fields=['*'])
   {
     return $this->field($fields)->where('id',$id)->limit(1)->find();
   }


    /**
     * 查询列表
     * @param array $condition 包含查询条件的数组
     * @param array $fields    包含要获取的字段数组
     * @param int   $page      当前页码
     * @param int   $per_page  每页显示的记录数
     * @param array $order     包含排序条件的数组
     * @return mixed           成功返回包含当前模型对象的二维数组,失败返回null
     */
    public function get_list($condition=[],$fields=['*'],$page=1,$per_page= 20,$order=['id'=>'desc']) 
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

}
