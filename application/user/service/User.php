<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服用户管理服务层
// +----------------------------------------------------------------------

namespace app\user\service;

use app\common\service\Base;

class User extends Base {

    public function login() {
        //验证字段合法性
        if ($this->verify('User', 'login') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->login($this->data);
    }

    //发送短信验证码
    public function send_verify()
    {
        //验证字段合法性
        if ($this->verify('User', 'send_verify') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->send_verify($this->data);
    }

    /**
     * 获得列表数据
     * @return type
     */
    public function get_list($user_info) {
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->get_list($this->data);
    }

    /**
     * 添加用户
     * @return type
     */
    public function add_user($user_info) {

        //验证字段合法性
        if ($this->verify('User', 'add') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->add_user($this->data, $user_info);
    }

    /**
     * 获得单个用户数据
     * @return type
     */
    public function get_user($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'get_data') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->get_user($this->data['id']);
    }

    /**
     * 修改用户
     * @return type
     */
    public function set_user($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'edit') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->set_user($this->data, $user_info);
    }

    /**
     * 修改状态
     * @return type
     */
    public function disable_user($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'disable') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->disable_user($this->data['status'], $this->data['ids'],$this->data['pwd'], $user_info);
    }

    /**
     * 删除用户
     * @return type
     */
    public function del_user($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'destroy') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->disable_user($this->data['status'], $this->data['ids'], $user_info);
    }

    /**
     * 修改密码
     * @param type $user_id
     * @return type
     */
    public function set_user_password($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'set_password') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->set_password($this->data, $user_info);
    }

    /**
     * 修改二级密码
     * @param type $user_info
     * @return type
     */
    public function set_user_secondary_password($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'set_secondary_password') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->set_user_secondary_password($this->data, $user_info);
    }
    
    /**
     * 修改真实姓名
     * @param type $user_info
     * @return type
     */
    public function set_user_realname($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'set_user_realname') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->set_user_realname($this->data, $user_info);
    }

    /**
     * 发送手机验证码
     * @param type $user_info
     * @return type
     */
    public function send_tel_sms($user_info) {
        //验证字段合法性
        if ($this->verify('User', 'sent_tel_sms') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('User', 'logic');
        return $logic->send_tel_sms($user_info);
    }

}
