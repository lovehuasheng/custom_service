<?php
/**
 * 管理后台基础类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\common\service;
use think\Model;
use think\Request;

class Base extends Model{

	//响应码
	protected $error_code		= 0;
	//响应消息                   
	protected $error_msg        = '';
	//响应主体
	protected $body          	= [];
	//数据主体
	protected $data             = [];

    
    //自定义初始化
    protected function initialize()
    {
    	//调用父类的初始化操作
        parent::initialize();
        //获取请求参数并赋值
    	$this->data = Request::instance()->param();    
    }


	/**
	 * 验证数据的合法性
	 * @param  string   $validator  要使用的验证器名称
	 * @param  string   $scene      验证场景
	 * @param  array    $data       待验证的数据
	 * @return boolean              验证通过返回true,失败返回false
	 */
	protected function verify($validator,$scene='',$data=[])
	{
		//如果未传递数据,默认验证自身的data属性
		if(empty($data))
		{
			$data = $this->data;
		}
		//根据传入的验证器名称,实例化对应的验证器类
		$validator_instance = \think\Loader::validate($validator);
		//如果定义了验证场景,则设置验证场景
		if(!empty($scene))
		{
			$validator_instance->scene($scene);
		}
		//根据场景规则进行数据验证
		if($validator_instance->check($data) !== true)
		{
			//验证不通过则获取错误信息,并赋值到自身的error_code与error_msg属性
			$validate_result = $validator_instance->getError();
			list($this->error_msg,$this->error_code)  = $validate_result;
			return false;
		}
		return true;
	}

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
}
