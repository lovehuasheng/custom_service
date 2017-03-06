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

namespace app\business\controller;
use app\common\controller\Base;

class Provide extends Base{
    
    /**
     * 提供资助列表
     * @return type
     */
    public function get_list() {
        $service = \think\Loader::model('Provide', 'service');
        return $service->get_list($this->user_info);
    }
    
    /**
     * 提供资助加入手动匹配列表
     * @return type
     */
    public function set_manual_match() {
        $service = \think\Loader::model('Provide', 'service');
        return $service->set_manual_match($this->user_info);
    }
    
    /**
     * 撤单
     * @return type
     */
    public function destroy_provide() {
        $service = \think\Loader::model('Provide', 'service');
        return $service->destroy_provide(2,$this->user_info);
    }
    
    /**
     * ajax取值【作用：查询提供订单数据】
     * @return type
     */
    public function get_proivde_data() {
        $service = \think\Loader::model('Provide', 'service');
        return $service->get_proivde_data($this->user_info);
    }
    
    
   
}