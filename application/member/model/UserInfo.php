<?php
/**
 * 会员信息管理模型层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\model;
use think\Model;

class UserInfo extends Model
{
   //开启自动写入时间戳
   protected $autoWriteTimestamp = true;
   //分表规则
   protected $rule = [
    'type' => 'id',       // 分表方式,按user_id范围分表
    'expr'  => 1000000    // 每张表的记录数
  ];


    public function getClassificationAttr($value)
    {
      $classification = [0=>'普通用户',1=>'功德主',2=>'服务中心'];
      return isset($classification[$value]) ? $classification[$value] : '';
    }

    public function getImageAAttr($value)
    {
      return empty($value) ? '' : getQiNiuPic($value);
    }

    public function getImageBAttr($value)
    {
      return empty($value) ? '' : getQiNiuPic($value);
    }

    public function getImageCAttr($value)
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
      return $this->partition(['user_id' => $uid],'user_id',$this->rule)->where('user_id',$uid)->update($data);
   }

   /**
    * 通过会员id获取会员信息
    * @param int $uid       会员id
    * @param array $fields 包含要查询字段的数组
    * @return mixed        成功返回当前模型的对象实例,失败返回null
    */
   public function get_by_uid($uid,$fields=['*'])
   {
      return $this->partition(['user_id'=>$uid],'user_id',$this->rule)->field($fields)->where('user_id',$uid)->limit(1)->find();
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
        $key   = model('User')->getTable() . ":username:{$username}:id";
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
    public function get_list($condition=[],$fields=['*'],$page=1,$per_page= 20,$order=['user_id'=>'desc']) 
    { 
        //获取分表数量
        $table_num = model('User')->get_table_num();

        if(!$table_num)
        {
          return [];
        }

        //基础表名
        $base_table_name = $this->getTable();

        //只有一张表
        if($table_num == 1)
        { 
        	if(isset($condition['logic']) && $condition['logic'] == 'or'){
        		unset($condition['logic']);
        		return  $this->field('*')->table("{$base_table_name}_1")->whereor($condition)->order($order)->page($page,$per_page) ->select();
        		 
        	}else{
        		 
        		return  $this->field('*')->table("{$base_table_name}_1")->where($condition)->order($order)->page($page,$per_page) ->select();
        		 
        	}
        
        }
        else
        { 
          //最终的sql语句
          $last_sql = '';
          //有多张表
          for($i=1;$i<=$table_num;$i++)
          {
            //获取sql语句
          	if(isset($condition['logic']) && $condition['logic'] == 'or'){
          		unset($condition['logic']);
          		 $sql = $this->field('*')->table("{$base_table_name}_$i")->whereor($condition)->fetchSql(true)->select();
          		 $condition['logic'] = 'or';
          	}else{
          		 
          		 $sql = $this->field('*')->table("{$base_table_name}_$i")->where($condition)->fetchSql(true)->select();
          	}
            
           

            $last_sql .= $sql . ' UNION ALL ';

          }

          $last_sql = trim($last_sql,'UNION ALL');

          $order_by = '';

          foreach($order as $k=>$v)
          {
              $order_by .= "`{$k}` {$v}";
          }

          if(!empty($order_by))
          {
            $last_sql .= ' ORDER BY ' . $order_by;
          }

          $limit = " LIMIT " . ($page-1)*$per_page . ",$per_page";

          $last_sql .= $limit;

          return $this->query($last_sql);
        }
    }

    //查询所有满足条件的会员信息列表
    public function get_all($condition=[],$fields=['*'],$order=['user_id'=>'desc'])
    {
        //获取分表数量
        $table_num = model('User')->get_table_num();
        
        if(!$table_num)
        {
          return [];
        }

         //基础表名
        $base_table_name = $this->getTable();

        //只有一张表
        if($table_num == 1)
        {
          return $this->field('*')->table("{$base_table_name}_1")->where($condition)->order($order)->page($page,$per_page)->select(); 
        }
        else
        {

          //最终的sql语句
          $last_sql = '';
          //有多张表
          for($i=1;$i<=$table_num;$i++)
          {
            //获取sql语句
            $sql = $this->field('*')->table("{$base_table_name}_$i")->where($condition)->fetchSql(true)->select();

            $last_sql .= $sql . ' UNION ALL ';

          }

          $last_sql = trim($last_sql,'UNION ALL');

          $order_by = '';

          foreach($order as $k=>$v)
          {
              $order_by .= "`{$k}` {$v}";
          }

          if(!empty($order_by))
          {
            $last_sql .= ' ORDER BY ' . $order_by;
          }

          return $this->query($last_sql);
        }
    }

    /**
     * 统计满足特定条件的记录
     * @param array $condition 包含查询条件的数组
     * @return int             返回满足查询条件的记录数
     */
    public function get_count($condition=[])
    {
        //获取分表数量
        $table_num = model('User')->get_table_num();

        if(!$table_num)
        {
          return 0;
        }

        //基础表名
        $base_table_name = $this->getTable();

        //只有一张表
        if($table_num == 1)
        {
        	if(isset($condition['logic']) && $condition['logic'] == 'or'){
        		unset($condition['logic']);
        		 return $this->table("{$base_table_name}_1")->whereor($condition)->count('user_id'); 
        	}else{
        		return  $this->table("{$base_table_name}_1")->where($condition)->count('user_id'); 
        	}
       
        }
        else
        {
          $count = 0;
          //有多张表
          for($i=1;$i<=$table_num;$i++)
          {
          	if(isset($condition['logic']) && $condition['logic'] == 'or'){
          		unset($condition['logic']);
          		 $cnt = \think\Db::table("{$base_table_name}_$i")->whereor($condition)->count('user_id');
                         $condition['logic'] = 'or';
          	}else{
          		 $cnt = \think\Db::table("{$base_table_name}_$i")->where($condition)->count('user_id');
          	}

           

            $count+=$cnt;
          }
          return $count;
        }
    }


    /**
     * 批量更新数据
     * @param array $condition 更新条件
     * @param int   $table_id  表id
     * @param array $data      要更新的数据
     */
    public function update_by_attr($condition=[],$data=[],$table_id=1)
    {
      //基础表名
      $base_table_name = $this->getTable();

      return $this->table("{$base_table_name}_{$table_id}")->where($condition)->update($data);
    }

    //获取当前会员所属的表id
    public function get_table_id($user_id)
    {
      return floor($user_id / $this->rule['expr']) + 1;
    }
}
