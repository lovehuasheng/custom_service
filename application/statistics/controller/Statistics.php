<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【接受资助】控制器
// +----------------------------------------------------------------------

namespace app\statistics\controller;
use app\common\controller\Base;

class Statistics extends Base{
    
    /**
     * 
     * @return type
     */
    public function lists() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->get_data($this->user_info);
    }
    
    /**
     * 登陆日志列表
     * @return type
     */
    public function get_login_log() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->get_login_log($this->user_info);
    }
    
    /**
     * 审核客服工作量统计
     * @return type
     */
    public function get_count_workload() {
         $service = \think\Loader::model('Statistics', 'service');
        return $service->get_count_workload($this->user_info);
    }
    
    /**
     * 注册质量统计
     * @return type
     */
    public function register_count() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->register_count($this->user_info);
    }
    
    /**
     * 注册质量统计  月统计
     * @return type
     */
    public function register_month_count() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->register_month_count($this->user_info);
    }
    
    /**
     * 工作有效时间   月统计
     * @return type
     */
    public function efficiency_month_count() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->efficiency_month_count($this->user_info);
    }
    
    /**
     * 工作有效时间统计
     * @return type
     */
    public function efficiency_count() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->efficiency_count($this->user_info);
    }
    
    /**
     * 审核质量统计
     * @return type
     */
    public function quality_count() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->quality_count($this->user_info);
    }
    
    
    /**
     * 审核质量统计 年统计
     * @return type
     */
    public function quality_year_count() {
        $service = \think\Loader::model('Statistics', 'service');
        return $service->quality_year_count($this->user_info);
    }
}