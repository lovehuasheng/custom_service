<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【匹配详情】业务逻辑层
// +----------------------------------------------------------------------


namespace app\business\logic;

use app\common\logic\Base;

class Matching extends Base {
    /**
     * 列表数据
     * @return type
     */
    public function get_list(&$data) { 
        
    	$partition_time = $_SERVER['REQUEST_TIME'];
    	
    	//季度,季度年
    	$jd_year = isset($data['year']) ? $data['year'] : date("Y",time());
    	if(isset($data['quarter']) && !empty($data['quarter'])){
    		$quarter = $data['quarter'];
    		switch ($quarter) {
    			case 1:
    				$partition_time =  strtotime("$jd_year-02-01");
    				break;
    			case 2:
    				$partition_time =  strtotime("$jd_year-05-01");
    				break;
    			case 3:
    				$partition_time =  strtotime("$jd_year-08-01");
    				break;
    			case 4:
    				$partition_time =  strtotime("$jd_year-11-01");
    				break;
    		}
    	}
    	
    	
        //状态判断
        if(isset($data['status']) && $data['status'] == 2) {
            $map['status'] = $data['status'];
        }else {
            $map['status'] = ['in',[1,2]];
        }
        $map['flag'] = 0;
         //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 1;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');
        //组装搜索条件
        //分配查询条件
        if(!empty($data['search_type']) && !empty($data['search_name'])) {
              //校验关键词是否为空
           
            //分配查询条件
            switch ($data['search_type']) {
                   case 1:
                       //提供资助订单ID
                       $map['other_id'] = $data['search_name'];
                       break;
                   case 2:
                       //提供人ID
                       $map['other_user_id'] = $data['search_name'];
                       break;
                   case 3:
                       //接受资助订单ID
                       $map['pid'] = $data['search_name'];
                       break;
                   case 4:
                       //接受人ID
                       $map['user_id'] = $data['search_name'];
                       break;
            }
        }
        
        
        //搜索时间
        if( isset($data['search_date'])  && !empty($data['search_date'])) {
            $start_time = strtotime(date('Y-m-d 00:00:00',strtotime($data['search_date'])));
            $end_time = strtotime(date('Y-m-d 23:59:59',strtotime($data['search_date'])));
            
            $map['create_time'] = ['between',[$start_time,$end_time]];
        }
       
        //分表
      //  $partition_time = (isset($data['search_date'])  && !empty($data['search_date'])) ? strtotime($data['search_date']):$_SERVER['REQUEST_TIME'];
        //实例化模型
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //获取满足条件的记录总数
        $total = $model->get_total_count($map,$partition_time,1);
  
         
        //取值字段
        $field = ['id','other_username','other_name','other_user_id','other_id','status','provide_money','pid','user_id','username','name','money','other_money','pay_image','create_time','flag','type_id as sign_text','delayed_time_status as status_text','sms_status as flag_text','expiration_create_time','audit_time','remark'];
  
        //取值
        $result_list = $model->get_new_overtime_order_list($map,$partition_time,$page,$per_page,$field);
        //获取页码列表
        $pages = get_pagination($total, $page, $per_page, $page_list);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data' => $result_list,
            'pages' => $pages
        ];
        
