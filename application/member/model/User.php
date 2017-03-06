<?php
/**
 * 会员管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class User extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   //分表规则
   protected $rule = [
    'type' => 'id',     // 分表方式,按id范围分表
    'expr'  => 1000000  // 每张表的记录数
  ];


    //获取当前最大的用户id,成功返回最大用户id,失败返回0
    public function get_max_id()
    {
        //引入redis库
       $redis = \org\RedisLib::get_instance('sxh_default');
       //return (int)$redis->get($this->table . ':id'); 
       return (int)$redis->get('sxh_user:id');
    }

    //获取当前会员的自增id
    public function get_id()
    {
      $redis = \org\RedisLib::get_instance('sxh_default');
      //return (int) $redis->incr($this->table . ':id');
      return (int) $redis->incr('sxh_user:id');
    }

   /**
    * 通过id更新会员信息
    * @param int   $id     要更新的会员id
    * @param array $data  包含更新数据的数组
    * @return int         成功返回1,失败返回0
    */
   public function update_by_id($id,$data=[])
   {
      return $this->partition(['id' => $id],'id',$this->rule)->where('id',$id)->update($data);
   }

   /**
    * 通过主键获取会员信息
    * @param int   $id        要查询的会员id
    * @param array $fields   包含要查询字段的数组
    * @return mixed          成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_id($id,$fields=['*'])
   {
      return $this->partition(['id'=>$id],'id',$this->rule)->field($fields)->where('id',$id)->limit(1)->find();
   }


   /**
    * 通过账号查找会员信息
    * @param  string $name   会员账号
    * @param  array  $fields 要查询的字段数组
    * @return mixed           成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_name($name,$fields=['*'])
   {
      $redis = \org\RedisLib::get_instance('sxh_default');
      $key   = $this->getTable() . ":username:{$name}:id";
      //获取会员id
      $id    = $redis->get($key);
      if(!$id)
      {
        return null;
      }
      //通过id查询会员信息
      return $this->get_by_id($id,$fields);
   }

    /**
     * 查询会员列表
     * @param array $condition 包含查询条件的数组
     * @param array $fields    包含要获取的字段数组
     * @param int   $page      当前页码
     * @param int   $per_page  每页显示的记录数
     * @param array $order     包含排序条件的数组
     * @return mixed           成功返回包含当前模型对象的二维数组,失败返回null
     */
    public function get_list($condition=[],$fields='[*]',$page=1,$per_page= 20,$order=['id'=>'desc'])
    {
        //获取分表数量
        $table_num = $this->get_table_num();
        if(!$table_num)
        {
          return null;
        }

        //基础表名
        $base_table_name = $this->getTable();

        //只有一张表
        if($table_num == 1)
        {
          return $this->field($fields)->table("{$base_table_name}_1")->where($condition)->order($order)->page($page,$per_page)->select(); 
        }
        else
        {
          //有多张表
          for($i=2;$i<=$table_num;$i++)
          {
            //sql数组
            $sql_arr = [];
            //获取sql语句
            $sql = $this->field($fields)->table("{$base_table_name}_$i")->where($condition)->fetchSql(true)->select();
            //将sql语句放到sql数组中
            array_push($sql_arr,$sql);
          }

          $union_table = $this->field($fields)->table("{$base_table_name}_1")->union($sql_arr,true)->fetchSql(true)->select();

          $union_table = "($union_table) AS {$base_table_name}";

          $sql = $this->field($fields)->where($condition)->order($order)->page($page,$per_page)->fetchSql(true)->select(); 

          $sql = str_replace("`{$base_table_name}`", $union_table, $sql);

          return $this->query($sql);
        }

    }

    /**
     * 统计满足条件的记录
     * @param array $condition 包含查询条件的数组
     * @return int             返回满足查询条件的记录数
     */
    public function get_count($condition=[])
    {
       //获取分表数量
      $table_num = $this->get_table_num();

      if(!$table_num)
      {
        return 0;
      }
        //基础表名
        $base_table_name = $this->getTable();

        //只有一张表
        if($table_num == 1)
        {
          return $this->field('id')->table("{$base_table_name}_1")->where($condition)->count();
        }
        else
        {
          //有多张表
          for($i=2;$i<=$table_num;$i++)
          {
            //sql数组
            $sql_arr = [];
            //获取sql语句
            $sql = $this->field('id')->table("{$base_table_name}_$i")->where($condition)->fetchSql(true)->select();
            //将sql语句放到sql数组中
            array_push($sql_arr,$sql);
          }

          $union_table = $this->field('id')->table("{$base_table_name}_1")->union($sql_arr,true)->fetchSql(true)->select();

          $union_table = "($union_table) AS {$base_table_name}";

          $sql = $this->field('id')->where($condition)->fetchSql(true)->count();

          $sql = str_replace("`{$base_table_name}`", $union_table, $sql);

          $result = $this->query($sql);

          return isset($result[0]['tp_count']) ? $result[0]['tp_count'] : 0;
        }
    }

    /**
     * 获取会员表当前的分表数量
     */
    public function get_table_num()
    {
      //获取最大会员id
      $max_id = $this->get_max_id(); 

      if(!$max_id)
      {
        return 0;
      } 
      //根据分表规则计算当前最大的表后缀
      $max_table_id = floor($max_id / $this->rule['expr']) + 1;
      return $max_table_id;
    }
    
    /**
     * 批量禁用用户
     * @param type $ids
     */
    public function update_by_ids($ids = [],$data) {
        if(empty($ids)) {
            return false;
        }
        $arr = [];
        //拼接 组装表
        for($i=0;$i<count($ids);$i++) {
            $seq = floor($ids[$i] / $this->rule['expr']) + 1;
            $arr[$seq]['table'] = $this->getTable().'_'.$seq;
        }
        unset($i);
        unset($seq);
        sort($arr);
        if(!empty($arr)) {
            
            //批量更新
            $this->startTrans();
            try {
                $map['id'] = ['in',  array_unique($ids)];
                for($i=0;$i<count($arr);$i++) {
                    $b = \think\DB::table($arr[$i]['table'])->where($map)->update($data);
                }
                
                $this->commit();
                return true;
            } catch (Exception $ex) {
                $this->rollback();
                return false;
            }
        }
        
        return true;
    
    }

    //通过用户名查询用户id
    public function get_id_by_username($username)
    {
      $username = strtolower($username);
      $redis = \org\RedisLib::get_instance();
      $key   = "sxh_user:username:{$username}:id";
      $id    = $redis->get($key);
      if($id)
      {
        return $id;
      } 

      return 0;
    }
}
