<?php
/**
 * 用户组管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\permission\service;
use app\common\service\Base;
class SysGroup extends  Base{

	/**
     * 添加用户组
     */
    public function create_group($data=[]) 
    {
    	return model('SysGroup', 'logic')->append_group($data);
    }

    /**
     * 更新用户组
     */
    public function edit_group($data=[])
    {   
        return model('SysGroup','logic')->modify_group($data);
    }

    /**
     * 获取用户组列表
     */
    public function fetch_group_list($data=[])
    {
        return model('SysGroup','logic')->get_groups($data);
    }

    /**
     * 设置用户组状态 0-启用 1-禁用 2-删除
     */
    public function edit_group_status($data=[])
    {
        return model('SysGroup','logic')->update_group_status($data);
    }

    /**
     * 查看回收站中删除的用户组
     */
    public function get_deleted_group($data=[])
    {   
        return model('SysGroup','logic')->get_destoryed_group($data);
    }

    /**
     * 还原回收站中删除的用户组
     */
    public function recover_group($data=[])
    {   
        return model('SysGroup','logic')->revert_group($data); 
    }

    /**
     * 设置用户组权限
     */
    public function setup_group_permission($data=[])
    {
        return model('SysGroup','logic')->set_permission($data); 
    }

    /**
     * 查看用户组权限
     */
    public function fetch_group_permission($data=[])
    {
        return model('SysGroup','logic')->get_group_permissions($data); 
    }

    /**
     * 查看用户组树
     */
    public function fetch_group_tree()
    {
        return model('SysGroup','logic')->acquire_group_tree(); 
    }
}
