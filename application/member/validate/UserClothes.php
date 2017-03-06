<?php
/**
 * 消息模板管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class UserClothes extends Validate
{   

    //验证规则
    protected $rule = [
        'id'                => 'require|gt:0',
        'user_id'           => 'require|number|gt:0',
        'username'          => 'require',
        'consignee_name'    => 'require',
        'is_apply'          => 'require|in:0,1',
        'is_received'       => 'require|in:0,1',
        'consignee_phone'   => 'require|is:mobile',
        'consignee_address' => 'require',
        'size'              => 'require|in:1,2,3,4,5,6',
        'start_time'        => 'date',
        'end_time'          => 'date',
        'province'          => 'require',
        'city'              => 'require',
        'is_shipping'       => 'require|in:0,1'
    ];
    
    //错误消息
    protected $message = [
        'id.require'                => '参数错误|60010',
        'id.gt'                     => '参数错误|60011',
        'user_id.require'           => '参数错误|60012',
        'user_id.number'            => '参数错误|60013',
        'user_id.gt'                => '参数错误|60014',
        'consignee_name.require'    => '收货人姓名不能为空|60015',
        'is_apply.require'          => '该选项不能为空|60016',
        'is_apply.in'               => '您选择的值不在给定的范围内|60017',
        'is_received.require'       => '该选项不能为空|60018',
        'is_received.in'            => '您选择的值不在给定的范围内|60019',
        'consignee_phone.require'   => '收货人手机号码不能为空|60020',
        'consignee_phone.is'        => '收货人手机号码格式不正确|60021',
        'consignee_address.require' => '收货人地址不能为空|60022',
        'size.require'              => '尺码不能为空|60023',
        'size.in'                   => '尺码不在给定范围内|60024',
        'start_time.date'           => '时间格式不正确|60025',
        'end_time.date'             => '时间格式不正确|60026',
        'is_shipping.require'       => '该选项不能为空|60027',
        'is_shipping.in'            => '您选择的值不在给定的范围内|60028'
    ]; 

    //验证场景
    protected $scene = [
         //查看列表
        'get_clothes_list'    => ['consignee_phone'=>'is:mobile','size'=>'in:1,2,3,4,5,6','start_time','end_time','is_shipping'=>'in:0,1'],
        //编辑
        'update_clothes'      => ['id','username','consignee_name','consignee_phone','province','city','consignee_address','size'],
        //删除
        'del_clothes'         => ['id'],
        //获取详情 
        'get_clothes_detail'  => ['id'],

    ];
   
}