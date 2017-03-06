<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【匹配详情】 数据层
// +----------------------------------------------------------------------

namespace app\business\model;
use app\common\model\Base;
use org\RedisLib;


class UserMatchhelp extends Base {

     protected function initialize() {
        $this->get_month_submeter();
      
    }
    protected $autoWriteTimestamp = 'true';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $err = '';
    /**
     * 接受资助状态文本
     * @param type $value
     * @param type $data
     * @return type
     */
    protected static function getTypeIdTextAttr($value, $data) {
        $type_text = [0 => '接受资助', 1 => '接受资助', 2 => '接单钱包'];
        return isset($data['type_id']) ? $type_text[$data['type_id']] : '';
    }

    /**
     * 支付状态文本
     * @param type $value
     * @param type $data
     * @return type
     */
    protected static function getStatusTextAttr($value, $data) {
//        $status_text = ['匹配成功', '审通过', '已打款', '已收款'];
//        return isset($data['status']) ? $status_text[$data['status']] : '';
        if(isset($data['status'])) {
             switch ($data['status']) {
                    case 1:
                        $data['status_text'] = '未打款';
                        break;
                    case 2:
                        $data['status_text'] = '已打款';
                        break;
                    case 3:
                        $data['status_text'] = '已打款';
                        break;
                    default:$data['status_text'] = '未审核';break;
    }

            return  $data['status_text'];
        }
        
        return '';
    }
    
    /**
     * 收款状态
     * @param type $value
     * @param type $data
     * @return string
     */
    protected static function getSignTextAttr($value, $data) {
//        $status_text = ['匹配成功', '审通过', '已打款', '已收款'];
//        return isset($data['status']) ? $status_text[$data['status']] : '';
        if(isset($data['status'])) {
            switch ($data['status']) {
                    case 1:
                        $data['sign_text'] = '未收款';
                        break;
                    case 2:
                        $data['sign_text'] = '未收款';
                        break;
                    case 3:
                        $data['sign_text'] = '已收款';
                        break;
                    default:$data['sign_text'] = '未审核';break;
            }
            return  $data['sign_text'];
        }
        
        return '';
    }

    /**
     * 提供资助状态文本
     * @param type $value
     * @param type $data
     * @return type
     */
    protected static function getOtherTypeIdTextAttr($value, $data) {
        $other_type_id_text = [0 => '提供资助', 1 => '提供资助', 2 => '接单资助'];
        return isset($data['other_type_id']) ? $other_type_id_text[$data['other_type_id']] : '';
    }

    /**
     * 数据状态文本
     * @param type $value
     * @param type $data
     * @return type
     */
    protected static function getFlagTextAttr($value, $data) {
        $flag_text = [0 => '已启用',1=>'已撤销', 2 => '已删除'];
        return isset($data['flag']) ? $flag_text[$data['flag']] : '';
    }
    
    /**
     * 打款图片
     * @param type $value
     * @param type $data
     * @return type
     */
    protected static function getPayImageAttr($value, $data) {
        return !empty($data['pay_image'])?getQiNiuPic($data['pay_image']):null;
    }
    
//    protected static function getStatusTextAttr($value, $data) {
////        if(isset($data['status'])) {
////            switch ($data['status']) {
////                case 1:
////                    $data['status_text'] = '';
////            }
////        }
//        
//        return $data['status_text'];
//    }

    /**
     * 付款超时文本
     * @param type $value
     * @param type $data
     * @return string
     */
    protected static function getPayTimeTextAttr($value, $data) {
        //审核通过才有收款倒计时
        if(isset($data['status']) && $data['status'] == 1) {        	
        	$matchhelp_pay_time = config('matchhelp_out_time');
        	
        	if($data['status_text'] == 0) {
        		
        		if(intval($matchhelp_pay_time + $data['audit_time']) > intval(time())){
        			return intval($matchhelp_pay_time + $data['audit_time']) - intval(time());
        		}else{
        			return '已超时';
        		}
        		
        	}else{
        		if(intval($data['expiration_create_time']) < intval(time())) {
        			return "已超时";
        		}else{
        			return   ((intval($data['expiration_create_time'])) - intval(time()));//'打款方剩余时间'
        		}
        		
        	}  
        }
        return '';
    }
    
    /**
     * 收款超时文本
     * @param type $value
     * @param type $data
     * @return string
     */
    protected static function getSignTimeTextAttr($value, $data) {
        //如果是打款状态 才会有倒计时
        if(isset($data['status']) && $data['status'] == '2') {
        
        	return  '收款已超时';
        }else{
        	return  '数据出错';
        } 
    }
    
    
    public function get_match_by_time($map,$partition_time, $field = '*'){
    	   $this->get_month_submeter($partition_time);
    return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();
    	 
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
    public function get_list($map,$partition_time, $page = 1, $r = 20, $field = '*', $order = 'id desc') {
        $this->get_month_submeter($partition_time);
        $list = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->order($order)->page($page,$r)->select();
        if ($list) {
            for ($i = 0; $i < count($list); $i++) {
                $list[$i]['flag_text'] = $list[$i]['flag_text'];
                $list[$i]['status_text'] = $list[$i]['status_text'];
                $list[$i]['type_id_text'] = $list[$i]['type_id_text'];
                $list[$i]['other_type_id_text'] = $list[$i]['other_type_id_text'];
            }
            return $list;
        }
        return [];
    }
    
    /**
     * 多条数据集
     * @param type $map
     * @param type $partition_time
     * @param type $field
     * @param type $order
     * @return type
     */
    public function get_data_list($map,$partition_time, $field = '*', $order = '') {
        $this->get_month_submeter($partition_time);
        $table2 = get_table_seq($partition_time)-1;
        $table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);
        
        $sql2    = $this::table($table_name2)->where($map)->field($field)->fetchSql(true)->select();
        
        $sql1  = 	$this->partition($this->info,$this->info_field,$this->rule)
        ->field($field)
        ->where($map)
        ->fetchSql()
        ->select();
        
        $sqlall = "( {$sql1} ) UNION ( {$sql2} ) ";

        $list =  $this->query($sqlall);
 
        if ($list) {
            //返回数组
            return get_array_to_object($list);
        }
        return [];
    }

