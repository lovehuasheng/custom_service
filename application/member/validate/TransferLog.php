<?php
/**
 * 转币查询管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class TransferLog extends Validate
{   

    //验证规则
    protected $rule = [
        'id'                => 'require|number|gt:0',
        'coin_type'         => 'require|number|in:1,2',
        'num'               => 'require|number|gt:0',
        'user_id'           => 'require|number|gt:0',
        'username'          => 'require',
        'operation_type'    => 'require|number|in:1,2',
        'operator_id'       => 'require|number|gt:0' ,
        'operator_name'     => 'require',
        'remark'            => 'require|max:64',
        'create_time'       => 'require|date',
        'update_time'       => 'require|date',
    ];
    
    //错误消息
    // protected $message = [
    // ]; 

    //验证场景
    protected $scene = [
         //查看转币列表
        'get_transfer_list'     => ['coin_type'=>"number|in:1,2"],
    ];
   
}