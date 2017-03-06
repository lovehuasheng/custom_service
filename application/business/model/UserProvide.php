<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【提供资助】 数据层
// +----------------------------------------------------------------------

namespace app\business\model;
use app\common\model\Base;


class UserProvide extends Base {

     protected function initialize() {
        $this->get_month_submeter();
      
    }
    /**
     * 提供资助类型文本
     * @param type $vaule
     * @param type $data
     * @return type
     */
    protected static function getTypeIdTextAttr($vaule, $data) {
        $type_text = [1 => '提供资助', 2 => '接单资助'];
        return isset($data['type_id']) ? $type_text[$data['type_id']] : '';
    }

    /**
     * 提供资助状态文本
     * @param type $vaule
     * @param type $data
     * @return type
     */
    protected static function getStatusTextAttr($vaule, $data) {
        $status_text = ['提交成功', '匹配成功', '已打款', '已收款'];
        return isset($data['status']) ? $status_text[$data['status']] : '';
    }
    
    /**
     * 提供资助软删除文本
     * @param type $vaule
     * @param type $data
     * @return type
     */
    protected static function getFlagTextAttr($vaule, $data) {
        $flag_text = [0=>'已启用',2=>'已删除'];
        return isset($data['flag']) ? $flag_text[$data['flag']] : '';
    }
    
    

    
     /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_count($map = [],$partition_time='') {
        $this->get_month_submeter($partition_time);    	
        $sql = $this->where($map)->fetchSql(true)->count('id');
        $table_name = get_partition_uine_table_name($this->getTable(),[get_table_seq($partition_time),(get_table_seq($partition_time)-1)],$partition_time);
        $table = $this->getTable();
        $sql = str_replace("`{$table}`", $table_name, $sql);
        $result = $this->query($sql);
        return (int)$result[0]['tp_count'];
    }
    
    
    /**
     * new获取总条数
     * @param type $map
     * @return type
     */
 public function get_total_count($map = [],$partition_time,$type=1){
    	$this->get_month_submeter($partition_time);
    	if($type == 1){
	    	$table1 = get_table_seq($partition_time);    	
	    	$table_name1 = get_partition_sql_name($this->getTable(),$table1 ,$partition_time);
	    	$sql=  $this::table($table_name1)->where($map)->fetchSql(true)->count();
	    	$result = $this->query($sql);
	    	return $result[0]['tp_count'];
	    	 
    	}else{
    		$table2  = get_table_seq($partition_time)-1;
    		$table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);
    		$sql=  $this::table($table_name2)->where($map)->fetchSql(true)->count();
    		$result = $this->query($sql);
    		return $result[0]['tp_count'];

    	}
   
    }

    /**
     * 分页数据
     * @param type $map
     * @param type $page
     * @param type $r
     * @param type $field
     * @param type $order
     * @return type
     */
     public function get_list($map=[],$partition_time,$fields=['*'],$page=1,$per_page= 20,$order=[]) {
        $sql =  $this->field($fields)->where($map)->order($order)->page($page,$per_page)->fetchSql(true)->select();
        $table_name = get_partition_uine_table_name($this->getTable(),[get_table_seq($partition_time),(get_table_seq($partition_time)-1)],$partition_time);
        $table = $this->getTable();
        $sql = str_replace("`{$table}`", $table_name, $sql);
        return $this->query($sql);
     }
     
     /**
      * new分页数据
      * @param type $map
      * @param type $page
      * @param type $r
      * @param type $field
      * @param type $order
      * @return type
      */
     public function get_new_list($map=[],$partition_time,$fields=['*'],$page=0,$limit= 20,$order='create_time desc') {
     		/* $this->get_month_submeter($partition_time);
     		  $table2 = get_table_seq($partition_time)-1;
     		$table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);
     		$sql2    = $this::table($table_name2)->where($map)->field($fields)->fetchSql(true)->select(); 
     		 $sql1  = 	$this->partition($this->info,$this->info_field,$this->rule)
     		->field($fields)
     		->where($map)
     		->fetchSql()
     		->select(); 
     		 $sqlall = "( {$sql1} ) UNION ( {$sql2} ) ";
     		 $sqlall .= $this->order($order);
     		 $sqlall .= $this->limit($page, $limit);
     		 return $this->query($sql1); */
     		 
     		  $sql1  = 	$this->partition($this->info,$this->info_field,$this->rule)
     		->field($fields)
     		->where($map)
     		->fetchSql()
     		->order($order)
     		->limit($page,$limit)
     		->select(); 
     	return  $this->query($sql1);

     }

    /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function update_provide_data($map = [], $partition_time,&$param) {
         $this->get_month_submeter($partition_time);
        if(empty($map)) {
            return $this->partition($this->info,$this->info_field,$this->rule)->insert($param);
        }
        else {
            return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);
        }
    }

    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_provide_info($map = [],$partition_time, $field = ['*']) {
        $this->get_month_submeter($partition_time);
        $list = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();
        if ($list) {
            $list->type_text = $list->type_id_text;
            $list->status_text = $list->status_text;
            $list->flag_text = $list->flag_text;
            $list = $list->toArray();
            return $list;
        }
        return [];
    }
    
   

    
     /**
      * 批量更新
      * @param type $match
      * @param type $partition_time
      * @return type
      */
     public function set_data_all(&$match,$partition_time) {
         $seq = ceil(date('m', $partition_time)/$this->rule['expr']);
         $table = $this->getTable().'_'.date('Y',time()). '_'.$seq;
         //组装sql
         $sql = 'update '.$table;
         //匹配金额减少
         $used      = '  set used = case id ';
         //匹配的笔数
         $match_num = ' END, match_num = case id ';
         //
         for($i=0;$i<count($match);$i++) {
             $used .= sprintf("WHEN %d THEN %s ", $match[$i]['other_id'], 'used-'.$match[$i]['other_money']); 
             $match_num .= sprintf("WHEN %d THEN %s ", $match[$i]['other_id'], ' match_num - 1 '); 
         }
         //获得主键条件
         $ids = array_unique(array_column($match, 'other_id'));
         $ids_where = implode(',', $ids);
         $end_sql .= 'END WHERE id IN ('.$ids_where.')';
         
         return  $this->execute($sql.$used.$match_num.$end_sql);
     }
     
     
     /**
      * union
      * @param type $provide
      * @param type $fields
      * @return type
      */
     public function get_match_list($provide,$fields='*') {
         $union = [];
         $map['id']   = ['in',array_unique(array_column($provide, 'id'))];
         $map['flag'] = 0;
         $sql = $this->where($map)->field($fields)->fetchSql(true)->select();
         for($i=0;$i<count($provide);$i++) {
             $seq = ceil(date('m', strtotime(str_replace('上午', '', str_replace('下午', '', $provide[$i]['partition_time']))))/$this->rule['expr']);
             
             $year = date('Y', strtotime(str_replace('上午', '', str_replace('下午', '', $provide[$i]['partition_time']))));
 
             $union[$seq]['table'] = 'SELECT * FROM '.$this->getTable().'_'.$year. '_'.$seq;
            
         }
         
        sort($union);
        //组装union表名
        $union_table = '( ' . implode(" UNION ", array_unique(array_column($union, 'table'))) . ') AS a';
       
        $table = $this->getTable();    
        $sql = str_replace("`{$table}`", $union_table , $sql);
        
        return $this->query($sql); 
        
         
        
     }
     
     
     /**
      * union
      * @param type $provide
      * @param type $fields
      * @return type
      */
     public function get_match_list_by_table($provide,$field='*') {
      
         $union = [];
         sort($provide['table']);
         $map['id'] = ['in',array_unique($provide['ids'])];
         for($i=0;$i<count($provide['table']);$i++) {
             $union[$i]['table'] = $provide['table'][$i];
             $union[$i]['field']  = $field;
             $list = $this->table($provide['table'][$i])->field($field)->where($map)->select();
         }
    
        return $list;
        // $this->partition($this->info,$this->info_field,$this->rule)->field($field)->where($map)->union($union)->select(); 
     }
     
     /**
      * 加入手动匹配列表的数据 写入session
      * @param type $data
      * @param type $user_info
      */
     public function get_table_on_ids(&$data,$user_info) {
         
         
         $arr   = [];
        //查看手动匹配列表数据session中是否存的提供资助id
        $tmp = session('set_manual_match_provide_'.$user_info['id']);
        if(!empty($tmp)) {
        	$info = unserialize($tmp);
        	$result = array_intersect($data['ids'],$info['ids']);
        	if($result){
        		return false;
        	}
            
            $arr['ids'] = array_merge($info['ids'],$data['ids']);
                        
            //组装表名
            for($i=0;$i<count($data['create_time']);$i++) {
                $seq = ceil(date('m', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))))/$this->rule['expr']);
              //  $arr['table'][$seq] = $this->getTable().'_'.date('Y',time()). '_'.$seq;
                $year = date('Y', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))));
                $arr['table'][$seq] = $this->getTable().'_'.$year. '_'.$seq;
             }
        }else {
            
            $arr['ids'] = $data['ids'];
            //组装表名
            for($i=0;$i<count($data['create_time']);$i++) {
                $seq = ceil(date('m', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))))/$this->rule['expr']);
                //$arr['table'][$seq] = $this->getTable().'_'.date('Y',time()). '_'.$seq;
                $year = date('Y', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))));
                $arr['table'][$seq] = $this->getTable().'_'.$year. '_'.$seq;
             }
        }
        //把提供资助的数据id加入session中 
        session('set_manual_match_provide_'.$user_info['id'],  serialize($arr));
         
     }
     
     /**
      * 获取表名
      * @param type $partition_time 时间戳
      * @return type
      */
     public function get_table_name($partition_time) {
         $seq = ceil(date('m', $partition_time)/$this->rule['expr']);
         $year = date('Y', $partition_time);
         return $this->getTable().'_'.$year. '_'.$seq;
     }
     
     
     /**
      * 手动匹配批量更新
      * @param type $match
      * @param type $partition_time
      * @return type
      */
      public function set_data_all_to_match(&$match) {
          if(empty($match)) {
              return false;
          }
          sort($match);
          $this->startTrans();
          try{
           
               for($i=0;$i<count($match);$i++) {
               	    sort($match[$i]['data']);
                    $sql            = 'update '.$match[$i]['table'];
                    $match_num      = '  set match_num = case id ';
                    $used           = ' END, used = case id ';
                    $status         = ' END, status = case id ';
 
                    
                    $end_sql        = '';
                  
                    for($j=0;$j<count($match[$i]['data']);$j++) {
                    	
                        $match_num .= sprintf("WHEN %d THEN match_num+%d ", $match[$i]['data'][$j]['id'], $match[$i]['data'][$j]['match_num']); 
                        $used      .= sprintf("WHEN %d THEN used+%d ", $match[$i]['data'][$j]['id'], $match[$i]['data'][$j]['used']); 
                        $status    .= sprintf("WHEN %d THEN %d ", $match[$i]['data'][$j]['id'], $match[$i]['data'][$j]['status']); 
                        
                    }
                    $ids            = array_unique(array_column($match[$i]['data'], 'id'));
                    $ids_where      = implode(',', $ids);
                    $end_sql       .= 'END WHERE id IN ('.$ids_where.')';

                    file_put_contents("./../runtime/provide_sql.txt",$sql.$match_num.$used.$status.$end_sql.'\r\n------------------\r\n'.date("Y-m-d",time()),FILE_APPEND);
                    
                    $this->execute($sql.$match_num.$used.$status.$end_sql);
                }
                
                $this->commit();
                return true;
          } catch (\Exception $ex) {
                $this->rollback();
                return false;
          }

     }
     
     /**
      * 更提供资助
      */
     public function updateProvideById($id,$data,$partition_time){
     	$this->get_month_submeter($partition_time);
     	return $this->partition($this->info,$this->info_field,$this->rule)
     	->where(["id"=>$id])->update($data);
     }
     
     /**
      * 更新数据
      * @param unknown $where
      * @param unknown $data
      * @return unknown
      */
     public function updateProvideByData($where,$data,$partition_time){
     	$this->get_month_submeter($partition_time);
        return $this->partition($this->info,$this->info_field,$this->rule)
     	->where($where)->update($data);

     }
     
     /** 获得提供资助单条数据
      * @param   $where
      * @param   $field
      * @return
      * @Author  江雄杰
      * @time  2016-10-19
      */
     public function getProvideData($where , $field='*' , $time=0) {
     	if($time > 0) {
     		$info_date = ['now_time'=>$time];
     	} else {
     		$info_date = $this->info_date;
     	}
     	return $this->partition($info_date , $this->info_field , $this->rule)
     	->where(['flag'=>0])
     	->where($where)->field($field)->order("create_time DESC")->find();
     }
     
     public function limit($page,$limit){
     	$page = empty($page)?0:$page-1;
     	$statPage = $page * $limit;
     	return " limit " . $statPage . "," . $limit;
     }
     public function order($order){
     	return "ORDER BY $order";
     }
     
}
