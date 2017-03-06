<?php
/**
 * 备注管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class SysRemark extends Validate
{   

    //验证规则
    protected $rule = [
        'user_id'   => 'require|number|gt:0',
        'type_id'   => 'require|number|gt:0',
    ];
    
    //错误消息
    protected $message = [
        'user_id.require'   => 'user_id不能为空|60013',
        'user_id.gt'        => 'user_id必须大于0|60014', 
        'user_id.number'    => 'user_id必须为整数|60015',  
        'type_id.require'   => 'type_id不能为空|60016',
        'type_id.gt'        => 'type_id必须大于0|60017', 
        'type_id.number'    => 'type_id必须为整数|60018',    
    ]; 

    //验证场景
    protected $scene = [
        //获取备注列表
        'get_remark_list' => ['user_id','type_id']
    ];
}