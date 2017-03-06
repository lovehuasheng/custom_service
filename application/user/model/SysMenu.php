<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【菜单管理】 数据层
// +----------------------------------------------------------------------

namespace app\user\model;
use think\Model;

class SysMenu extends Model
{
    
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    
   
    
    
    /**
     * 获取状态文本
     * @param type $value
     * @param type $data
     * @return string
     */
    protected function getStatusTextAttr($value,$data) {
         $status = ['启用','禁用','删除'];
         return isset($data['status'])?$status[$data['status']]:0;
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
    public function get_list($map,$page=1,$r=20,$field='*',$order='id desc') {
        $config['page'] = $page;
        $list = $this->where($map)->field($field)->order($order)->page($page,$r)->select();
        if($list) {
            return $list->toArray();
        }
        return [];
    }
    
    /**
     * 添加数据
     * @param type $map
     * @param type $data
     * @return type
     */
    public function  set_menu_data($map = [],&$data) {
        $category = [];
        if(isset($data['pid'])) {
            $category = $this->get_menu_info(['id'=>$data['pid']],'name');
        }
        $param = [
            'name'  => $data['name'],
            'href'  => $data['href'],
            'group' => $data['group'],
            'pid'   => isset($data['pid'])?$data['pid']:0,
            'pname' => !empty($category['name'])?$category['name']:'',
            'sort'  => isset($data['sort'])?$data['sort']:0,
            'status'=> isset($data['status'])?$data['status']:0,
            'is_hidden'=> isset($data['is_hidden'])?$data['is_hidden']:0,
        ];
        return $this->save($param,$map);
    }
    
    /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function  update_menu_data($map=[],&$param) {
        
        return $this->save($param,$map);
       
    }
    
    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_menu_info($map = [],$field='*') {
        $list = $this->where($map)->field($field)->find();
        if($list) {
            $list->status_text = $list->status_text;
            $list =  $list->toArray();
            return $list;
        }
        return [];
    }
    
    
    /**
     * 获取一级菜单
     * @param type $field
     * @param type $order
     * @return type
     */
    public function get_frist_menu_list($field='id,name',$order = 'sort asc') {
        $map['pid'] = 0;
        return $this->where($map)->field($field)->order($order)->select();
    }
    
    /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_count($map = []) {
        return $this->where($map)->count();
    }
}