        return $this->result;
 
    }
    
    /**
     * 删除匹配订单 还原订单
     * @param type $status
     * @param type $ids
     * @param type $user_id
     * @return type
     */
    public function destroy_match(&$data,$user_info) {
        //组装条件
        //匹配表ID
        $map['id']       = $data['id'];
        //分表规则 匹配时间
        $partition_time = strtotime(str_replace('上午', '', str_replace('下午', '', $data['match_times'])));
        //实例化
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //取值字段
        $field = ['id','pid','other_id','other_money','other_user_id','other_username','other_name','status','flag','accepthelp_create_time','provide_create_time'];
        //取值
        $match = $model->get_match_info($map,$partition_time,$field);
        //返回空值
        if(empty($match)){
            //返回结果
            $this->error_code = '-10016';
            $this->error_msg = '匹配数据错误!';
            $this->body = [];

            return $this->result;
           
        }
        //数据状态为删除时，返回错误 0-正常 2-删除
        if($match['flag'] == 2) {
            //返回结果
            $this->error_code = '-10017';
            $this->error_msg = '此数据已删除过了!';
            $this->body = [];

            return $this->result;
        }
        //查看订单是否已付款  0-已匹配 1-已审核 2-已付款 3-已收款
        if($match['status'] > 1) {
            //返回结果
            $this->error_code = '-10018';
            $this->error_msg = '此订单已付款或已完成了!';
            $this->body = [];

            return $this->result;
        }
        
        //匹配金额
        $data['other_money'] = $match['other_money'];
        $data['provide_id'] = $match['other_id'];
        $data['accept_id'] = $match['pid'];
        $data['accepthelp_create_time'] = $match['accepthelp_create_time'];
        $data['provide_create_time'] = $match['provide_create_time'];
        //删除状态
        $param['flag'] = 2;
      
        //更新数据
        $result_list = $model->destroy_match_data($data,$partition_time,$param);
       
        if(!$result_list) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '删除失败!';
            $this->body = [];

            return $this->result;
        }

        //1-加入手动匹配 2-否
        if($data['type'] == 1) {
             $arr = [];
            //查看手动匹配列表数据session中是否存的提供资助id
            $tmp = session('set_manual_match_provide_'.$user_info['id']);
           
            if(!empty($tmp)) {
                $tmp = unserialize($tmp);
                $arr['ids']  =  $ids = $tmp['ids'];
                $arr['ids'][count($ids)]  = $match['other_id'];
                $arr['table']             = $tmp['table'];
            }else {
                $arr['ids'][] = $match['other_id'];
            }
      
            //把提供资助的数据id加入session中 
            session('set_manual_match_provide_'.$user_info['id'],  serialize($arr));
            unset($ids);
            unset($arr);
            
             $arr = [];
            //查看手动匹配列表数据session中是否存的提供资助id
            $tmp = session('set_manual_match_accept_'.$user_info['id']);
            if(!empty($tmp)) {
                $tmp = unserialize($tmp);
                $arr['ids']  =  $ids = $tmp['ids'];
                $arr['ids'][count($ids)]  = $match['pid'];
                $arr['table']             = $tmp['table'];
            }else {
                $arr[] = $match['pid'];
            }
            //把提供资助的数据id加入session中 
            session('set_manual_match_accept_'.$user_info['id'],  serialize($arr));
        }
        
        unset($data);
         //写入操作日志
         //实例化redis
     
        //记录操作日志
        $msg = '修改提供资助订单状态为删除【匹配ID:'. $match['id'] .',提供资助ID:'.$match['other_id'].',接受资助ID：'.$match['pid'].'】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 3;
        $log['data']['remark']                  = get_log_type_text(3,$msg,'business/matching/destroy_match');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
       //加入队列
        add_to_queue('',$log);
        
        //取消写入日志
        $destroy_log['data']['provide_id']       = $match['id'];
        $destroy_log['data']['user_id']          = $match['other_user_id'];
        $destroy_log['data']['username']         = $match['other_username'];
        //1-取消订单 2-撤销假图 3-还原订单
        $destroy_log['data']['type']             = 3;
        $destroy_log['data']['operator_id']      = $user_info['id'];
        $destroy_log['data']['operator_name']    = $user_info['username'];
        $destroy_log['data']['create_time']      = $_SERVER['REQUEST_TIME'];
        $destroy_log['model_name']               = 'DestroyProvide';
        add_to_queue('sxh_user_blacklist',$destroy_log);
        
        
        unset($log);
        unset($match);
        unset($user_info);
        
       //返回结果
        $this->error_code = '0';
        $this->error_msg = '操作成功!';
        $this->body = [];

        return $this->result;    
    }
   
   
    
    /**
     * 订单延时【测试通过】
     * @param array $data
     * @param type $user_id
     * @return type
     */
    public function delayed_match(&$data,$user_info) {
        //匹配表id
        if(! is_array($data['ids'])) {
            $data['ids']      = array($data['ids']);
        } 
        
        if(! is_array($data['matchhelp_time'])) {
        	$data['matchhelp_time']      = array($data['matchhelp_time']);
        }
        $error_math    = array();
        $result_error  = array();  
        //实例化模型
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //取值字段
        $field = ['id','pid','other_id','other_user_id','other_username','other_name','other_money','status','flag','create_time','expiration_create_time','pay_time','audit_time','delayed_time_status'];
 
        if($data['ids'] && is_array($data['ids'])){
        	
        	foreach ($data['ids'] as $k=>$id){
        		$partition_time = $data['matchhelp_time'][$k];
        		 
        		//取值
        		$map['id'] = $id;
        		$delayed_time = empty($data['delayed_time']) ? 0 :(intval($data['delayed_time'])*3600);
        	 
        		$match = $model->get_match_by_time($map,$partition_time,$field);
        		$match = get_array_to_object($match);
        		if($match){        			
        			//更新数据
        			//计算延时
        			//如果还没超时，就让expiration_create_time 加上延时时间
        			$time= time();
 
        			if(intval($match['audit_time']) + config('matchhelp_pay_time') >$time){
        				$param['expiration_create_time'] = intval($match['audit_time']) + config('matchhelp_pay_time') + intval($delayed_time);
        				$param['delayed_time_status'] = 1;
        			}else {
        			    $param['expiration_create_time'] = intval($time) + intval($delayed_time);
        			    $param['delayed_time_status'] = 1;
        			}
        			
        			if($match['delayed_time_status'] > 1) {
        				$param['expiration_create_time']=$match['expiration_create_time'];
        				$param['delayed_time_status'] = 0;
        			}

        			$result_list = $model->new_delayed_match($map,$partition_time,$param);
        			if($result_list){        				
        				
        				//记录操作日志
        				$msg =  '延时了匹配订单的打款时间'.$data['delayed_time'].'小时；【匹配ID:'. implode(',', array_unique(array_column($match, 'id'))) .',提供资助ID:'.implode(',', array_unique(array_column($match, 'other_id'))) .',接受资助ID：'.implode(',', array_unique(array_column($match, 'pid'))).'】';
        				$log['data']['uid']                     = $user_info['id'];
        				$log['data']['username']                = $user_info['username'];
        				$log['data']['realname']                = $user_info['realname'];
        				$log['data']['type']                    = 1;
        				$log['data']['remark']                  = get_log_type_text(1,$msg,'business/matching/delayed_match');
        				$log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        				$log['model_name']                      = 'SysUserLog';
        				//加入队列
        				add_to_queue('',$log);
        				
        				//取消写入日志
        				$destroy_log['data']['provide_id']       = $match['id'];
        				$destroy_log['data']['user_id']          = $match['other_user_id'];
        				$destroy_log['data']['username']         = $match['other_username'];
        				//1-取消订单 2-撤销假图 3-还原订单4-订单延时
        				$destroy_log['data']['type']             = 3;
        				$destroy_log['data']['operator_id']      = $user_info['id'];
        				$destroy_log['data']['operator_name']    = $user_info['username'];
        				$destroy_log['data']['create_time']      = $_SERVER['REQUEST_TIME'];
        				$destroy_log['model_name']               = 'DestroyProvide';
        				add_to_queue('sxh_user_blacklist',$destroy_log);

        			}else{
        				$result_error[] = $id; 
        				
        			}
        			
        		}else{
        			$error_math[]   = $id;
        		}
        	}
        }
        
        
        $this->error_msg = " 延时成功!";
        if(isset($error_math) || isset($result_error) ){
        	if($error_math){
        		$this->error_msg = $error_math.'匹配数据错误';
        	}
        	if($result_error){
        		$this->error_msg .=$result_error.'延时失败';
        	}
        }
        
        //返回结果
        $this->error_code = '0';       
        $this->body = $error_math;
        unset($data);
        return $this->result;
 
    }
    
    
    /**
     * 超时订单列表【测试通过】
     * @param type $data
     * @return type
     */
    public function overtime_order_list(&$data) {

        //数据状态
        $map['flag'] = ['in',[0,1]];
         
        
        $partition_time = $_SERVER['REQUEST_TIME'];
        
        //季度,季度年
        $jd_year = isset($data['year']) ? $data['year'] : date("Y",time());
        if(isset($data['quarter']) && !empty($data['quarter'])){
        	$quarter = $data['quarter'];
        	switch ($quarter) {
        		case 1:
        			$partition_time =  strtotime("$jd_year-02-01");
        			break;
        		case 2:
        			$partition_time =  strtotime("$jd_year-05-01");
        			break;
        		case 3:
        			$partition_time =  strtotime("$jd_year-08-01");
        			break;
        		case 4:
        			$partition_time =  strtotime("$jd_year-11-01");
        			break;
        	}
        } 
        
 
        //取昨天的时间戳 也就是超时前的时间戳
        $yesterday = $_SERVER['REQUEST_TIME'];
        $map['status'] = 1;
        switch ($data['type']) {
 
            case 1://打款超时
             
               //审核状态
               $map['status'] = 1;
               // 
               $order = 'audit_time asc,other_id desc';
               break;
               
               
            case 2://收款超时
                //打款时间
            	$yesterday         = $yesterday-config ( 'matchhelp_out_time' );
                $map['pay_time']   =   ['lt',$yesterday];
                //打款状态
                $map['status'] = 2;
                //收款排序字段
                $order = 'pay_time asc,other_id desc';
                break;
           
        }
        
        //搜索关键词
        //@param search_type 1-提供资助订单ID，2-提供人ID，3-接受资助订单ID，4-接受人ID
        if(isset($data['search_type'])) {
            //校验关键词是否为空
            if( ! empty($data['search_name'])) {             
          
            //分配查询条件
            switch ($data['search_type']) {
                   case 1:
                       //提供资助订单ID
                       $map['other_id'] = $data['search_name'];
                       break;
                   case 2:
                       //提供人ID
                       $map['other_user_id'] = $data['search_name'];
                       break;
                   case 3:
                       //接受资助订单ID
                       $map['pid'] = $data['search_name'];
                       break;
                   case 4:
                       //接受人ID
                       $map['user_id'] = $data['search_name'];
                       break;
            }
          }
        }
        
       
        //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 1;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');
       
        //实例化模型
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //获取满足条件的记录总数
 
        $total = $model->get_total_count($map,$partition_time,1);
  
        //取值字段
        $field = ['id','pid','user_id','username','name','money','other_id','other_user_id','other_username','other_name','status','provide_money','other_money','create_time','handlers as pay_time_text','pay_time','expiration_create_time','ip_address as sign_time_text','audit_time','remark','delayed_time_status as status_text'];
        //取值
        $result_list = $model->get_new_overtime_order_list($map,$partition_time,$page,$per_page,$field,$order);
  
 
        //获取页码列表
        $pages = get_pagination($total, $page, $per_page, $page_list);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data' => $result_list,
            'pages' => $pages
        ];

        return $this->result;

    }
    
   
    
    
    /**
     * 转移订单到接单人
     * @return type
     */
    public function transfer_order_to_user(&$data,&$user_info) {
    	
    	//先判断是否 为 部分匹配单,是的话,提示
    	$where['other_id']        = $data['other_id'];
    	$where['flag']            = ['in',[0,1]];
    	$where['status']          = 1;
    	$partition_time           = $data['create_time'];
   
        //组装条件
          //匹配数据ID
        if(is_array($data['ids'])) {
            $this->error_code = '-10039';
            $this->error_msg = '请勿批量操作!';
            $this->body = [];
            return $this->result;
            //$map['id'] = ['in',$data['ids']];/*暂时不允许批量操作*/
            //$count = count($data['ids']);/*暂时不允许批量操作*/
        }else {
            //$map['id'] = $data['ids'];/*源程序*/
            $id_createtime      = explode('|',$data['ids']);
            $map['id']          = $id_createtime[0]; 
            //$map['create_time'] = $id_createtime[1]; 
            $count = 1;
        }
        
     //--------------判断转接单是否为部分匹配--------------------   
        //实例化模型
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //获取满足条件的记录总数
         
        //取值字段
        $field = ['id','provide_money','other_money','other_user_id','other_id','audit_time','delayed_time_status','expiration_create_time'];
        
        //取值
        $match = $model->get_data_list($where,$partition_time,$field);
        
        $yesterday = $_SERVER['REQUEST_TIME'];
        $result_list = 0;
        if($match){
        	$other_money = 0;
        	 
        	foreach ($match as $key=>$val){
        		if($val['delayed_time_status'] == 0) {
        				
        			if(intval(config('matchhelp_out_time') + $val['audit_time']) < intval(time())){
        				$other_money  = intval($other_money) +	intval($val['other_money']);
        			}
        				
        		}else{
        			if(intval($val['expiration_create_time']) < intval(time())) {
        				$other_money  = intval($other_money) +	intval($val['other_money']);
        			}
        		}
        	}
        	 
        	$provide_money = $val['provide_money'];
        	 
        	if($provide_money != $other_money){
        		$result_list = 1;
        	}
        }
        
        if($result_list == 1){
        	//返回结果
        	$this->error_code = '-10020';
        	$this->error_msg = '订单未全部超时或已部分打款!';
        	$this->body = [];
        	return $this->result;
        }
        //--------------判断部分匹配结束---------------
  
        //数据状态
        $map['flag'] = 0;
        //取值字段
        $field = ['id','pid','user_id','username','name','other_id','other_user_id','other_username','other_name','status','other_money','provide_create_time'];
        //分表时间  
        //$partition_time = ($_SERVER['REQUEST_TIME'] - config('matchhelp_out_time'));/*源程序代码，觉得此处有点问题*/
        $partition_time = $id_createtime[1];/*分表的时间必须根据记录的创建时间，而不能单纯的认为是本季度*/
        //取值
        //实例化模型
        $model = \think\Loader::model('UserMatchhelp', 'model');
        $match = $model->get_list($map,$partition_time,1,$count,$field);
        unset($map);
        unset($field);
        //为空时，返回错误
        if(empty($match)) {
            //返回结果
            $this->error_code = '-10016';
            $this->error_msg = '匹配数据错误,不存在!';
            $this->body = [];
            return $this->result;     
        }
        if($match[0]['status']>=2){
            $this->error_code = '-10016';
            $this->error_msg = '此单已经打款，不能转接单操作!';
            $this->body = [];
            return $this->result;     
        }
        //查看提供资助是否已打款
        //组装条件
        $match = get_array_to_object($match);
        //数据状态
        $provide_map['flag'] = 0;
        //接受资助ID
        $otherids = array_unique(array_column($match, 'other_id'));
        $other_user_ids = array_unique(array_column($match, 'other_user_id'));
        $provide_map['id'] = ['in',$otherids];
        $provide_field = ['id','status'];
        $provide = model('UserProvide')->get_provide_info($provide_map,$match[0]['provide_create_time'],$provide_field);
        //为空时，返回错误
        if(empty($provide)) {
            //返回结果
            $this->error_code = '-10037';
            $this->error_msg = '提供资助数据错误,不存在!';
            $this->body = [];
            return $this->result;     
        }
        //取所以的提供资助中的支付状态
         $status_ids = array_unique(array_column($provide, 'status'));
        //判断是否已付款
        if(in_array(2,$status_ids)) {
            //返回结果
            $this->error_code = '-10038';
            $this->error_msg = '卡哇伊，此提供资助订单已有付款订单了，需要超级管理员权限的皮卡丘!';
            $this->body = [];
            return $this->result;  
        }
        unset($provide_field);
        unset($provide_map);
        unset($provide);
        //取用户
        $redis = \org\RedisLib::get_instance('sxh_default');
        $other_user_id = $redis->get('sxh_user:username:'.$data['other_username'].':id');
        if(empty($other_user_id)) {
            //返回结果
            $this->error_code = '-10039';
            $this->error_msg = '信息错误,会员不存在!';
            $this->body = [];
            return $this->result;
        }
        //查看用户是否正常
        $field = ['status','verify','username','name'];
        $user =  model('member/UserInfo')->get_by_uid($other_user_id,$field);
        if(! $user){
            $field = ['status','verify','username','company_name as name'];
            $user =  model('member/CompanyInfo')->get_by_uid($other_user_id,$field);
        }
        $user = get_array_to_object($user);
        if(empty($user)) {
            //返回结果
            $this->error_code = '-10039';
            $this->error_msg = '会员信息错误!';
            $this->body = [];
            return $this->result;
        }
        //验证用户状态
        if($user['status'] != 1) {
            //返回结果
            $this->error_code = '-10040';
            $this->error_msg = '新会员账号已禁用!';
            $this->body = [];
            return $this->result;
        }
         //验证用户审核状态
        if($user['verify'] != 2) {
            //返回结果
            $this->error_code = '-10040';
            $this->error_msg = '新会员账号未通过审核!';
            $this->body = [];
            return $this->result;
        }
        $data['other_user_id']  = $other_user_id;
        $data['other_name']     = $user['name'];
        $data['other_username'] = $user['username'];
        unset($user);
        //转接单逻辑
        $result = $model->transfer_order_to_user($data,$match,$user_info,$partition_time);
        //销毁变量
        unset($data);
        unset($user_info);
        if(!$result) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '转单失败!';
            $this->body = [];

            return $this->result;
        }
        
          //成功后,把原来的提供资助的挂单redis 去掉provide_create_num=provide_finish_num
       if($other_user_ids && is_array($other_user_ids)){
	       	foreach ($other_user_ids as $id){
	          $redis->hmset("sxh_userinfo:id:{$id}",array("provide_finish_num"=>1,'provide_create_num'=>1));
	       	}
       }

        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [];

        return $this->result;
    }
    
    
    /**
     * 撤销假图
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function undo_img(&$data,&$user_info) {
        //组装条件
        //匹配表ID
        $map['id']       = $data['id'];
        //分表规则 匹配时间
        $partition_time = strtotime(str_replace('上午', '', str_replace('下午', '', $data['match_times'])));
        //实例化
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //取值字段
        $field = ['id','pid','other_id','other_money','user_id','other_user_id','other_username','other_name','status','flag','provide_create_time','accepthelp_create_time'];
        //取值
        $match = $model->get_match_info($map,$partition_time,$field);
        //返回空值
        if(empty($match)){
            //返回结果
            $this->error_code = '-10016';
            $this->error_msg = '匹配数据错误!';
            $this->body = [];

            return $this->result;
           
        }
        //数据状态为删除时，返回错误 0-正常 2-删除
        if($match['flag'] == 2) {
            //返回结果
            $this->error_code = '-10017';
            $this->error_msg = '此数据已删除!';
            $this->body = [];

            return $this->result;
        }
        //查看订单是否已付款  0-已匹配 1-已审核 2-已付款 3-已收款
        if($match['status'] < 2) {
            //返回结果
            $this->error_code = '-10017';
            $this->error_msg = '此订单未付款!';
            $this->body = [];

            return $this->result;
        }
        //撤销假图后  更新三个表的关系
        $provideModel  = \think\Loader::model("UserProvide");
        $acceptModel   = \think\Loader::model("UserAccepthelp");
    
        $accept_id     = $match['pid'];
        
        $provide_id    = $match['other_id'];
        
        $provide_time         = $match['provide_create_time'];
        $accepthelp_time      = $match['accepthelp_create_time'];
        
        //打款人退回
        $provideData = array(
        		"pay_num"      => array('exp', 'pay_num-1'),
        		"update_time"  => time(),
        		"status"       =>1,
        );
        
        //受助 退回
        $acceptData = array(
        		"pay_num"      => array('exp', 'pay_num-1'),
        		"update_time"  => time(),
        		"status"       =>1,
        );
        
       $model::startTrans();
        try{
        	$match_result       = $model->undo_img($data,$partition_time);
        	$accept_result      =  $acceptModel->updateAccepthelp($accept_id,$acceptData,$accepthelp_time);
        	$provide_result     =  $provideModel->updateProvideById($provide_id,$provideData,$provide_time);
 
        	if ($accept_result && $match_result && $provide_result) {
        		$model::commit();
        		$result = true;
        	} else {
        		$model::rollback();
        		$result =  false;
        	}
        	
        } catch (\Exception $e) {
        	\think\Log::error($e->getMessage());
        	$model::rollback();
        	$result =  false;
        }
        
       
        if(!$result) {
            $this->error_code = '-10018';
            $this->error_msg = '撤销假图失败!';
            $this->body = [];

            return $this->result;
        }
        
         //写入操作日志

        //记录操作日志
        $msg = '修改匹配订单为未付款【匹配ID:'. $match['id'] .'】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg,'business/matching/undo_img');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        add_to_queue(config('log_queue'),$log,'default');
       
          //取消写入日志
        $destroy_log['data']['provide_id']       = $match['id'];
        $destroy_log['data']['user_id']          = $match['other_user_id'];
        $destroy_log['data']['username']         = $match['other_username'];
        //1-取消订单 2-撤销假图
        $destroy_log['data']['type']             = 2;
        $destroy_log['data']['operator_id']      = $user_info['id'];
        $destroy_log['data']['operator_name']    = $user_info['username'];
        $destroy_log['data']['create_time']      = $_SERVER['REQUEST_TIME'];
        $destroy_log['model_name']               = 'DestroyProvide';
        add_to_queue('sxh_user_blacklist',$destroy_log);
       
        
  
         //返回结果
        $this->error_code = '0';
        $this->error_msg = '撤销假图成功!';
        $this->body = [];

        return $this->result;
    }
    
    
    
    /**
     * 撤单封号
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function disable_no(&$data,&$user_info) {
        //组装条件
        //匹配表ID
        $map['id']       = $data['id'];
        //分表规则 匹配时间
        $partition_time = strtotime($data['match_times']);
        //实例化
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //取值字段
        $field = ['id','pid','cid','user_id','username','name','other_id','other_user_id','other_username','other_name','other_money','status','flag','provide_create_time','accepthelp_create_time'];
        //取值
        $match = $model->get_match_info($map,$partition_time,$field);
        //返回空值
        if(empty($match)){
            //返回结果
            $this->error_code = '-10016';
            $this->error_msg = '匹配数据错误!';
            $this->body = [];

            return $this->result;
           
        }
        //数据状态为删除时，返回错误 0-正常 2-删除
        if($match['flag'] == 2) {
            //返回结果
            $this->error_code = '-10017';
            $this->error_msg = '此数据已删除!';
            $this->body = [];

            return $this->result;
        }
        //查看订单是否已付款  0-已匹配 1-已审核 2-已付款 3-已收款
//        if($match['status'] > 1) {
//            //返回结果
//            $this->error_code = '-10018';
//            $this->error_msg = '此订单已付款!';
//            $this->body = [];
//
//            return $this->result;
//        }
        //1-提供人封号  2-接受人封号
        //如果包含1，2时 提供人、接受人都封号
        if(in_array('1',$data['flags']) && in_array('2',$data['flags'])) {

        }
        //如果包含1时 提供人封号
        else if(in_array('1', $data['flags'])) {
            $result = $model->provide_disable_no($data,$match['provide_create_time'],$match,$user_info);
        	$disable_uid       = $match['other_user_id'];
        	$disable_username  = $match['other_username'];
        }
        //如果包含2时 接受人封号
        else if(in_array('2', $data['flags'])) {
             $result = $model->accept_disable_no($data,$match['accepthelp_create_time'],$match,$user_info);
 
             $disable_uid      = $match['user_id'];
             $disable_username = $match['username'];
        }
//        if($data['flag'] == 1) {
//            $result = $model->provide_disable_no($data,$match['provide_create_time'],$match,$user_info);
//            $disable_uid = $match['other_user_id'];
//            $disable_username = $match['other_username'];
//            
//            //同步
//            //加入手动匹配
//            //1-加入手动匹配 2-否
//            if($data['type'] == 1) {
//                //提供人封号
//            }
//        }else {
//            $result = $model->accept_disable_no($data,$match['accepthelp_create_time'],$match,$user_info);
//            $disable_uid = $match['user_id'];
//            $disable_username = $match['username'];
//        }
 
        if(!$result) {
            $this->error_code = '-1001';
            $this->error_msg = '撤单封号失败!';
            $this->body = [];

            return $this->result;
        }
        
         //写入操作日志
         //记录操作日志
        $msg = '修改匹配订单为已删除【匹配ID:'. $match['id'] .'】 ，用户ID:'.$disable_uid.',用户：'.$disable_username.' 并封号';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 3;
        $log['data']['remark']                  = get_log_type_text(1,$msg,'business/matching/disable_no');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        add_to_queue(config('log_queue'),$log);
       
        //加入手动匹配
        //1-加入手动匹配 2-否
        if($data['type'] == 1) {
             $arr = [];
            //查看手动匹配列表数据session中是否存的提供资助id
            $tmp = session('set_manual_match_provide_'.$user_info['id']);
            if(!empty($tmp)) {
                $ids = unserialize($tmp);
                $ids[count($ids)]['id']  = $match['other_id'];
                $ids[count($ids)]['partition_time']  = $partition_time;
            }else {
                $arr[]['id'] = $match['other_id'];
                $arr[]['partition_time'] = $partition_time;
            }
            //把提供资助的数据id加入session中 
            session('set_manual_match_provide_'.$user_info['id'],  serialize($arr));
            unset($ids);
            
             $arr = [];
            //查看手动匹配列表数据session中是否存的提供资助id
            $tmp = session('set_manual_match_accept_'.$user_info['id']);
            if(!empty($tmp)) {
                $ids = unserialize($tmp);
                $ids[count($ids)]['id']  = $match['pid'];
                $ids[count($ids)]['partition_time']  = $partition_time;
            }else {
                $arr[]['id'] = $match['pid'];
                $arr[]['partition_time'] = $partition_time;
            }
            //把提供资助的数据id加入session中 
            session('set_manual_match_accept_'.$user_info['id'],  serialize($arr));
        }
        
        
         //返回结果
        $this->error_code = '0';
        $this->error_msg = '撤单封号成功!';
        $this->body = [];

        return $this->result;
    }
    
    
    /**
     * 手动匹配列表
     * @param type $user_info
     * @return type
     */
    public function get_manal_match_list($user_info) {
        
        $provide_list = [];
        $accept_list  = [];
        $field = 'id,user_id,username,name,name,money,used,(money-used) as match_money,create_time';
        //提供资助
        $provide = session('set_manual_match_provide_'.$user_info['id']); 
        if(!empty($provide)) {
            $provide = unserialize($provide);
            if(empty($provide['ids'])) {
                session('set_manual_match_provide_'.$user_info['id'],null);
                $provide_list = [];
            }else {
                $provide_list = model('UserProvide')->get_match_list_by_table($provide,$field);
            }
            
        }
        
        //接受资助
        $accept = session('set_manual_match_accept_'.$user_info['id']);
        if(!empty($accept)) {
            $accept = unserialize($accept);
            if(empty($accept['ids'])) {
                session('set_manual_match_accept_'.$user_info['id'],null);
                $accept_list  =  [];
                //返回结果
            }else {
                 $accept_list = model('UserAccepthelp')->get_match_list_by_table($accept,$field);
            }
        }
        
         //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'accept_list'=>$accept_list,
            'provide_list'=>$provide_list,
        ];

        return $this->result;
    }
    
    
    /**
     * 手动匹配订单
     * @param type $data
     * @param type $user_id
     * @return type
     */
    public function manual_match(&$data,$user_info) {
        $provide = [];
        $accept  = [];
        $provide_= [];
        $field = 'id,type_id,cid,user_id,username,name,money,used,match_num,create_time,status';
        //提供资助
       // $provide_ = session('set_manual_match_provide_'.$user_info['id']);
        if(!empty($data['ids'])) {
            for($i=0;$i<count($data['ids']);$i++) {
                $provide_[$i]['id'] = $data['ids'][$i];
                $provide_[$i]['partition_time'] = $data['partition_time'][$i];
            }
        }
        if(!empty($provide_)) {
            $provide = model('UserProvide')->get_match_list($provide_,$field);
        }
        
        
        //接受资助
        $accept_ = session('set_manual_match_accept_'.$user_info['id']);
        if(!empty($accept_)) {
            $accept = model('UserAccepthelp')->get_match_list(unserialize($accept_),$field);
        }
        
        session('admin_match_list',null);
        session('admin_match_provide_list',null);
        session('admin_match_accepthelp_list',null);
        
        $match_arr        = [];
        $match_provide    = [];
        $match_accepthelp = [];
        $num = -1;
        //生成匹配数据
        for($i=0;$i<count($provide);$i++) {
            
                for($j=0;$j<count($accept);$j++) {
                    
                    $match_used = 0;
                    //1.判断提供资助的单的是否还有匹配的金额
                    //2.判断接受资助的单是否还有匹配金额
                    //3.判断接受与提供是否是一个人
                    if(($provide[$i]['money'] - $provide[$i]['used']) > 0 && ($accept[$j]['money'] - $accept[$j]['used']) > 0 && $accept[$j]['user_id'] != $provide[$i]['user_id']) {
                        //提取提供资助待匹配金额
                        if($provide[$i]['used'] == 0) {
                            $provide_used = $provide[$i]['money'];
                        }else {
                            $provide_used = $provide[$i]['money']-$provide[$i]['used'];
                        }

                        //提取接受资助待匹配金额
                        if($accept[$j]['used'] == 0) {
                            $accept_used = $accept[$j]['money'];
                        }else {
                            $accept_used = $accept[$j]['money']-$accept[$j]['used'];
                        }

                        if($provide_used > $accept_used) {
                            $match_used = $accept_used;
                            $accept[$j]['used'] += $accept_used;
                            $provide[$i]['used'] += $accept_used;
                            $accept[$j]['match_num'] += 1;
                            $provide[$i]['match_num'] += 1;
                        }else{
                            $match_used = $provide_used;
                            $accept[$j]['used'] += $provide_used;
                            $provide[$i]['used'] += $provide_used;
                            $accept[$j]['match_num'] += 1;
                            $provide[$i]['match_num'] += 1;
                        }

                        if($match_used > 0) {
                            $num += 1;
                            //匹配列表
                            $match_arr[$num]['type_id']                = $accept[$j]['type_id'];
                            $match_arr[$num]['other_type_id']          = $provide[$i]['type_id'];
                            $match_arr[$num]['cid']                    = $accept[$j]['cid'];
                            $match_arr[$num]['other_cid']              = $provide[$i]['cid'];
                            $match_arr[$num]['pid']                    = $accept[$j]['id'];
                            $match_arr[$num]['user_id']                = $accept[$j]['user_id'];
                            $match_arr[$num]['username']               = $accept[$j]['username'];
                            $match_arr[$num]['name']                   = $accept[$j]['name'];
                            $match_arr[$num]['money']                  = $accept[$j]['money'];
                            //
                            $match_arr[$num]['other_id']               = $provide[$i]['id'];
                            $match_arr[$num]['other_user_id']          = $provide[$i]['user_id'];
                            $match_arr[$num]['other_username']         = $provide[$i]['username'];
                            $match_arr[$num]['other_name']             = $provide[$i]['name'];
                            $match_arr[$num]['provide_money']          = $provide[$i]['money'];
                            $match_arr[$num]['other_money']            = $match_used;
                            $match_arr[$num]['status']                 = 1;
                            $match_arr[$num]['handlers']               = $user_info['id'];
                            //
                            $match_arr[$num]['ip_address']             = ip2long(get_client_ip());
                            $match_arr[$num]['create_time']            = $_SERVER['REQUEST_TIME'];
                            $match_arr[$num]['update_time']            = $_SERVER['REQUEST_TIME'];
                            $match_arr[$num]['batch']                  = !empty($accept[$j]['batch']) ? $accept[$j]['batch'] :strtotime(date('Y-m-d 0:0:0',$_SERVER['REQUEST_TIME']));
                            $match_arr[$num]['audit_user_id']          = $user_info['id'];
                            $match_arr[$num]['audit_username']         = $user_info['username'];
                            $match_arr[$num]['audit_time']             = $_SERVER['REQUEST_TIME'];
                            $match_arr[$num]['flag']                   = 0;
                            $match_arr[$num]['provide_create_time']    = $provide[$i]['create_time'];
                            $match_arr[$num]['accepthelp_create_time'] = $accept[$j]['create_time'];
                            $match_arr[$num]['expiration_create_time'] = $_SERVER['REQUEST_TIME'];
                            //自定义的id用于识别
                            $match_arr[$num]['match_id']               = $num+1;

                            //提供匹配列表
                            $match_provide[$num]['cid']                = $provide[$i]['cid'];
                            //自定义的id用于识别
                            $match_provide[$num]['match_id']           = $num+1;
                            $match_provide[$num]['id']                 = $provide[$i]['id'];
                            $match_provide[$num]['match_num']          = $provide[$i]['match_num'];
                            $match_provide[$num]['money']              = $provide[$i]['money'];
                            $match_provide[$num]['type_id']            = $provide[$i]['type_id'];
                            $match_provide[$num]['used']               = $provide[$i]['used'];
                            $match_provide[$num]['match_money']        = $match_used;
                            $match_provide[$num]['user_id']            = $provide[$i]['user_id'];
                            $match_provide[$num]['username']           = $provide[$i]['username'];
                            $match_provide[$num]['name']               = $provide[$i]['name'];
                            $match_provide[$num]['create_time']        = $provide[$i]['create_time'];
                            $match_provide[$num]['status']             = $provide[$i]['status'];
                            //接受匹配列表

                            $match_accepthelp[$num]['cid']                = $accept[$j]['cid'];
                            $match_accepthelp[$num]['id']                 = $accept[$j]['id'];
                            $match_accepthelp[$num]['match_num']          = $accept[$j]['match_num'];
                            $match_accepthelp[$num]['money']              = $accept[$j]['money'];
                            $match_accepthelp[$num]['type_id']            = $accept[$j]['type_id'];
                            $match_accepthelp[$num]['used']               = $accept[$j]['used'];
                            $match_accepthelp[$num]['match_money']        = $match_used;
                            $match_accepthelp[$num]['match_id']           = $num+1;
                            $match_accepthelp[$num]['user_id']            = $accept[$j]['user_id'];
                            $match_accepthelp[$num]['username']           = $accept[$j]['username'];
                            $match_accepthelp[$num]['name']               = $accept[$j]['name'];
                            $match_accepthelp[$num]['create_time']        = $accept[$j]['create_time'];
                            $match_accepthelp[$num]['status']             = $accept[$j]['status'];
                        }
                    }
               
            }
        }
    
        session('admin_match_list',$match_arr);
        session('admin_match_provide_list',$match_provide);
        session('admin_match_accepthelp_list',$match_accepthelp);
        session('set_manual_match_provide_tmp_'.$user_info['id'],  serialize($provide));   
        session('set_manual_match_accept_tmp_'.$user_info['id'], serialize($accept));        
        if(empty($match_provide) || empty($match_accepthelp) || empty($match_arr))  {
            //返回结果
            $this->error_code = '-1002';
            $this->error_msg = '手动匹配失败';
            $this->body = [];

            return $this->result;
        }
         //返回结果
        $this->error_code = '0';
        $this->error_msg = '手动匹配成功';
        $this->body = [
            'list'=>$match_arr,
            'provide_list'=>$match_provide,
            'accept_list'=>$match_accepthelp,
        ];

        return $this->result;
    }
    
    
    /**
     * 审核匹配
     * @param type $data
     * @param type $user_info
     */
    public function set_manual_match(&$data,$user_info) {
            
            //匹配数据
            $match_arr = session('admin_match_list');
            //提供资助数据
            $provide = session('admin_match_provide_list');
            //接受资助数据
            $accept = session('admin_match_accepthelp_list');
             //提供资助数据 原始赋值数据
            $tmp_provide_array = unserialize(session('set_manual_match_provide_tmp_'.$user_info['id']));        
            //接受资助数据  原始赋值数据
            $tmp_accept_array  = unserialize(session('set_manual_match_accept_tmp_'.$user_info['id']));      
 
            //如果参数为空是  返回错误
            if(empty($match_arr) || empty($provide) || empty($data['ids']) ) {
                //返回结果
                $this->error_code = '-1';
                $this->error_msg = '数据错误！';
                $this->body = [];

                return $this->result;
            }
       
            $insert_arr = [];
            $update_provide_arr = [];
            $update_accept_arr = [];
            $tmp_provide = [];
            for($i=0;$i<count($provide);$i++) {
                //查看提供资助的数据  金额是否匹配完成
                if(isset($provide[$i]['match_id']) &&  in_array($provide[$i]['match_id'],$data['ids'])) {
                	//如果提供表的状态status >0 时 表示已经匹配了或者打款了,不能更改人家的状态了
           
                	$update_provide_arr[$provide[$i]['id']][$i]['match_num']    = 1;
                	$update_provide_arr[$provide[$i]['id']][$i]['used']         = $provide[$i]['match_money'];
                	$update_provide_arr[$provide[$i]['id']][$i]['status']       = $provide[$i]['status'];
                	$update_provide_arr[$provide[$i]['id']][$i]['id']           = $provide[$i]['id'];
                	$update_provide_arr[$provide[$i]['id']][$i]['create_time']  = $provide[$i]['create_time'];
                   
                    
                }
              
                //组装要进库的数据
                if(isset($match_arr[$i]['match_id']) && in_array($match_arr[$i]['match_id'],$data['ids'])) {
                    unset($match_arr[$i]['match_id']);
                    $insert_arr[$i] = $match_arr[$i];
     
                    
                    $update_accept_arr[$accept[$i]['id']][$i]['match_num']    = 1;
                    $update_accept_arr[$accept[$i]['id']][$i]['used']         = $accept[$i]['match_money'];
                    $update_accept_arr[$accept[$i]['id']][$i]['status']       = $accept[$i]['status'];
                    $update_accept_arr[$accept[$i]['id']][$i]['id']           = $accept[$i]['id'];
                    $update_accept_arr[$accept[$i]['id']][$i]['create_time']  = $accept[$i]['create_time'];
       
                }
                
            }
            
            if(empty($update_provide_arr)) {
            	// 返回结果
            	$this->error_code = '-21';
            	$this->error_msg = '匹配数据错误！';
            	$this->body = [];
            
            	return $this->result;
            }
  
        //  
            if($update_provide_arr && is_array($update_provide_arr)){
            	
            	$new_provide_arr = array();
            	$match_num  = 0;
            	$used       = 0;
            	$status_big = 0;
            	foreach ($update_provide_arr as $key=>$provide){

            		$count = count($provide);
            		 
            		if($count>1){
            			foreach ($provide as $k=>$val){
            				if($key == $val["id"]){
            					$match_num = $match_num + $val['match_num'];
            					$used      = $used + $val['used'];
            				}
            				$provide_table = model('UserProvide')->get_table_name($val['create_time']);
            				
            				//判断是否原先的状态大于0 ,大于0 就还原回去
            				if($val['status']>0){
            					$status_big = $val['status'];
            				}
            			}
            			$seq = substr($provide_table, -1);
            			$new_provide_arr[$seq]['table'] = $provide_table;
            			$new_provide_arr[$seq]['data'][$key]['match_num']  = $match_num;
            			$new_provide_arr[$seq]['data'][$key]['used']       = $used;
            			if($status_big == 0 ){
            				$new_provide_arr[$seq]['data'][$key]['status'] = 1;
            			}else{
            				$new_provide_arr[$seq]['data'][$key]['status'] = $status_big;
            			}
            			$new_provide_arr[$seq]['data'][$key]['id']         = $key;
            			$match_num = 0;
            			$used      = 0;
 
            		}else{
            			foreach($provide as $p){
	            			$provide_table = model('UserProvide')->get_table_name($p['create_time']);
	            			$seq = substr($provide_table, -1);
	            			$new_provide_arr[$seq]['table'] = $provide_table;
	            			$new_provide_arr[$seq]['data'][$key]['match_num']  = $p['match_num'];
	            			$new_provide_arr[$seq]['data'][$key]['used']       = $p['used'];
	            			
	            			if($p['status'] == 0){
	            				$new_provide_arr[$seq]['data'][$key]['status']  = 1;
	            			}else{
	            				$new_provide_arr[$seq]['data'][$key]['status']  = $p['status'];
	            			}
	            			
	            			$new_provide_arr[$seq]['data'][$key]['id']     = $key;
            			}
            		}
            		
            	}
	
            }
 
            if($update_accept_arr && is_array($update_accept_arr)){
            	 
            	$new_accept_arr = array();
            	$match_num     = 0;
            	$used          = 0;
            	$accept_status = 0; 
            	foreach ($update_accept_arr as $key=>$accept){
            
            		$count = count($accept);
            		 
            		if($count>1){
            			 
            			foreach ($accept as $k=>$val){
            				if($key == $val["id"]){
            					$match_num = $match_num + $val['match_num'];
            					$used      = $used + $val['used'];
            				}
            				 
            				 $accept_table = model('UserAccepthelp')->get_table_name($val['create_time']);
            				 
            			    if($val['status']>0){
            					$accept_status = $val['status'];
            				}
            				  
            			}
            			$seq_a = substr($accept_table, -1);
            			$new_accept_arr[$seq_a]['table'] = $accept_table;
            			
            			$new_accept_arr[$seq_a]['data'][$key]['match_num']  = $match_num;
            			$new_accept_arr[$seq_a]['data'][$key]['used']       = $used;
            			if($accept_status == 0){
            				$new_accept_arr[$seq_a]['data'][$key]['status']     = 1;
            			}else{
            				$new_accept_arr[$seq_a]['data'][$key]['status']     = $val['status'];
            			}
            			
            			$new_accept_arr[$seq_a]['data'][$key]['id']         = $key;
            			$match_num = 0;
            			$used      = 0;
            
            		}else{
            			foreach($accept as $p){
            				 
            				$accept_table = model('UserAccepthelp')->get_table_name($p['create_time']);
            				
            				$seq_a = substr($accept_table, -1);
            			    $new_accept_arr[$seq_a]['table'] = $accept_table;
            				 
            				$new_accept_arr[$seq_a]['data'][$key]['match_num']  = $p['match_num'];
            				$new_accept_arr[$seq_a]['data'][$key]['used']       = $p['used'];
            				if($p['status'] == 0){
            					$new_accept_arr[$seq_a]['data'][$key]['status']     = 1;
            				}else{
            					$new_accept_arr[$seq_a]['data'][$key]['status']     = $p['status'];
            				}
            				
            				$new_accept_arr[$seq_a]['data'][$key]['id']         = $key;
            			}
            		}
            
            	}
            
            }
             
            $time = date('Y-m-d:H:i:s',time());
           file_put_contents("./../runtime/minsert.txt", json_encode($insert_arr)."\r\n---------------------------------------------------------------------------------\r\n".$time,FILE_APPEND);
           file_put_contents("./../runtime/mprovide.txt", json_encode($new_provide_arr).'\r\n---------------------------------------------------------------------------------\r\n'.$time,FILE_APPEND);
           file_put_contents("./../runtime/maccept.txt", json_encode($new_accept_arr).'\r\n---------------------------------------------------------------------------------\r\n'.$time,FILE_APPEND); 
 
            //进库
            $result = model('UserMatchhelp')->insert_manual_match_data($insert_arr,$new_provide_arr,$new_accept_arr);
            
            if(!$result){
                //返回结果
                $this->error_code = '-200';
                $this->error_msg = '审核匹配数据失败！';
                $this->body = [];

                return $this->result;
            }
            
            //返回结果
            $this->error_code = '0';
            $this->error_msg = '审核匹配数据成功';
            $this->body = [];
            
            
            session('admin_match_list',null);
            session('admin_match_provide_list',null);
            session('admin_match_accepthelp_list',null);
            session('admin_accept_list',null);
            session('admin_provide_list',null);
            session('set_manual_match_provide_tmp_'.$user_info['id'],null);
            session('set_manual_match_accept_tmp_'.$user_info['id'],null);
            session('set_manual_match_provide_'.$user_info['id'],null);
            session('set_manual_match_accept_'.$user_info['id'],null);
            unset($match_arr);
            unset($provide);
            unset($accept);
            unset($data);

            return $this->result;
    }
    
   
   /**
     * 收款
     * @param type $data
     * @param type $user_info
     */
    public function accept_collections(&$data,$user_info) {
        
        $partition_time = $data['match_time'];
        //匹配ID 
        $map['id'] = $data['id'];
        $map['flag'] = 0;
         //实例化
        $model = \think\Loader::model('UserMatchhelp', 'model');
        //取值
        $match = $model->get_match_info($map,$partition_time,'id,other_id,pid,user_id,other_type_id,other_cid,other_user_id,username,other_username,other_money,status,flag,provide_create_time,accepthelp_create_time,create_time');
        
        //校验数据
        if(empty($match)) {
             //返回结果
            $this->error_code = '-1003';
            $this->error_msg = '数据错误或被删除了！';
            $this->body = [];
            return $this->result;
        }
        //校验数据是否重复提交了
        $tmp_cache = cache('match_info_'.$map['id']);
        if(md5(json_encode($match))  == $tmp_cache) {
              //返回结果
            $this->error_code = '-1004';
            $this->error_msg = '请勿重复提交！';
            $this->body = [];
            return $this->result;
        }
        cache('match_info_'.$map['id'],md5(json_encode($match)),5);
        
        //校验打款状态
        if($match['status'] < 2) {
            cache('match_info_'.$map['id'],null);
             //返回结果
            $this->error_code = '-1005';
            $this->error_msg = '对方还未打款，订单暂时不能收款！';
            $this->body = []; 
            return $this->result;
        }
        if($match['status'] == 3) {
            cache('match_info_'.$map['id'],null);
             //返回结果
            $this->error_code = '-1006';
            $this->error_msg = '订单已收款，请勿重复提交！';
            $this->body = []; 
            return $this->result;
        }
        //查看社区信息
        $community = model('UserCommunity')->getOneData($match['other_cid']);
        if(empty($community)) {
            cache('match_info_'.$map['id'],null);
             //返回结果
            $this->error_code = '-1007';
            $this->error_msg = '社区信息错误！';
            $this->body = []; 
            return $this->result;
        }
        //校验完了，后面剩下改变订单状态   接受资助状态   提供资助状态 
        //更新订单
        
        //判断是企业用户还是个人用户
        $is_company = model('member/Company')->get_by_id( $match['other_user_id'],'id');
        if($is_company){
        	$result = $model->accept_company_collections($match,$partition_time,$user_info,$community);
        }else{
        	$result = $model->accept_collections($match,$partition_time,$user_info,$community); 
        }
 
        cache('match_info_'.$map['id'],null);
        if(!$result) {
            $this->error_code = '-1008';
            $this->error_msg = '收款失败！';
            $this->body = [];

            return $this->result;
        }

        //如果选择是  就禁用  1-是 2-否
        if($data['flag'] == 1) {
            //禁用用户 0-未激活 1-已激活 2-已冻结
            $user_arr['status'] = 2;
            if($is_company){
            	$user =  model('member/CompanyInfo')->update_by_uid($data['user_id'],$user_arr);
            }else{
            	model('member/User')->update_by_id($data['user_id'],$user_arr);
            }
           
            unset($user_arr);
            
            //加入黑名单
            model('user/UserBlacklist')->set_blacklist_to_queue($data['user_id'],'确认收款封号');
        } 
        
        unset($data);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '收款成功';
        $this->body = [];

        return $this->result;
    }
    
    
    /**
     * 删除匹配数据
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function del_manual_match(&$data,$user_info) {
        

         
            //provide删除
            if($data['flag'] == 1) {
                    $provide = session('set_manual_match_provide_'.$user_info['id']);
                    if(empty($provide)) {
                       //返回结果
                       $this->error_code = '-1';
                       $this->error_msg = '数据错误！';
                       $this->body = [];
                       return $this->result;
                    }
                    $provide = unserialize($provide);
                    $arr = array_diff($provide['ids'],$data['ids']);
                    $provide['ids'] = $arr;
                    session('set_manual_match_provide_'.$user_info['id'],  serialize($provide));
            }
            //匹配数据删除
            else if($data['flag'] == 2) {
                //匹配数据
                $match_arr         =  session('admin_match_list');
                //提供资助数据
                $match_provide     =  session('admin_match_provide_list');
                //接受资助数据
                $match_accepthelp  =  session('admin_match_accepthelp_list');
                if(empty($match_arr) || empty($match_provide) || empty($match_accepthelp)) {
                       //返回结果
                       $this->error_code = '-1';
                       $this->error_msg = '数据错误！';
                       $this->body = [];
                       return $this->result;
                }
                $new_match_arr           = [];
                $new_match_provide       = [];
                $new_match_accepthelp    = [];
                $num = -1;
                for($i=0;$i<count($match_arr);$i++) {
                
                        if(!in_array($match_arr[$i]['match_id'], $data['ids'])) {   
                            $num += 1;
                            $new_match_arr[$num] = $match_arr[$i];
                            $new_match_provide[$num] = $match_provide[$i];
                            $new_match_accepthelp[$num] = $match_accepthelp[$i]; 
                        }
                    
                }
                unset($match_arr);
                unset($match_provide);
                unset($match_accepthelp);
                unset($num);
              session('admin_match_list',$new_match_arr);
              session('admin_match_provide_list',$new_match_provide);
              session('admin_match_accepthelp_list',$new_match_accepthelp);
            }
            
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '删除成功';
        $this->body = [];

        return $this->result;
    }
    
    /**
     * ajax 判断超时订单  是否部分接口了
     * @return
     */
    public function get_jieke($data,$user_info){
    	
    	$map['other_id']        = $data['other_id'];
    	$map['status']          = 1;
    	$map['flag']            = ['in',[0,1]];      
    	$partition_time         = $data['create_time'];
    	//实例化模型
    	$model = \think\Loader::model('UserMatchhelp', 'model');
    	//获取满足条件的记录总数
    	 
    	//取值字段
    	$field = ['id','provide_money','other_money','other_user_id','other_id','audit_time','delayed_time_status','expiration_create_time'];
    	
    	//取值

    	$match = $model->get_data_list($map,$partition_time,$field);
    	// echo "<pre>";print_r($match);exit;
    	$yesterday = $_SERVER['REQUEST_TIME'];
    	$result_list = 0;
    	if($match){
    		$other_money = 0;
    		
    		foreach ($match as $key=>$val){
    			if($val['delayed_time_status'] == 0) {
    			
    				if(intval(config('matchhelp_out_time') + $val['audit_time']) < intval(time())){
    					$other_money  = intval($other_money) +	intval($val['other_money']);
    				}
    			
    			}else{
    				if(intval($val['expiration_create_time']) < intval(time())) {
    					$other_money  = intval($other_money) +	intval($val['other_money']);
    				}
    			}
    		}
    		
    		$provide_money = $val['provide_money'];
    		
    		if($provide_money != $other_money){
    			$result_list = 1;
    		}
    	}
 
    	
    	//返回结果
    	$this->error_code = '0';
    	$this->error_msg = '请求成功!';
    	$this->body = [
    	'data' => $result_list, 
    	];
    	
    	return $this->result;
    	 
    }
}