    /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function update_match_data($map = [],$partition_time='', &$param) {
        $this->get_month_submeter($partition_time);
        return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);
    }
    
    /**
     * 添加
     * @param type $param
     * @return type
     */
    public function insert_data(&$param) {
        return $this->partition($this->info,$this->info_field,$this->rule)->insert($param);
    }

    
    /**
     * 手动匹配数据 审核通过加入数据表
     * @param type $param
     */
    public function insert_manual_match_data(&$param ,&$update_provide_arr,&$update_accept_arr) {
        $this->startTrans();
        try{
        	if($param && is_array($param)){
        		foreach ($param as $key=>$val){
	        		$redis = \org\RedisLib::get_instance('sxh_default');
	        		$param[$key]['id'] = $redis->incr('sxh_user_matchhelp:id');
        		}
        	}

             $match_result = $this->partition($this->info,$this->info_field,$this->rule)->insertAll($param);
             $provide_result = model('UserProvide')->set_data_all_to_match($update_provide_arr);
             $accept_result = model('UserAccepthelp')->set_data_all_to_match($update_accept_arr);
             
            
             if($match_result && $provide_result && $accept_result) {
                  $this->commit();
                  return true;
             }else {
                 $this->rollback();
                 return false;
             }
            
        } catch (\Exception $ex) {
            \think\Log::error($ex->getMessage());
            $this->rollback();
            return false;
        }
       
    }
    /**
     * 删除匹配订单
     * @param type $map
     * @param type $param
     */
    public function destroy_match_data(&$data,$partition_time, &$param) {
        $this->get_month_submeter($partition_time);
        $this->startTrans();
        try {
            $map['id'] = $data['id'];
            //匹配表删除订单
            $match_flag = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);

            //删除提供资助表的匹配金额和匹配笔数
            $provide_map['id']        = $data['provide_id'];
            $provide_arr['used']      = ['exp', ' used - ' . $data['other_money']];
            $provide_arr['match_num'] = ['exp', 'match_num - 1'];
           // $provide_arr['status']    = 1;
            
            //提供资助判断是否为一个人匹配,或者多个人匹配           
            $provide_field=['id','match_num','money','used','status'];
            $provide_pipei = model('UserProvide')->get_provide_info($provide_map,$data['provide_create_time'],$provide_field);
           
            if($provide_pipei){
            	//如果是一对一的情况
            	if(($provide_pipei['match_num'] ==1) && ($provide_pipei['status'] ==1) && ($provide_pipei['money'] == $provide_pipei['used']) ){
            		  $provide_arr['status'] = 0;
            	} 
            }
           
            $provide = model('UserProvide')->update_provide_data($provide_map,$data['provide_create_time'], $provide_arr);

            //删除接受资助表匹配金额和匹配笔数
            $accept_map['id']        = $data['accept_id'];
            $accept_arr['used']      = ['exp', 'used - ' . $data['other_money']];
            $accept_arr['match_num'] = ['exp', 'match_num - 1'];
           // $accept_arr['status']    = 1;
            
            $accept_field=['id','match_num','money','used','status'];
            $accept_pipei = model('UserAccepthelp')->get_accept_info($accept_map,$data['accepthelp_create_time'],$accept_field);
            if($accept_pipei){
            	//如果是一对一的情况
            	if(($accept_pipei['match_num'] ==1) && ($accept_pipei['status'] ==1) && ($accept_pipei['money'] == $accept_pipei['used']) ){
            		 $accept_arr['status'] = 0;
            	}
            }

            $accept = model('UserAccepthelp')->update_accept_data($accept_map,$data['accepthelp_create_time'], $accept_arr);
            
            if ($match_flag && $provide && $accept) {
                $this->commit();
                return true;
            } else {
                $this->rollback();
                return false;
            }
        } catch (\Exception $ex) {
            \think\Log::error($ex->getMessage());
            $this->rollback();
            return false;
        }
    }
    
   /**
    * 打款人撤单封号
    * @param type $data
    * @param type $partition_time
    */
    public function provide_disable_no(&$data,$partition_time,&$param,&$user_info) {
        
        $this->get_month_submeter($partition_time);
        //组装条件
        $map['other_id'] = $param['other_id'];
        //状态 0-匹配成功 1-审通过 2-已打款，3-已收款
        $map['status'] = ['in',[0,1]];
        //0-正常 2-删除
        $map['flag'] = 0;
        //取值字段
        $field = ['pid','other_money','accepthelp_create_time'];
        //取值
        $match = $this->get_data_list($map,$partition_time,$field);
        if(empty($match)) {
            return false;
        }
        $this->startTrans();
        try{
            //更改对应收款人的匹配金额
            $accept_result = model('UserAccepthelp')->set_data_all($match,$partition_time);
            //删除匹配的单
            //删除条件
            $update_map['other_id'] = $param['other_id'];
            //更新字段
            $update_arr['flag'] = 1;
            $match_result  = $this->update_match_data($update_map,$partition_time,$update_arr);
            //更改打款人的匹配金额与状态
            //提供表的更新条件
            $provide_map['id'] = $param['other_id'];
            //取出匹配金额的总和
            $sum_other_money = array_sum(array_column($match, 'other_money'));
            //更新字段
            $provide_arr['used'] = ['exp','used-'.$sum_other_money];
            $provide_result = model('UserProvide')->update_provide_data($provide_map,$partition_time,$provide_arr);
            //禁用打款人
            $user_arr['status'] = 0;
            //判断是企业用户还是还是个人用户
            $is_company = model('member/Company')->get_by_id( $param['other_user_id'],'id');
            if($is_company){
            	$user_result = model('member/Company')->update_by_id($param['other_user_id'],$user_arr);
            }else{
            	$user_result = model('member/User')->update_by_id($param['other_user_id'],$user_arr);
            }
            
            
            //进入黑名单
//            $blank_arr['user_id'] = $param['other_user_id'];
//            $blank_arr['username'] = $param['other_username'];
//            $blank_arr['remark'] = '撤单封号';
//            $blank_arr['create_time'] = $_SERVER['REQUEST_TIME'];
            //$blank_result = model('user/UserBlacklist')->update_user_data([],$blank_arr);
            $blank_result = model('user/UserBlacklist')->set_blacklist_to_queue($param['other_user_id'],'撤单封号');

            //记录撤单操作日志
            //1-转接单，2-流水转让记录 3-撤单记录
            $operation['type'] = 3;
            //provide表ID
            $operation['provide_id'] = $param['other_id'];
            //原用户id
            $operation['primary_id'] = $param['other_user_id'];
            //原用户
            $operation['primary_username'] = $param['other_username'];
            $operation['user_id'] = 0;
            $operation['username'] = 'provide';
            //状态1-已还原 0-正常
            $operation['status'] = 0;
            //操作人id
            $operation['operator_id'] = $user_info['id'];
            //操作人
            $operation['operator_name'] = $user_info['username'];
            $operation['create_time'] = $_SERVER['REQUEST_TIME'];
            add_to_queue(config('log_queue'),$operation);
            
            $redis = \org\RedisLib::get_instance('sxh_default');
            
            if ($accept_result && $match_result && $provide_result &&$user_result&&$blank_result) {
                $this->commit();
                
                	//撤单后,把相应挂单的redis 次数去掉
                	if($param['other_user_id'] ){                
                		$redis->hmset("sxh_userinfo:id:{$param['other_user_id']}",array("provide_finish_num"=>1,'provide_create_num'=>1));
                	}
             
                return true;
            } else {
                $this->rollback();
                return false;
            }
        } catch (Exception $e) {
            \think\Log::error($ex->getMessage());
            $this->rollback();
            return false;
        }
        
    }
    
    
    /**
     * 收款人撤单封号
     * @param type $data
     * @param type $partition_time
     * @param type $param
     * @param type $user_info
     * @return boolean
     */
    public function accept_disable_no(&$data,$partition_time,&$param,&$user_info) {
        $this->get_month_submeter($partition_time);
        //组装条件
        $map['pid'] = $param['pid'];
        //状态 0-匹配成功 1-审通过 2-已打款，3-已收款
        $map['status'] = ['in',[0,1]];
        //0-正常 2-删除
        $map['flag'] = 0;
        //取值字段
        $field = ['other_id','other_money'];
        //取值
        $match = $this->get_data_list($map,$partition_time,$field);
        if(empty($match)) {
            return false;
        }
        $this->startTrans();
        try{
            //更改对应收款人的匹配金额
            $provide_result = model('UserProvide')->set_data_all($match,$partition_time);
            //删除匹配的单
            //删除条件
            $update_map['pid'] = $param['pid'];
            //更新字段
            $update_arr['flag'] = 1;
            $match_result  = $this->update_match_data($update_map,$partition_time,$update_arr);
            //更改打款人的匹配金额与状态
            //提供表的更新条件
            $accept_map['id'] = $param['other_id'];
            //取出匹配金额的总和
            $sum_other_money = array_sum(array_column($match, 'other_money'));
            //更新字段
            $accept_arr['used'] = ['exp','used-'.$sum_other_money];
            $accept_result = model('UserAccepthelp')->update_accept_data($accept_map,$partition_time,$accept_arr);
            //禁用打款人
            $user_arr['status'] = 0;
            
            //判断是企业用户还是还是个人用户            
            $is_company = model('member/Company')->get_by_id( $param['user_id'],'id');
            if($is_company){
            	$user_result = model('member/Company')->update_by_id($param['user_id'],$user_arr);
            }else{
            	$user_result = model('member/User')->update_by_id($param['user_id'],$user_arr);
            }
            
            //进入黑名单
//            $blank_arr['user_id'] = $param['user_id'];
//            $blank_arr['username'] = $param['username'];
//            $blank_arr['remark'] = '撤单封号';
//            $blank_arr['create_time'] = $_SERVER['REQUEST_TIME'];
//            $blank_result = model('user/UserBlacklist')->update_user_data([],$blank_arr);
            $blank_result = model('user/UserBlacklist')->set_blacklist_to_queue($param['user_id'],'撤单封号');
            //记录撤单操作日志
            
            //1-转接单，2-流水转让记录 3-撤单记录
            $operation['type'] = 3;
            //accepthelp表ID
            $operation['provide_id'] = $param['pid'];
            //原用户id
            $operation['primary_id'] = $param['user_id'];
            //原用户
            $operation['primary_username'] = $param['username'];
            $operation['user_id'] = 0;
            $operation['username'] = 'accepthelp';
            //状态1-已还原 0-正常
            $operation['status'] = 0;
            //操作人id
            $operation['operator_id'] = $user_info['id'];
            //操作人
            $operation['operator_name'] = $user_info['username'];
            $operation['create_time'] = $_SERVER['REQUEST_TIME'];
            add_to_queue(config('log_queue'),$operation);
            $redis = \org\RedisLib::get_instance('sxh_default');
            if ($accept_result && $match_result && $provide_result &&$user_result&&$blank_result) {
                $this->commit();
                
                if($param['cid'] == 8){
                	//撤单后,把相应挂单的redis 次数去掉
                	if($param['user_id'] ){
                		$redis->hmset("sxh_userinfo:id:{$param['user_id']}",array("accepthelp8_create_num"=>1,'accepthelp8_finish_num'=>1));
                	}
                }else{
                	//撤单后,把相应挂单的redis 次数去掉
                	if($param['user_id'] ){
                		$redis->hmset("sxh_userinfo:id:{$param['user_id']}",array("accepthelp_finish_num"=>1,'accepthelp_create_num'=>1));
                	}
                }
                return true;
            } else {
                $this->rollback();
                return false;
            }
        } catch (\Exception $e) {
            \think\Log::error($e->getMessage());
            $this->rollback();
            return false;
        }
        
    }
    
    /**
     * 删除假图
     * @param type $data
     * @param type $partition_time
     * @return type
     */
    public function undo_img(&$data,$partition_time) {
        $this->get_month_submeter($partition_time);
  
        $map['id'] = $data['id'];
        $param['pay_image'] = '';
        $param['pay_time']  = 0;
        $param['status']  = 1;//0-匹配成功 1-审通过 2-已打款，3-已收款
        //匹配表
        return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);
         
    }

 

    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_match_info($map = [], $partition_time,$field = '*') {
        $this->get_month_submeter($partition_time);
        $list = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();
        if ($list) {
            $list = $list->toArray();
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
         $sql =  $this->where($map)->fetchSql(true)->count();
         $table_name = get_partition_uine_table_name($this->getTable(),[get_table_seq($partition_time),(get_table_seq($partition_time)-1)],$partition_time);
         $table = $this->getTable();
         $sql = str_replace("`{$table}`", $table_name, $sql);
         $list =  $this->query($sql); 
         return $list[0]['tp_count'];
    }
    
    /**
     * 获取总条数 优化后
     * @param type $map
     * @return type
     */
    public function get_total_count($map = [],$partition_time,$type=1){
    	$this->get_month_submeter($partition_time);
    	$sql  = 	$this->partition($this->info,$this->info_field,$this->rule)
    	->field("COUNT(id) AS tp_count")
    	->where($map)
    	->fetchSql()
    	->select();
    	
    	
    	if($map['status'] == 1){
    		$out_time = config ( 'matchhelp_out_time' );
    		$sql .="  AND  (case delayed_time_status WHEN 0 THEN audit_time+{$out_time}<UNIX_TIMESTAMP(now()) END  OR case delayed_time_status WHEN 1 THEN expiration_create_time < UNIX_TIMESTAMP(now()) END) ";
    	}
   
    	$list =  $this->query($sql);
    	$resutl = array();
    	if($list && is_array($list)){
    		$resutl = $list[0]['tp_count'];
    	}
      return $resutl;
 
    }
    
   public function get_new_overtime_order_list($map,$partition_time, $page = 0, $limit = 20, $field = '*', $order = 'create_time desc'){
   	 
    
   	$this->get_month_submeter($partition_time);
   
    $sql  = 	$this->partition($this->info,$this->info_field,$this->rule)
   	->field($field)
   	->where($map)
   	->fetchSql()
   	->select(); 

    if($map['status'] == 1){
    	$out_time = config ( 'matchhelp_out_time' );
    	$sql .="  AND  ( case delayed_time_status WHEN 0 THEN audit_time+{$out_time}<UNIX_TIMESTAMP(now()) END or case delayed_time_status WHEN 1 THEN expiration_create_time < UNIX_TIMESTAMP(now()) END) ";
    }
    
    $sql .= $this->order($order);
    $sql .= $this->limit($page, $limit);
    
   $list =  $this->query($sql);
   
 
   	if(!empty($list)) {
   		for($i=0;$i<count($list);$i++) {
   			 
   			 $list[$i]['pay_time_text'] = self::getPayTimeTextAttr($list[$i]['expiration_create_time'],$list[$i]);
   			 
   			if(!empty($list[$i]['status'])) {
   				$list[$i]['status_text'] = self::getStatusTextAttr($list[$i]['status'],$list[$i]);
   				$list[$i]['sign_text'] = self::getSignTextAttr($list[$i]['status'],$list[$i]);
   			}
   			if(!empty($list[$i]['pay_time'])) {
   				$list[$i]['sign_time_text'] = self::getSignTimeTextAttr($list[$i]['sign_time_text'],$list[$i]);
   			}
   			
   			if(!empty($list[$i]['pay_image'])) {
   				$list[$i]['pay_image'] =  self::getPayImageAttr($list[$i]['pay_image'],$list[$i]);
   			}
   		}
   	}
   	
   	return $list;
 
   }
    
    /**
     * 获取提供资助超时列表
     * @param type $map
     * @param type $page
     * @param type $r
     * @param type $field
     * @param type $order
     */
    public function get_overtime_order_list($map,$partition_time, $page = 1, $r = 20, $field = '*', $order = 'create_time desc') {
        $sql = $this->where($map)->field($field)->page($page,$r)->order($order)->fetchSql(true)->select();
        $table_name = get_partition_uine_table_name($this->getTable(),[get_table_seq($partition_time),(get_table_seq($partition_time)-1)],$partition_time);
        $table = $this->getTable();
        $sql = str_replace("`{$table}`", $table_name, $sql);
        $list =  $this->query($sql); 
        if(!empty($list)) {
            for($i=0;$i<count($list);$i++) {
                
                $list[$i]['pay_time_text'] = self::getPayTimeTextAttr($list[$i]['expiration_create_time'],$list[$i]);
                
                if(!empty($list[$i]['status'])) {
                     $list[$i]['status_text'] = self::getStatusTextAttr($list[$i]['status'],$list[$i]);
                     $list[$i]['sign_text'] = self::getSignTextAttr($list[$i]['status'],$list[$i]);
                }
                if(!empty($list[$i]['sign_time_text'])) {
                    $list[$i]['sign_time_text'] = self::getSignTimeTextAttr($list[$i]['sign_time_text'],$list[$i]);
                }
                
                if(!empty($list[$i]['pay_image'])) {
                    $list[$i]['pay_image'] =  self::getPayImageAttr($list[$i]['pay_image'],$list[$i]);
                }
                
            }
        }
      
        return $list;
    }

    
    /**
     * 转移订单到接单人
     * @param type $data
     * @param type $match
     * @param type $user_info
     * @return boolean
     */
    public function transfer_order_to_user(&$data,&$match,&$user_info,$partition_time) {

        $this->startTrans();
        try{
            //匹配ID
          //  $map['id'] = ['in',array_unique(array_column($match, 'id'))];
            $map['other_id'] = ['in', array_unique(array_column($match, 'other_id'))];
            //更改为 接单资助 1-提供资助 2-接单资助
            $match_arr['other_type_id'] =  2;
            $match_arr['other_cid']     =  9;
            //替换新用户id
            $match_arr['other_user_id'] = $data['other_user_id'];
            //替换新用户
            $match_arr['other_username'] = $data['other_username'];
            $match_arr['other_name']     = $data['other_name'];
            //更新时间
           // $match_arr['audit_time'] = $_SERVER['REQUEST_TIME'];
            $match_arr['delayed_time_status']    = 1;
            $match_arr['expiration_create_time'] = $_SERVER['REQUEST_TIME']+config('matchhelp_out_time');;
            $match_arr['update_time'] = $_SERVER['REQUEST_TIME'];
           // $match_arr['create_time'] = $_SERVER['REQUEST_TIME'];
            //更新数据
            $match_result = $this->update_match_data($map,$partition_time,$match_arr);
  
            //更改提供资助表
            //提供资助表ID
            $provide_map['id']          = ['in', array_unique(array_column($match, 'other_id'))];
            //更改为 接单资助 1-提供资助 2-接单资助
            $provide_arr['type_id']     =  2;
            $provide_arr['cid']         =  9;
            $provide_arr['cname']       =  "个人接单";
            
            //替换新用户
            $provide_arr['user_id']     = $data['other_user_id'];
            //替换新用户
            $provide_arr['username']    = $data['other_username'];
            $provide_arr['name']        = $data['other_name'];
            //$provide_arr['create_time'] = $_SERVER['REQUEST_TIME'];
            //更新提供资助表数据
            $provide_result = model('UserProvide')->update_provide_data($provide_map,$match[0]['provide_create_time'],$provide_arr);
            
             //禁用原不打款用户
            //预定义
            $user_result = true;
            if($data['flag'] == 1) {
                 //用户ID
                $user_ids = array_unique(array_column($match, 'other_user_id'));
                //禁用状态 0-未激活 1-已激活 2-已冻结
                $user_arr['status'] = 2;
                //后台禁用标识 0-未禁用 1-已禁用
                $user_arr['flag'] = 1;
                //更新会员状态
                if($user_ids && is_array($user_ids)){
                	
                	foreach ($user_ids as $uid){
                		$is_company = model('member/Company')->get_by_id( $uid,'id');
                		if($is_company){
                			$user_result = model('member/Company')->update_by_id($uid,$user_arr);
                		}else{
                			$user_result = model('member/User')->update_by_id($uid,$user_arr);
                		}
                	}
                	
                }else{
                	
                	$is_company = model('member/Company')->get_by_id( $user_ids,'id');
                	if($is_company){
                		$user_result = model('member/Company')->update_by_id($user_ids,$user_arr);
                	}else{
                		$user_result = model('member/User')->update_by_id($user_ids,$user_arr);
                	}
                	$user_result =  model('member/User')->update_by_id($user_ids,$user_arr);
                }
                
            }

                    
            if($match_result && $provide_result && $user_result) {
                   
                    for($i=0;$i<count($match);$i++) {
                        if($data['flag'] == 1) {
                            //加入黑名单
                            //不打款会员ID
                            $blacklist_arr['data']['user_id']          = $match[$i]['other_user_id'];
                            //不打款会员名
                            $blacklist_arr['data']['username']         = $match[$i]['other_username'];
                            //备注
                            $blacklist_arr['data']['remark']           = '不打款封号【转接单封号】';
                            //model名称
                            $blacklist_arr['model_name']               = 'UserBlacklist';
                            //加入队列
                            //$redis->lPush(config('log_queue'),json_encode($blacklist_arr));
                            add_to_queue('',$blacklist_arr,'sxh_default');
                         }
                        //写入转单记录
                        //provide表ID
                        $operation_arr['data']['provide_id']       = $match[$i]['other_id'];
                        //原用户ID
                        $operation_arr['data']['primary_id']       = $match[$i]['other_user_id'];
                        //原用户名
                        $operation_arr['data']['primary_username'] = $match[$i]['other_username'];
                        //1-转接单，2-流水转让记录
                        $operation_arr['data']['type']             = 1;
                        //新用户ID
                        $operation_arr['data']['user_id']          = $data['other_user_id'];
                        //新用户名
                        $operation_arr['data']['username']         = $data['other_username'];
                        //设置状态 0-正常 1-还原
                        $operation_arr['data']['status']           = 0;
                        //操作人ID
                        $operation_arr['data']['operator_id']      = $user_info['id'];
                        //操作人
                        $operation_arr['data']['operator_name']    = $user_info['realname'];
                        //操作时间
                        $operation_arr['data']['create_time']      = $_SERVER['REQUEST_TIME'];
                        //模型名称
                        $operation_arr['model_name']               = 'SysOperation';
                         //加入队列
                      //  $redis->lPush(config('log_queue'),json_encode($operation_arr));
                        add_to_queue('',$operation_arr);
                    }

                    //记录操作日志
                    $msg = '转接单 禁用了用户'. implode(',', array_unique(array_column($match, 'other_username'))).'('.  implode(',', array_unique(array_column($match, 'other_user_id'))).')【匹配ID:'.  implode(',', array_unique(array_column($match, 'id'))) .',提供资助ID:'.  implode(',', array_unique(array_column($match, 'other_id'))).',接受资助ID：'.  implode(',', array_unique(array_column($match, 'pid'))).',匹配金额：'.  implode(',', array_unique(array_column($match, 'other_money'))).'】';
                    $log['data']['uid']                     = $user_info['id'];
                    $log['data']['username']                = $user_info['username'];
                    $log['data']['realname']                = $user_info['realname'];
                    $log['data']['type']                    = 1;
                    $log['data']['remark']                  = get_log_type_text(1,$msg,'business/matching/transfer_order_to_user');
                    $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
                    $log['model_name']                      = 'SysUserLog';
                    add_to_queue('',$log);
                    //加入用户禁用日志表
                    //sxh_activate_log
       
                 $this->commit();
                 return true;
            }else {
                $this->rollback();
                return false;
            }
            
        } catch (\Exception $ex) {
            \think\Log::error($ex->getMessage());
            $this->rollback();
            return false;
        }
                
    }
    
    /**
     * 打款延时批量更新 主要是找时间
     * @param type $match
     * @param type $partition_time
     * @param type $delayed_time
     * @return boolean
     */
    public function new_delayed_match($map,$partition_time,$param) {
     	
    	$this->get_month_submeter($partition_time);
    	return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);
    }
    
    
    
    
    /**
     * 打款延时批量更新
     * @param type $match
     * @param type $partition_time
     * @param type $delayed_time
     * @return boolean
     */
    public function delayed_match($match,$partition_time,$delayed_time) {
        //获得分表的表名
       // $this->get_month_submeter($partition_time);
        $seq = ceil(date('m', $partition_time)/$this->rule['expr']);
        $year = date('Y', $partition_time);
        $table = $this->getTable().'_'.$year. '_'.$seq;
   
        //预定义错误的匹配订单ID数组
        $error_arr = [];
        //预定义可更新的匹配订单ID数组
        $ids = [];
        //组装批量更新sql
        $sql = 'update '.$table;
        $create_time = '  set expiration_create_time = case id ';
        $delayed_time_status = 'END, delayed_time_status = case id ';
        $end_sql = '';
        for($i=0;$i<count($match);$i++) {
            if($match[$i]['status'] == 1) {
                $ids[] = $match[$i]['id'];
                 //匹配时间+24小时  < 当前时间时 取当前时间减去24小时再加上需要延时的时间  延时时间为小时
                if($_SERVER['REQUEST_TIME'] > ($match[$i]['expiration_create_time']+config('matchhelp_out_time'))) {
                    $stime = strtotime(date('Y-m-d H:i:s',(($_SERVER['REQUEST_TIME']-config('matchhelp_out_time'))+($delayed_time*3600))));
                }else {
                    //匹配时间+延时时间
                    
                    $stime = strtotime(date('Y-m-d H:i:s',($match[$i]['expiration_create_time']+($delayed_time*3600))));
                }
                $create_time .= sprintf("WHEN %d THEN %d ", $match[$i]['id'], $stime); 
                $delayed_time_status .= sprintf("WHEN %d THEN %d ", $match[$i]['id'], 1); 
            }else {
                 $error_arr[] = $match[$i]['id'];
            }
        }
         if(!empty($error_arr)) {
             $this->err = '失败的匹配数据ID:'.implode(',', $error_arr);
         }
        if(!empty($ids)) {
            $ids_where = implode(',', $ids);
            $end_sql .= 'END WHERE id IN ('.$ids_where.')';
            //拼接同步sql
            $total_sql = $sql.$create_time.$delayed_time_status.$end_sql;

            //执行sql 
            return  $this->execute($sql.$create_time.$delayed_time_status.$end_sql);
        }
        
        return false;
       
    }
    
    
    
    /**
     * 确认收款
     * @param type $match
     * @param type $partition_time
     * @param type $user_info
     * @param type $community
     */
    public function accept_collections(&$match,$partition_time,&$user_info,$community) {
 
    	$provideID       = $match['other_id'];//提供资助表ID
    	$acceptID        = $match["pid"];//接受资助ID
        $other_cid       = $match["other_cid"];//provide表社区id
        $other_user_id   = $match["other_user_id"];
        $user_id         = $match["user_id"];
        $math_id         = $match["id"];
        
        //定义变量
        $match_resut              ='';
        $updateaccepthelp_result  ='';
        $updateprovide_result     ='';
        $updateInvented_result    =true;
        $income_sult_type1        =true;
        $p1_type_1                =true;
        $p11_type_1               =true;
        $pRes3_type1              =true;
        $p33_type1                =true;
        $sell_money_type1         ='';
        $sell_money_income_type1  ='';
        $sell_money_type2         ='';
        $self_income_type2        ='';
  
        // /** 指定哪个匹配表 */
        $table_provide_create_time    = $match['provide_create_time'];//提供表创建时间
        $table_accepthelp_create_time = $match['accepthelp_create_time'];//接受表创建时间
        
        $provideModel    = \think\Loader::model('UserProvide', 'model');
        $accepthelpModel = \think\Loader::model('UserAccepthelp', 'model');
        $relationModel   = \think\Loader::model('member/UserRelation', 'model');
        $accountModel    = \think\Loader::model('member/UserAccount', 'model');
        $userModel       = \think\Loader::model('member/User', 'model');
        $userInfoModel   = \think\Loader::model('member/UserInfo', 'model');
        $incomeModel     = \think\Loader::model('member/UserIncome', 'model');
       
        //查询提供表信息  受助表的信息  提供资助人 Relation
        $provideInfo     = $provideModel    -> getProvideData(["id"=>$provideID] , '*' , $table_provide_create_time);
        $accepthelpInfo  = $accepthelpModel -> getAccepthelpData(["id"=>$acceptID] , '*' , $table_accepthelp_create_time);
        $relationInfo    = $relationModel   -> getRelationOne(["user_id" => $other_user_id],"full_url"); 


        /********** Redis 事务前，获取数据 Start *******************************/
        //提供资助者 确认收款的次数（在第一笔确认收款时更新+1）
        $provide_finish_num       = RedisLib::get_instance()->hgetUserinfoByID($other_user_id , 'provide_finish_num');
        
        //小康社区挂单总次数
        $community_provide_count  = RedisLib::get_instance()->hgetUserinfoByID($other_user_id , 'provide_community_3_count');
        
        //提供资助的次数（在最后一单确认收款成功时更新，取消订单时更新）
        $provide_num              = RedisLib::get_instance()->hget("sxh_userinfo:id:{$other_user_id}","provide_num");
        
        //货款提取接受资助完成数（最后一笔确认收款时 cid=8 的时候更新+1）
        $accepthelp8_finish_num   = RedisLib::get_instance()->hgetUserinfoByID($user_id , 'accepthelp8_finish_num');
        
        //接受资助者 确认收款的次数（在最后一笔确认收款时更新+1）
        $accepthelp_finish_num    = RedisLib::get_instance()->hgetUserinfoByID($user_id, 'accepthelp_finish_num');
        
        /********** Redis 事务前，获取数据 End   *******************************/
        $this->startTrans();
        try{
        	
            //更新matchhelp表的状态
            //组装条件 matchhelp表id
            $map['id'] = $match['id'];
            //更新状态为已收款
            $match_arr['status'] = 3;
            //更新打款时间
            $match_arr['sign_time'] = $_SERVER['REQUEST_TIME'];
            //更新matchhelp数据表
            $match_resut = $this->update_match_data($map,$partition_time,$match_arr);
            
            //---------------------
            
            
            //Mysql 查询小康挂单次数，很慢
            $community_3_c = 0;
            if($community['id'] == 3) {
            	$provide_user_create_time = $userModel->get_by_id($other_user_id, 'create_time');
            	$provide_user_create_time = is_numeric($provide_user_create_time) ? $provide_user_create_time : strtotime($provide_user_create_time);
            	$community_3_c = $this->getCommunityProvideCount($other_user_id , $provide_user_create_time);
            }
            
            //小康社区挂单总次数
            /* if($community['id'] == 3) {
            	$community_provide_count = empty($community_provide_count) ? 1 : (intval($community_provide_count)+1);
            } */
  
            
            //判断是否为最后一次确认 收款----- 改状态---改finish_count
            if(($provideInfo->match_num - $provideInfo->finish_count) == 1 && $provideInfo->money == $provideInfo->used)
            {
            	$pwhere = array(
            			"id" => $provideID,
            			"user_id" => $other_user_id,
            	);
            	$pdata = array(
            			"status"  => 3,
            			"sign_time" => time(),
            			"update_time" => time(),
            			"finish_count" => ($provideInfo->finish_count+1),
            	);
            	//更新 提供资助表状态
            	
            }else{
            	$pwhere = array(
	                "id"      => $provideID,
	                "user_id" => $other_user_id,
	            );
	            $pdata = array(
	                "update_time" => time(),
	                "finish_count" => ($provideInfo->finish_count+1),
	            );   
            }
           
           $updateprovide_result = $provideModel->updateProvideByData($pwhere,$pdata,$match['provide_create_time']);
 
             /***************** 接受资助表状态 修改表accepthelp **********************/
             //如果 提供资助，分多个接受资助，判断是不是最后一个接受资助
             //如果是最后一个接受资助，则修改接受资助表状态
             //保存最近匹配时间
             
             if(($accepthelpInfo->match_num - $accepthelpInfo->finish_count) == 1 && $accepthelpInfo->money == $accepthelpInfo->used)
             {
             	$awhere = array(
             			"id" => $acceptID,
             			"user_id" => $user_id,
             	);
             	$adata = array(
             			"status"  => 3,
             			"sign_time" => time(),
             			"update_time" => time(),
             			"finish_count" => ($accepthelpInfo->finish_count+1)
             	);

             }else{
	        	$awhere = array(
	        			"id" => $acceptID,
	        			"user_id" => $user_id,
	        	);
	        	$adata = array(
	        			"update_time" => time(),
	        			"finish_count" => ($accepthelpInfo->finish_count+1)
	        	); 
             } 
             
             //更新 接受资助表状态
            $updateaccepthelp_result = $accepthelpModel->updateAccepthelpByData($awhere,$adata,$match['accepthelp_create_time']);
            
            $other_money = isset($match["other_money"]) ? $match["other_money"]:0;//匹配金额
            //'资助类型 1-提供资助 2-接单资助',
           if($match["other_type_id"] == 1){  
	        //这里是接受资助的第一笔，如果是第一笔，就返利
		         if(empty($accepthelpInfo->finish_count) || $accepthelpInfo->finish_count == 0) {
		        	$userInfo = $userModel->get_by_id($match["other_user_id"]);
		        	//根据小区，挂单社区所需善心币need_currency  接受资助挂单币，返善金币
		        	$needToMoney = intval($community["need_currency"]) * 100;
		        	//根据用户id 更新钱
		         	$updateInvented_result = $accountModel->updateInventedCurrency($match["other_user_id"] , $needToMoney,["user_id"=>$match["other_user_id"]],1);
 
		        	$incomeData = array(
		        			"user_id"       => $match["other_user_id"],
		        			"username"      => empty($userInfo["username"])?"":$userInfo["username"],
		        			"pid"           => $provideID,
		        			"type"          => 3,//善金币
		        			"cat_id"        => $math_id,
		        			"income"        => $needToMoney,//一个善心币，返利100善金币
		        			"info"          => "提供资助返利善金币",
		        			"create_time"   => time(),
		          );		        	
		          $income_sult_type1 = $incomeModel->saveData($incomeData);		          
		        } 
        	 
 
                /** 给提供资助人 的父1，3，5级 返利  Start *************************************/
                $rurlToArray = [];
                $rurlToArray_res = trim($relationInfo->full_url , ',');

	            if(strpos($rurlToArray_res , ',')) { 
	                $rurlToArray = explode(",", $rurlToArray_res);
	                $rurlToArray = array_reverse($rurlToArray);
	                $rurlToArray = array_slice( $rurlToArray, 0 , 7);//拿到级关系  ，拆分成数组
	               
	            } else {
	                $rurlToArray[0] = intval($match["other_user_id"]);
	            }
	            
        		
        		//判断有木有 ，上一级返利（（一半返到管理钱包，一半返到善金币））
        		if(!empty($rurlToArray[1])){
        	
	        		//上一级返利（一半返到管理钱包，一半返到善金币）
	        		$level1Rebate = $community["level1_rebate"];//获取返回一级返利点
	        		$p1Money = $other_money * ($level1Rebate/100);//一级返利金额
	        		$p1Money1 = ceil($p1Money/2);
	        		
	        		//最总要这个判断事物
	        		$p1_type_1  = self::addManageWallet($p1Money1, $rurlToArray[1],$math_id,$provideID);
	         		$p11_type_1 = self::addInventedCurrency($p1Money1, $rurlToArray[1],$math_id,$provideID);
        		} 
        	
        		//上三级返利（一半返到管理钱包，一半返到善金币）
        		if(!empty($rurlToArray[3])){
	        		$level1Rebate   = $community["level3_rebate"];//获取返回三级返利点
	        		$p3Money        = $other_money * ($level1Rebate/100);//三级返利金额
	        		$p3Money1       = ceil($p3Money/2);
	         		$pRes3_type1    = self::addManageWallet($p3Money1, $rurlToArray[3],$math_id,$provideID);
	         		$p33_type1      = self::addInventedCurrency($p3Money1, $rurlToArray[3],$math_id,$provideID);
        		}	 
    	
        	/** 
        	 * 给提供资助人返利
        	*/
        	$provideUserInfo = $userModel->get_by_id($other_user_id);
        	$provideUserInfo["username"] = empty($provideUserInfo["username"])?"":$provideUserInfo["username"];
        			$rebate = $community["rebate"];
        	$money = $other_money * ($rebate/100);//提供资助人的返利点
        	//返利旧出局钱包的钱（新社区钱包）
        	$totalMoney = $other_money + $money;//（本金 + 返利点）
        	
        	/* if($community_provide_count > 5) {
        	   $totalMoney = $other_money + ($other_money*(15/100));
        	} */
        	
        	/** 如果是小康社区，并且挂单次数 >= 5 */
        	if($community_3_c >= 5 && $community['id'] == 3) {
        		$money = $other_money*(15*0.01);
        		$totalMoney = $other_money + $money;
        	}
        	
        	//社区钱包类型
        	$field_array = [
        	    1   => 'poor_wallet',
        	    2   => 'needy_wallet',
        	    3   => 'comfortably_wallet',
        	    4   => 'wealth_wallet',//富人
        		5   => 'kind_wallet',//德善
        		6   => 'big_kind_wallet',
        		7   =>"company_wallet"
        	];
        	$income_type_array = [
        		1   => '特困钱包',
        		2   => '贫穷钱包',
        		3   => '小康钱包',
        		4   => '富人钱包',
        		5   => '德善钱包',
        		6   => '大德钱包',
        		7   => '企业钱包',
        	];

        	//收入类型
        	$income_type_array = [
        	    1   => 7,//'特困社区',
        		2   => 8,//'贫穷社区',
        		3   => 9,//'小康社区',
        		4   => 11,//'富人社区',
        		5   => 10,//'德善社区',
        		6   => 15,//'大德社区',
        		7   => 12,//'企业社区',
        	];
        	
        	//社区钱包类型
        	$redis_field_array = [
        	   1   => 'poor_wallet_last_changetime',
        	   2   => 'needy_wallet_last_changetime',
        	   3   => 'comfortably_wallet_last_changetime',
        	   4   => 'wealth_wallet_last_changetime',//富人
        	   5   => 'kind_wallet_last_changetime',//德善
        	   6   => 'big_kind_wallet_last_changetime',
        	];
        	
        	$income_text = $income_type_array[$community['id']];        	 
        	$income_type = $income_type_array[$community['id']];
        	//返利一多
            $sell_money_type1 = $accountModel->updateInc($match["other_user_id"] , $field_array[$community['id']] , $totalMoney);
        	
        	//返利 本金+返利 存入
           $incomeData = array(
        	"user_id"      => $match["other_user_id"],
        	"username"     => empty($provideUserInfo["username"])?"":$provideUserInfo["username"],
        	"pid"          => $provideID,
        	"type"         => $income_type,//旧出局钱包（现社区钱包）
        	"earnings"     => $money,
        	"cat_id"       => $match['id'],
        	"income"       => $totalMoney,//
        	"info"         => $income_text,
        	"create_time"  => time(),
        	);
           
          $sell_money_income_type1 = $incomeModel->saveData($incomeData);
          
        	/** !================================================================================================
        	 *                        提供资助 返利 End
        	 *  !=============================================================================================== 
        	 * */
        }else if($match["other_type_id"] == 2){ 
            /** 给提供资助人返利 **********************************************************
             */
            $provideUserInfo = $userModel->get_by_id($match["other_user_id"]);
            
            $money = $other_money * (0.05);//自己的返利金额
            
            //返利旧出局钱包的钱（现社区钱包）
            $totalMoney = $other_money + $money;
            
            $sell_money_type2 = $accountModel->updateInc($match['other_user_id'] , 'order_taking' , $totalMoney);
            
            //返利 本金+ 返利 存入
            $incomeData = array(
                "user_id"   => $match["other_user_id"],
                "username"  => $provideUserInfo["username"],
                "pid"       => $provideID,
                "type"      => 6,//接单钱包
                "cat_id"    => $math_id,
                "income"    => $totalMoney,//社区钱包金额
                "earnings"  => $money,
                "info"      => '提供资助反利接单钱包',
                "create_time"  => time(),
            );
            $self_income_type2 = $incomeModel->saveData($incomeData);
            
        } 
       
        
        if($match["other_type_id"] == 1){
             
         if($match_resut && $updateaccepthelp_result && $updateprovide_result &&  $updateInvented_result && $income_sult_type1 && $p1_type_1 &&  $p11_type_1 
        	 && $pRes3_type1 && $p33_type1  && $sell_money_type1 && $sell_money_income_type1 )
        	{
        		
        		RedisLib::get_instance()->multi();
        		RedisLib::get_instance()->hset("sxh_userinfo:id:{$other_user_id}","provide_match_time",time());
        		 
        		/** 第一笔确认收款，更新Redis provide_finish_num */
        		if( $provideInfo->finish_count == 0) {
        			//保存最近提供资助时间
        			$provide_finish_num = empty($provide_finish_num) ? 1 : (intval($provide_finish_num)+1);
        			RedisLib::get_instance()->hsetUserinfoByID($provideInfo->user_id , 'provide_finish_num' , $provide_finish_num);
        		}
        		
        		
        		//第一个提供资助，修改提供资助表状态
        		if(($provideInfo->match_num -$provideInfo->finish_count) == 1 && $provideInfo->money == $provideInfo->used){
        			//最后一个提供资助
        			$provide_num = empty($provide_num)?1:($provide_num+1);        		
        			RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo->user_id}","provide_num",$provide_num);
        			//提取管理奖判断provide_current_id
        			RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo->user_id}","provide_current_id",$provideID);
        			RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo->user_id}","provide_current_money",$provideInfo->money);
        		
        		} 
        		

        		/***************** 接受资助表状态 修改表accepthelp **********************/
        		//如果 提供资助，分多个接受资助，判断是不是最后一个接受资助
        		//如果是最后一个接受资助，则修改接受资助表状态
        		//保存最近匹配时间
        		RedisLib::get_instance()->hset("sxh_userinfo:id:{$user_id}","accept_match_time",time());
	
        		//第一个提供资助，修改提供资助表状态
        		if(($accepthelpInfo->match_num -$accepthelpInfo->finish_count) == 1 && $accepthelpInfo->money == $accepthelpInfo->used){
        		    //企业货款接受次数
	        		if($accepthelpInfo->cid == 8) {
	        			$accepthelp8_finish_num = empty($accepthelp8_finish_num) ? 1 : (intval($accepthelp8_finish_num)+1);
	        			RedisLib::get_instance()->hsetUserinfoByID($user_id , ' accepthelp8_finish_num' , $accepthelp8_finish_num);
	        		}else{
	        			//接受资助者 确认收款的次数（在最后一笔确认收款时更新+1）
	        			$accepthelp_finish_num = empty($accepthelp_finish_num) ? 1 : $accepthelp_finish_num+1;
	        			RedisLib::get_instance()->hsetUserinfoByID($user_id , 'accepthelp_finish_num' , $accepthelp_finish_num);
	        		}
        		}	
        		
        		RedisLib::get_instance()->hsetUserinfoByID($user_id , $redis_field_array[$community['id']] , time());

        		RedisLib::get_instance()->hset("sxh_userinfo:id:{$user_id}","accept_match_time",time());
        		
        		RedisLib::get_instance()->exec();
        
        		self::db()->commit();//提交事务
         
        		return true;
        	}else{
        		self::db()->rollback();
        		return false;
        	}
        }else{
        	if($match_resut && $updateaccepthelp_result && $sell_money_type2 && $self_income_type2 && $updateprovide_result){
        		self::db()->commit();//提交事务
        		return true;
        	}else{
        		self::db()->rollback();
        		return false;
        	}
         }
       } catch (\Exception $ex) {
            
            $this->rollback();
            return false;
        }
        
        
    }
    
    
    /**
     * 企业付款
     * @param type $match
     */
    public function accept_company_collections(&$match,$partition_time,&$user_info,$community){
 
    	$provideID       = $match['other_id'];//提供资助表ID
    	$acceptID        = $match["pid"];//接受资助ID
    	$other_cid       = $match["other_cid"];//provide表社区id
    	$other_user_id   = $match["other_user_id"];
    	$user_id         = $match["user_id"];
    	$math_id         = $match["id"];
    	$match_time      = $match['create_time'];
    	
    	//接受人信息，提供人信息，社区信息
    	$table_provide_create_time    = $match['provide_create_time'];//提供表创建时间
    	$table_accepthelp_create_time = $match['accepthelp_create_time'];//接受表创建时间
    	
    	$provideModel     = \think\Loader::model('UserProvide', 'model');
    	$accepthelpModel  = \think\Loader::model('UserAccepthelp', 'model'); 
    	$acceptModel      = \think\Loader::model('member/UserAccount', 'model');
    	$companyInfoModel = \think\Loader::model('member/CompanyInfo', 'model'); 
    	$incomeModel      = \think\Loader::model('member/UserIncome', 'model');
    	
 
    	//查询打款企业的企业info
    	$provideCompanyInfo = $companyInfoModel->where(["company_id"=>$match["other_user_id"]])->find();
    	//提供资助信息
    	$provideInfo     = $provideModel    ->getProvideData(["id"=>$provideID] , '*' , $table_provide_create_time);
    	//接受资助信息
    	$accepthelpInfo  = $accepthelpModel ->getAccepthelpData(["id"=>$acceptID] , '*' , $table_accepthelp_create_time);
    	 
    	$self_account_income = $self_account = false;

    	//匹配数
    	$provideMatchNum = $provideInfo['match_num'];
    	
    	//获取Redis 信息
    	$provide_create_num = RedisLib::get_instance()->hgetUserinfoByID($match["other_user_id"],"provide_create_num");
    	$provide_num =  RedisLib::get_instance()->hget("sxh_userinfo:id:{$provideInfo->user_id}","provide_num");
    	$accepthelp_create_num = RedisLib::get_instance()->hgetUserinfoByID($accepthelpInfo->user_id,"accepthelp_create_num");
    	$accepthelp8_create_num = RedisLib::get_instance()->hgetUserinfoByID($accepthelpInfo->user_id,"accepthelp8_create_num");
    	 
    	$backRes = true;
    	//开启事务
       $this->startTrans();
        try{
            if(empty($provideInfo->finish_count) && ($match['other_type_id']==1)){
        		//判断是不是商务中心 商务中心返  挂单扣除的善心币*100 = 善金币
        		//查提供资助人的收入，判断是否已经返利过，一个提供资助期内只返利一次善金币
        		if($provideCompanyInfo["business_type"] == 1  ){
        			//根据小区，挂单社区所需善心币need_currency  接受资助挂单币，返出局钱包
        			$needToMoney = intval($community["need_currency"]) * 100;
        			//挂单返善金币
        			$backRes = $this->backActivateCurrency($match,$needToMoney);
        		}
        	}        	
        	$updata_provide_accept = $this->updateTableStatus($provideInfo,$accepthelpInfo,$match);
    	
	    	//匹配表状态 修改表matchhelp
	    	$data  = array(
	    			"update_time" => time(),
	    			"sign_time" => time(),
	    			"status" => 3,
	    	);
	        $updataMatchStatus = $this->updateMachthelpById($math_id, $data,$match_time);
	       
	       //'资助类型 1-提供资助 2-接单资助',//提供资助----确认收款处理
	       if($match["other_type_id"] == 1){
	       	 //给提供资助者的引荐人 返利
	       	 $referee_id          =$provideCompanyInfo["referee_id"];//引荐人ID
	       	 $level1_rebate       =$community["level1_rebate"];//引荐人返利点
	       	 $refereeMoney        =$match["other_money"] * ($level1_rebate*0.01);
	       	 //引荐人，但是引荐人不一定有
	       	 $rebate_res          =true;
	       	 $business_center_res =true;
	       	 $membership_res      =true;
	       	
	       	if($referee_id){
	       	    $rebate_res = $this->setCompSuperiorEarnings($referee_id, $refereeMoney, $match['other_id'], $match['other_user_id'], $match['id'], $provideCompanyInfo["referee_account"]);
	       	} 
	       	
	       	//给提供资助者的商务中心 返利
	       	$business_rebate    = $community["business_rebate"];//商务中心返利点
	       	$businessMoney      = $match["other_money"] * ($business_rebate*0.01);
	       	$business_center_id = $provideCompanyInfo["business_center_id"];//商务中心ID
	       	$businessMoney1     = ceil($businessMoney/2);//商务中心取一半
	       	//给商务中心返利
	       	//一半返到企业管理钱包，一半返到善金币
	       	if($business_center_id){
	       	  $business_center_res = $this->setCompSuperiorEarnings($business_center_id, $businessMoney1, $match['other_id'], $match['other_user_id'], $match['id'], $provideCompanyInfo["business_center_account"],true) ;
	       	} 
	       	//给提供资助者的招商员 返利
	       	$membership_rebate  = $community["membership_rebate"];//招商员返利点
	       	$membershipMoney    = $match["other_money"] * ($membership_rebate*0.01);
	       	$membership_id      = $provideCompanyInfo["membership_id"];//招商员ID
	       	if($membership_id){
	       	  $membership_res   = $this->setCompSuperiorEarnings($membership_id,$membershipMoney,$match['other_id'],$match['other_user_id'],$match['id'],$provideCompanyInfo["membership_name"]);
	       	} 
	       	/***************************************相关返利处理 END**************/
	       	//------给打款人返利---------//查询打款企业的企业info
	       	$rebate = $community["rebate"];
	       	$money = $match['other_money'] * ($rebate*0.01);//自己的返利金额
	       	$money1 = ceil($money/2);//分一半出来。
	       	
	       	//判断是不是商务中心
	       	if($provideCompanyInfo["business_type"] == 0){
	       		//返利出局钱包的钱
	       		$totalMoney = $match['other_money'] + $money1;
	       		$self_account = $acceptModel->updateCompanyWallet($match["other_user_id"] , $totalMoney,["user_id"=>$match["other_user_id"]],1);
	       		$incomeData = array(
	       				"user_id"   => $match["other_user_id"],
	       				"username"  => empty($provideCompanyInfo["username"])?"":$provideCompanyInfo["username"],
	       				"pid"       =>$provideID,
	       				"type"      => 12,//12企业出局钱包
	       				"earnings"  => $money,
	       				"cat_id"    => $math_id,
	       				"income"    => $totalMoney,
	       				"info"      => "挂单返利企业出局钱包",
	       				"create_time"  => time(),
	       		);
	       		$self_account_income12 = $incomeModel->saveData($incomeData);
	       		unset($incomeData);
	         	 
	       		$self_account_income = $self_account_income12;
	       		unset($incomeData);
	       		//企业--商务中心
	       		}else if($provideCompanyInfo["business_type"] == 1){
	       			//返利出局钱包的钱
	       			$totalMoney = $match['other_money'];
	       			$self_account = $acceptModel->updateCompanyWallet($match["other_user_id"] , $totalMoney,["user_id"=>$match["other_user_id"]],1);
	       			//返利 本金+ 返利数 存入
	       			$incomeData = array(
	       					"user_id"   => $match["other_user_id"],
	       					"username"  => empty($provideCompanyInfo["username"])?"":$provideCompanyInfo["username"],
	       					"pid"       =>$provideID,
	       					"type"      => 12,//12企业出局钱包
	       					"earnings"  => $money,
	       					"cat_id"    => $math_id,
	       					"income"    => $totalMoney,
	       					"info"      => "挂单返利企业出局钱包",
	       					"create_time"  => time(),
	       			);
	       			$self_account_income = $incomeModel->saveData($incomeData);
	       			unset($incomeData);
	       		}
  
	       }else if($match["other_type_id"] == 2){
           //------给打款人返利---------
           $rebate = $community["rebate"];
           $money = $match['other_money'] * (0.05);//自己的返利金额 转接单只返5%
           //返利出局钱包的钱
           $totalMoney = $match['other_money'] + $money;
           $self_account = $acceptModel->updateInc($match["other_user_id"],"company_order_taking",$totalMoney);
           //返利 本金+ 返利 存入
           $incomeData = array(
               "user_id"   => $match["other_user_id"],
               "username"  => empty($provideCompanyInfo["username"])?"":$provideCompanyInfo["username"],
               "pid"       =>$provideID,
               "type"      => 18,//接单钱包
               "cat_id"    => $math_id,
               "income"    => $totalMoney,//接单钱包
               "earnings"  => $money,
               "info"      => "企业接单钱包",
               "create_time"  => time(),
           );
           $self_account_income = $incomeModel->saveData($incomeData);
    	}   
    	
    	
    	$other_type_id_true = true;
    	if($match["other_type_id"] == 1){
    		if(!$business_center_res || !$rebate_res || !$business_center_res){
    			 $other_type_id_true = false;
    		}
    	}
 
     if($updata_provide_accept && $backRes && $self_account_income  && $updataMatchStatus && $updata_provide_accept && $self_account  && $other_type_id_true){
    				
    				RedisLib::get_instance()->multi();
    				//企业Redis
    				if($provideInfo->type_id == 1 ){//不是转接单，普通企业挂单
    					//保存最近提供资助时间
    					RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo["user_id"]}","provide_match_time",time());
    				}
    				if($accepthelpInfo->type_id == 1 ){//不是转接单，普通企业挂单
    					//保存最近提供资助时间
    					RedisLib::get_instance()->hset("sxh_userinfo:id:{$accepthelpInfo["user_id"]}","accept_match_time",time());
    				}
    				 
    				if(($provideMatchNum-$provideInfo->finish_count) == 1 && $provideInfo->money == $provideInfo->used){
    					$provide_num = empty($provide_num)?1:($provide_num+1);
    					if($provideInfo->type_id == 1 ){//不是转接单，普通企业挂单
    						//更新最近完成的提供资助的CID
    						RedisLib::get_instance()->hsetUserinfoByID($provideInfo->user_id,"provide_last_community_id",$provideInfo->cid);
    						RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo->user_id}","provide_num",$provide_num);
    						//最近提供资助的时间
    						RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo["user_id"]}","provide_current_id",$provideID);
    						//保存最近提供资助金额 provide_current_money
    						RedisLib::get_instance()->hset("sxh_userinfo:id:{$provideInfo["user_id"]}","provide_current_money",$provideInfo["money"]);
    					}
    					 
    					RedisLib::get_instance()->hsetUserinfoByID($match["other_user_id"],'provide_finish_num',$provide_create_num);
    				}
    				if(($accepthelpInfo->match_num -$accepthelpInfo->finish_count )  == 1
    						&& $accepthelpInfo->money == $accepthelpInfo->used) {
    					    if($accepthelpInfo->type_id == 1){
    								$provide_community_7_count = 	RedisLib::get_instance()->hgetUserinfoByID($accepthelpInfo->user_id,'provide_community_7_count');
    								$provide_community_7_count = empty($provide_community_7_count)?1:$provide_community_7_count+1;
    								RedisLib::get_instance()->hsetUserinfoByID($accepthelpInfo->user_id,'provide_community_7_count',($provide_community_7_count));
    								if($accepthelpInfo->type_id == 1){
    									if($accepthelpInfo->cid == 8){
    										RedisLib::get_instance()->hsetUserinfoByID($accepthelpInfo->user_id,"accepthelp8_finish_num",$accepthelp8_create_num);
    									}else{
    										RedisLib::get_instance()->hsetUserinfoByID($accepthelpInfo->user_id,"accepthelp_finish_num",$accepthelp_create_num);
    									}
    								}
    						 }
    				 }
    				 
    				 
    			RedisLib::get_instance()->exec();
    						
    			self::db()->commit();//提交事务
    			return true;
	
    			}else{
    				self::db()->rollback();
    				 return false;
    			}
    	 
	    	
        } catch (\Exception $ex) {
    
        	$this->rollback();
        	return false;
        }
    	
    }
    
    
    /**
     * 给商务中心返利 给引荐人返利
     * @param int $company_id 收返利的人的ID
     * @param int $money 金额
     * @param int $provide_id 挂单ID
     * @param int $provide_user_id 挂单用户ID
     * @param int $cat_id 匹配表ID
     * @param int $username 返利人的用户名
     * @param boolean $isBc 是否商务中心
     */
    public function setCompSuperiorEarnings($company_id,$money,$provide_id,$provide_user_id,$cat_id,$username,$isBc=false){
    	$accountModel      = \think\Loader::model('member/UserAccount', 'model');
    	$incomeModel       = \think\Loader::model('member/UserIncome', 'model');
    	$accountModel->startTrans();
    	if($isBc){
    		////商务中心处理
    		//$remap['UserID'] = $company_id;//收钱人
    		$arr['company_manage_wallet'] = array('exp', 'company_manage_wallet+' . $money);
    		//挂单金额的4%的二分之一，另一半变成【善金币】
    		$arr['invented_currency'] = array('exp', 'invented_currency+' . $money);
    		$res = $accountModel->partition(['id'=>$company_id] , 'id' , ['type'=>'id','expr'=>1000000])->where(["user_id"=>$company_id])->update($arr);
    		$incomeData = array(//企业管理钱包
    				"user_id"   =>$company_id,
    				"username"  => empty($username)?"NULL":$username,
    				"pid"       => $provide_id,
    				"type"      => 3,//善金币
    				"cat_id"    =>$cat_id,
    				"income"    =>$money,
    				"earnings"  =>$money,
    				"info"      =>"引荐企业挂单返善金币",
    				"create_time" => time(),
    		);
    		$res1 = $incomeModel->saveData($incomeData);
    		unset($incomeData);
    		$incomeData = array(
    				"user_id"   =>$company_id,
    				"username"  => empty($username)?"NULL":$username,
    				"pid"       => $provide_id,
    				"type"      => 13,//企业管理钱包
    				"cat_id"    =>$cat_id,
    				"income"    =>$money,
    				"earnings"  =>$money,
    				"info"      =>"引荐企业挂单返企业管理钱包",
    				"create_time" => time(),
    		);
    		$res2 = $incomeModel->saveData($incomeData);
    		unset($incomeData);
    	}else{
    		//判断是不是商务中心
    		//$remap['UserID'] = $company_id;//收钱人
    		$arr['company_manage_wallet'] = array('exp', 'company_manage_wallet+' . $money);
    		$res = $accountModel->partition(['id'=>$company_id] , 'id' , ['type'=>'id','expr'=>1000000])->where(["user_id"=>$company_id])->update($arr);
    		$incomeData = array(
    				"user_id"   =>$company_id,
    				"username"  => empty($username)?"NULL":$username,
    				"pid"       => $provide_id,
    				"type"      => 13,//企业管理钱包
    				"cat_id"    =>$cat_id,
    				"income"    =>$money,
    				"earnings"  =>$money,
    				"info"      =>"引荐企业挂单返企业管理钱包",
    				"create_time" => time(),
    		);
    		$res2 = $incomeModel->saveData($incomeData);
    		unset($incomeData);
    	}
    	 
    	if($isBc){
    		if($res &&$res1&& $res2){
    			$accountModel->commit();
    			return true;
    		}else{
    			$accountModel->rollback();
    			return false;
    		}
    	}else {
    		if($res && $res2){
    			$accountModel->commit();
    			return true;
    		}else{
    			$accountModel->rollback();
    			return false;
    		}
    	}
    }
    

    /**
     *
     * 修改匹配表
     * @author jwf
     * @param int $userId
     * @param array $data
     * @return boolean
     */
    public function updateMachthelpById($machtID,$data,$partition_time){
    	$this->get_month_submeter($partition_time);
    	return $this->partition($this->info , $this->info_field , $this->rule)
    	->where(["id"=>$machtID])->update($data);
    }
    
    
    public function  backActivateCurrency($matchInfo,$money){
    	$accountModel      = \think\Loader::model('member/UserAccount', 'model');
    	$incomeModel       = \think\Loader::model('member/UserIncome', 'model');
    	
    	$res = $accountModel->updateInventedCurrency($matchInfo["other_user_id"] , $money,["user_id"=>$matchInfo["other_user_id"]],1);
    	$accountModel->startTrans();
    	//返利（给提供资助人）
    	$incomeData = array(
    			"user_id"   => $matchInfo["other_user_id"],
    			"username"  => empty($matchInfo["other_username"])?"":$matchInfo["other_username"],
    			"pid"       =>$matchInfo["other_id"],
    			"type"      =>3,//善金币
    			"cat_id"    => $matchInfo["id"],
    			"income"    => $money,//一个善心币，返利100善金币
    			"info"      => "挂单返善金币",
    			"create_time"  => time(),
    	);
    	$incRes = $incomeModel->saveData($incomeData);
    	 
    	unset($incomeData);

    	if($res && $incRes){
    		$accountModel->commit();
    		return true;
    	}else{
    		$accountModel->rollback();
    		return false;
    	}
    }
    
    
    /**
     * 接单资助收益
     * @param type $match
     */
    protected function provide_order_earnings($match) {
         //个人返利点
        $rebate = ($match['other_money']*5*0.01);
       //钱包获得数量
        $wallet_num = $match['other_money']+$rebate;
      
        //更新钱包
       //出局钱包
       $wallet_arr['data']['order_taking']     = ['exp','order_taking+'.$wallet_num];
       //条件
       $wallet_arr['map']['user_id'] = $match['other_user_id'];
       //模型名称
       $wallet_arr['model_name'] = 'UserAccount';
       //更新钱包队列
       add_to_queue('user_wallet_edit',$wallet_arr);
       unset($wallet_arr);
       
        //收益接单钱包
       //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
       $this->set_income_log(6,$match['other_cid'],$match['other_user_id'],$wallet_num,$rebate,$match['other_id'],$match['id'],'收益接单钱包');       
                    
    }
    
    /**
     * 提供资助收益
     * @param type $match
     * @param type $community
     */
    protected function provide_earnings($match,$community) {
            //收益开始
            
            //先自己收益
             //个人返利点
              $rebate = ($match['other_money']*$community['rebate']*0.01);
             //钱包获得数量
              $wallet_num = $match['other_money']+$rebate;
              //更新钱包
              //更新钱包
             //出局钱包
             $wallet_arr['data'][$community['wallet_field']]     = ['exp',$community['wallet_field'].'+'.$wallet_num];
             //条件
            $wallet_arr['map']['user_id'] = $match['other_user_id'];
             //模型名称
             $wallet_arr['model_name'] = 'UserAccount';
             //更新钱包队列
             add_to_queue('user_wallet_edit',$wallet_arr);
             unset($wallet_arr);
             
             //收益出局钱包
            //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
              $this->set_income_log($community['wallet_status'],$match['other_cid'],$match['other_user_id'],$wallet_num,$rebate,$match['other_id'],$match['id'],'收益'.$community['name'].'钱包');       
                    
          
              //查看会员的关系
              $user_relation = model('member/UserRelation')->get_by_uid($match['other_user_id']);
              if(!empty($user_relation) && !empty($user_relation['url'])) {
                 $parents = explode(',', $user_relation['url']);
                 //排序
               //  ksort($parents);
                 //上一级收益
                if(!empty($parents[0]) && !empty($community['level1_rebate'])) {
                   // model('UserAccount')->update_by_uid($parents[0],$pid_wallet_arr);
                   // $user_wallet_result = model('member/UserAccount')->update_by_uid($match['other_user_id'],$wallet_arr);
                   
                    
                    //根据用户ID 取用户名
                    //管理奖收益
                    $pid_rebate = ($match['other_money']*$community['level1_rebate']*0.01)/2;
                    
                    //更新钱包 管理奖与善金币
                    unset($pid_wallet_arr);
                    //管理奖
                    $pid_wallet_arr['data']['manage_wallet']     = ['exp','manage_wallet+'.$pid_rebate];
                    //条件
                    $pid_wallet_arr['map']['user_id'] = $parents[0];
                    //善金币
                    $pid_wallet_arr['data']['invented_currency'] = ['exp','invented_currency+'.$pid_rebate];
                    //模型名称
                    $pid_wallet_arr['model_name'] = 'UserAccount';
                    //更新钱包队列
                     add_to_queue('user_wallet_edit',$pid_wallet_arr);
                     unset($pid_wallet_arr);
                     
                    //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
                    
                      $this->set_income_log(5,$match['other_cid'],$parents[0],$pid_rebate,$pid_rebate,$match['other_id'],$match['id'],'收益管理奖');
                    //收益善金币
                    //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
                    $this->set_income_log(3,$match['other_cid'],$parents[0],$pid_rebate,$pid_rebate,$match['other_id'],$match['id'],'收益善金币');
                   
                    //
                }
                //上三级收益
                if(!empty($parents[2]) && !empty($community['level3_rebate']) ) {
                    $ppid_rebate = ($match['other_money']*$community['level3_rebate']*0.01)/2;
                    
                     //更新钱包 管理奖与善金币
                     unset($pid_wallet_arr);
                    //管理奖
                    $pid_wallet_arr['data']['manage_wallet']     = ['exp','manage_wallet+'.$ppid_rebate];
                    //善金币
                    $pid_wallet_arr['data']['invented_currency'] = ['exp','invented_currency+'.$ppid_rebate];
                    //条件
                    $pid_wallet_arr['map']['user_id'] = $parents[2];
                    //模型名称
                    $pid_wallet_arr['model_name'] = 'UserAccount';
                    //更新钱包队列
                     add_to_queue('user_wallet_edit',$pid_wallet_arr);
                     unset($pid_wallet_arr);
                     
                    //管理奖收益
                    //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
                     $this->set_income_log(5,$match['other_cid'],$parents[2],$ppid_rebate,$ppid_rebate,$match['other_id'],$match['id'],'收益管理奖');
                    //收益善金币
                    //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
                    $this->set_income_log(3,$match['other_cid'],$parents[2],$ppid_rebate,$ppid_rebate,$match['other_id'],$match['id'],'收益善金币');
                }
                
                //上五级收益
                if(!empty($parents[4])  && !empty($community['level5_rebate']) ) {
                    $pppid_rebate = ($match['other_money']*$community['level5_rebate']*0.01)/2;
                    
                    //更新钱包 管理奖与善金币
                    unset($pid_wallet_arr);
                    //管理奖
                    $pid_wallet_arr['data']['manage_wallet']     = ['exp','manage_wallet+'.$pppid_rebate];
                    //善金币
                    $pid_wallet_arr['data']['invented_currency'] = ['exp','invented_currency+'.$pppid_rebate];
                    //条件
                    $pid_wallet_arr['map']['user_id'] = $parents[4];
                    //模型名称
                    $pid_wallet_arr['model_name'] = 'UserAccount';
                    //更新钱包队列
                     add_to_queue('user_wallet_edit',$pid_wallet_arr);
                     unset($pid_wallet_arr);
                     
                    //管理奖收益
                    //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
                    //加入队列
                     $this->set_income_log(5,$match['other_cid'],$parents[4],$pppid_rebate,$pppid_rebate,$match['other_id'],$match['id'],'收益管理奖');
                    
                    //收益善金币
                    //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
                    $this->set_income_log(3,$match['other_cid'],$parents[4],$pppid_rebate,$pppid_rebate,$match['other_id'],$match['id'],'收益善金币');
                }
              }
    }
    
    /**
     * 组装收入数据进入队列
     * @param type $type
     * @param type $cid
     * @param type $user_id
     * @param type $rebate
     * @param type $earnings
     * @param type $other_id
     * @param type $match_id
     * @param type $remark
     */
    protected function set_income_log($type,$cid,$user_id,$rebate,$earnings,$other_id,$match_id,$remark) {
         $redis = \org\RedisLib::get_instance('sxh_default');
        //取用户的账号
        $username = $redis->get('sxh_user:id:'.$user_id.'username');
        //收益类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
        $pid_arr['data']['type']          =  $type;
        //社区ID
        $pid_arr['data']['cid']           =  $cid;
        //受益人ID
        $pid_arr['data']['user_id']       =  $user_id;
        //受益人
        $pid_arr['data']['username']      =  $username;
        //收益总数量
        $pid_arr['data']['income']        =  $rebate;
        //收益提成
        $pid_arr['data']['earnings']      =  $earnings;
        //来源ID【provide表】
        $pid_arr['data']['pid']           =  $other_id;
        //来源ID【matchhelp表】
        $pid_arr['data']['cat_id']        =  $match_id;
        //描述
        $pid_arr['data']['info']          =  $remark;
        //创建时间
        $pid_arr['data']['create_time']   =  $_SERVER['REQUEST_TIME'];
        //数据状态  状态 1-删除 0-正常
        $pid_arr['data']['status']        =  0;
        
        $pid_arr['model_name']      = 'user_income';
        //加入队列
        add_to_queue('sxh_user_running_water',$pid_arr);
        unset($pid_arr);
        
        return true;
    }
    
    
    /** 添加管理金(jwf)
     */
    public function addManageWallet($money,$user_id,$actId,$provideID){
  
    	$userModel       = \think\Loader::model('member/User', 'model');
    	$incomeModel     = \think\Loader::model('member/UserIncome', 'model');
    	$accountModel     = \think\Loader::model('member/UserAccount', 'model');
    	$accountModel->startTrans();
    	
    	$p5Res = $accountModel->updateManageWallet($user_id , $money , ["user_id"=>$user_id],1);
    	
    	//获取P3的username
    	$p5Username = $userModel->get_by_id($user_id,"username");
    	//返利
    	$incomeData = array(
    			"user_id"   => $user_id,
    			"username"  => $p5Username,
    			"pid"       =>$provideID,
    			"type"      => 5,//管理钱包
    			"cat_id"    => $actId,
    			"income"    => $money,//
    			"info"      => "管理钱包",
    			"create_time"  => time(),
    	);
    	$p5IncRes = $incomeModel->saveData($incomeData);
    	 
    	if($p5Res && $p5IncRes){
    		$accountModel->commit();
    		return true;
    	}else{
    		$accountModel->rollback();
    		return false;
    	}
    }
    
    /** 添加善金币
     */
    public function addInventedCurrency($money,$user_id,$actId,$provideID){
    	$userModel       = \think\Loader::model('member/User', 'model');
    	$incomeModel     = \think\Loader::model('member/UserIncome', 'model');
    	$accountModel     = \think\Loader::model('member/UserAccount', 'model');
    	
    	//开启事务
    	$accountModel->startTrans();
    	
    	$p5Res = $accountModel->updateInventedCurrency($user_id , $money,["user_id"=>$user_id],1);//
    	 
    	//获取P3的username
    	$p5Username = $userModel->get_by_id($user_id,"username");
    	 
    	//返利
    	$incomeData = array(
    			"user_id"   => $user_id,
    			"username"  => $p5Username,
    			"type"      => 3,//3善金币
    			"cat_id"    => $actId,
    			"income"    => $money,//一个善心币，返利100善金币
    			"info"      => "善金币",
    			"create_time"  => time(),
    	);
    	
    
    	 
    	$p5IncRes = $incomeModel->saveData($incomeData);
    	if($p5Res && $p5IncRes){
    		$accountModel->commit();
    		return true;
    	}else{
    		$accountModel->rollback();
    		return false;
    	}
    }
    
    //更新表 provide  accepthelp
    public function updateTableStatus($provideInfo,$acceptHelpInfo,$matchInfo){
 
    	$provideModel       = \think\Loader::model('UserProvide', 'model');
    	$accepthelpModel    = \think\Loader::model('UserAccepthelp', 'model');
    	$update_accepthlep  = '';
    	$update_provide     = '';
    	$provideModel->startTrans();
        try {	
    	     if(($acceptHelpInfo->match_num -$acceptHelpInfo->finish_count )  == 1 && $acceptHelpInfo->money == $acceptHelpInfo->used) {
    				$pmap = array(
    						"id" => $matchInfo['pid'],
    						"user_id" => $matchInfo["user_id"],
    				);
    				$pWhere = array(
    						"status"  => 3,
    						'finish_count' => ($acceptHelpInfo->finish_count+1),
    						"sign_time" => time(),
    						"update_time" => time()
    				);
 	         }else{ 
    				$pmap = array(
    						"id" => $matchInfo['pid'],
    						"user_id" => $matchInfo["user_id"],
    				);
    				$pWhere =[
    				"finish_count" => ($acceptHelpInfo->finish_count+1)
    				]; 
    		  }
    		 //更新acceptHelp
    		 $update_accepthlep = $accepthelpModel->updateAccepthelpByData($pmap,$pWhere,$matchInfo['accepthelp_create_time']);
    	  
    		 //添加确认收款笔数
    		 if(($provideInfo->match_num-$provideInfo->finish_count) == 1 && $provideInfo->money == $provideInfo->used){
    			 //更新状态
    			 $pmap = array(
    				 "id" => $matchInfo['other_id'],
    				 "user_id" => $matchInfo["other_user_id"],
    			 );
    			 $pdata = array(
    				 "status"  => 3,
    				 "sign_time" => time(),
    				 "update_time" => time(),
    				 "finish_count" => ($provideInfo->finish_count+1)
    			 );
    				
    			}else{
    				$pmap = array(
    						"id" => $matchInfo['other_id'],
    						"user_id" => $matchInfo["other_user_id"],
    				);
    				$pdata = [
    				"finish_count" => ($provideInfo->finish_count+1)
    				];
    				 
    			}
    			$update_provide = $provideModel->updateProvideByData($pmap,$pdata,$matchInfo['provide_create_time']);
    			 
    			if($update_accepthlep && $update_provide){
    				$provideModel->commit();
    				return true;
    			}else{

    				$provideModel->rollback();
    				return false;
    			}
       }catch (\Exception $ex){
     	 
     	$provideModel->rollback();
     	return false;
       }
   }
   
   public function limit($page,$limit){
   	$page = empty($page)?0:$page-1;
   	$statPage = $page * $limit;
   	return " limit " . $statPage . "," . $limit;
   }
   
   public function order($order){
   	return "ORDER BY $order";
   }
   
   /** 查询小康次数<从现在表查到用户注册时的季度表>
    * @param   $user_id    打款用户id
    * @param   $user_create_time   用户创建时间
    * @param   $historyTime    不用传
    * @param   $count          不用传
    */
   public function getCommunityProvideCount($user_id , $user_create_time , $historyTime=0 , $count=0){
   	$where = "user_id=".$user_id." AND cid=3 AND status=3 AND type_id=1 AND flag=0";
   	$field = "id";
   	$result = 0;

   	if(empty($historyTime)){
   		$historyTime=time();
   	}else{
   		$historyTime = strtotime("-3 month", $historyTime);
   	}
   	//获取转入时间当前季度的最开始的时间
   	$_historyTime = getQuarterLowTime($historyTime);
   	$_userCreateTime = getQuarterLowTime($user_create_time);
   	$startTime = 1451577600;//2016
   	//取传过来值的下一季度表名
   	if($_historyTime >= $_userCreateTime && $_historyTime >= $startTime) {   		
   		$tableName = "user_provide_".getTimeTableName($historyTime);
   		$result = db($tableName)->where($where)->field($field)->count();
   	}
   	$count += $result;
   	if($count<5 && ($_historyTime > $_userCreateTime && $_historyTime > $startTime)){
   		$count = $this->getCommunityProvideCount($user_id , $user_create_time , $historyTime , $count);
   	}
   	return $count;
   }

}
