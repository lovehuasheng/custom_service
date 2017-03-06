<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【提供资助】控制器
// +----------------------------------------------------------------------

namespace app\business\logic;

use app\common\logic\Base;

class Transfer extends Base{
    
	/**
	 * ajax  转接单记录
	 * @return
	 */
	public function  get_transfer(&$data,&$user_info){
		
		$map = [];
		$partition_time = $_SERVER['REQUEST_TIME'];
		
		//时间搜索
		if(!empty($data['data_time'])) {
			$start_time = strtotime(date('Y-m-d 00:00:00',strtotime($data['data_time'])));
			$end_time   = strtotime(date('Y-m-d 23:59:59',strtotime($data['data_time'])));
			$map['create_time'] = ['between',[$start_time,$end_time]];
		 
		}
		
		//搜索类型
		if(!empty($data['search_type'])) {
			switch($data['search_type']) {
				case 1://订单ID
					$map['other_id'] = $data['search_name'];
					break;
				case 2://用户ID
					$map['other_user_id'] = $data['search_name'];
					break;
			}
		}
		
		
		
		//当前页码 默认为1
		$page = !empty($data['page']) ? $data['page'] : 0;
		//每页条数 默认为20
		$per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
		//设置页码列表,默认为5页
		$page_list = config('page_list');
		
		//实例化
		$model = \think\Loader::model('UserTransfer', 'model');
		
		
		//获取满足条件的记录总数
		$total = $model->get_total_count($map);
		
		//当前的中数量
		$current_total  = $model->get_total_count();
		$current_money  = $model->get_max_count('provide_money');
		//取值字段
		$field = ['id','other_id','other_user_id','other_username','other_name','create_time','provide_money','operator_name','remark'];
		//获得列表数据
		$result_list = $model->get_transger_list($map, $field, $page, $per_page,'id desc');
		
		//获取页码列表
		$pages = get_pagination($total, $page, $per_page, $page_list);
		//返回结果
		$this->error_code = '0';
		$this->error_msg = '请求成功!';
		$this->body = [
		'data' => $result_list,
		'pages' => $pages,
		'current_total' =>$current_total,
		'current_money' =>$current_money
		];
		 
		return $this->result;
	}
   
}