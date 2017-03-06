<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【接受资助】 验证层
// +----------------------------------------------------------------------

namespace app\statistics\validate;

use think\Validate;

class Statistics extends Validate {

    protected $rule = [
        'flag'                                                      => 'require|min:1',
        'page'                                                      => 'number|min:1',
        'per_page'                                                  => 'number|min:1',
        'uid'                                                       => 'number|min:1',
        'year_date'                                                 => 'require|number|min:0',
        'month_date'                                                => 'require|number|min:0',
        'day_date'                                                  => 'require|number|min:0',
    ];
    
    
    protected $message = [
        'flag.require'                                              => '参数错误|-10001',
        'flag.min'                                                  => '参数错误|-10002',
        'page.number'                                               => 'page必须是数字|-10003',
        'page.min'                                                  => 'page不在取值范围内|-10004',
        'per_page.number'                                           => 'per_page必须是数字|-10003',
        'per_page.min'                                              => 'per_page不在取值范围内|-10004',
        'uid.min'                                                   => 'uid不在取值范围内|-10004',
        'uid.number'                                                => 'uid必须是数字|-10003',
        'year_date.min'                                             => '不在取值范围内|-10004',
        'year_date.number'                                          => '必须是数字|-10003',
        'year_date.require'                                         => '参数错误|-10003',
        'month_date.min'                                            => '不在取值范围内|-10004',
        'month_date.number'                                         => '必须是数字|-10003',
        'month_date.require'                                        => '参数错误|-10003',
        'day_date.min'                                              => '不在取值范围内|-10004',
        'day_date.number'                                           => '必须是数字|-10003',
        'day_date.require'                                          => '参数错误|-10003',
    ];
    
     protected $scene = [
        'get_data'                                                  =>  ['flag'],
        'get_login_log'                                             =>  ['flag','page','per_page'],
        'get_count_workload'                                        =>  ['uid'],
        'register_count'                                            =>  ['year_date'],
        'register_month_count'                                      =>  ['year_date','month_date'],
        'efficiency_month_count'                                    =>  ['month_date','uid'=>'number|min:0'],
        'efficiency_count'                                          =>  ['year_date','month_date','day_date'],
        'quality_count'                                             =>  ['year_date','month_date'],
        'quality_year_count'                                             =>  ['year_date'],
       
    ];

}
