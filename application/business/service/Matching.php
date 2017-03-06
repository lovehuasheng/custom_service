<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【匹配详情】服务层
// +----------------------------------------------------------------------

namespace app\business\service;

use app\common\service\Base;

class Matching extends Base {

  
    /**
     * 提供资助列表【测试通过】
     * @return type
     */
    public function get_list($user_info,$type) {
        //验证字段合法性
        if($this->verify('Matching','list_data') != true) {
           return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->get_list($this->data,$type);
    }
    
    /**
     * 软删除【测试通过】还原订单
     * @return type
     */
    public function destroy_match($user_info) {
        //验证字段合法性
        if($this->verify('Matching','destroy') != true) {
            return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->destroy_match($this->data,$user_info);
    }
    
    
     /**
     * 还原删除订单
     * @return type
     */
//    public function reduction_match($user_info) {
//        //验证字段合法性
//        if($this->verify('Matching','reduction') != true) {
//            return  $this->result;
//        }
//        //实例化
//        $logic = \think\Loader::model('Matching', 'logic');
//        return $logic->reduction_match($this->data,$user_info);
//    }
    
    /**
     * 订单延时【测试通过】
     * @param type $user_id
     * @return type
     */
    public function delayed_match($user_info) {
        //验证字段合法性
        if($this->verify('Matching','delayed') != true) {
            return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->delayed_match($this->data,$user_info);
    }
    
    /**
     * 手动匹配
     * @param type $user_id
     * @return type
     */
    public function manual_match($user_info) {
        //验证字段合法性
        if($this->verify('Matching','add') != true) {
            return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->manual_match($this->data,$user_info);
    }
   
    /**
     * 手动匹配列表
     * @param type $user_info
     * @return type
     */
    public function get_manal_match_list($user_info) {
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->get_manal_match_list($user_info);
    }
    
    /**
     *审核匹配
     * @param type $user_info
     * @return type
     */
     public function set_manual_match($user_info) {
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->set_manual_match($this->data,$user_info);
    }
    /**
     * 更改订单
     * @param type $user_info
     * @return type
     */
//    public function edit_match($user_info) {
//        //验证字段合法性
//        if($this->verify('Matching','edit') != true) {
//           return  $this->result;
//        }
//        //实例化
//        $logic = \think\Loader::model('Matching', 'logic');
//        return $logic->manual_match($this->data,$user_info);
//    }
    
    /**
     * 超时订单列表【测试通过】
     * @param type $user_info
     * @return type
     */
    public function overtime_order_list($user_info,$type) {
        //验证字段合法性
        if($this->verify('Matching','overtime') != true) {
           return  $this->result;
        }
        $this->data['type'] = $type;
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->overtime_order_list($this->data);
    }
    
    /**
     * 转移订单到接单人
     * @return type
     */
    public function transfer_order_to_user($user_info) {
        //验证字段合法性
        if($this->verify('Matching','transfer') != true) {
           return  $this->result;
        }
        
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->transfer_order_to_user($this->data,$user_info);
    }
    
    
    /**
     * 撤销假图
     * @param type $user_info
     * @return type
     */
     public function undo_img($user_info) {
         //验证字段合法性
        if($this->verify('Matching','undo') != true) {
           return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->undo_img($this->data,$user_info);
     }
     
     /**
      * 撤单封号
      * @param type $user_info
      * @return type
      */
     public function disable_no($user_info) {
         //验证字段合法性
        if($this->verify('Matching','disable_no') != true) {
           return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->disable_no($this->data,$user_info);
     }
     
     /**
      * 确认收款
      * @param type $user_info
      * @return type
      */
     public function accept_collections($user_info) {
          //验证字段合法性
        if($this->verify('Matching','collections') != true) {
           return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->accept_collections($this->data,$user_info);
     }
     
     
     /**
      * 删除手动匹配数据
      * @param type $user_info
      * @return type
      */
     public function del_manual_match($user_info) {
           //验证字段合法性
        if($this->verify('Matching','del') != true) {
           return  $this->result;
        }
        //实例化
        $logic = \think\Loader::model('Matching', 'logic');
        return $logic->del_manual_match($this->data,$user_info);
     }
     
     public function get_jieke($user_info){
     	 $logic = \think\Loader::model('Matching', 'logic');
     	return $logic->get_jieke($this->data,$user_info);
     }
}
