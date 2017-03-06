<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【收入流水】控制器
// +----------------------------------------------------------------------

namespace app\journal\controller;
use app\common\controller\Base;

class Income extends Base{
    
   /**
   * 收入流水操作日志列表
   * @return type
   */
    public function get_list() {

        
        $service = \think\Loader::model('Income', 'service');
        return $service->get_list($this->user_info);
    }
    
    
    /**
     * 转让收入流水
     * @return type
     */
    public function make_over_log() {
        $service = \think\Loader::model('Income', 'service');
        return $service->make_over_log($this->user_info);
    }
    
    /**
     * 删除收入记录
     * @return type
     */
    public function destroy_income_log() {
        $service = \think\Loader::model('Income', 'service');
        return $service->make_over_log($this->user_info);
    }
   
}