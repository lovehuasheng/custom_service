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

namespace app\business\controller;
use app\common\controller\Base;

class Accept extends Base{
    
    /**
     * ajax取值【作用：查询接受订单数据】
     * @return type
     */
    public function get_accept_data() {
        $service = \think\Loader::model('Accept', 'service');
        return $service->get_accept_data($this->user_info);
    }
    
    
     /**
     * 接受资助列表
     * @return type
     */
    public function get_list() {
        $service = \think\Loader::model('Accept', 'service');
        return $service->get_list($this->user_info);
    }
    
    /**
     * 接受资助加入手动匹配列表
     * @return type
     */
    public function set_manual_match() {
        $service = \think\Loader::model('Accept', 'service');
        return $service->set_manual_match($this->user_info);
    }
    
    /**
     * 更改会员接受资助的金额，从出局钱包中转入接受资助中
     * @return type
     */
    public function set_accepthelp_money_by_account() {
        $service = \think\Loader::model('Accept', 'service');
        return $service->set_accepthelp_money_by_account($this->user_info);
    }
   
}