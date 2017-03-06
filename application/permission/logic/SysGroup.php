<?php
/**
 * 用户组管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\permission\logic;
use app\common\logic\Base;
class SysGroup extends Base
{
  
  /**
   * 添加用户组
   * @param  array  $params 待添加的用户组信息数组
   * @return array          包含响应消息的数组,若数组中的错误码为0,表示添加用户成功
   */
   public function append_group($params=[])
   {
      
      $sys_group_model = model('SysGroup');
      //过滤掉参数中的id,添加用户组时不需要id
      unset($params['id']);
      //如果选择了父级用户组,则检测父级组是否存在
      if(!empty($params['pid']))
      {
          //要查询的字段
          $fields = [
              //用户组id
              'id',
              //用户组名称
              'group_name'
            ];
          //查询父级用户组信息
          $group_info = $sys_group_model->get_by_id($params['pid'],$fields);

          //父级用户组不存在,返回错误信息
          if(empty($group_info))
          {
              $this->error_code = 41000;
              $this->error_msg  = '父级用户组不存在';
              return $this->result;
          }
          //将父级用户组名添加到数组中
          $params['pname'] = $group_info->group_name;
      }

      $conditon = [
        //组名
        'group_name' => $params['group_name'],
        //状态
        'status' => ['<>',2]
      ];

      //检测是否存在同名的用户组,有则禁止添加
      $sys_group_info = $sys_group_model->get_by_attr($conditon,['id']);

      if(!empty($sys_group_info))
      {
          $this->error_code = 41001;
          $this->error_msg  = "{$params['group_name']}已存在";
          return $this->result;
      }

      //添加用户组
      if(!$sys_group_model->add($params))
      {
          $this->error_code = 41001;
          $this->error_msg  = '添加用户组失败';
      }
      return $this->result;
   } 

   /**
    * 通过id更新用户组信息
    * @param  array  $params  包含要更新数据的用户信息数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示更新用户组信息成功
    */
   public function modify_group($params=[])
   {
      //实例化用户组模型
      $sys_group_model = model('SysGroup');
      //获取用户组id
      $id = $params['id'];
      //id作为更新条件,不是更新数据中的一部分
      unset($params['id']);
      // 
      if(!$sys_group_model->get_by_id($id,['id']))
      {
          $this->error_code = 41002;
          $this->error_msg  = '用户组不存在';
          return $this->result;
      }

      //如果选择了父级用户组,则检测父级组是否存在
      if(isset($params['pid']))
      {
          //要查询的字段
          $fields = ['id','group_name'];
          //查询父级用户组信息
          $group_info = $sys_group_model->get_by_id($params['pid'],$fields);
          //父级用户组不存在,返回错误信息
          if(empty($group_info))
          {
              $this->error_code = 41003;
              $this->error_msg  = '父级用户组不存在';
              return $this->result;
          }
          //将父级用户组名添加到数组中
          $params['pname'] = $group_info->group_name;
      } 

      if(!$sys_group_model->update_by_id($id,$params))
      {
          $this->error_code = 41004;
          $this->error_msg  = '更新用户组信息失败,请稍后再试';
      }
      return $this->result;
   }


   /**
    * 查看用户列表
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取用户列表成功
    */
   public function get_groups($params=[])
   {

      //查询条件,列表默认只显示启用/禁用状态的用户组,被删除的用户组在回收站中 0-启用 1-禁用 2-删除
      $conditon['status'] = ['in',[0,1]];
      //按父级组id查询
      if(isset($params['pid']))
      {
        $conditon['pid'] = $params['pid'];
      }
      //按组状态查询
      if(isset($params['status']))
      {
        $conditon['status'] = $params['status'];
      }

      //设置要获取的字段列表
      $fields = [
        //用户组id
        'id',
        //组名称
        'group_name',
        //状态
        'status',
        //状态文本
        'status'=>'status_text',
        //备注
        'remark',
        //创建时间
        'create_time'
      ];
      //获取用户组列表
      $group_list = model('SysGroup')->get_all($conditon,$fields);
      //设置响应数据
      $this->body = empty($group_list) ? [] : $group_list;
      return $this->result;
   }

   /**
    * 改变用户组状态 0-启用 1-禁用 2-删除
    * @param array $params 包含更新条件和更新数据的数组
    * @return array        包含响应消息的数组,若数组中的错误码为0,表示设置用户组状态成功
    */
   public function update_group_status($params=[])
   {
      $sys_group_model = model('SysGroup');
      //更新条件,按id更新,多个id按逗号分隔
      $conditon['id'] = ['in',$params['ids']];
      //要设置的状态值
      $status = $params['status'];

      //删除用户组时要验证二级密码
      if($status == 2)
      {
        //二级密码
        $secondary_password = $params['secondary_password'];
        $map['id'] = session('user_auth.id');
        $user = model('user/SysUser')->get_user_info($map, 'secondary_password');
        if ($user['secondary_password'] != set_password(md5($secondary_password))) 
        {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '二级密码错误!';
            return $this->result;
        }

        //检测用户组下面是否有用户
        $users = model('user/SysUser')->get_user_info(['group_id' => $params['ids']],'id');
        if(!empty($users))
        {
            //返回结果
            $this->error_code = '-201';
            $this->error_msg = '请先删除该用户组下的用户!';
            return $this->result;
        }
        
      }

      if(!$sys_group_model->update_status($conditon,$status))
      {
          //获取状态文本
          $status_text = $sys_group_model->get_status_attr($status);
          $this->error_code = 41005;
          $this->error_msg  = $status_text . '用户组失败';
      }
       return $this->result;
   }


   /**
    * 查看回收站
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取回收站列表成功
    */
   public function get_destoryed_group($params=[])
   {

        //设置搜索条件,回收站中的用户组status固定为2  0-启用 1-禁用 2-删除
        $conditon['status'] = 2;
        //设置要获取的字段列表
        $fields = [
            //用户组id
            'id',
            //用户组名称
            'group_name',
            //状态数值
            'status',
            //状态文本
            'status'=>'status_text',
            //创建时间
            'create_time'
          ];
        //获取所有被删除的用户组
        $group_list = model('SysGroup')->get_list($conditon,$fields);
        //设置响应数据
        $this->body = empty($group_list) ? [] : $group_list;
        return $this->result;
   }


   /**
    * 恢复回收站
    * @param  array  $params  包含更新条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示恢复回收站成功
    */
   public function revert_group($params=[])
   {
        //设置更新条件,按id更新,多个id用逗号分隔
        $conditon['id'] = ['in',$params['ids']];
        //默认恢复到启用状态 0-启用 1-禁用 2-删除
        $status = 0;
        if(!model('SysGroup')->update_status($conditon,$status))
        {
            $this->error_code = 41006;
            $this->error_msg  = '恢复用户组失败';
        }
        return $this->result;
   }

   /**
    * 设置用户组权限
    * @param  array  $params  包含更新条件以及更新数据的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示设置用户组权限成功
    */
   public function set_permission($params=[])
   {
      //权限列表
      $data['permissions'] = $params['permissions'];

      //更新用户组权限
      if(!model('SysGroup')->update_by_id($params['id'],$data))
      {
          $this->error_code = 41008;
          $this->error_msg  = '设置用户组权限失败';
      }
      return $this->result;
   }

   /**
    * 查看用户组权限列表
    * @param  array  $params 包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取用户组权限列表成功
    */
   public function get_group_permissions($params=[])
   {
     
      //权限节点要查询的字段
      $operation_fields = [
          //权限节点id
          'id',
          //权限节点名称
          'name'
      ];
      //查询所有的权限节点
      $operations = model('SysOperation')->get_all([],$operation_fields);
      //用户组要查询的字段
      $group_fields = [
         //用户组权限
        'permissions'
      ];
      //根据用户组id获取用户组权限
      $group = model('SysGroup')->get_by_id($params['id'],$group_fields);
      if($group)
      {
        //分隔权限节点为数组
        $permissions = array_unique(explode(',',$group->permissions));
      }
      //设置响应数据
      $this->body = [
          //权限节点列表
          'operations' => !empty($operations) ? $operations : [],
          //当前用户组拥有的权限
          'permissions' => !empty($permissions) ? $permissions : []
      ];
      return $this->result;
   }

   /**
    * 获取用户组树
    * @return array $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取用户组权限列表成功
    */
   public function acquire_group_tree()
   {
      //用户组权限列表
      $group_permissions = [];
      //查询条件
      $conditon = [];
      //要查询的字段
      $fields = [
        //用户组id
        'id',
        //父级用户组id
        'pid',
        //用户组名称
        'group_name'
      ];
      //获取用户组列表
      $group_list = model('SysGroup')->get_all($conditon,$fields);
      //获取用户组无限极菜单
      $group_tree = $this->get_tree($group_list);
      //设置响应数据
      $this->body = $group_tree;
      return $this->result;
   }

  /**
   * 生成无限极分类树
   * @param  array   &$list 原始数组
   * @param  integer $pid   父级id
   * @param  integer $level 层级
   * @return array          无限极分类树数组
   */
  public function get_tree($list,$pid=0,$level=0)
  {
    $tree = array();
    foreach($list as $key=>$value)
    {      
      if($value['pid'] == $pid)
      { 
        $value['level'] = $level;
        $tree[] = $value;
        unset($list[$key]);
        array_merge($list);
        $tree =  array_merge($tree,$this->get_tree($list,$value['id'],$level+1));
      }
    }
    return $tree;
  }

}