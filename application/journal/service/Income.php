<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【收入流水】服务层
// +----------------------------------------------------------------------

namespace app\journal\service;

use app\common\service\Base;

class Income extends Base {

    /**
     * 查询列表数据
     * @param type $user_id
     * @return type
     */
    public function get_list($user_info) {
        //验证字段合法性
        if($this->verify('Income','get_list') != true) {
            $this->ajax_return();
        }
        //实例化
        $logic = \think\Loader::model('Income', 'logic');
        return $logic->get_list($this->data);
    }
    
    /**
     * 转让记录
     * @param type $user_info
     * @return type
     */
    public function make_over_log($user_info) {
        //验证字段合法性
        if($this->verify('Income','get_list') != true) {
            $this->ajax_return();
        }
        //实例化
        $logic = \think\Loader::model('Income', 'logic');
        return $logic->make_over_log($this->data,$user_info);
    }
    
    /**
     * 删除收入记录
     * @return type
     */
    public function destroy_income_log() {
         //验证字段合法性
        if($this->verify('Income','destroy') != true) {
            $this->ajax_return();
        }
        //实例化
        $logic = \think\Loader::model('Income', 'logic');
        return $logic->make_over_log($this->data,$user_info);
    }

}
