<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台 【菜单管理】 控制器
// +----------------------------------------------------------------------

namespace app\user\controller;
use app\common\controller\Base;

class Menu extends Base{
    
    /**
     * 菜单列表
     * @return type
     */
    public function menu_list() {
        
        $service = \think\Loader::model('Menu', 'service');
        return $service->get_list($this->user_info);
    }
    
    /**
     * 添加菜单
     * @return type
     */
    public function add_menu() {
        $service = \think\Loader::model('Menu', 'service');
        return $service->add_menu($this->user_info);
    }
    
    /**
     * 获得单个用户数据
     * @return type
     */
    public function get_menu() {
        $service = \think\Loader::model('Menu', 'service');
        return $service->get_menu($this->user_info);
    }
    
    /**
     * 修改菜单
     * @return type
     */
    public function set_menu() {
        $service = \think\Loader::model('Menu', 'service');
        return $service->set_menu($this->user_info);
    }
    
    /**
     * 禁用/启用菜单
     * @return type
     */
    public function disable_menu() {
        $service = \think\Loader::model('Menu', 'service');
        return $service->disable_menu($this->user_info);
    }
    
    /**
     * 删除菜单
     * @return type
     */
    public function del_menu() {
        $service = \think\Loader::model('Menu', 'service');
        return $service->del_menu($this->user_info);
    }
    
    /**
     * 回收站
     * @return type
     */
    public function menu_recycle_bin() {
       $service = \think\Loader::model('Menu', 'service');
       return $service->get_list($this->user_info); 
    }
    
    /**
     * 清空回收站
     * @return type
     */
    public function clean_menu_recycle() {
       $service = \think\Loader::model('Menu', 'service');
       return $service->del_menu($this->user_info); 
    }
}
