<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【提供资助】业务逻辑层
// +----------------------------------------------------------------------

namespace app\business\logic;

use app\common\logic\Base;

class Provide extends Base {

    /**
     * 列表数据
     * @param community_id 社区ID
     * @param data_time 时间搜索关键词
     * @param flag 数据状态 0-正常 1-错误数据 2-删除 
     * @return type
     */
    public function get_list(&$data,&$user_info) {
        $map = [];
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
 
        //社区ID
        if(!empty($data['community_id'])) {
            $map['cid'] = $data['community_id'];
        }
        
        
        //时间搜索
        if(!empty($data['data_time'])) {
            $start_time = strtotime(date('Y-m-d 00:00:00',strtotime($data['data_time'])));
            $end_time   = strtotime(date('Y-m-d 23:59:59',strtotime($data['data_time'])));
            $map['create_time'] = ['between',[$start_time,$end_time]];
            $partition_time = strtotime($data['data_time']);
        }
      
        if(!empty($data['search_type'])) {
            switch($data['search_type']) {
                case 1://订单ID
                    $map['id'] = $data['search_name'];
                    break;
                case 2://用户ID
                    $map['user_id'] = $data['search_name'];
                    break;
            }
        }else{
              //查看手动匹配列表数据session中是否存的提供资助id
            $tmp = session('set_manual_match_provide_'.$user_info['id']);
            if(!empty($tmp)) {
                //排除session中的id
                $ids = unserialize($tmp);
                $map['id'] = ['not in',  array_unique($ids['ids'])];
            }
        }
        
        //提交金额 不等于 匹配金额
        $map['money']  = ['gt','used'];
        $map['status'] = ['neq',3];
        
        //由于自动匹配 ,匹配后，status=0 ,但是金额确是 used =匹配值,导致付款剩余查询不到,所以加入此参数
        if(isset($data['check']) && $data['check'] == 1){
        	$map['money']  = ['EGT','used'];
        	$map['status'] = 0;
        }        
       
        
        //数据状态
        $map['flag']   = 0;
        
        //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 0;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');

        //实例化
        $model = \think\Loader::model('UserProvide', 'model');
        

        //获取满足条件的记录总数
        $total = $model->get_total_count($map,$partition_time,1);

        //取值字段
        $field = ['id','cid','money','used','user_id','create_time','username','name','status','money-used as mused '];
        //获得列表数据
        $result_list = $model->get_new_list($map,$partition_time, $field, $page, $per_page,'create_time desc, mused desc');

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
     * 提供资助加入手动匹配列表
     * @return type
     */
    public function set_manual_match(&$data,$user_info) {
        
        $result = model('UserProvide')->get_table_on_ids($data,$user_info);
 
        if($result){
        	$this->error_code = '0';
        	$this->error_msg = '你选中的已经有加入匹配列表了,请不要重复选中!';
        	$this->body = [];
        }else{
         //返回结果
	        $this->error_code = '0';
	        $this->error_msg = '加入手动匹配列表成功!';
	        $this->body = [];
        }
       
        return $this->result;
    }
    
    /**
     * 改变提供资助的订单状态
     * @param type $status  0-正常 1-还原 2-删除
     * @param type $ids
     * @param type $user_id
     * @return type
     */
    public function destroy_provide($status, $data, $user_info) {
        if(is_array($data['ids'])) {
            //返回结果
            $this->error_code = '-10015';
            $this->error_msg = '操作失败,不能操作多条记录！';
            $this->body = [];
            return $this->result;
        }
        $map['id'] =  $data['ids'];
        $param = ['flag' => ($status == 3) ? 0 : $status];

        $model = \think\Loader::model('UserProvide', 'model');
        $where = $map;
         //创建时间分表
        $partition_time = strtotime(str_replace('上午','',str_replace('下午','',$data['partition_time'])));
        //状态 0-提交成功 1-匹配成功 2-已打款，3-已收款
        //$where['status'] = 0;
        $where['flag'] = 0;
        $provide = $model->get_provide_info($where, $partition_time,'id,status,user_id,username');
        if (empty($provide)) {
            //返回结果
            $this->error_code = '-10015';
            $this->error_msg = '操作失败,此单不存在！';
            $this->body = [];
            return $this->result;
        }
        
        if($provide['status']  == 1) {
            $this->error_code = '-10015';
            $this->error_msg = '操作失败,订单已匹配成功！';
            $this->body = [];
            return $this->result;
        }
        
        if($provide['status']  == 2) {
            $this->error_code = '-10015';
            $this->error_msg = '操作失败,订单已支付打款！';
            $this->body = [];
            return $this->result;
        }
        
        if($provide['status']  == 3) {
            $this->error_code = '-10015';
            $this->error_msg = '操作失败,订单已完成收款了！';
            $this->body = [];
            return $this->result;
        }

        //销毁变量
        unset($where);
        

        $result_list = $model->update_provide_data($map,$partition_time, $param);
        if (!$result_list) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '操作失败！';
            $this->body = [];
            return $this->result;
        }

        //写入操作日志
        $arr = ['2' => '删除', '3' => '还原'];
        //记录操作日志
        $msg =  '修改提供资助订单状态为' . $arr[$status] . '【用户ID:' . $data['ids'] . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg,'business/provide/destroy_provide');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        //取消写入日志
        $destroy_log['data']['provide_id']       = $data['ids'];
        $destroy_log['data']['user_id']          = $provide['user_id'];
        $destroy_log['data']['username']         = $provide['username'];
        //1-取消订单 2-撤销假图
        $destroy_log['data']['type']             = 1;
        $destroy_log['data']['operator_id']      = $user_info['id'];
        $destroy_log['data']['operator_name']    = $user_info['username'];
        $destroy_log['data']['create_time']      = $_SERVER['REQUEST_TIME'];
        $destroy_log['model_name']               = 'DestroyProvide';
        add_to_queue('sxh_user_blacklist',$destroy_log);
            
   
        unset($provide);
        unset($data);
        unset($destroy_log);
        
        //销毁变量
        unset($log);
        unset($map);
        unset($param);
        unset($arr);
        unset($user_info);

        //返回结果
        $this->error_code = '0';
        $this->error_msg = '操作成功！';
        $this->body = [];
        return $this->result;
    }

    /**
     * 取单条数据
     * @param type $id
     * @return type
     */
    public function get_proivde_data($id) {
        //实例化
        $model = \think\Loader::model('UserProvide', 'model');
        //取值字段
        $field = 'id,type_id,money,used,user_id,status,flag';
        //查询条件
        $map = ['id' => $id, 'flag' => 0];
        //调取数据
        $result_list = $model->get_provide_info($map, $field);

        unset($map);
        unset($field);

        //返回结果
        $this->error_code = '0';
        $this->error_msg = '操作成功！';
        $this->body = ['data' => $result_list];

        unset($result_list);
        return $this->result;
    }
    
/**
     * ajax  转接单记录
     * @return
     */
    public function  get_transfer(){
    	 
    }

}
