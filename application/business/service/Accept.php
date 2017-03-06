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

namespace app\business\service;

use app\common\service\Base;

class Accept extends Base {

    /**
     * 查询单条数据
     * @param type $user_id
     * @return type
     */
    public function get_accept_data($user_info) {
        //验证字段合法性
        if($this->verify('Accept','get_data') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Accept', 'logic');
        return $logic->get_accept_data($this->data['id'],$user_info);
    }
    
    
    /**
     * 提供资助列表
     * @return type
     */
    public function get_list($user_info) {
        //验证字段合法性
        if($this->verify('Accept','get_list') != true) {
            return $this->result;
        }
        $logic = \think\Loader::model('Accept', 'logic');
        //实例化
        return $logic->get_list($this->data,$user_info);
    }
    
    /**
     * 提供资助加入手动匹配列表
     * @return type
     */
     public function set_manual_match($user_info) {
        //验证字段合法性
        if($this->verify('Accept','set_manual_match') != true) {
            return $this->result;
        }
        $logic = \think\Loader::model('Accept', 'logic');
        //实例化
        return $logic->set_manual_match($this->data,$user_info);
    }
    
     public function set_accepthelp_money_by_account($user_info) {
         
        //验证字段合法性
        if($this->verify('Accept','set_accepthelp_money') != true) {
            return $this->result;
        }
        $logic = \think\Loader::model('Accept', 'logic');
        //实例化
        return $logic->set_accepthelp_money_by_account($this->data,$user_info);
    }

}
