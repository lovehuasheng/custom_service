<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服管理业务逻辑层
// +----------------------------------------------------------------------

namespace app\user\logic;

use app\common\logic\Base;

class User extends Base {

    /**
     * 列表数据
     * @return type
     */
    public function get_list(&$data) {
        //判断数据状态 0-启用 1-禁用 2-删除
//        if(isset($data['status']) && $data['status'] == 2) {
//            $map['status'] = $data['status'];
//        }else {
//            $map['status'] = ['in',[0,1]];
//        }

        $map['status'] = ['in', [0, 1]];
        //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 1;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //获取满足条件的记录总数
        $total = $model->get_count($map);
        //取值字段
        $field = ['id', 'username', 'realname', 'group_id', 'group_name', 'status', 'mobile','inet_ntoa(last_login_ip) as last_login_ip', 'last_login_time', 'login_num', 'remark'];
        //取值
        $result_list = $model->get_list($map, $page, $per_page, $field);

        //获取页码列表
        $pages = get_pagination($total, $page, $per_page, $page_list);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data' => $result_list,
            'pages' => $pages
        ];

        return $this->result;
    }

    /**
     * 添加数据
     * @param type $data
     */
    public function add_user(&$data, $user_info) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');

        //添加数据
        $result_list = $model->set_user_data($data);

        if (!$result_list) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '添加失败!';
            $this->body = [];

            return $this->result;
        }
        
        //记录操作日志
        $msg =  '添加用户【用户ID：' . $model->id . '用户名：' . $data['username'] . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 2;
        $log['data']['remark']                  = get_log_type_text(2,$msg,'user/user/add_user');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
       //返回结果
        $this->error_code = '0';
        $this->error_msg = '添加成功!';
        $this->body = [];

        return $this->result;
    }

    /**
     * 获得用户数据
     * @param type $data
     */
    public function get_user($id) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //组装条件参数
        $map = ['id' => $id];
        //取值字段
        $field = ['id', 'username', 'realname', 'mobile','group_id', 'remark'];
        //取值
        $result_list = $model->get_user_info($map, $field);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data' => $result_list
        ];

        return $this->result;
    }

    /**
     * 修改用户
     * @param type $data
     */
    public function set_user(&$data, $user_info) {
        //重组数据
        $param = [
            'realname' => $data['realname'],
            'group_id' => $data['group_id'],
            'mobile' => isset($data['mobile']) ? $data['mobile'] : '',
            'email' => isset($data['email']) ? $data['email'] : '',
            'remark' => isset($data['remark']) ? $data['remark'] : '',
            'status' => isset($data['status']) ? $data['status'] : 0,
        ];

        if (!empty($data['password'])) {
            $param['salt']     = rand_string(6);
            $param['password'] = set_password($data['password'], $param['salt']);
        }
        //没有备注就销毁
        if (empty($param['remark'])) {
            unset($param['remark']);
        }
        
        if(!empty($data['group_id'])) {
           $group = model('permission/SysGroup')->get_by_id($data['group_id'],'group_name');
           $param['group_name'] = $group['group_name'];
        }
        //条件
        $map['id'] = $data['id'];
        //销毁变量
        unset($data);
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //更新数据
        $result_list = $model->update_user_data($map, $param);
        //判断返回结果
        if (!$result_list) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '更新失败!';
            $this->body = [];

            return $this->result;
        }
         //记录操作日志
        $msg =  '修改用户【用户ID:' . $map['id'] . '昵称：' . $param['realname'] . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg,'user/user/set_user');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '更新成功!';
        $this->body = [];

        return $this->result;
    }

    /**
     * 修改状态
     * @param type $status
     * @param type $ids
     * @return type
     */
    public function disable_user($status, $ids, $secondary_password, $user_info) {
        //判断id是否为数组，并组装条件
        if (is_array($ids)) {
            $map['id'] = ['in', $ids];
            $tmp_ids = implode(',', $ids);
        } else {
            $map['id'] = $ids;
            $tmp_ids = $ids;
        }
        $model = \think\Loader::model('SysUser', 'model');
        $map_info['id'] = $user_info['id'];
        $user = $model->get_user_info($map_info, 'secondary_password');
        if ($user['secondary_password'] != set_password(md5($secondary_password))) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '二级密码错误!';
            $this->body = [];

            return $this->result;
        }

        //更新的状态
        $param = ['status' => ($status == 3) ? 0 : $status];
        //定义状态值
        $arr = ['启用', '禁用', '删除', '还原'];
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //更新数据
        $result_list = $model->update_user_data($map, $param);
        //判断返回结果
        if (!$result_list) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = $arr[$status] . '操作失败!';
            $this->body = [];

            return $this->result;
        }

           //记录操作日志
        $msg = '修改用户状态为' . $arr[$status] . '【用户ID:' . $tmp_ids . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg,($status == 2 || $status == 3) ? 'user/user/del_user' : 'user/user/disable_user');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        //返回结果
        $this->error_code = '-200';
        $this->error_msg = $arr[$status] . '操作成功!';
        $this->body = [];

        return $this->result;
    }

    /**
     * 根据当前用户修改密码
     * @param type $data
     * @param type $user_id
     * @return type
     */
    public function set_password(&$data, $user_info) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //比对验证码
        $session_arr = session('send_tel_sms_admin');
        if (empty($session_arr) || $session_arr['code'] != $data['code']) {
            $this->error_code = '-200';
            $this->error_msg = '验证码错误!';
            $this->body = [];

            return $this->result;
        }
        //修改新密码
        //要更改密码的用户ID
        $map['id'] = $user_info['id'];
        //新密码
        $param['salt'] = rand_string(6);
        $param['password'] =set_password($data['password'],$param['salt']) ;
        
        //销毁变量
        unset($data);
        //更新数据
        $result_list = $model->update_user_data($map, $param);
        //判断返回结果
        if (!$result_list) {
            $this->error_code = '-200';
            $this->error_msg = '密码修改失败!';
            $this->body = [];

            return $this->result;
        }
        
             //记录操作日志
        $msg = '修改用户密码【用户ID:' . $map['id'] . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg,'user/user/set_user_password');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        //密码
        session('send_tel_sms_admin', null);
        //二级密码
        session('send_tel_sms_admin_pwds', null);
        //姓名
        session('send_tel_sms_admin_relaname', null);

        //返回结果
        $this->error_code = '0';
        $this->error_msg = '密码修改成功!';
        $this->body = [];

        return $this->result;
    }

    /**
     * 根据当前用户修改二级密码
     * @param type $data
     * @param type $user_id
     * @return type
     */
    public function set_user_secondary_password(&$data, $user_info) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //比对验证码
        $session_arr = session('send_tel_sms_admin_pwds');
        if (empty($session_arr) || $session_arr['code'] != $data['code']) {
            $this->error_code = '-200';
            $this->error_msg = '验证码错误!';
            $this->body = [];

            return $this->result;
        }
        //修改新密码
        //要更改密码的用户ID
        $map['id'] = $user_info['id'];
        //新二级密码
        $param['secondary_password'] = set_password(md5($data['secondary_password']));

        //销毁变量
        unset($data);
        //更新数据
        $result_list = $model->update_user_data($map, $param);
        //判断返回结果
        if (!$result_list) {
            $this->error_code = '-200';
            $this->error_msg = '二级密码修改失败!';
            $this->body = [];

            return $this->result;
        }
        
            //记录操作日志
        $msg = '修改用户二级密码【用户ID:' . $map['id'] . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg, 'user/user/set_user_secondary_password');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        //密码
        session('send_tel_sms_admin', null);
        //二级密码
        session('send_tel_sms_admin_pwds', null);
        //姓名
        session('send_tel_sms_admin_relaname', null);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '二级密码修改成功!';
        $this->body = [];

        return $this->result;
    }

    /**
     * 根据当前用户修改真实姓名
     * @param type $data
     * @param type $user_id
     * @return type
     */
    public function set_user_realname(&$data, $user_info) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //比对验证码
        $session_arr = session('send_tel_sms_admin_relaname');
        if (empty($session_arr) || $session_arr['code'] != $data['code']) {
            $this->error_code = '-200';
            $this->error_msg = '验证码错误!';
            $this->body = [];

            return $this->result;
        }
        //修改新密码
        //要更改密码的用户ID
        $map['id'] = $user_info['id'];
        //新名称
        $param['realname'] = $data['realname'];
        //销毁变量
        unset($data);
        //更新数据
        $result_list = $model->update_user_data($map, $param);
        //判断返回结果
        if (!$result_list) {
            $this->error_code = '-200';
            $this->error_msg = '姓名修改失败!';
            $this->body = [];

            return $this->result;
        }
        
        //记录操作日志
        $msg = '修改用户姓名【用户ID:' . $map['id'] . '】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg, 'user/user/set_user_realname');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
       //密码
        session('send_tel_sms_admin', null);
        //二级密码
        session('send_tel_sms_admin_pwds', null);
        //姓名
        session('send_tel_sms_admin_relaname', null);

        //返回结果
        $this->error_code = '0';
        $this->error_msg = '姓名修改成功!';
        $this->body = [];

        return $this->result;
    }

    /**
     * 发送短信
     * @param type $user_info
     */
    public function send_tel_sms($user_info) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        $map['id'] = $user_info['id'];
        $user = $model->get_user_info($map, 'mobile');

     
        $code = rand_string(6, 1);
        //存入session
        $arr['code'] = $code;
        //密码
        session('send_tel_sms_admin', $arr);
        //二级密码
        session('send_tel_sms_admin_pwds', $arr);
        //姓名
        session('send_tel_sms_admin_relaname', $arr);
        //发送短信
        $text = '你的账号正在修改，如若不是本人操作，请登录查看！验证码是';
        if (sendSms($user['mobile'], $text, $code)) {
            $data = [
                'sys_uid' => $user_info['id'],
                'mobile' => $user['mobile'],
                'code' => $code,
                'create_time' => time(),
                'update_time' => time()
            ];
            \think\Db::table('sxh_sys_sms')->insert($data);
            //返回结果
            $this->error_code = '0';
            $this->error_msg = '验证码发送成功!';
            $this->body = [];
            return $this->result;
        } else {
            //返回结果
            $this->error_code = '-20032';
            $this->error_msg = '发送短信失败请稍后再试!';
            $this->body = [];
            return $this->result;
        }
    }

    /**
     * 登录
     * @return type
     */
    public function login(&$data) {

        //判断验证码是否正确
        if(!session('?verify.code') || $data['code'] != session('verify.code'))
        {
            $this->error_code = '-20029';
            $this->error_msg = '验证码不正确!';
            $this->body = [];
            return $this->result;
        }
        //计算时间差
        $time_diff = time()-session('verify.time');
        //验证码过期时间
        $verify_expire = config('verify_expire');
        //验证码5分钟失效
        if($time_diff > $verify_expire)
        {   
            //清除过期的session
            session('verify.code',null);
            session('verify.time',null);
            
            $this->error_code = '-20030';
            $this->error_msg = '验证码已过期!';
            $this->body = [];
            return $this->result;
        } 
       
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //查询用户信息
        $user = $model->get_user_info(['username' => $data['username']], 'id,username,password,salt,realname,group_id,group_name,permissions,mobile,email,is_super,status,last_login_ip,last_login_time,login_num,bind_uid');
       //数据比对
        if (empty($user)) {
            //返回结果
            $this->error_code = '-20030';
            $this->error_msg = '用户名或密码不存在!';
            $this->body = [];

            return $this->result;
        }
        //比对状态
        if ($user['status'] == 1) {
            //返回结果
            $this->error_code = '-20031';
            $this->error_msg = '账号被禁用了!';
            $this->body = [];

            return $this->result;
        }
        //比对密码
        if ($user['password'] !== set_password($data['password'], $user['salt'])) {
            //返回结果
            $this->error_code = '-20032';
            $this->error_msg = '密码不对哦!';
            $this->body = [];

            return $this->result;
        }


        if($user['is_super'] == 0)
        {
            //查询用户组信息
            $group_info = model('permission/SysGroup')->get_by_id($user['group_id'],['panel_type','status']);
           //用户组不可用
            if($group_info->status != 0 )
            {
                $this->error_code = '-20033';
                $this->error_msg  = '你所在的用户组被禁用或者删除,无法登录系统';
                return $this->result;
            }
        }

        //用户面板
        $user['panel_type'] = isset($group_info->panel_type) ? $group_info->panel_type : 0;

        //记录登录时间与ip
        $param = [
            'last_login_ip' => get_client_ip(1),
            'last_login_time' => $_SERVER['REQUEST_TIME'],
            'login_num' => $user['login_num'] + 1,
        ];
        //更新登录时间 
        $model->update_user_data(['id' => $user['id']], $param);
        //记录seseeion
        $info = $model->auto_login($user, $param);
        
         //记录操作日志
        $msg = '【用户:' . $user['realname'] . '】登录账号成功';
        $log['data']['uid']                     = $user['id'];
        $log['data']['username']                = $user['username'];
        $log['data']['realname']                = $user['realname'];
        $log['data']['type']                    = 0;
        $log['data']['remark']                  = get_log_type_text(1,$msg, 'user/index/login');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
  
        
        $login_log['data']['uid']                     = $user['id'];
        $login_log['data']['username']                = $user['username'];
        $login_log['data']['realname']                = $user['realname'];
        $login_log['data']['remark']                  = '登录系统';
        $login_log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $login_log['model_name']                      = 'SysUserLoginLog';
        //加入队列
        add_to_queue('',$login_log);
        session('login_log_time',$_SERVER['REQUEST_TIME']+config('login_time_out'));
      
        
        unset($data);
        unset($param);
        unset($login_log);
        unset($user);

        //返回结果
        $this->error_code = '0';
        $this->error_msg = '登录成功!';
        $this->body = [];

        return $this->result;
    }

    //发送验证码
    public function send_verify(&$data) {
        //实例化模型
        $model = \think\Loader::model('SysUser', 'model');
        //查询用户信息
        $user = $model->get_user_info(['username' => $data['username']], 'id,mobile,status');
        //数据比对
        if (empty($user)) {
            //返回结果
            $this->error_code = '-20030';
            $this->error_msg = '用户名或密码不存在!';
            $this->body = [];
            return $this->result;
        }

        //比对状态
        if ($user['status'] == 1) {
            //返回结果
            $this->error_code = '-20031';
            $this->error_msg = '账号被禁用了!';
            $this->body = [];

            return $this->result;
        }

        //获取用户的手机号码
        $mobile = $user['mobile'];
        //获取随机数
        $verify_code = get_rand_num();
        //保存随机数到sesion
        session('verify', ['code' => $verify_code, 'time' => time()]);

        //发送短信
        $text = '你本次登录的验证码是';
        if (sendSms($mobile, $text, $verify_code)) {
            $data = [
                'sys_uid' => $user['id'],
                'mobile' => $mobile,
                'code' => $verify_code,
                'create_time' => time(),
                'update_time' => time()
            ];
            \think\Db::table('sxh_sys_sms')->insert($data);
            //返回结果
            $this->error_code = '0';
            $this->error_msg = '验证码发送成功!';
            $this->body = [];
            return $this->result;
        } else {
            //返回结果
            $this->error_code = '-20032';
            $this->error_msg = '发送短信失败请稍后再试!';
            $this->body = [];
            return $this->result;
        }
    }

}
