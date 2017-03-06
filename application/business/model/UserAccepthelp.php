<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【接受资助】 数据层
// +----------------------------------------------------------------------

namespace app\business\model;
use app\common\model\Base;


class UserAccepthelp extends Base
{
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
        $type_text = [1 => '接受资助', 2 => '接单钱包'];
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
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function  update_accept_data($map=[],$partition_time,&$param) {
        $this->get_month_submeter($partition_time);
        if(!empty($map)) {
        	return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);
        }else {
        	return $this->partition($this->info,$this->info_field,$this->rule)->insert($param);
            
        }
        
       
    }
    
    
   
    
    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_accept_info($map = [],$partition_time,$field='*') {
         $this->get_month_submeter($partition_time);
        $list = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();
        if($list) {
            $list->status_text  = $list->status_text;
            $list->flag_text    = $list->flag_text;
            $list->type_id_text = $list->type_id_text;
            $list =  $list->toArray();
            return $list;
        }
        return [];
    }
    
    
     /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_count($map = [],$partition_time) {
        $this->get_month_submeter($partition_time);
        $sql = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->fetchSql(true)->count();
 
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
    		return $this::table($table_name1)->where($map)->count();
    
    	}else{
    		$table2  = get_table_seq($partition_time)-1;
    		$table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);
    		return $this::table($table_name2)->where($map)->count();
    
    	}
    	 
    }
    /**
     * 列表数据
     * @param type $map
     * @param type $fields
     * @param type $page
     * @param type $per_page
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
      * new 列表数据
      * @param type $map
      * @param type $fields
      * @param type $page
      * @param type $per_page
      * @param type $order
      * @return type
      */
     public function get_new_list($map=[],$partition_time,$fields=['*'],$page=0,$limit= 20,$order=[]) {
     
     	/* $this->get_month_submeter($partition_time);
     		$table2 = get_table_seq($partition_time)-1;
     		$table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);
     		$sql2    = $this::table($table_name2)->where($map)->field($fields)->fetchSql(true)->select();
     		$sqlall  = 	$this->partition($this->info,$this->info_field,$this->rule)
     		->union($sql2)
     		->field($fields)
     		->where($map)
     		->fetchSql()
     		->select();
     		 
     		$sqlall .= $this->limit($page, $limit);
     		echo $sqlall;exit; */
     	
     	$sql1  =  $this->partition($this->info,$this->info_field,$this->rule)
     	->field($fields)
     	->where($map)
     	->fetchSql()
     	->order($order)
     	->limit($page,$limit)
     	->select();
      
     	return  $this->query($sql1);
      
     }
     
     
   
     /**
      * 批量更新
      * @param type $matchget_list
      * @param type $partition_time
      * @return type
      */
     public function set_data_all(&$match,$partition_time) {
         //获取接受资助表的创建时间数组
         $partition_times = array_unique(array_column($match,'accepthelp_create_time'));
         for($i=0;$i<count($partition_times);$i++) {
             $seq          =  get_table_seq($partition_times[$i]);
             $table[$seq]  =  get_table_name($this->getTable(),$seq);
         }
         
         
//         $seq = ceil(date('m', $partition_time)/$this->rule['expr']);
//         $table = $this->getTable().'_'.date('Y',time()). '_'.$seq;
         $this->startTrans();
         try{
              foreach($table as $v) {
                    //组装sql
                   $sql = 'update '.$v;
                   //匹配金额减少
                   $used      = '  set used = case id ';
                   //匹配的笔数
                   $match_num = 'END,  match_num = case id ';
                   //
                   $end_sql = '';
                   for($i=0;$i<count($match);$i++) {
                       $used .= sprintf("WHEN %d THEN %s ", $match[$i]['pid'], 'used-'.$match[$i]['other_money']); 
                       $match_num .= sprintf("WHEN %d THEN %s ", $match[$i]['pid'], ' match_num - 1 '); 
                   }

                   //获得主键条件
                   $ids = array_column($match, 'pid');
                   $ids_where = implode(',', $ids);
                   $end_sql .= 'END WHERE id IN ('.$ids_where.')';

                   $this->execute($sql.$used.$match_num.$end_sql);
               }
                $this->commit();
                return true;
         } catch (Exception $ex) {
             $this->rollback();
             return false;
         }
}
     
     
     /**
      * union
      * @param type $provide
      * @param type $fields
      * @return type
      */
     public function get_match_list($accept,$fields='*') {
         $union = [];
         $map['id'] = ['in',array_unique($accept['ids'])];
         $map['flag'] = 0;
         $sql = $this->where($map)->field($fields)->fetchSql(true)->select();
         
         sort($accept['table']);
         for($i=0;$i<count($accept['table']);$i++) {
             $accept['table'][$i] =  'SELECT * FROM '.$accept['table'][$i];
          }
         //组装union表名
         $union_table = '( ' . implode(" UNION ", array_unique($accept['table'])) . ') AS a';
        
         $table = $this->getTable();    
         $sql = str_replace("`{$table}`", $union_table , $sql);
      
        return $this->query($sql); 
     }
     
     
     /**
      * union
      * @param type $accept
      * @param type $fields
      * @return type
      */
     public function get_match_list_by_table($accept,$field='*') {
         $union = [];
          sort($accept['table']);
           $map['id'] = ['in',array_unique($accept['ids'])];
         for($i=0;$i<count($accept['table']);$i++) {
             $union[$i]['table'] = $accept['table'][$i];
             $union[$i]['field']  = $field;
             $list = $this->table($accept['table'][$i])->field($field)->where($map)->select();
         }
         return $list;
        
        // return $this->field($fields)->where($map)->union($union)->select();
     }
     
     /**
      * 加入手动匹配列表的数据 写入session
      * @param type $data
      * @param type $user_info
      */
     public function get_table_on_ids(&$data,$user_info) {
    
         $arr   = [];
        //查看手动匹配列表数据session中是否存的提供资助id
        $tmp = session('set_manual_match_accept_'.$user_info['id']);
   
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
                 $year = date('Y', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))));
                 $arr['table'][$seq] = $this->getTable().'_'.$year. '_'.$seq;
             }
        }else {
            
            $arr['ids'] = $data['ids'];
            //组装表名
            for($i=0;$i<count($data['create_time']);$i++) {
                $seq = ceil(date('m', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))))/$this->rule['expr']);
               // $arr['table'][$seq] = $this->getTable().'_'.date('Y',time()). '_'.$seq;
                $year = date('Y', strtotime(str_replace('上午', '', str_replace('下午', '', $data['create_time'][$i]))));
                $arr['table'][$seq] = $this->getTable().'_'.$year. '_'.$seq;
             }
        }
 
        //把提供资助的数据id加入session中 
        session('set_manual_match_accept_'.$user_info['id'],  serialize($arr));
         
     }
     
     
     public function set_data_match_num_all(&$data) {
         $union = [];
         for($i=0;$i<count($accept);$i++) {
             $seq = ceil(date('m', $accept[$i]['create_time'])/$this->rule['expr']);
             $union[$seq]['table'] = $this->getTable().'_'.$seq;
             $union[$seq]['ids'][$i]  = $accept[$i]['id'];
         }
         
         sort($union);
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
         //return $this->getTable().'_'.date('Y',time()). '_'.$seq;
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
                    $sql            = 'update '.$match[$i]['table'];
                    $match_num      = '  set match_num = case id ';
                    $used           = ' END, used = case id ';
                    $status         = ' END, status = case id ';
     
                    $end_sql        = '';
                    sort($match[$i]['data']);
                    for($j=0;$j<count($match[$i]['data']);$j++) {
                        $match_num .= sprintf("WHEN %d THEN match_num+%d ", $match[$i]['data'][$j]['id'], $match[$i]['data'][$j]['match_num']); 
                        $used      .= sprintf("WHEN %d THEN used+%d ", $match[$i]['data'][$j]['id'], $match[$i]['data'][$j]['used']); 
                        $status    .= sprintf("WHEN %d THEN %d ", $match[$i]['data'][$j]['id'], $match[$i]['data'][$j]['status']);  
                    }
                    $ids            = array_unique(array_column($match[$i]['data'], 'id'));
                    $ids_where      = implode(',', $ids);
                    $end_sql       .= 'END WHERE id IN ('.$ids_where.')';
 
                    file_put_contents("./../runtime/accepthelp_sql.txt",$sql.$match_num.$used.$status.$end_sql.'\r\n-------------------\r\n'.date("Y-m-d",time()),FILE_APPEND);
                    
                    $this->execute($sql.$match_num.$used.$status.$end_sql);
                }
                
                $this->commit();
                return true;
          } catch ( \Exception $ex) {
                $this->rollback();
                return false;
          }

     }
     
     
      public function set_accepthelp_money_by_account(&$map,&$partition_time,$accept,$data,$user_info) {
           $this->startTrans();
          try{
                //更改接受资助订单金额
               $update_arr['money'] = ['exp','money+'.(int)$data['amount']];
               $this->update_accept_data($map,$partition_time,$update_arr); 
               //更改钱包出局钱包数量
               $account_arr['wallet_currency'] = ['exp','wallet_currency-'.(int)$data['amount']];
               model('member/UserAccount')->update_by_uid($accept['user_id'],$account_arr);
              
                //记录操作日志
                $msg = '【' . $user_info['realname'] . '】帮助【'.$accept['username'].'】增加接受资助金额【'.$data['amount'].'】';
                $log['data']['uid']                     = $user_info['id'];
                $log['data']['username']                = $user_info['username'];
                $log['data']['realname']                = $user_info['realname'];
                $log['data']['type']                    = 1;
                $log['data']['remark']                  = get_log_type_text(1,$msg, 'business/accept/set_accepthelp_money_by_account');
                $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
                $log['model_name']                      = 'SysUserLog';
                //加入队列
                add_to_queue('',$log);
        
             $this->commit();
             return true;
          } catch (Exception $ex) {
              $this->rollback();
              return false;
          }
            
    }
    
    /**
     * 更接受资助
     */
    public function updateAccepthelp($accid,$data,$partition_time){
    	$this->get_month_submeter($partition_time);
    	return $this->partition($this->info,$this->info_field,$this->rule)->where(["id"=>$accid])->update($data);
    }
    
    /**
     * jwf 更新数据
     * @param unknown $where
     * @param unknown $data
     * @return unknown
     */
    public function updateAccepthelpByData($where,$data,$partition_time){
    	$this->get_month_submeter($partition_time);
    	return $this->partition($this->info,$this->info_field,$this->rule)
    	->where($where)->update($data);
    }
    /** 获得提供资助单条数据
     * @param   $where
     * @param   $field
     * @return
     * @Author  江雄杰
     * @time  2016-10-20
     */
    public function getAccepthelpData($where , $field='*',$partition_time) {
    	$this->get_month_submeter($partition_time);
    	return $this->partition($this->info,$this->info_field,$this->rule)
    	->where($where)
    	->field($field)
    	->order(" create_time DESC ")
    	->find();
    }
    
    public function limit($page,$limit){
    	$page = empty($page)?0:$page-1;
    	$statPage = $page * $limit;
    	return " limit " . $statPage . "," . $limit;
    }
}

