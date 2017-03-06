<?php
/**
 * 申请解封
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class Deblocking extends Base
{

  //获取申请解封列表
  public function acquire_apply_list($params=[])
  { 
      //查询条件
      $condition = [];
      //被封人账号
      $deblock_username = empty($params['deblock_username']) ? '' : trim($params['deblock_username']);
      //页码
      $page             = empty($params['page']) ? 0 : intval($params['page']);

      if(!empty($deblock_username))
      {
        $condition['deblock_username'] = $deblock_username;
      }

      //设置页码
      if($page <=0)
      {
        $page = 1;
      }

      //每页记录数,默认100条
      $per_page = config('page_total');

      //页码列表,默认为5页
      $page_list = config('page_list');

      //申请列表
      $apply_list = [];

      //满足条件的记录总数
      $total     = 0;

      $deblocking_model = model('Deblocking');

      //获取的字段列表
      $fields = [
          //主键
          'id',
          //被冻结会员账号
          'deblock_username',
          //被冻结会员真实姓名
          'deblock_name',
          //解封状态
          'status',
          //服务中心账号
          'service_username',
          //提交时间
          'create_time'
        ];

      //不显示未通过的记录
      $condition['status'] = ['<',2];

      //查询满足条件的会员数量
      $total = $deblocking_model->get_count($condition);

      //按解封状态排序,未解封的排在前面
      $order = ['status' => 'asc'];

      if($total)
      { 
        $apply_list = $deblocking_model->get_list($condition,$fields,$page,$per_page,$order);
      }

      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //返回结果
      $this->body = [
          'apply_list' => $apply_list,
          'pages'      => $pages,
          'total'      => $total
        ];

      return $this->result;

  }

  //获取申请解封详情
  public function acquire_apply_info($params=[])
  {

    $apply_id = empty($params['apply_id']) ? 0 : intval($params['apply_id']);

    if($apply_id <= 0)
    {
      $this->error_code = 200003;
      $this->error_msg  = '参数不正确';
      return $this->result;
    }

    $deblocking_model = model('Deblocking');

    $blacklist_model  = model('user/UserBlacklist');

    $fields = [
      //申请解封描述
      'deblock_content',
      //缴纳罚款截图
      'image',
      //被封会员id
      'deblock_user_id'
    ];

    $apply_info  = $deblocking_model->get_by_id($apply_id,$fields); 

    if(empty($apply_info))
    {
      $this->error_code = 200004;
      $this->error_msg  = '数据不存在';
      return $this->result;
    } 

    //查询封号原因
    $black_info = $blacklist_model->get_by_uid($apply_info->deblock_user_id,['remark']);

    $redis = \org\RedisLib::get_instance('sxh_default');

    //此前解封次数
    $deblock_num = $redis->get('sxh_user_deblock_num:user_id:' . $apply_info->deblock_user_id);

    $this->body = [
       //申请解封描述
      'deblock_content' => $apply_info->deblock_content,
      //封号原因
      'block_reason'    => $black_info['remark'],
      //缴纳罚款截图
      'image'           => getQiNiuPic($apply_info->image),
      //此前解封次数
      'deblock_num'     => intval($deblock_num)
    ];  

    return $this->result;
  }

  //更新解封信息
  public function modify_apply_info($params=[])
  { 
     //主键id
     $apply_id = empty($params['apply_id']) ? 0 : intval($params['apply_id']);
     //同意解封/不同解封 0-不同意 1-同意
     $status = empty($params['status']) ? 0 : intval($params['status']);
     //不予解封描述
     $unblock_comtent = empty($params['unblock_comtent']) ? '' : trim($params['unblock_comtent']);

     if($apply_id <=0)
     {
        $this->error_code =  200005;
        $this->error_msg  = '参数错误';
        return $this->result;
     }

     $status = intval($status);

     if(!in_array($status,[0,1]))
     {
        $this->error_code =  200006;
        $this->error_msg  = '请选择解封或者继续冻结中的一个';
        return $this->result;
     }
     
      $data = [
             //操作人id
            'auit_user_id'    => session('user_auth.id'),
            //操作人用户名
            'auit_username'   => session('user_auth.username'),
            //操作时间
            'operation_time'  => time(),
            //解封状态
            'status'          => $status == 1 ? 1 : 2,
        ];

     //如果不给予解封则必须填写不解封原因
     if($status == 0)
     {  
        if(empty($unblock_comtent))
        {
          $this->error_code = 200007;
          $this->error_msg  = '请填写不予解封描述';
          return $this->result;
        }
        //不予解封描述
        $data['unblock_comtent'] = $unblock_comtent;
     }

      $deblocking_model = model('Deblocking');

      $blacklist_model  = model('user/UserBlacklist');

      $user_model       = model('member/User');

      $user_info_model  = model('member/UserInfo');

      $fields = [
        //被封会员id
        'deblock_user_id',
        //申请人id
        'user_id'
      ];

    $apply_info  = $deblocking_model->get_by_id($apply_id,$fields);

    if(empty($apply_info))
    {
      $this->error_code = 200008;
      $this->error_msg  = '数据不存在';
      return $this->result;
    } 

    //解封通过发送短息,发送给被封号的会员
    if($status == 1){
        $phone = $user_info_model->get_by_uid($apply_info->deblock_user_id,['phone']);
        //被封号会员手机号码
        $sms['phone']     = $phone['phone'];
        //短信内容
        $sms['content']   = "您的账号已解封，可以正常登录了！如需帮助请联系客服";
        //附加数据
        $sms['extra_data']['user_id'] = $apply_info->deblock_user_id;
        //短信标题
        $sms['extra_data']['title'] = '解封通知';
        //ip地址
        $sms['extra_data']['ip_address'] = ip2long(request()->ip());
    }else{
        //不予解封,发送短信到申请解封人
        $phone = $user_info_model->get_by_uid($apply_info->user_id,['phone']);
        //申请人手机号码
        $sms['phone']     = $phone['phone'];
        //短信内容
        $sms['content']   = "您提交的账号申请未通过，详细原因请前往【系统公告】";
        //附加数据
        $sms['extra_data']['user_id'] = $apply_info->user_id;
        //短信标题
        $sms['extra_data']['title'] = '不予解封通知';
        //ip地址
        $sms['extra_data']['ip_address'] = ip2long(request()->ip());
    }
      $redis = \org\RedisLib::get_instance('sxh_default');
      //开启事务
      \think\Db::startTrans();
      try{  
          //更新申请解封表信息
         $deblocking_model->update_by_id($apply_id,$data);
         //解封通过将用户从黑名单中移除
         if($status == 1)
         {
           //将用户从黑名单中移除
           $blacklist_model->del_by_uid($apply_info->deblock_user_id);
           //更新会员的激活状态
           $user_model->update_by_id($apply_info->deblock_user_id,['status'=>1]);
           //更新解封次数
           $redis->incr('sxh_user_deblock_num:user_id:' . $apply_info->deblock_user_id);
         }
         //发送短信
         add_to_queue('sxh_user_sms',$sms);
        // 提交事务
        \think\Db::commit();
      }catch (\Exception $e){
          // 回滚事务
          \think\Db::rollback();
          $this->error_code = 200009;
          $this->error_msg  = '操作失败';
      }
      return $this->result;
  }

}