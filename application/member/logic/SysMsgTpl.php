<?php
/**
 * 消息模板管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class SysMsgTpl extends Base
{


    /**
     * 添加消息模板
     * @param  array  $params 待添加的消息模板信息数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示添加消息模板成功
     */
    public function append_msg_tpl($params=[])
    {
      //添加消息模板
      if(!model('SysMsgTpl')->add($params))
      {
          $this->error_code = 41001;
          $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
    }

    /**
     * 获取消息模板列表
     * @param  array  $params 包含查询条件的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板列表成功
     */
    public function get_msg_tpls($params=[])
    {    
      //设置要获取的字段列表
      $fields = [
        //模板id
        'id',
        //模板标题
        'title',
        //模板内容
        'content',
        //模板状态
        'status',
        //模板创建时间
        'create_time'
      ];

      //搜索条件,只显示启用/禁用的消息模板,0-启用 1-禁用 2-删除
      $conditon['status'] = ['in',[0,1]]; 

      //按状态搜索 
      if(isset($params['status']))
      {
        $conditon['status'] = intval($params['status']);
      }

      //获取消息模板列表
      $msg_tpl_list = model('SysMsgTpl')->get_all($conditon,$fields);
      //设置响应数据
      $this->body = !empty($msg_tpl_list) ? $msg_tpl_list : [];

      return $this->result;
    } 

    /**
     * 修改消息模板
     * @param  array  $params 包含查询条件和更新数据的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示修改消息模板成功
     */
    public function modify_msg_tpl($params=[])
    {
        if(!model('SysMsgTpl')->update_by_id($params['id'],$params))
        {
            $this->error_code = 10010;
            $this->error_msg  = '操作失败,请稍后再试';
        }
        return $this->result;
    }

   /**
    * 改变消息模板状态       0-启用 1-禁用 2-删除
    * @param array $params 包含更新条件和更新数据的数组
    * @return array        包含响应消息的数组,若数组中的错误码为0,表示设置消息模板状态成功
    */
    public function modify_msg_tpl_status($params=[])
    {
      $sys_msg_tpl_model = model('SysMsgTpl');
      //设置更新条件,按id更新,可以批量更新,格式为 1,2,3...
      $condition['id'] = ['in',$params['ids']];
      //更新消息模板状态 0-启用 1-禁用 2-删除
      if(!$sys_msg_tpl_model->update_status($condition,$params['status']))
      {
          $this->error_code = 10011;
          $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
    }

    /**
    * 查看回收站
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取回收站列表成功
    */
    public function get_destoryed_msg_tpl($params=[])
    {
        //回收站中的用户组状态都是已删除状态 0-启用 1-禁用 2-删除
        $conditon['status'] = 2;

        //设置要获取的字段列表
        $fields = [
          //模板id
          'id',
          //模板标题
          'title',
          //模板内容
          'content',
          //模板状态
          'status',
          //创建时间
          'create_time'
      ];

      //获取消息模板列表
      $msg_tpl_list = model('SysMsgTpl')->get_all($conditon,$fields);
      //设置响应数据
      $this->body = !empty($msg_tpl_list) ? $msg_tpl_list : [];

      return $this->result;
    } 

    //还原回收站中的消息模板
    public function revert_msg_tpl($params=[])
    {
        //设置更新条件,按id更新,格式为 1,2,3...
        $conditon['id'] = ['in',$params['ids']];
        //审核状态
        $status = 0;
        //更新消息模板状态 0-启用 1-禁用 2-删除
        if(!model('SysMsgTpl')->update_status($conditon,$status))
        {
            $this->error_code = 41006;
            $this->error_msg  = '操作失败,请稍后再试';
        }
        return $this->result;
    }

   /**
    * 获取消息模板详情
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板详情成功
    */
   public function acquire_msg_tpl_detail($params=[])
   {
      //要获取的字段
      $fields = [
        //模板id
        'id',
        //模板id
        'title',
        //模板内容
        'content',
        //模板状态
        'status',
        //创建时间
        'create_time',
        //更新时间
        'update_time'
      ];
      //获取消息模板详情
      $sys_msg_tpl = model('SysMsgTpl')->get_by_id($params['id'],$fields);
      if(!$sys_msg_tpl)
      {
          $this->error_code = 10012;
          $this->error_msg  = '获取消息模板详情失败,请稍后再试';
      }
      //设置响应数据
      $this->body = !empty($sys_msg_tpl) ? $sys_msg_tpl : [];
      return $this->result;
   }  
}