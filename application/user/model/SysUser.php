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
use think\Model;

class SysUser extends Model
{
    
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    
    /**
     * 设置密码
     * @param type $value
     * @param type $data
     * @return type
     */
//    protected function setPasswordAttr($value,$data) {
//
//        return isset($data['password'])?set_password($data['password'],$data['salt']):'';
//        
//       
//    }
//    protected function setSecondaryPasswordAttr($value,$data) {
//   
//        return isset($data['secondary_password'])?set_password(md5($data['secondary_password'])):'';
//        
//       
//    }
    

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
            return $list;
        }
        return [];
    }
    
    /**
     * 添加数据
     * @param type $map
     * @param type $data
     * @return type
     */
    public function  set_user_data(&$data) {
        $data['salt'] = rand_string(6);
        $param = [
            'username' => $data['username'],
            'password' => set_password($data['password'],$data['salt']),
            'secondary_password' => set_password(md5($data['password'])),
            'realname' => $data['realname'],
            'mobile'   => isset($data['mobile'])?$data['mobile']:'',
            'email'    => isset($data['email'])?$data['email']:'',
            'salt'     => $data['salt'],
            'is_super' => isset($data['is_super'])?$data['is_super']:0,
            'remark'   => isset($data['remark'])?$data['remark']:'后台注册',
            'status'   => isset($data['status'])?$data['status']:0,
        ];

        return $this->save($param);
    }
    
    /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function  update_user_data($map=[],&$param) {
        
        return $this->save($param,$map);
       
    }
    
    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_user_info($map = [],$field='*') {
        $list = $this->where($map)->field($field)->find();
        if($list) {
            $list->status_text = $list->status_text;
            $list =  $list->toArray();
            return $list;
        }
        return [];
    }
    
    /**
     * 记录session，自动登陆
     * @param type $user
     */
    public function auto_login(&$user,&$param) {
        $rand_str = rand_string(16);
        $data = [
            'id'               => $user['id'],
            'username'         => $user['username'],
            'realname'         => $user['realname'],
            'group_id'         => $user['group_id'],
            'group_name'       => $user['group_name'],
            'permissions'      => $user['permissions'],
            'is_super'         => $user['is_super'],
            'panel_type'       => $user['panel_type'],
            'bind_uid'         => $user['bind_uid'],
            'last_login_ip'    => $user['last_login_ip'],
            'last_login_time'  => $user['last_login_time'],
            'final_login_ip'   => $param['last_login_ip'],
            'final_login_time' => $param['last_login_time'],
            'rand_str'         => $rand_str,
           
        ];
        
        cache('user_rank_'.$user['id'],substr(md5($rand_str),0,16));
        session('user_auth', $data);
	session('user_auth_sign', set_user_session_sign($data));
        
        return true;
    }
    
     /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_count($map = []) {
        return $this->where($map)->count();
    }
    
    /**
     * 获取客服列表
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_list_by_map($map,$field) {
         return $this->where($map)->field($field)->select();
    }
}