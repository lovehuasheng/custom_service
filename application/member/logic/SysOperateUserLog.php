<?php
/**
 * 管理员操作会员日志
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class SysOperateUserLog extends Base
{

  //获取日志列表
  public function obtain_log_list($user_id,$page)
  {
      $model = \think\Loader::model('SysOperateUserLog', 'model');
      //每页显示的记录数
      $per_page = config('page_total');
      //字段列表
      $fields = [
        //管理员姓名
        'sys_realname',
        //操作类型  1-审核 2-编辑 3-通知
        'operation_type',
        //操作时间
        'create_time'
      ];

     try{ 

          $data = $model->get_list_by_uid($user_id,$fields,$page,$per_page);

          $this->body = empty($data) ? [] : $data; 

      }catch (\Exception $e){

          $this->error_code = 52002;

          $this->error_msg  = '服务器出错,请稍后再试';
      }

      return $this->result;
  }

}