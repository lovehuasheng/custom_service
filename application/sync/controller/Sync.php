<?php
/**
 * 队列管理控制器
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\sync\controller;
use \think\Controller;
class Sync extends Controller{

	//同步短信消息到数据库,以后台任务执行
	public function sync_sms()
	{
      //获取redis单例
      $redis = \org\RedisLib::get_instance();
      //起始计数器
      $i    = 0;
      //一次同步2000条记录
      $num  = 1000;
      //短信队列名称
      $key = 'sxh_user_sms';
      //判断队列中是否有短信,并且计数器是否小于$num
      while($redis->lSize($key) && $i<$num)
      {
          $i++;
          //取出队列末尾的短信
          $msg = $redis->rPop($key);
          if(!empty($msg))
          {
            //解码后的消息数组
            $decode_msg = json_decode($msg,true);
            //手机号码
            $phone = $decode_msg['phone'];
            //替换-隔开的手机号码 如：135-1656-5566
            $phone = str_replace('-', '', $phone);
            //手机号码验证表达式
            $pattern = '/^(13[0-9]\d{8}|15[0-3|5-9]\d{8}|18[0-9]\d{8}|17[0-9]\d{8}|14[57]\d{8})$/';
            //验证手机号码是否合法
            if(!preg_match($pattern,$phone))
            {
                continue;
            }
            //短信内容
            $content = $decode_msg['content']; 
            //发送短信失败,重新加入到短信队列
            $rs = sendSms($phone,$content);
            //短信写入数据库
            if(!empty($decode_msg['extra_data']))
            {
               //附加数据
              $extra_data = $decode_msg['extra_data'];
              //主键id
             // $extra_data['id'] = $redis->incr("{$key}:id");
              //手机号码
              $extra_data['phone'] = $phone;
              //发送状态
              $extra_data['status'] = (int)$rs;
              //发送时间
              $extra_data['create_time'] = time();  
              //表后缀
              $table_postfix = date('Y',$extra_data['create_time']) . '_' . ceil(date('m',$extra_data['create_time'])/3);
              //取得表名
              $table = "sxh_user_sms_{$table_postfix}";
              //加入到数据库
              \think\Db::table($table)->insert($extra_data);

              //$redis->lPush('sxh_user_sms_data',json_encode($extra_data));
            }
          }
          //延迟0.001秒
          usleep(100);
      } 
	}


    //同步短信消息到数据库,以后台任务执行
  public function sync_sms_test()
  {
      //获取redis单例
      $redis = \org\RedisLib::get_instance();
      //起始计数器
      $i    = 0;
      //一次同步2000条记录
      $num  = 1000;
      //短信队列名称
      $key = 'sxh_user_sms';
      //判断队列中是否有短信,并且计数器是否小于$num
      while($redis->lSize($key) && $i<$num)
      {
          $i++;
          //取出队列末尾的短信
          $msg = $redis->rPop($key);
          if(!empty($msg))
          {
            //解码后的消息数组
            $decode_msg = json_decode($msg,true);
            //手机号码
            $phone = $decode_msg['phone'];
            //替换-隔开的手机号码 如：135-1656-5566
            $phone = str_replace('-', '', $phone);
            //手机号码验证表达式
            $pattern = '/^(13[0-9]\d{8}|15[0-3|5-9]\d{8}|18[0-9]\d{8}|17[0-9]\d{8}|14[57]\d{8})$/';
            //验证手机号码是否合法
            if(!preg_match($pattern,$phone))
            {
                continue;
            }
            //短信内容
            $content = $decode_msg['content']; 
            //发送短信失败,重新加入到短信队列
            $rs = sendSms($phone,$content);

            //var_dump($rs);exit();
            //短信写入数据库
            if(!empty($decode_msg['extra_data']))
            {
               //附加数据
              $extra_data = $decode_msg['extra_data'];
              //主键id
              //$extra_data['id'] = $redis->incr("{$key}:id"); 

              //手机号码
              $extra_data['phone'] = $phone;
              //发送状态
              $extra_data['status'] = (int)$rs;
              //发送时间
              $extra_data['create_time'] = time();  
              //表后缀
              $table_postfix = date('Y',$extra_data['create_time']) . '_' . ceil(date('m',$extra_data['create_time'])/3);
              //取得表名
              $table = "sxh_user_sms_{$table_postfix}";
              //加入到数据库
              \think\Db::table($table)->insert($extra_data);

              //$redis->lPush('sxh_user_sms_data',json_encode($extra_data));
            }
          }
          //延迟0.001秒
          usleep(100);
      } 
  }



  //同步短信到数据库
  public function sync_sms_to_db()
  {

      //获取redis单例
      $redis = \org\RedisLib::get_instance();
      //起始计数器
      $i    = 0;
      //一次同步2000条记录
      $num  = 2000;
      //短信队列名称
      $key = 'sxh_user_sms_data';
      //判断队列中是否有短信,并且计数器是否小于$num
      while($redis->lSize($key) && $i<$num)
      {
          //取出队列末尾的短信
          $msg = $redis->rPop($key);
          if(!empty($msg))
          {
            //解码后的消息数组
            $decode_msg = json_decode($msg,true);
            //表后缀
            $table_postfix = date('Y',$decode_msg['create_time']) . '_' . ceil(date('m',$decode_msg['create_time'])/3);
            //取得表名
            $table = "sxh_user_sms_{$table_postfix}";
            //加入到数据库
            \think\Db::table($table)->insert($decode_msg);
          }
          $i++;
          //延迟1秒
          usleep(100);
      } 
      
  }
	
	//同步客服任务到数据库,已后台任务运行
	// public function sync_work()
	// {
	// 	return model('member/SysWork','service')->write_to_db();
	// }
        
        
        //sxh_user_running_water
       /**
        * 订单收入支出队列入库
        * @return boolean
        */ 
       public function sync_running_water() {
           //实例化redis
           $redis = \org\RedisLib::get_instance();
           //每次调用执行次数
           $num = 1000;
           //判断redis队列中条数是否存在，并且每次循环数大于0
           while ($redis->lSize('sxh_user_running_water') && $num > 0) {
               $json = $redis->rPop('sxh_user_running_water');
               //校验数据是否存在
               if(!empty($json)) {
                   $result = json_decode($json,true);
                   $seq = ceil(date('m', $_SERVER['REQUEST_TIME'])/3);
                   $result['data']['id'] = $redis->incr("sxh_{$result['model_name']}:id");
                   $b = db($result['model_name'].'_'.date('Y',$_SERVER['REQUEST_TIME']).'_'.$seq)->insert($result['data']);
                   if(!$b) {
                       //如果进入数据库错误，重新加入队列
                       add_to_queue('sxh_user_running_water',$result);
                   }
               }
               
               $num --;
              //延迟0.1秒
               usleep(100);
           }
           
           return  true;
           
       }
       
      
       /**
        * log日志队列
        * @return boolean
        */
      public function sync_set_log() {
          
          //实例化redis
           $redis = \org\RedisLib::get_instance();
           //每次调用执行次数
           $num = 1000;
           //判断redis队列中条数是否存在，并且每次循环数大于0
           while ($redis->lSize(config('log_queue')) && $num > 0) {
               $json = $redis->rPop(config('log_queue'));
               //校验数据是否存在
               if(!empty($json)) {
                   $result = json_decode($json,true);
               
                   $seq = ceil(date('m', $_SERVER['REQUEST_TIME'])/3);
                   $b = db($result['model_name'].'_'.date('Y',$_SERVER['REQUEST_TIME']).'_'.$seq)->insert($result['data']);
                   if(!$b) {
                       //如果进入数据库错误，重新加入队列
                       add_to_queue(config('log_queue'),$result);
                   }
               }
               
               $num --;
              //延迟0.1秒
               usleep(100);
           }
           
           return  true;
      }
    
      
      /**  没经过分表的可以走这队列
       * 加入黑名单队列
       * @return boolean
       */
      public function sync_set_blacklist() {
          
          //实例化redis
           $redis = \org\RedisLib::get_instance();
           //每次调用执行次数
           $num = 1000;
           //判断redis队列中条数是否存在，并且每次循环数大于0
           while ($redis->lSize('sxh_user_blacklist') && $num > 0) {
               $json = $redis->rPop('sxh_user_blacklist');
               //校验数据是否存在
               if(!empty($json)) {
                   $result = json_decode($json,true);
                  
                   $b = db($result['model_name'])->insert($result['data']);
                   if(!$b) {
                       //如果进入数据库错误，重新加入队列
                       add_to_queue('sxh_user_blacklist',$result);
                   }
               }
               
               $num --;
              //延迟0.1秒
               usleep(100);
           }
           
           return  true;
      }
      
      /**
       * 更新钱包
       * @return boolean
       */
      public function sync_set_user_wallet() {
          //实例化redis
           $redis = \org\RedisLib::get_instance();
           //每次调用执行次数
           $num = 1000;
           //判断redis队列中条数是否存在，并且每次循环数大于0
           while ($redis->lSize('user_wallet_edit') && $num > 0) {
               $json = $redis->rPop('user_wallet_edit');
               //校验数据是否存在
               if(!empty($json)) {
                   $result = json_decode($json,true);
                   $b = model($result['model_name'])->update_by_uid($result['map']['user_id'],$result['data']);
                   if(!$b) {
                       //如果进入数据库错误，重新加入队列
                       add_to_queue('user_wallet_edit',$result);
                   }
               }
               
               $num --;
              //延迟0.1秒
               usleep(100);
           }
           
           return  true;
      }
      
      
      
      /**
       * 定时统计排名  指定定时时间为凌晨两点
       * @return boolean
       */
      public function  work_statistic_count() {
          $map['create_date'] = date('Ymd',strtotime('-1 day'));
          $field = ['id','sys_uid','total_num','success_num','work_time'];
          $model = model('member/SysWorkStatistic');
          $list = $model->get_statistic($map,$field);
          
          $month_map['year_date']  = date('Y',strtotime('-1 month'));
          $month_map['month_date'] = date('m',strtotime('-1 month'));
          $info = $model->get_statistic($month_map,$field);
         
          if(!empty($list)) {
                $list = get_array_to_object($list);
                $arr = [];
                //工作量排行榜
                $total_num = list_sort_by($list,'total_num','desc');
                for($i=0; $i<count($total_num); $i++) {
                    $arr[$total_num[$i]['sys_uid']]['id'] = $total_num[$i]['id'];
                    $arr[$total_num[$i]['sys_uid']]['total'] = ($i+1);
                }
                
                //通过率排行榜
                $success_num = list_sort_by($list,'success_num','desc');
                for($i=0; $i<count($success_num); $i++) {
                    $arr[$success_num[$i]['sys_uid']]['success'] = ($i+1);
                }
                //工作时间排行榜
                $work_time = list_sort_by($list,'work_time','desc');
                for($i=0; $i<count($work_time); $i++) {
                    $arr[$work_time[$i]['sys_uid']]['work'] = ($i+1);
                }
     
                unset($total_num);
                unset($success_num);
                unset($work_time);
              
                if(!empty($arr)) {
                    $model->work_statistic_count($arr);
                }
                unset($arr);
          }
          
          unset($list);
          unset($month_map);
          unset($field);
          unset($map);
          
          if(!empty($info)) {
               $list = get_array_to_object($list);
               $array = [];
               //工作量排行榜
               $total_num_month = list_sort_by($info,'total_num','desc');
               for($i=0; $i<count($total_num_month); $i++) {
                    $array[$total_num_month[$i]['sys_uid']]['id'] = $total_num_month[$i]['id'];
                    $array[$total_num_month[$i]['sys_uid']]['total'] = ($i+1);
                }
                
                //通过率排行榜
                $success_num_month = list_sort_by($info,'success_num','desc');
                for($i=0; $i<count($success_num_month); $i++) {
                    $array[$success_num_month[$i]['sys_uid']]['success'] = ($i+1);
                }
                //工作时间排行榜
                $work_time_month = list_sort_by($info,'work_time','desc');
                for($i=0; $i<count($work_time_month); $i++) {
                    $array[$work_time_month[$i]['sys_uid']]['work'] = ($i+1);
                }
                unset($total_num_month);
                unset($success_num_month);
                unset($work_time_month);
               
                if(!empty($array)) {
                    $model->work_statistic_month_count($array);
                }
                unset($array);
          }
          unset($info);
          
          return true;
      }

      /**
       * 转移推荐人
       */
      public function modify_referee()
      {
          //实例化redis
           $redis = \org\RedisLib::get_instance();
           //每次调用执行次数
           $num = 1000;
           //判断redis队列中条数是否存在，并且每次循环数大于0
           while ($redis->lSize('modify_referee') && $num > 0) {
               $json = $redis->rPop('modify_referee');
               //校验数据是否存在
               if(!empty($json)) {

                   $data = json_decode($json,true);
                   //个人会员
                   if($data['user_type'] ==0 )
                   {
                      $b = model('change/Change','service')->do_change_ref_action($data['data']);
                   }
                   else
                   {
                      //企业会员
                      $b = mdoel('change/Change','service')->do_change_company_ref_action($data['data']);
                   }
                   
                   if($b->errCode != 0) {
                         //更改失败,重新加入队列
                         add_to_queue('modify_referee',$data);
                    }

               }
               
               $num --;
              //延迟0.1秒
               usleep(100);
           }
           
           return  true;
      }



  //删除redis中存在用户信息表中不存在的手机号码
  public function sync_phone()
  {
      $i=0;

      $redis = \org\RedisLib::get_instance();

      $it = null;

      $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY); 

      while($phones = $redis->sScan('sxh_user_info:phone', $it, '',10000))
      {
          foreach($phones as $phone) {

            $sql1 = 'select user_id from sxh_user_info_1 where phone=' . $phone;
            $sql2 = 'select user_id from sxh_user_info_2 where phone=' . $phone;
            //查询手机号码在数据库中是否存在
            $rs1 = \think\Db::table('sxh_user_info_1')->query($sql1);
            $rs2 = \think\Db::table('sxh_user_info_2')->query($sql2);
            //手机号码在数据中不存在则删除redis中的手机号码
            if(empty($rs1) && empty($rs2)){
              $redis->sRem('sxh_user_info:phone',$phone);
              $i++;
              echo "------第{$i}条已处理完成------" . PHP_EOL;
            }
          }
         usleep(10);
      } 
      echo 'success';
  }


  //删除redis中存在用户信息表中不存在的支付宝帐号
  public function sync_alipay_account()
  {
      $i=0;

      $redis = \org\RedisLib::get_instance();

      $it = null;

      $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);

      while($alipay_accounts = $redis->sScan('sxh_user_info:alipay_account', $it, '',10000))
      {
          foreach($alipay_accounts as $alipay_account) {
            $sql1 = 'select user_id from sxh_user_info_1 where alipay_account=' . $alipay_account;
            $sql2 = 'select user_id from sxh_user_info_2 where alipay_account=' . $alipay_account;
            //查询支付宝账号在数据库中是否存在
            $rs1 = \think\Db::table('sxh_user_info_1')->query($sql1);
            $rs2 = \think\Db::table('sxh_user_info_2')->query($sql2);
            //支付宝账号在数据中不存在则删除redis中的支付宝账号
            if(empty($rs1) && empty($rs2)){
              $redis->sRem('sxh_user_info:alipay_account',$alipay_account);
              $i++;
              echo "------第{$i}条已处理完成------" . PHP_EOL;
            }
          }
         usleep(10);
      } 
      echo 'success';
  }


  //删除redis中存在用户信息表中不存在的微信帐号
  public function sync_weixin_account()
  {
      $i=0;

      $redis = \org\RedisLib::get_instance();

      $it = null;

      $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY); 

      while($weixin_accounts = $redis->sScan('sxh_user_info:weixin_account', $it, '',10000))
      {
          foreach($weixin_accounts as $weixin_account) {
            $sql1 = 'select user_id from sxh_user_info_1 where weixin_account=' . $weixin_account;
            $sql2 = 'select user_id from sxh_user_info_2 where weixin_account=' . $weixin_account;
            //查询微信号在数据库中是否存在
            $rs1 = \think\Db::table('sxh_user_info_1')->query($sql1);
            $rs2 = \think\Db::table('sxh_user_info_2')->query($sql2);
            //微信号在数据中不存在则删除redis中的微信号
            if(empty($rs1) && empty($rs2)){
              $redis->sRem('sxh_user_info:weixin_account',$weixin_account);
              $i++;
              echo "------第{$i}条已处理完成------" . PHP_EOL;
            }
          }
         usleep(10);
      }
      echo 'success';
  }


  //删除redis中存在用户信息表中不存在的银行帐号
  public function sync_bank_account()
  {
      $i = 0;

      $redis = \org\RedisLib::get_instance();

      $it = null;

      $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY); 

      while($bank_accounts = $redis->sScan('sxh_user_info:bank_account', $it, '',10000))
      {
          foreach($bank_accounts as $bank_account) {
            $sql1 = 'select user_id from sxh_user_info_1 where bank_account=' . $bank_account;
            $sql2 = 'select user_id from sxh_user_info_2 where bank_account=' . $bank_account;
            //查询银行账号在数据库中是否存在
            $rs1 = \think\Db::table('sxh_user_info_1')->query($sql1);
            $rs2 = \think\Db::table('sxh_user_info_2')->query($sql2);
            //银行账号在数据中不存在则删除redis中的银行帐号
            if(empty($rs1) && empty($rs2)){
              $redis->sRem('sxh_user_info:bank_account',$bank_account);
              $i++;
              echo "------第{$i}条已处理完成------" . PHP_EOL;
            }
          }
         usleep(10);
      }
      echo 'success';
  }


  //删除redis中存在用户信息表中不存在的身份证号码
  public function sync_card_id()
  {
      $i=0;

      $redis = \org\RedisLib::get_instance();

      $it = null;

      $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY); 

      while($card_ids = $redis->sScan('sxh_user_info:card_id', $it, '',10000))
      {
          foreach($card_ids as $card_id) {
            $sql1 = 'select user_id from sxh_user_info_1 where card_id=' . $card_id;
            $sql2 = 'select user_id from sxh_user_info_2 where card_id=' . $card_id;
            //查询身份证号码在数据库中是否存在
            $rs1 = \think\Db::table('sxh_user_info_1')->query($sql1);
            $rs2 = \think\Db::table('sxh_user_info_2')->query($sql2);
            //身份证号码在数据中不存在则删除redis中的身份证号码
            if(empty($rs1) && empty($rs2)){
              $redis->sRem('sxh_user_info:card_id',$card_id);
              $i++;
              echo "------第{$i}条已处理完成------" . PHP_EOL;
            }
          }
         usleep(10);
      } 
      echo 'success';
  }

  //同步用会员信息表1到redis
  public function sync_redis()
  {

    set_time_limit(0);

    //计算会员表1的会员总数
    $user_total_sql = "select count(*) as total from sxh_user_info_1";

    $user_total_res = \think\Db::query($user_total_sql);

    if($user_total_res && is_array($user_total_res)){

        $total = $user_total_res[0]['total'];
    }else{
      $total = 0;
    }

    $per_page   = 2000; 

    $total_page = ceil($total/$per_page);

    $j=1;

    $redis = \org\RedisLib::get_instance();

    for($page=1;$page<=$total_page;$page++)
    {
      $sql = "select user_id,username,phone,alipay_account,weixin_account,bank_account,card_id from sxh_user_info_1 limit " . ($page-1)*$per_page . ',' . $per_page;
      $info = \think\Db::query($sql);
      if(!empty($info)){
           
                foreach($info as $v){

                       $redis->multi();

                        //去除空格
                        $username = str_replace(' ', '', $v['username']);
                        //转换大小写
                        $username = strtolower($username);
                        //去除空格
                        $username = trim($username);

                        /*绑定用户名与用户ID*/
                        if(!empty($username)){
                          $redis->set('sxh_user:username:' . $username . ':id',intval($v['user_id']));
                          $redis->set('sxh_user:id:' . intval($v['user_id']) . ':username',$username);
                        }

                        
                        //用户名集合
                        if(!empty($username)){
                            $redis->sAdd('sxh_user:username',$username);
                        }

                        //去除空格
                        $phone = trim($v['phone']);

                        //手机号码集合
                        if(!empty($phone) && strtolower($phone) != 'null'){

                           $redis->sAdd('sxh_user_info:phone',$phone);

                           $redis->hSet('sxh_userinfo:id:' . intval($v['user_id']) ,'phone',$phone);
                        }

                        //去除空格
                        $alipay_account = trim($v['alipay_account']);

                        //支付宝账号集合
                        if(!empty($alipay_account) && strtolower($alipay_account) != 'null'){

                                $redis->sAdd('sxh_user_info:alipay_account',$alipay_account);
                        }

                        //去除空格
                        $weixin_account = trim($v['weixin_account']);

                        //微信账号集合
                        if(!empty($weixin_account) && strtolower($weixin_account) != 'null'){
                                $redis->sAdd('sxh_user_info:weixin_account',$weixin_account);
                        }

                        //去除空格
                        $bank_account = trim($v['bank_account']);

                        //银行卡集合
                        if(!empty($bank_account) && strtolower($bank_account) != 'null'){

                          $redis->sAdd('sxh_user_info:bank_account',$bank_account);
                        }

                        //去除空格
                        $card_id = trim($v['card_id']);

                        //身份证号集合
                        if(!empty($card_id) && strtolower($card_id) != 'null'){

                            $redis->sAdd('sxh_user_info:card_id',$card_id);
                        }

                      $redis->exec();

                      file_put_contents(LOG_PATH ."sxh_user_info_1_redis.txt" , "{$j}/{$total} finished\r\n" , FILE_APPEND);

                      $j++;
                          
                    }
           
          }
      }

    file_put_contents(LOG_PATH ."sxh_user_info_1_redis.txt" , "-----ok-----\r\n" , FILE_APPEND);
  }

  //同步用户信息表2到redis
  public function sync_redis_two()
  {
    
    set_time_limit(0);

    //计算会员表2的会员总数
    $user_total_sql = "select count(*) as total from sxh_user_info_2";

    $user_total_res = \think\Db::query($user_total_sql);

    if($user_total_res && is_array($user_total_res)){

        $total = $user_total_res[0]['total'];
    }else{
      $total = 0;
    }

    $per_page   = 2000; 

    $total_page = ceil($total/$per_page);

    $j=1;

    $redis = \org\RedisLib::get_instance();

    for($page=1;$page<=$total_page;$page++)
    {
      $sql = "select user_id,username,phone,alipay_account,weixin_account,bank_account,card_id from sxh_user_info_2 limit " . ($page-1)*$per_page . ',' . $per_page;
      $info = \think\Db::query($sql);
      if(!empty($info)){
           
                foreach($info as $v){

                       $redis->multi();

                        //去除空格
                        $username = str_replace(' ', '', $v['username']);
                        //转换大小写
                        $username = strtolower($username);
                        //去除空格
                        $username = trim($username);

                        /*绑定用户名与用户ID*/
                        if(!empty($username)){
                          $redis->set('sxh_user:username:' . $username . ':id',intval($v['user_id']));
                          $redis->set('sxh_user:id:' . intval($v['user_id']) . ':username',$username);
                        }

                        
                        //用户名集合
                        if(!empty($username)){
                            $redis->sAdd('sxh_user:username',$username);
                        }

                        //去除空格
                        $phone = trim($v['phone']);

                        //手机号码集合
                        if(!empty($phone) && strtolower($phone) != 'null'){

                           $redis->sAdd('sxh_user_info:phone',$phone);

                           $redis->hSet('sxh_userinfo:id:' . intval($v['user_id']) ,'phone',$phone);
                        }

                        //去除空格
                        $alipay_account = trim($v['alipay_account']);

                        //支付宝账号集合
                        if(!empty($alipay_account) && strtolower($alipay_account) != 'null'){

                                $redis->sAdd('sxh_user_info:alipay_account',$alipay_account);
                        }

                        //去除空格
                        $weixin_account = trim($v['weixin_account']);

                        //微信账号集合
                        if(!empty($weixin_account) && strtolower($weixin_account) != 'null'){
                                $redis->sAdd('sxh_user_info:weixin_account',$weixin_account);
                        }

                        //去除空格
                        $bank_account = trim($v['bank_account']);

                        //银行卡集合
                        if(!empty($bank_account) && strtolower($bank_account) != 'null'){

                          $redis->sAdd('sxh_user_info:bank_account',$bank_account);
                        }

                        //去除空格
                        $card_id = trim($v['card_id']);

                        //身份证号集合
                        if(!empty($card_id) && strtolower($card_id) != 'null'){

                            $redis->sAdd('sxh_user_info:card_id',$card_id);
                        }

                        $redis->exec();

                       file_put_contents(LOG_PATH ."sxh_user_info_2_redis.txt" , "{$j}/{$total} finished\r\n" , FILE_APPEND);

                       $j++;
                          
                    }
           
          }
      }

    file_put_contents(LOG_PATH ."sxh_user_info_2_redis.txt" , "-----ok-----\r\n" , FILE_APPEND);
  }

  //同步企业信息到redis
  public function sync_redis_company()
  {
    

      set_time_limit(0);

      $redis = \org\RedisLib::get_instance();

      $j=1;
      $sql = "select id,username from sxh_company";
      $info = \think\Db::query($sql);
      if(!empty($info)){
           
                foreach($info as $v){

                        //去除空格
                        $username = str_replace(' ', '', $v['username']);
                        //转换大小写
                        $username = strtolower($username);
                        //去除空格
                        $username = trim($username);
                        
                        //用户名集合
                        if(!empty($username)){
                            $redis->sAdd('sxh_user:username',$username);
                        }

                       file_put_contents(LOG_PATH ."sxh_company_redis.txt" , "{$j} finished\r\n" , FILE_APPEND);

                       $j++;
                          
                    }
           
          }

      file_put_contents(LOG_PATH ."sxh_company_redis.txt" , "-----ok-----\r\n" , FILE_APPEND);
  }


}
