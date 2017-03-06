<?php
/**
 * Redis封装类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace org;
use \think\Config;
use app\common\controller\UserRedis;
class RedisLib 
{
	//redis实例
	protected static $pool = [];

	final private function __construct($group='default')
	{
		//加载redis配置文件
		Config::load(APP_PATH . 'redis.php');
		//检测是否存在对应的配置组
		if(!Config::has($group))
		{
			throw new \Exception("读取redis配置时出错,不存在{$group}的配置组",-1);	
		}
		//加载对应的配置项
		$config = Config::get($group);
		//检测是设置host选项
		if(!isset($config['host']))
		{
			throw new \Exception("读取redis配置出错,host配置项未设置",-2);
		}
		//设置host
		$host = $config['host'];
		//设置port,默认为6379
		$port = !empty($config['port']) ? $config['port'] : 6379;
		//实例化redis
		$redis = new UserRedis();
		//连接redis
		if(!$redis->connect($host,$port))
		{
		 	throw new \Exception("连接redis时出错", -3);
		}
		//检测是否设置了redis连接密码
		if(!empty($config['auth']))
		{	
			//验证redis是否正确
			if($redis->auth($config['auth']) === FALSE)
			{
				throw new \Exception("redis认证失败", -4);
			}
		}
		self::$pool[$group] = $redis;
		
	}

	final private function __clone()
	{

	}

	//获取redis实例
	public static function get_instance($group='default')
	{
		if(isset(self::$pool[$group]) && self::$pool[$group] instanceof Redis)
		{
			return self::$pool[$group];
		}
		new self($group);
		return self::$pool[$group];
	}
}