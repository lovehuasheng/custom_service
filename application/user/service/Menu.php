<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【菜单管理】 服务层
// +----------------------------------------------------------------------

namespace app\user\service;

use app\common\service\Base;

class Menu extends Base {
    
    /**
     * 获得列表数据
     * @return type
     */
    public function get_list($user_info) {
        //实例化
        $logic = \think\Loader::model('Menu', 'logic');
        return $this->ajax_return( $logic->get_list($this->data) );
    }
    
    

    /**
     * 添加菜单
     * @param type $user_id
     * @return type
     */
    public function add_menu($user_info) {
         //验证字段合法性
        if($this->verify('Menu','add') != true) {
             return $this->result;
        }
        //实例化 
        $logic = \think\Loader::model('Menu', 'logic');
        return $logic->add_menu($this->data,$user_info);
     
    }
    
    /**
     * 获得单个菜单数据
     * @return type
     */
    public function get_menu($user_info) {
        //验证字段合法性
        if($this->verify('Menu','get_data') != true) {
             return $this->result;
        }
        //实例化 
        $logic = \think\Loader::model('Menu', 'logic');
        return $logic->get_menu($this->data['id']);
       
    }
    
     /**
     * 修改菜单
     * @return type
     */
    public function set_menu($user_info) {
        //验证字段合法性
        if($this->verify('Menu','edit') != true) {
             return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Menu', 'logic');
        return $logic->set_menu($this->data,$user_info);
        
    }
    
    
    
    /**
     * 修改菜单状态
     * @return type
     */
    public function disable_menu($user_info) {
        
       //验证字段合法性
        if($this->verify('Menu','disable') != true) {
            return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Menu', 'logic');
        return $logic->disable_menu($this->data['status'],$this->data['ids'],$user_info);
      
    }
    
    /**
     * 删除菜单
     * @return type
     */
    public function del_menu($user_info) {
        
          
       //验证字段合法性
        if($this->verify('Menu','destroy') != true) {
             return $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Menu', 'logic');
        return $logic->disable_menu($this->data['status'],$this->data['ids'],$user_info);
     
    }
    
   
}
