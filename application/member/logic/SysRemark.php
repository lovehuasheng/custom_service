<?php
/**
 * 备注管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class SysRemark extends Base
{

   /**
    * 备注列表
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获备注列表成功
    */
   public function get_remarks($params=[])
   {

      //查询条件
      $condition = [
        //会员id
        'user_id' => intval($params['user_id']),
        //备注类型 1-封号备注 2-特权备注 3-编辑资料备注 4-转移推荐人备注
        'type_id' => intval($params['type_id'])
      ];


      //要查询的字段列表
      $fields = [
        //备注
        'remark',
        //创建时间
        'create_time'
      ];
      //获取备注列表

      $remark_list = model('SysRemark')->get_by_attr($condition,$fields,0);

      //设置响应数据
      $this->body = [
        'remark_list' => empty($remark_list) ? [] : $remark_list
      ];
      return $this->result;
   }

}