<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【收入流水】业务逻辑层
// +----------------------------------------------------------------------


namespace app\journal\logic;
use app\common\logic\Base;


class Income extends Base
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
        //收入用户id
        if(!empty($data['user_id'])) {
            $map['user_id'] = $data['user_id'];
        }
        //收入用户
        if(!empty($data['username'])) {
            $map['user_name'] = $data['user_name'];
        }
        //收益来源(provide主键id)
        if(!empty($data['pid'])) {
            $map['pid'] = $data['pid'];
        }
        //匹配编号(matchhelp表主键id)
        if(!empty($data['cat_id'])) {
            $map['cat_id'] = $data['cat_id'];
        }
        //收益类型 1-出局钱包 2-善心币 3-善种子 4-善金币 5-接单钱包 6-管理奖 7-管理钱包 8-贫穷钱包
        if(!empty($data['type'])) {
            $map['type'] = $data['type'];
        }
        
        //实例化模型
        $model = \think\Loader::model('UserIncome', 'model');
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
    
    
    /**
     * 转让流水记录
     * @return type
     */
    public function make_over_log(&$data,&$user_info) {
        $model = model('UserIncome');
        //收入记录ID
        $map['id'] = $data['id'];
        //数据状态
        $map['status'] = 0;
        //查询记录
        $info = $model = $this->get_data($map);
        if(empty($info)) {
            //返回结果
                $this->error_code = '-2';
                $this->error_msg = '数据错误，可能被删除了!';
                $this->body = [];
                return $this->result;
        }
        
        //查看原会员钱包数据
        $account =  model('UserAccount')->get_by_uid($info['user_id'],get_user_account_field($info['type']));
        //判断钱包数量
        if($account[get_user_account_field($info['type'])] <= 0 ) {
            //返回结果
            $this->error_code = '-2';
            $this->error_msg = '会员钱包'.get_user_account_name($info['type']).'数量不足了!';
            $this->body = [];
            return $this->result;
        }
        
        
        //转让流水记录
        $result = $model->make_over_log($data,$info,$user_info);
        unset($data);
        unset($info);
        unset($user_info);
        
        //返回结果
        if(!$result) {
               //返回结果
                $this->error_code = '-200';
                $this->error_msg = '删除失败!';
                $this->body = [];
                return $this->result;
        }
       
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '删除成功!';
        $this->body = [];
        unset($result);
        
        return $this->result;
    }
    
    
    /**
     * 删除收入记录
     * @return type
     */
    public function destroy_income_log(&$data,&$user_info) {
        $model = model('UserIncome');
        //收入记录ID
        $map['id'] = $data['id'];
        //数据状态
        $map['status'] = 0;
        //查询记录
        $info = $model = $this->get_data($map);
        if(empty($info)) {
            //返回结果
                $this->error_code = '-2';
                $this->error_msg = '数据错误，可能被删除了!';
                $this->body = [];
                return $this->result;
        }
        //判断是否更改会员钱包
        if($data['type'] == 1) {
            //查看会员钱包数据
            $account =  model('UserAccount')->get_by_uid($info['user_id'],get_user_account_field($info['type']));
            //判断钱包数量
            if($account[get_user_account_field($info['type'])] <= 0 ) {
                //返回结果
                $this->error_code = '-2';
                $this->error_msg = '会员钱包'.get_user_account_name($info['type']).'数量不足了!';
                $this->body = [];
                return $this->result;
            }
        }
        
        //更改原来的记录为删除状态
        $result = $model->destroy_income_log($data,$info,$user_info);
        unset($data);
        unset($info);
        unset($user_info);
        
        //返回结果
        if(!$result) {
               //返回结果
                $this->error_code = '-200';
                $this->error_msg = '删除失败!';
                $this->body = [];
                return $this->result;
        }
       
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '删除成功!';
        $this->body = [];
        unset($result);
        
        return $this->result;
    }
}