<?php
/**
 * 消息模板管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class UserNews extends Validate
{   

    //验证规则
    protected $rule = [
        'id'            => 'require|gt:0',
        'classify_id'   => 'require|number|in:1,2',
        'title'         => 'require',
        'content'       => 'require',
        'status'        => 'require|in:0,1',
        'is_company'    => 'require|in:0,1,2',
    ];
    
    //错误消息
    protected $message = [
        'id.require'           => 'id不能为空|60010',
        'id.gt'                => 'id必须大于0|60011',
        'classify_id.require'  => '分类id不能为空|60012',
        'classify_id.number'   => '分类id必须为整数|60013',
        'classify_id.in'       => '分类id不在给定的范围内|60014',
        'title.require'        => '标题不能为空|60015',
        'content.require'      => '内容不能为空|60016',
        'status.require'       => '状态不能为空|60017',
        'status.in'            => '状态不在允许范围内|60018',
        'is_company.require'   => 'is_company不能为空|60019',
        'is_company.in'        => 'is_company不在给定的范围内|60020' 
    ]; 

    //验证场景
    protected $scene = [
         //查看新闻列表
        'get_news_list'     => ['id'=>'gt:0','status'=>"in:'',0,1",'is_company'=>"in:'',0,1,2"],
         //添加新闻
        'add_news'          => ['title','content','status','is_company'],
        //编辑公告
        'update_news'       => ['id','title','content','status','is_company'],
        //删除公告
        'del_news'          => ['id'],
        //获取公告详情 
        'get_news_detail'   => ['id'],

    ];
   
}