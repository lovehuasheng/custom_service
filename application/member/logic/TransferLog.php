<?php
/**
 * 转币记录管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class TransferLog extends Base
{

    /**
     * 获取转币列表
     * @param  array  $params 包含查询条件的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板列表成功
     */
    public function get_transfer($params=[])
    {    
      //设置要获取的字段列表
      $fields = [
        //币种 1-善种子 2-善心币
        'coin_type',
        //数量
        'num',
        //接受账号
        'username',
        //操作类型 1-转入 2-转出
        'operation_type',       
        //操作人账号
        'operator_name',
        //备注
        'remark',
        //操作时间
        'create_time'
      ];  

      //总记录数
      $total = 0;

      //会员未找到标志
      $user_not_find = false;

      //当前页的记录列表
      $transfer_list = [];

      //搜索条件
      $condition = [];

      //按会员账号查询
      if(!empty($params['username']))
      {
        //会员账号
        $username = trim($params['username']);
        //查询会员id
        $user_id = model('User')->get_id_by_username($username);
        //没有查询到该会员直接返回空
        if(!$user_id)
        {
            $user_not_find = true;
        }
        else
        {
          $condition['user_id']  = $user_id;
        }
      }

      //按币种类型查询 1-善种子 2-善心币
      if(!empty($params['coin_type']))
      { 
        $condition['coin_type'] = $params['coin_type'];
      }

      //设置页码
      if(!empty($params['page']))
      {
        $page = intval($params['page']);
      }

      //设置默认页码
      if(empty($page) || $page <=0)
      {
        $page = 1;
      }

      //设置每页记录数,默认为20条
      $per_page = config('page_total');
      //设置页码列表,默认为5页
      $page_list = config('page_list');

      //会员存在才查询
      if($user_not_find === false)
      {
        $transfer_model = model('TransferLog');
        //查询满足条件的会员数量
        $total = $transfer_model->get_count($condition);
        //查询数量不为空才进行下一步查询
        if($total)
        {
          $transfer_list = $transfer_model->get_list($condition,$fields,$page,$per_page);
        }
      }

      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //返回结果
      $this->body = [
          'transfer_list' => !empty($transfer_list) ? $transfer_list : [],
          'pages'     => $pages,
          'total'     => $total
        ];
      return $this->result;
    } 
}