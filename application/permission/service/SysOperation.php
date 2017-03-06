<?php
/**
 * 权限节点管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\permission\service;
use app\common\service\Base;
class SysOperation extends  Base{

	/**
     * 添加权限节点
     */
    public function create_operation($data=[]) 
    {

    	return model('SysOperation', 'logic')->append_operation($data);
    }

    /**
     * 更新权限节点信息
     */
    public function edit_operation($data=[])
    {   
        return model('SysOperation','logic')->modify_operation($data);
    }

    /**
     * 获取权限节点列表
     */
    public function fetch_operation_list($data=[])
    {
        return model('SysOperation','logic')->get_operations($data);
    }   

    /**
     * 获取当前用户的初始菜单
     */
    public function fetch_init_menu($data=[])
    {
        return model('SysOperation','logic')->acquire_init_menu($data);
    }

    /**
     * 获取当前菜单的子菜单
     * @param  array  $data 查询条件
     */
    public function fetch_sub_menu($data=[])
    {
        return model('SysOperation','logic')->acquire_sub_menu($data);
    }

    /**
     * 获取菜单列表
     * @return array  $data 查询条件
     */
    public function fetch_menu_list($data=[])
    {
        return model('SysOperation','logic')->acquire_menu_list($data);
    }

    /**
     * 设置权限节点状态 0-启用 1-禁用 2-删除
     */
    public function edit_operation_status($data=[])
    {
        return model('SysOperation','logic')->update_operation_status($data);
    }

    /**
     * 查看回收站中的权限节点列表
     */
    public function get_deleted_operation($data=[])
    {   
        return model('SysOperation','logic')->get_destoryed_operation($data);
    }

    /**
     * 还原回收站中删除的权限节点列表
     */
    public function recover_operation($data=[])
    {   
        return model('SysOperation','logic')->revert_operation($data); 
    }

    /**
     * 获取权限节点详情
     */
    public function fetch_operation_detail($data=[])
    {
        return model('SysOperation','logic')->acquire_operation_detail($data); 
    }
}
