<?php
/**
 * 消息管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class UserSms extends Base
{

  /**
   * 将通知从数据库中同步到db
   */
  public function store_to_db()
  {
      //实例化短信发送记录模型
      $user_sms_model    = model('member/UserSms');
      //获取redis单例
      $redis = \org\RedisLib::get_instance();
      //起始计数器
      $i    = 0;
      //一次同步2000条记录
      $num  = 2000;
      //短信队列名称
      $key = $user_sms_model->getTable();
      //判断队列中是否有短信,并且计数器是否小于$num
      while($redis->lSize($key) && $i<$num)
      {
          //取出队列末尾的短信
          $msg = $redis->rPop($key);
          if(!empty($msg))
          {
            //解码后的消息数组
            $decode_msg = json_decode($msg,true);
            //接收短信的手机号
            $phone   = $decode_msg['phone'];
            //短信内容
            $content = $decode_msg['content']; 
            //发送短信失败,重新加入到短信队列
            if(!sendSms($phone,$content))
            {
                $redis->lPush($key,$msg);
            }
            else
            {
              //短信写入数据库
              if(!empty($decode_msg['extra_data']))
              {
                //附加数据
                $extra_data = $decode_msg['extra_data'];
                //主键id
                $extra_data['id'] = $redis->incr("{$key}:id");
                //手机号码
                $extra_data['phone'] = $phone;
                //发送状态
                $extra_data['status'] = 1;
                //发送时间
                $extra_data['create_time'] = time();
                //加入到数据库
                $user_sms_model->add($extra_data);
              }
            }
          }
          $i++;
          //延迟0.01秒
          usleep(10);
      } 
  }

  //插入短信队列
  public function dispatch_sms($params=[])
  {
      //获取redis单例
      $redis = \org\RedisLib::get_instance();
      //将短信推入到短信队列中
      if(!$redis->lPush('sxh_user_sms',json_encode($params)))
      {
          $this->error_code = 91000;
          $this->error_msg  = '发送短信失败';
      }
      return $this->result;
  }
}