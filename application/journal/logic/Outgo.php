<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【支出流水】业务逻辑层
// +----------------------------------------------------------------------


namespace app\journal\logic;
use app\common\logic\Base;


class Outgo extends Base
{
  
   
   /**
    * 取列表数据
    * @param type $id
    * @return type
    */
    public function get_list($data) {
         //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 1;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');
        //组装条件
        //查询条件
        $map = [];
        
        //搜索关键词
        //支出用户id
        if(!empty($data['user_id'])) {
            $map['user_id'] = $data['user_id'];
        }
        //支出用户
        if(!empty($data['username'])) {
            $map['user_name'] = $data['user_name'];
        }
        //支出来源(accepthelp表的主键)
        if(!empty($data['pid'])) {
            $map['pid'] = $data['pid'];
        }
        //支出类型 1-善种子 2-善心币 3-出局钱包 4-管理奖 5-接单钱包
        if(!empty($data['type'])) {
            $map['type'] = $data['type'];
        }
        
        //实例化模型
        $model = \think\Loader::model('UserOutgo', 'model');
        //获取满足条件的记录总数
        $total = $model->get_count($map);
        //取值字段
        $field = 'id,type,outgo,user_id,username,pid,info,create_time';
        
        //调取数据
        $result_list = $model->get_list_info($map,$field);
        
        unset($map);
        unset($field);
        
        //获取页码列表
        $pages = get_pagination($total, $page, $per_page, $page_list);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data' => $result_list,
            'pages' => $pages
        ];
        unset($result_list);
        
        return $this->result;
    }
}