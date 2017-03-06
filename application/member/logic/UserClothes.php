<?php
/**
 * 会员文化衫管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class UserClothes extends Base
{


    /**
     * 获取文化衫列表
     * @param  array  $params 包含查询条件的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板列表成功
     */
    public function get_clothes($params=[])
    {    
      //设置要获取的字段列表
      $fields = [
        //模板id
        'id',
        //申领账号
        'username',
        //收货人姓名
        'consignee_name',
        //收货人电话
        'consignee_phone',
        //省
        'province',
        //市
        'city',
        //收货人地址
        'consignee_address',
        //尺寸
        'size',
        //是否申领过  0-否 1-是
        'is_apply', 
        //是否领到过 0-否 1-是
        'is_received',
         //提交时间
        'create_time',
        //是否发货
        'is_shipping',
        //物流单号
        'shipping_no',
        //物流公司
        'shipping_company'
      ];  

      //搜索条件
      $condition = [];

      //按会员账号查询
      if(!empty($params['username']))
      {
        $condition['username'] = $params['username'];
      }

      //按收货人姓名查询
      if(!empty($params['consignee_name']))
      {
          $condition['consignee_name'] = $params['consignee_name'];
      }

      //按收货人手机查询
      if(!empty($params['consignee_phone']))
      {
        $condition['consignee_phone']  = $params['consignee_phone'];
      }

      //按尺寸查询
      if(!empty($params['size']))
      {
        $condition['size'] = $params['size'];
      }

      //按物流单号查询
      if(!empty($params['shipping_no']))
      {
        $condition['shipping_no'] = $params['shipping_no'];
      }

      //按物流公司查询
      if(!empty($params['shipping_company']))
      {
        $condition['shipping_company'] = $params['shipping_company'];
      }

      //按是否发货查询
      if(isset($params['is_shipping']) && $params['is_shipping'] != '')
      {
        $condition['is_shipping'] = $params['is_shipping'];
      }

      //按最早时间查询
      if(!empty($params['start_time']))
      {
          $condition['create_time'] = ['>=',strtotime($params['start_time'])];
      }

      //按最晚时间查询
      if(!empty($params['end_time']))
      {
          $end_time = strtotime($params['end_time']);

          if(strtotime($params['start_time']) == $end_time)
          {
              $end_time += 86400;
          }
        
        $exp = ['<',$end_time];

        if(!empty($condition['create_time']))
        {
          $condition['create_time'] = [$condition['create_time'],$exp,'AND']; 
        }
        else
        {
          $condition['create_time'] = $exp;
        }
      }

      //页码
      if(!empty($params['page']))
      {
        //设置页码
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

      $user_clothes_model = model('UserClothes');

      //查询满足条件的会员数量
      $total = $user_clothes_model->get_count($condition);
      //将搜索条件保存到session中
      session('clothes.search_condition',$condition);
      //将满足条件的记录数存放在session中
      session('clothes.search_count',$total);

      if($total)
      {
        $clothes_list = $user_clothes_model->get_list($condition,$fields,$page,$per_page);
      }

      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //返回结果
      $this->body = [
          'clothes_list' => !empty($clothes_list) ? $clothes_list : [],
          'pages'     => $pages,
          'total'     => $total
        ];
      return $this->result;
    } 

    /**
     * 修改
     * @param  array  $params 包含查询条件和更新数据的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示修改消息模板成功
     */
    public function modify_clothes($params=[])
    { 
        if(!model('UserClothes')->update_by_id($params['id'],$params))
        {
            $this->error_code = 10010;
            $this->error_msg  = '操作失败,请稍后再试';
        }
        return $this->result;
    }


    //删除
    public function destroy_clothes($params=[])
    {
      if(!model('UserClothes')->del_by_id($params['id']))
      {
        $this->error_code = 10011;
        $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
    }

   /**
    * 获取详情
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板详情成功
    */
   public function acquire_clothes_detail($params=[])
   {
      //设置要获取的字段列表
      $fields = [
          //主键
          'id',
          //申领登录账号
          'username',
          //收货人姓名
          'consignee_name',
          //收货人手机
          'consignee_phone',
          //省
          'province',
          //市
          'city',
          //收货人详细地址
          'consignee_address',
          //尺寸
          'size'
      ]; 

      //获取详情
      $clothes = model('UserClothes')->get_by_id($params['id'],$fields);
      //设置响应数据
      $this->body = !empty($clothes) ? $clothes : [];
      return $this->result;
   }  
}