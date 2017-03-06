<?php
/**
 * 文化衫模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class UserClothes extends Model
{
   
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;


    /**
    * 添加数据
    * @param array $data 
    * @return int        成功返回1,失败返回0
    */
   public function add($data=[])
   {
      return $this->data($data)->allowField(true)->save();
   }

   /**
    * 通过id更新
    * @param int   $id     id
    * @param array $data   包含更新数据的数组
    * @return int          成功返回1,失败返回0
    */
   public function update_by_id($id,$data=[])
   {
      return $this->allowField(true)->isUpdate(true)->save($data,['id'=>$id]);
   }

   /**
    * 通过主键获一条数据
    * @param int   $id       要查询的id
    * @param array $fields   包含要查询字段的数组
    * @return mixed          成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_id($id,$fields=['*'])
   {
     return $this->field($fields)->where('id',$id)->limit(1)->find();
   }

    /**
     * 一次性查询所有的列表,不带分页
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

    //根据id删除数据
    public function del_by_id($id)
    {
       return $this->destroy($id);
    }

    //获取尺寸的文本表示
    public function get_size($size_id)
    {
        switch ($size_id) {
          case 1:
            $size = 'S';
            break;
          case 2:
            $size = 'M';
            break;
          case 3:
            $size = 'L';
            break;
          case 4:
            $size = 'XL';
            break;
          case 5:
            $size = 'XXL';
            break;
          case 6:
            $size = 'XXXL';
            break;
          default:
            $size= '未知';
        }
      return $size;
    }

    //获取尺寸的id表示
    public function get_size_id($size)
    {
        $size = strtoupper($size);

        switch ($size) {
          case 'S':
            $size_id = 1;
            break;
          case 'M':
            $size_id = 2;
            break;
          case 'L':
            $size_id = 3;
            break;
          case 'XL':
            $size_id = 4;
            break;
          case 'XXL':
            $size_id = 5;
            break;
          case 'XXXL':
            $size_id = 6;
            break;
          default:
            $size_id= 0;
        }
      return $size_id;
    }

    //获取是否申领过
    public function get_is_apply($apply)
    {
        
        $apply = trim($apply);

        switch ($apply)
        {
          case '否':
            $is_apply = 0;    
            break;
          case '是':
            $is_apply = 1;
            break;
          default:
            $is_apply = -1;
        }
        return $is_apply;
    }

    //获取是否已经领取过
    public function get_is_receive($receive)
    { 
        $receive = trim($receive);
        switch ($receive) {
          case '否':
            $is_receive = 0;
            break;
          case '是':
            $is_receive = 1;
            break;
          default:
            $is_receive = -1;
        }
        return $is_receive;
    }
}
