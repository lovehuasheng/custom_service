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

class Ranking extends Base{
    
    /**
     * ajax取值【作用：查询接受订单数据】
     * @return type
     */
    public function lists() {
        $service = \think\Loader::model('Ranking', 'service');
        return $service->get_data($this->user_info);
    }
    
    
     
}