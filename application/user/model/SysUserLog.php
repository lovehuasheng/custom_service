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
use app\common\model\Base;

class SysUserLog extends Base
{
    
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = false;
    
    protected function initialize() {
        $this->get_month_submeter();
      
    }
    
    protected static function getTypeAttr($value,$data) {
        $type = ['登录','修改','添加','删除','还原'];
        return $type[$data['type']];
    }
            


    /**
     * 添加数据
     * @param type $map
     * @param type $data
     * @return type
     */
    public function  set_log_data($uid,$username,$realname,$type,$remark,$url) {
        $param = [
            'uid'          => $uid,
            'username'     => $username,
            'realname'     => $realname,
            'type'         => $type,
            'remark'       => $this->get_log_type_text($type,$remark,$url),
            'create_time'  => $_SERVER['REQUEST_TIME'],
        ];
        return $this->partition($this->info,$this->info_field,$this->rule)->insert($param);
    }
    
    
    /**
     * 获取操作文本
     * @param type $type
     * @param type $remark
     * @param type $url
     * @return string
     */
    protected static function get_log_type_text($type,$remark,$url) {
        $str = '';
        switch ($type) {
            case 1:
                $str = '【修改更新】'.$remark.';操作地址：'.$url;
                break;
            case 2:
                $str = '【添加数据】'.$remark.';操作地址：'.$url;
                break;
            case 3:
                $str = '【删除数据】'.$remark.';操作地址：'.$url;
                break;
            default : 
                $str = '【登录后台】'.$remark.';操作地址：'.$url;
                break;
        }
        
        return $str;
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