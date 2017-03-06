<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台 【菜单管理】 业务逻辑层
// +----------------------------------------------------------------------


namespace app\user\logic;
use think\Model;


class Menu extends Model
{
    /**
     * 列表数据
     * @return type
     */
    public function get_list(&$data) {
        //上级id
        $map['pid'] = isset($data['pid'])?$data['pid']:0;
        //数据状态 0-启用 1-禁用 2-删除
        if(isset($data['status']) && $data['status'] == 2) {
            $map['status'] = $data['status'];
        }else {
            $map['status'] = ['in',[0,1]];
        }
        //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 1;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');
        //实例化模型
        $model = \think\Loader::model('SysMenu', 'model');
        //获取满足条件的记录总数
        $total = $model->get_count($map);
        //取值字段
        $field = ['*'];
        //取值
        $result_list = $model->get_list($map,$page,$per_page,$field);
       
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
    public function add_menu(&$data,$user_info) {
        //实例化模型
        $model = \think\Loader::model('SysMenu', 'model');
        //插入数据
        $result_list = $model->set_menu_data([],$data);
        //判断返回结果
        if(!$result_list) {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '添加失败!';
            $this->body = [];

            return $this->result;
        }
        
        
         //记录操作日志
        $msg = '添加菜单【菜单ID：'.$model->id.'菜单名：'.$data['name'].'】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 2;
        $log['data']['remark']                  = get_log_type_text(1,$msg, 'user/menu/add_menu');
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
     * 获得菜单数据
     * @param type $data
     */
    public function get_menu($id) {
        //实例化模型
        $model = \think\Loader::model('SysMenu', 'model');
        //组装条件
        $map = ['id'=>$id];
        //取值字段
        $field = ['*'];
        //取值
        $result_list = $model->get_menu_info($map,$field);
        //取一级菜单列表
        $first_menu = $model->get_frist_menu_list();
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '添加成功!';
        $this->body = [
            'data'=>$result_list,
            'menu'=> $first_menu
                ];

        return $this->result;
      
    }
    
    /**
     * 修改菜单
     * @param type $data
     */
    public function set_menu(&$data,$user_info) {
        //实例化模型
        $model = \think\Loader::model('SysMenu', 'model');
        //组装条件
        $map = ['id'=>$data['id']];
        //更新数据
        $result_list = $model->set_menu_data($map,$data);
        //判断返回结果
        if(!$result_list) {
            return ['code'=>'-1','msg'=>'更新失败','body'=>[]];
        }
        
        //记录操作日志
        $msg = '修改菜单【菜单ID：'.$data['id'].'；菜单名称：'.$data['name'].'】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg, 'user/menu/set_menu');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        
        //销毁变量
        unset($data);
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
    public function disable_menu($status,$ids,$user_info) {
        //判断id是否为数组
        if(is_array($ids)) {
            $map['id'] = ['in',$ids];
            $tmp_ids = implode(',', $ids);
        }else {
            $map['id'] = $ids;
            $tmp_ids = $ids;
        }
        //状态值
        $param = ['status'=>($status == 3)?0:$status];
        
        //定义状态
        $arr = ['启用', '禁用','删除','还原'];
        //实例化模型
        $model = \think\Loader::model('SysMenu', 'model');
        //更新状态
        $result_list = $model->update_menu_data($map,$param);
        //判断返回结果
        if(!$result_list) {
            //返回结果
            $this->error_code = '0';
            $this->error_msg = $arr[$status].'操作失败!';
            $this->body = [];

            return $this->result;
        }
        
         //记录操作日志
        $msg = '修改菜单状态为'.$arr[$status].'【菜单ID：'.$tmp_ids.'】';
        $log['data']['uid']                     = $user_info['id'];
        $log['data']['username']                = $user_info['username'];
        $log['data']['realname']                = $user_info['realname'];
        $log['data']['type']                    = 1;
        $log['data']['remark']                  = get_log_type_text(1,$msg,($status==2 || $status==3)?'user/menu/del_menu':'user/menu/disable_menu');
        $log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
        $log['model_name']                      = 'SysUserLog';
        //加入队列
        add_to_queue('',$log);
        
        
         //返回结果
        $this->error_code = '0';
        $this->error_msg = $arr[$status].'操作成功!';
        $this->body = [];

        return $this->result;
    }

}