<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服用户管理控制器
// +----------------------------------------------------------------------

namespace app\statistics\controller;

use app\common\controller\Base;
    
class Templet extends Base {

    //排行榜
    public function lists() {
        return view(ROOT_PATH . 'templates/ranking_list.html');
    }
    
    //我的首页
    public function home() {
        return view(ROOT_PATH . 'templates/home.html');
    }
    
    //log更多页面
    public function more() {
        return view(ROOT_PATH . 'templates/more.html');
    }
    
    //注册质量统计
    public function register_count() {
        return view(ROOT_PATH . 'templates/register.html');
    }
    
    //审核质量统计
    public function quality_count() {
        return view(ROOT_PATH . 'templates/quality.html');
    }
    
    //审核质量统计  全年统计
    public function yearly_count() {
        return view(ROOT_PATH . 'templates/quality_yearly.html');
    }
    
    //工作效率统计
    public function efficiency_count() {
        return view(ROOT_PATH . 'templates/efficiency.html');
    }
}
