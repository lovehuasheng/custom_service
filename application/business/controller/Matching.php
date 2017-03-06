<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【匹配详情】控制器
// +----------------------------------------------------------------------

namespace app\business\controller;
use app\common\controller\Base;

class Matching extends Base{
    
    /**
     * 匹配数据列表
     * @return type
     */
    public function get_list() {
        
        $service = \think\Loader::model('Matching', 'service');
        return $service->get_list($this->user_info,0);
    }
    
    /**
     * 删除订单【还原打款订单】
     * @return type
     */
    public function destroy_match() {
        
        $service = \think\Loader::model('Matching', 'service');
        return $service->destroy_match($this->user_info);
    }
    
    /**
     * 还原
     * @return type
     */
//    public function reduction_match() {
//
//        $service = \think\Loader::model('Matching', 'service');
//        return $service->reduction_match($this->user_info);
//    }
    
    /**
     * 订单延时【测试通过】
     * @return type
     */
    public function delayed_match() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->delayed_match($this->user_info);
    }
   
    /**
     * 手动匹配
     * @return type
     */
    public function manual_match() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->manual_match($this->user_info);
    }
    
    /**
     * 获取手动匹配列表
     * @return type
     */
    public function get_manal_match_list() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->get_manal_match_list($this->user_info);
    }
    
    /**
     *审核匹配
     * @param type $user_info
     * @return type
     */
    public function set_manual_match() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->set_manual_match($this->user_info);
    }
    
    /**
     * 删除收动匹配数据
     * @return type
     */
    public function del_manual_match() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->del_manual_match($this->user_info);
    }
      
    /**
     * 改单[待定]
     * @return type
     */
//    public function edit_match() {
//        $service = \think\Loader::model('Matching', 'service');
//        return $service->manual_match($this->user_info);
//    }
    
    
    /**
     * 付款超时订单列表【测试通过】
     * @return type
     */
    public function pay_overtime_order_list() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->overtime_order_list($this->user_info,1);
    }
    
    /**
     * 收款超时订单列表【测试通过】
     * @return type
     */
    public function make_money_overtime_order_list() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->overtime_order_list($this->user_info,2);
    }
    
    /**
     * 转移订单到接单人
     * @return type
     */
    public function transfer_order_to_user() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->transfer_order_to_user($this->user_info);
    }
    
    /**
     * 撤销假图【测试通过】
     * @return type
     */
    public function undo_img() {

        $service = \think\Loader::model('Matching', 'service');
        return $service->undo_img($this->user_info);
    }
    
   /**
    * 撤单封号【测试通过】
    * @return type
    */
    public function disable_no() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->disable_no($this->user_info);
    }
    
    
    /**
     * 确认收款
     * @return type
     */
    public function accept_collections() {
        $service = \think\Loader::model('Matching', 'service');
        return $service->accept_collections($this->user_info);
    }
    
    /**
     * ajax 判断超时订单  是否部分接口了
     * @return  
     */
    public function get_jieke(){
    	$service = \think\Loader::model('Matching', 'service');
    	return $service->get_jieke($this->user_info);
    }
    
    
}