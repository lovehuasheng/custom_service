<?php
/**
 * 管理后台逻辑类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\common\logic;
use think\Model;
class Base extends Model
{

	//响应码
	protected $error_code = 0;
	//响应消息                  
	protected $error_msg  = '';
	//响应主体
	protected $body       = [];

	/**
	 * 通过魔术方法将响应结果赋值到自身的result属性上
	 * @param   $key  要访问的属性
	 */
	public function __get($key)
	{
		if($key == 'result')
		{
			return [
				'errorCode' => $this->error_code,
				'errorMsg'  => $this->error_msg,
				'result'    => $this->body
			];
		}
		return null;
	}

	/**
	 * 将数据添加到队列,失败则写入到本地文件中
	 * @param  string $queue_name 队列名称
	 * @param  array  $data       要同步的数据
	 */
	public function add_to_queue($queue_name='',$data=[])
	{
	   //同步标志
	   $syn_flag = true;
	   try
	   {
	   	 //实例化redis
       	 $redis = \org\RedisLib::get_instance();
       	 //推送数据到同步队列
       	 if(!$redis->lPush($queue_name,json_encode($data)))
       	 {
       	 	$syn_flag = false;
       	 }
	   }catch(Exception $e)
	   {
	   		$syn_flag = false;
	   }

	   //redis推送失败,将失败数据写入到文件,等待后续同步 ,文件以队列名称命名
	   if(!$syn_flag)
	   {
	    	$file = LOG_PATH . $queue_name . 'log';
	   		file_put_contents($file,json_encode($data),FILE_APPEND|LOCK_EX); 
	   }
	}
}
