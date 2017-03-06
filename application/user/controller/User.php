<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服用户管理控制器
// +----------------------------------------------------------------------

namespace app\user\controller;

use app\common\controller\Base;

class User extends Base {

    //首页
    public function index() {
        return view(ROOT_PATH . 'templates/system_management.html');
    }

    //用户列表
    public function show_user_list() {
        return view(ROOT_PATH . 'templates/itunes.html');
    }

    //安全中心
    public function security_center() {
        return view(ROOT_PATH . 'templates/security_center.html');
    }

    /**
     * 用户列表
     * @return type
     */
    public function user_list() {

        $service = \think\Loader::model('User', 'service');
        return $service->get_list($this->user_info);
    }

    /**
     * 添加用户
     * @return type
     */
    public function add_user() {
        $service = \think\Loader::model('User', 'service');
        return $service->add_user($this->user_info);
    }

    /**
     * 获得单个用户数据
     * @return type
     */
    public function get_user() {
        $service = \think\Loader::model('User', 'service');
        return $service->get_user($this->user_info);
    }

    /**
     * 修改用户
     * @return type
     */
    public function set_user() {
        $service = \think\Loader::model('User', 'service');
        return $service->set_user($this->user_info);
    }

    /**
     * 禁用/启用用户
     * @return type
     */
    public function disable_user() {
        $service = \think\Loader::model('User', 'service');
        return $service->disable_user($this->user_info);
    }

    /**
     * 删除用户
     * @return type
     */
    public function del_user() {
        $service = \think\Loader::model('User', 'service');
        return $service->del_user($this->user_info);
    }

    /**
     * 用户分组
     * @return type
     */
    public function set_user_grouping() {
        $service = \think\Loader::model('User', 'service');
        return $service->get_list($this->user_info);
    }

    /**
     * 修改密码
     * @return type
     */
    public function set_user_password() {
        $service = \think\Loader::model('User', 'service');
        return $service->set_user_password($this->user_info);
    }

    /**
     * 修改二级密码
     * @return type
     */
    public function set_user_secondary_password() {
        $service = \think\Loader::model('User', 'service');
        return $service->set_user_secondary_password($this->user_info);
    }

    /**
     * 修改真实姓名
     * @return type
     */
    public function set_user_realname() {
        $service = \think\Loader::model('User', 'service');
        return $service->set_user_realname($this->user_info);
    }

    /**
     * 发送手机短信
     * @return type
     */
    public function send_tel_sms() {
        $service = \think\Loader::model('User', 'service');
        return $service->send_tel_sms($this->user_info);
    }

    /**
     * 获取登录用户的信息
     */
    public function get_login_info() {
        return $this->user_info;
    }

    
    /**
     * 退出登录
     * @return boolean
     */
    public function logout()
    {
        //清除session
        session(null);
       
        $login_log['data']['uid']                     = $this->user_info['id'];
        $login_log['data']['username']                = $this->user_info['username'];
        $login_log['data']['realname']                = $this->user_info['realname'];
        $login_log['data']['remark']                  = '退出登录';
        $login_log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $login_log['model_name']                      = 'SysUserLoginLog';
        //加入队列
        add_to_queue('',$login_log);
    
        
       $this->redirect('/user/index/index');
       return true;
}

}
