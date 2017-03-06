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


class UserTransfer extends Base {
 
     /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_total_count($map = []) {      
    	return  $this->where($map)->count();
    }
    
    /**
     * 获取总金额
     * @param type $map
     * @return type
     */
    public function get_max_count($max) {
    	return  $this->max($max);
    }
 
    
    
    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_transger_list($map, $field = '*',$page = 1, $r = 20,  $order = 'id desc') {

       $list = $this->where($map)->field($field)->order($order)->page($page,$r)->select();
    	if ($list && is_array($list)) {    	 
    		return $list;
    	}
    	return [];
    }
    
}