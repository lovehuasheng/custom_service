<?php

namespace app\common\model;

use think\Model;

class Base extends Model {

    protected $rule = [];
    protected $info = [];
    protected $info_field = '';

    //自定义初始化
    protected function initialize() {
        
    }

    
    /**
     * 按月分表
     * @param type $month_num
     */
    protected function get_month_submeter($search_time = '', $month_num = 3) {
        //分表规则
        $this->rule = [
            'type' => 'quarter', // 分表方式,按月分表
            'expr' => $month_num     // 按3月一张表分
        ];
        //分表数据
        $this->info = [
            'now_time' => $search_time? $search_time : $_SERVER['REQUEST_TIME']  
        ];
        $this->info_field = 'now_time';
    }

}
