<?php
/**
 * Api基础控制器
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\common\controller;
use think\Controller;
use think\Session;
class Api extends Controller{

    //响应码
	protected $error_code 		= 0;
	//响应消息                  
	protected $error_msg  		= '';
	//响应主体
	protected $body       		= [];
	//数据主体
	protected $data             = [];

	/**
	 * 控制器初始化方法
	 * @return null
	 */
	public function _initialize()
	{	
        //获取请求参数并赋值
    	$this->data = $this->request->param();
    	//api校验
    	//$this->api_verify($this->data);
	}

	/**
     * 校验api调用是否合法
     * @param  arary $arr  调用参数
     */
    protected function api_verify($arr=[])
    {
        //获取调用接口传递的时间戳
        $req_time = isset($arr['ts']) ? $arr['ts']+0 : 0;
        //校验时间参数是否正确
        if(false === $this->verify_expire($req_time))
        {
            $this->ajax_error('请求时间不正确',1);
        }
        //获取传递过来的签名参数
        $req_sig = isset($arr['sig']) ? trim($arr['sig']) : '';
        //删除传递过来的签名参数,用剩余的参数重新生成签名参数
        unset($arr['sig']);
        //获取排序后的查询字符串
        $sorted_query_string = $this->get_sorted_query_string($arr);
        $sig = $this->get_signature($sorted_query_string);
        if($sig != $req_sig)
        {
            $this->ajax_error('签名校验失败',2);
        }
    }

    /**
     * 校验接口调用时间是否已过期,防止一次签名多次调用
     * @param int $req_time 接口请求时间
     * @return bool         请求时间过期返回true,否则返回false
     */

    protected function verify_expire($req_time)
    {
        //api设置5分钟过期
        $expire = config('api_expire');
        //将请求时间与当前时间进行比较,判断请求是否合法
        $interval = time() - intval($req_time);

        if(abs($interval) > $expire)
        {
            return false;
        }
        return true;
    }

    /**
     * 获取排序后的查询字符串
     * @param array $arr 请求参数数组
     * @return string    按字典序排序后的字符串
     */
    protected function get_sorted_query_string($arr=array())
    {
        $str = '';
        if(is_array($arr) && !empty($arr))
        {
            ksort($arr);
            $i = 0;
            foreach($arr as $key=>$value)
            {
                if($i != 0)
                {
                    $str .= "&";
                }
                $str .= "{$key}={$value}";
                $i++;
            }
        }
        return $str;
    }


    /**
     * 获取签名参数
     * @param   string $sorted_query_srting 排好序之后的请求字符串
     * @return  string                      签名字符串
     */
    protected function get_signature($sorted_query_srting)
    {
         //获得通信密钥
         $key = config('api_key');
         //生成签名校验参数
         return strtoupper(md5($sorted_query_srting .'&key=' . $key));
    }


	/**
	 * 以josn格式返回结果
	 */
	protected function ajax_return()
	{
		$data = array(
			'errorCode' => $this->error_code,
			'errorMsg'  => $this->error_msg,
			'result'    => $this->body
		);
		header('Content-Type:application/json');
		echo json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		exit();
	}


	/**
     * ajax返回错误信息
     * @param  int    $error_code 错误代码
     * @param  string $error_msg  错误信息
     */
    protected function ajax_error($error_msg = '', $error_code = 0)
    {
        $this->error_msg = $error_msg;
        $this->error_code = $error_code;
        $this->ajax_return();
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
