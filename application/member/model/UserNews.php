<?php
/**
 * 公告管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class UserNews extends Model
{
   
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;


    /**
    * 添加新公告
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
    * 通过主键获取公告
    * @param int   $id       要查询的公告id
    * @param array $fields   包含要查询字段的数组
    * @return mixed          成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_id($id,$fields=['*'])
   {
     return $this->field($fields)->where('id',$id)->limit(1)->find();
   }

    /**
     * 一次性查询所有的公告列表,不带分页
     * @param  array  $condition 条件数组
     * @param  array  $fields    要查询的字段列表
     * @param  array  $order     排序数组
     * @return array             返回满足条件的记录数组
     */
    public function get_all($condition=[],$fields=['*'],$order=['id'=>'desc'])
    {
      return $this->field($fields)->where($condition)->order($order)->select();
    }

    /**
     * 查询公告列表
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
     * 统计满足条件的记录
     * @param array $condition 包含查询条件的数组
     * @return int             返回满足查询条件的记录数
     */
    public function get_count($condition=[])
    {
       return $this->where($condition)->count();
    }

    /**
     * 设置消息模板状态
     * @param array $condition 包含更新条件的数组
     * @param int $status      要设置的状态
     * @return int             成功返回影响数据的条数,没修改任何数据字段返回 0
     */
    public function update_status($condition=[],$status=0)
    {
       return $this->where($condition)->setField('status',$status);
    }

    //根据id删除数据
    public function del_by_id($id)
    {
       return $this->destroy($id);
    }
}
