<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【接受资助】业务逻辑层
// +----------------------------------------------------------------------


namespace app\business\logic;
use app\common\logic\Base;


class Accept extends Base
{
  
   
   /**
    * 取单条数据
    * @param type $id
    * @return type
    */
    public function get_accept_data($id) {
        $model = \think\Loader::model('UserAccepthelp', 'model');
        //取值字段
        $field = 'id,type_id,money,used,user_id,status,flag';
        //查询条件
        $map = ['id'=>$id,'flag'=>0];
        //调取数据
        $result_list = $model->get_accept_info($map,$field);
        
        unset($map);
        unset($field);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg  = '操作成功！';
        $this->body = ['data'=>$result_list];
        
        unset($result_list);
        return $this->result;
    }
    
    
    
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
        }else {
            //查看手动匹配列表数据session中是否存的提供资助id
            $tmp = session('set_manual_match_accept_'.$user_info['id']);
            if(!empty($tmp)) {
                //排除session中的id
                $ids = unserialize($tmp);
                $map['id'] = ['not in',$ids['ids']];
            }
        }
        
        
        //提交金额 不等于 匹配金额
        $map['money'] = ['gt','used'];
        $map['status'] = ['neq',3];
        
        //由于自动匹配 ,匹配后，status=0 ,但是金额确是 used =匹配值,导致付款剩余查询不到,所以加入此参数
        if(isset($data['check']) && $data['check'] == 1){
        	$map['money']  = ['EGT','used'];
        }
        
        //数据状态
        $map['flag'] = 0;
        
        //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 0;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');

        //实例化
        $model = \think\Loader::model('UserAccepthelp', 'model');

        //获取满足条件的记录总数
        $total = $model->get_total_count($map,$partition_time,1);

        //取值字段
        $field = ['id','cid','money','used','user_id','create_time','username','name','flag as differ_money'];
        
        //排序
        $order = ['create_time desc'];
        //获得列表数据
        $result_list = $model->get_new_list($map,$partition_time, $field, $page, $per_page,$order);

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
        
        $result = model('UserAccepthelp')->get_table_on_ids($data,$user_info);

         //返回结果
         if($result){
         	$this->error_code = '0';
         	$this->error_msg = '你选中的已经有加入匹配列表了,请不要重复选中!';
         	$this->body = [];
         }else{
         	$this->error_code = '0';
         	$this->error_msg = '加入手动匹配列表成功!';
         	$this->body = [];
         }
        
       
        return $this->result;
    }
    
    /**
     * 更改会员接受资助的金额，从出局钱包中转入接受资助中
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function set_accepthelp_money_by_account(&$data,$user_info) {
        
        //接受资助订单号
        $map['id'] = $data['ids'];
        //创建时间分表
        $partition_time = strtotime(str_replace('上午','',str_replace('下午','',$data['partition_time'])));
        //实例化模型
                $model = model('UserAccepthelp');
        //查询数据是否存在
        $accept = $model->get_accept_info($map,$partition_time,'user_id,username');
        //校验数据
        if(empty($accept)) {
            $this->error_code = '-1';
            $this->error_msg = '数据错误！!';
            $this->body = [];
            return $this->result;
        }
        //查看会员钱包
        $user_wallet = model('member/UserAccount')->get_by_uid($accept['user_id'],'wallet_currency');
        //交易会员钱包数量是否足够增加
        if($data['amount'] > $user_wallet['wallet_currency']) {
            $this->error_code = '-1';
            $this->error_msg = '钱包数量不足'.$data['amount'].'！!';
            $this->body = [];
            return $this->result;
        }
   
       $result = $model->set_accepthelp_money_by_account($map,$partition_time,$accept,$data,$user_info);
        
       
        if(!$result) {
            $this->error_code = '-1';
            $this->error_msg = '更改金额失败！!';
            $this->body = [];
            return $this->result;
        }
        
        $this->error_code = '0';
        $this->error_msg = '更改金额成功！!';
        $this->body = [];
        return $this->result;
    }
}