<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【接受资助】服务层
// +----------------------------------------------------------------------

namespace app\statistics\service;

use app\common\service\Base;

class Statistics extends Base {

    /**
     * 查询
     * @param type $user_id
     * @return type
     */
    public function get_data($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','get_data') != true) {
           return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        //flag 1-超管  2-客服
        if($this->data['flag'] == 1 ) {
            return $logic->get_data($this->data,$user_info);
        }
        
    }
    
    /**
     * 登陆日志
     * @param type $user_info
     * @return type
     */
    public function get_login_log($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','get_login_log') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->get_login_log($this->data,$user_info);
        
        
    }
    
    /**
     * 审核客服工作量统计
     * @param type $user_info
     * @return type
     */
     public function get_count_workload($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','get_count_workload') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->get_count_workload($this->data,$user_info);
        
        
    }
    
    
     /**
     * 注册质量统计
     * @param type $user_info
     * @return type
     */
     public function register_count($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','register_count') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->register_count($this->data,$user_info);
        
        
    }
    
    /**
     * 注册质量统计
     * @param type $user_info
     * @return type
     */
     public function register_month_count($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','register_month_count') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->register_month_count($this->data,$user_info);
        
        
    }
    
    /**
     * 工作有效时间   月统计
     * @param type $user_info
     * @return type
     */
    public function efficiency_month_count($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','efficiency_month_count') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->efficiency_month_count($this->data,$user_info);
        
        
    }
    
    /**
     * 工作有效时间
     * @param type $user_info
     * @return type
     */
     public function efficiency_count($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','efficiency_count') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->efficiency_count($this->data,$user_info);
        
        
    }
    
    /**
     * 审核质量统计
     * @param type $user_info
     * @return type
     */
     public function quality_count($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','quality_count') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->quality_count($this->data,$user_info);
        
        
    }
    
    
    /**
     * 审核质量统计
     * @param type $user_info
     * @return type
     */
     public function quality_year_count($user_info) {
        //验证字段合法性
        if($this->verify('Statistics','quality_year_count') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Statistics', 'logic');
        return $logic->quality_year_count($this->data,$user_info);
        
        
    }
}
