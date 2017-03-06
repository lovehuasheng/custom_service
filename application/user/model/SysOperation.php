<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服用户管理数据层
// +----------------------------------------------------------------------

namespace app\user\model;
use app\common\model\Base;

class SysOperation extends Base
{
    
    protected $autoWriteTimestamp = 'true';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = false;
 
    protected function initialize() {
        $this->get_month_submeter();
      
    }
    
    
    /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function  update_user_data($map=[],&$param) {
        
        return $this->partition($this->info,$this->info_field,$this->rule)->save($param,$map);
       
    }
    
    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_user_info($map = [],$field='*') {
        $list = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();
        if($list) {
            $list->status_text = $list->status_text;
            $list =  $list->toArray();
            return $list;
        }
        return [];
    }
    
    
    
    /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_count($map = []) {
        return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->count();
    }
    
    /**
     * 分页数据
     * @param type $map
     * @param type $page
     * @param type $r
     * @param type $field
     * @param type $order
     * @return type
     */
    public function get_list_info($map, $page = 1, $r = 20, $field = '*', $order = 'id desc') {
       return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->order($order)->page($page,$r)->select();
    }

}