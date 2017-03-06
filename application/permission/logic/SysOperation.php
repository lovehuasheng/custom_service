<?php
/**
 * 权限节点管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\permission\logic;
use app\common\logic\Base;
class SysOperation extends Base
{
  
  /**
   * 添加权限节点
   * @param  array  $params 待添加的权限节点信息数组
   * @return array          包含响应消息的数组,若数组中的错误码为0,表示添加权限节点成功
   */
   public function append_operation($params=[])
   {
      //添加权限节点
      if(!model('SysOperation')->add($params))
      {
          $this->error_code = 51001;
          $this->error_msg  = '添加权限节点失败';
      }
      return $this->result;
   } 

    /**
    * 通过id更新权限节点信息
    * @param  array  $params  包含要更新数据的权限节点信息数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示更新权限节点信息成功
    */
   public function modify_operation($params=[])
   {
      //实例化权限节点模型
      $sys_operation_model = model('SysOperation');
      //获权限节点id
      $id = $params['id'];
      //id作为更新条件,不是更新数据中的一部分
      unset($params['id']);

      //如果存在父级id则检测父级id是否存在
      if(!empty($params['pid']) && !$sys_operation_model->get_by_id($params['pid'],['id']))
      {
          $this->error_code = 51001;
          $this->error_msg  = '父级节点不存在';
          return $this->result;
      }

      if(!$sys_operation_model->update_by_id($id,$params))
      {
          $this->error_code = 51003;
          $this->error_msg  = '更新权限节点信息失败,请稍后再试';
      }
      return $this->result;
   }


   /**
    * 查看权限节点列表
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取权限节点列表成功
    */
   public function get_operations($params=[])
   {

      //实例化权限节点模型
      $sys_operation_model = model('SysOperation');

      //查询条件列表,列表默认只显示启用/禁用状态的用户组,被删除的用户组在回收站中 0-启用 1-禁用 2-删除
      $conditon['status'] = ['in',[0,1]];
      //按权限节点状态查询
      if(isset($params['status']))
      {
        $conditon['status'] = $params['status'];
      }
      //按权限节点名称查询
      if(!empty($params['name']))
      {
        $conditon['name'] = ['like',"%{$params['name']}%"];
      }
      //按权限节点分组名称查询
      if(!empty($params['group']))
      {
        $conditon['group'] = ['like', "%{$params['group']}%"];
      }
      //设置每页记录数,默认为20
      $per_page = config('page_total');
      //设置页码列表,默认为5页
      $page_list = config('page_list');
      //页码
      if(!empty($params['page']))
      {
        $page = intval($params['page']);
        unset($params['page']);
      } 

      //设置默认页码
      if(empty($page) || $page <=0)
      {
        $page = 1;
      }

      //获取满足条件的记录总数
      $total = $sys_operation_model->get_count($conditon);
      //没有满足条件的记录,停止处理
      if($total)
      {
        //设置要获取的字段列表
        $fields = ['id','name','operation','group','status','status'=>'status_text','create_time'];
        //获取当前页码的记录
        $operation_list = $sys_operation_model->get_list($conditon,$fields,$page,$per_page);
      }
    
      //获取页码列表
       

      //设置响应数据
      $this->body = [
        'operation_list' => empty($operation_list) ? [] : $operation_list,
        'pages'   => $pages
      ];
      return $this->result;
   }


   /**
    * 获取当前用户的初始化菜单
    * @param  array  $params 空
    * @return array          当前用户拥有的菜单数组
    */
   public function acquire_init_menu($params=[])
   {

    if(session('?init_menu'))
     {
        $this->body = session('init_menu');
        return $this->result;
     }  

     //非超级管理员,则查询其对应的权限列表
    if(!session('user_auth.is_super'))
     {
        //当前用户所属用户组
        $group_id = session('user_auth.group_id'); 
        //要查询的字段
        $search_fields = [
          //权限列表
          'permissions'
        ];

        //查询当前用户组的权限列表
        $sys_group = model('SysGroup')->get_by_id($group_id,$search_fields);
        if(empty($sys_group->permissions))
        {
           //设置返回的数据
           $this->body = [
              //一级菜单
              'first_meuns'   =>  [],
              //二级菜单 
              'second_menus'  =>  []
           ];
           return $this->result;
        }

        $group_permissions = explode(',',$sys_group->permissions);
    }
 
       //查询一级菜单
       $first_menus =array();
       $first_menus_arr =  config('menu.first_menu');
      if(isset($group_permissions) && is_array($group_permissions)){
         if($first_menus_arr && is_array($first_menus_arr)){
       	   foreach ($first_menus_arr as $key=>$val){
       	   	   if(in_array($val['id'], $group_permissions))	
       	   	 	  $first_menus[$key]= $val;
       	   	 }
       	   	
       	   }
       }else{
       	$first_menus = $first_menus_arr;
       }
       	
   
       //没有一级菜单
       if(empty($first_menus))
       {
           //设置响应数据
           $this->body = [
              //一级菜单
              'first_meuns'   =>  [],
              //二级菜单 
              'second_menus'  =>  []
           ];
           return $this->result;
       }

       

       //非超级管理员,检查二级菜单是否在当前用户的权限列表中
       $second = config('menu.second_menu');
       $second_menus_arr = $second[1];
       $second_menus = array();
       if(isset($group_permissions) && is_array($group_permissions)){
         if($second_menus_arr && is_array($second_menus_arr)){
       	   foreach ($second_menus_arr as $key=>$val){
       			if(in_array($val['id'], $group_permissions))
       				$second_menus[$key]= $val;
       		}
       
       	 }
       }else{
           $second_menus = 	$second_menus_arr;
       }
   
       //设置返回的数据
       $this->body = [
          'first_meuns'   => empty($first_menus) ? [] : $first_menus,
          'second_menus'  => empty($second_menus) ? [] : $second_menus
       ];

       //将初始化菜单存入session
       session('init_menu',$this->body);
       return $this->result;
   }

   /**
    * 获取当前菜单的子菜单
    * @param  array  $params 查询条件数组
    * @return array          当前菜单的子菜单
    */
   public function acquire_sub_menu($params=[])
   {
   	 
     //非超级管理员,则查询其对应的权限列表
     if(!session('user_auth.is_super'))
     {
        //当前用户所属用户组
        $group_id = session('user_auth.group_id');
        //要查询的字段
        $search_fields = [
          //权限列表
          'permissions'
        ];
        //查询当前用户组的权限列表
        $sys_group = model('SysGroup')->get_by_id($group_id,$search_fields);
        if(empty($sys_group->permissions))
        {
          //权限列表为空,则没有子菜单
          $this->body = [
              'sub_menus' => []
          ];
          return $this->result;
        }
        $group_permissions = explode(',',$sys_group->permissions);
     }
    
     //二级导航
     $sub_menus = array();
     if(isset($params['menu']) &&  $params['menu'] == 2){
     	$pid =  $params['id'];
     	//非超级管理员,检查二级菜单是否在当前用户的权限列表中
     	$second = config('menu.second_menu');
     	
     	$second_menus_arr = isset($second[$pid])?$second[$pid]:'';
     	
     	$second_menus = array();
     	if($second_menus_arr){
	     	if(isset($group_permissions) && is_array($group_permissions)){
	     		if($second_menus_arr && is_array($second_menus_arr)){
	     			foreach ($second_menus_arr as $key=>$val){
	     				if(in_array($val['id'], $group_permissions)){
	     					$sub_menus[$key]= $val;
	     				}
	     			}
	     			 
	     		}
	     	}else{
	     		$sub_menus = 	$second_menus_arr;
	     	}
     	}
     }
  
     //三级级导航
     if(isset($params['menu']) &&  $params['menu'] == 3){
     	//非超级管理员,检查二级菜单是否在当前用户的权限列表中
     	$pid =  $params['id'];
     	$second = config('menu.sub_menu');
     	$second_menus_arr = isset($second[$pid])?$second[$pid]:'';
     	$second_menus = array();
      if($second_menus_arr){	
     	if(isset($group_permissions) && is_array($group_permissions)){
     		if($second_menus_arr && is_array($second_menus_arr)){
     			foreach ($second_menus_arr as $key=>$val){
     				if(in_array($val['id'], $group_permissions)){
     					$sub_menus[$key]= $val;
     				}
     					
     			}
     			 
     		}
     	}else{
     		$sub_menus = 	$second_menus_arr;
     	}
      }
     }
     
     
       // $sub_menus 
       if(empty($sub_menus))
       {
          //没有可用的子菜单
          $this->body = [
            'sub_menus' => []
          ];
          return $this->result;
       }
       
       //设置返回的数据
       $this->body = [
          'sub_menus'   => empty($sub_menus) ? [] : $sub_menus,
       ];
       return $this->result;
   }

   /**
    * 获取菜单列表
    * @param  array  $params  空
    * @return array           菜单列表
    */
   public function acquire_menu_list($params=[])
   {
        //要获取的字段
         $fields = [
            //菜单id
            'id',
            //菜单名称
            'name'
         ];

         //查询条件 
         $conditon = [
              //类型 0-权限节点 1-菜单节点
              'type' => 1,
         ];
      //排序
      $order['sort'] = 'asc';
      //查询所有菜单
       $menus = model('SysOperation')->get_all($conditon,$fields,$order);
       $this->body = empty($menus) ? [] : $menus;
       return $this->result;
   }

   /**
    * 改变权限节点状态 0-启用 1-禁用 2-删除
    * @param array $params 包含更新条件和更新数据的数组
    * @return array        包含响应消息的数组,若数组中的错误码为0,表示设置权限节点状态成功
    */
   public function update_operation_status($params=[])
   {
      //实例化权限节点模型
      $sys_operation_model = model('SysOperation');
      //设置更新条件,按id更新,格式为 1,2,3...
      $conditon['id'] = ['in',$params['ids']];
      //要设置的状态值
      $status = $params['status'];
      //更新权限节点状态失败,返回错误信息
      if(!$sys_operation_model->update_status($conditon,$status))
      {
          //获取状态文本
          $status_text = $sys_operation_model->get_status_attr($status);
          $this->error_code = 51004;
          $this->error_msg  = $status_text . '权限节点失败';
      }
       return $this->result;
   }


   /**
    * 查看回收站中删除的权限节点列表
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取回收站列表成功
    */
   public function get_destoryed_operation($params=[])
   {
        //实例化权限节点模型
        $sys_operation_model = model('SysOperation');
        //查询条件列表
        $conditon = [];
        //回收站中的用户组状态都是已删除状态 0-启用 1-禁用 2-删除
        $conditon['status'] = 2;

        //按权限节点名称查询
        if(!empty($params['name']))
        {
          $conditon['name'] = ['like',"%{$params['name']}%"];
        }
        //按权限节点分组名称查询
        if(!empty($params['group']))
        {
          $conditon['group'] = ['like',"%{$params['group']}%"];
        }

      //设置每页记录数,默认为20
      $per_page = config('page_total');
      //设置页码列表,默认为5页
      $page_list = config('page_list');
      //页码
      if(!empty($params['page']))
      {
        $page = intval($params['page']);
        unset($params['page']);
      } 

      //设置默认页码
      if(empty($page) || $page <=0)
      {
        $page = 1;
      }

      //获取满足条件的记录总数
      $total = $sys_operation_model->get_count($conditon);
      //没有满足条件的记录,停止处理
      if(!$total)
      {
        return $this->result;
      }

      //设置要获取的字段列表
      $fields = ['id','name','operation','group','status','status'=>'status_text','create_time'];
      //获取当前页码的记录
      $operation_list = $sys_operation_model->get_list($conditon,$fields,$page,$per_page);
      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //设置响应数据
      $this->body = [
        'operation_list' => empty($operation_list) ? [] : $operation_list,
        'pages'   => $pages
      ];
      return $this->result;
   }


   /**
    * 恢复回收站中删除的权限节点列表
    * @param  array  $params  包含更新条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示恢复回收站成功
    */
   public function revert_operation($params=[])
   {
        $sys_operation_model = model('SysOperation');
        //设置更新条件,按id更新,格式为 1,2,3...
        $conditon['id'] = ['in',$params['ids']];
        //恢复到默认恢复到启用状态 0-启用 1-禁用 2-删除
        $status = 0;
        //更新权限节点状态失败,返回错误信息
        if(!$sys_operation_model->update_status($conditon,$status))
        {
            $this->error_code = 51005;
            $this->error_msg  = '恢复权限节点失败';
        }
        return $this->result;
   }


   /**
    * 获取权限节点详情
    * @param  array  $params 包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示成功
    */
   public function acquire_operation_detail($params=[])
   {
        $sys_operation_model = model('SysOperation');
        //权限节点id
        $id = $params['id'];
        //要查询的字段
        $fields = ['id','name','operation','group','sort','remark','status'];
        //查询权限节点详情
        $operation_detail = $sys_operation_model->get_by_id($id,$fields);
        if(!$operation_detail)
        {
            $this->error_code = 51006;
            $this->error_msg  = '获取权限节点详情失败';
        }
        $this->body = $operation_detail;
        return $this->result;
   }

    //获取分组形式的权限节
    public function acquire_operation_group()
    {
        $operation_groups = [];
        //要查询的字段
        $fields = ['id','name','operation','group'];
        $operation_list =  model('SysOperation')->get_all([],$fields);
        if(!empty($operation_list))
        {
            foreach ($operation_list as $key => $value)
            { 
               $find = false;
               foreach ($operation_groups as $k => $v) 
               {
                  if($value['group'] == $v['group'])
                  {
                    $operation_groups[$k]['permissions'][] = [
                      'id'        => $value['id'],
                      'name'      => $value['name'],
                      'operation' => $value['operation']
                    ];
                    $find = true;
                    break;
                  } 
               }

               if(!$find)
               {
                 $operation_groups[] = [
                    'group' => $value->group,
                    'permissions' => [
                        [
                          'id'        => $value['id'],
                          'name'      => $value['name'],
                          'operation' => $value['operation']
                        ]
                    ],
                 ];
               }
            }
        }
        $this->body = $operation_groups;
        return $this->result;
    }
    
}