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

class Ranking extends Base {

    /**
     * 查询
     * @param type $user_id
     * @return type
     */
    public function get_data($user_info) {
        //验证字段合法性
        if($this->verify('Ranking','get_data') != true) {
            $this->ajax_return();
        }
        //实例化
        $logic = \think\Loader::model('Ranking', 'logic');
        if($this->data['flag'] == 1) {
            return $logic->get_data($this->data,$user_info);
        }else {
            return $logic->get_data_by_month($this->data,$user_info);
        }
        
    }
    
    
}
