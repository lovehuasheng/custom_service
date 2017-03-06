<?php
/**
 * 管理后台基础类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\common\controller;
use think\Controller;
use think\Session;
class Base extends Controller{

	//无需登录即可以访问的操作列表
	protected $no_login_methods = [];
	//无需检测权限即可访问的操作列表
	protected $no_auth_methods  = [];
	//用户登录态数据
	protected $user_info        = [];
	//登录用户id
    protected $user_id          =  0;
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
		//获取请求的模块
		$module 	= $this->request->module();
		//获取请求的控制器
		$controller = $this->request->controller();
		//获取请求的操作
		$action     = $this->request->action();
		//检测请求的操作是否要求登录
		if(!in_array($module . '/' . $controller . '/' . $action,$this->no_login_methods))
		{
			//检测用户是否已经登录
			if(!$this->check_login())
			{
				//检测是否是ajax请求
				if($this->request->isAjax() || $this->request->isPjax())
				{
					//如果是Ajax请求或者Pjax请求则以json格式返回响应消息
					$this->error_code = -1999;
					$this->error_msg  = '请登录后再进行操作';
					$this->ajax_return();
				}
				else
				{
					//如果用户未登录,而且请求类型非ajax则重定向到特定的操作
					$this->no_login();
				}
			}
		}

		//检测请求的操作是否需要进行权限验证
		if(!in_array($module . '/' . $controller . '/' . $action,$this->no_auth_methods))
		{
			//检测用户是否有权限进行特定的操作
			if(!$this->check_auth())
			{
				//检测是否是ajax请求
				if($this->request->isAjax() || $this->request->isPjax())
				{
					$this->error_code = -2;
					$this->error_msg  = '你无权进行本操作';
					$this->ajax_return();
				}
				else
				{
					//如果用无无权进行特定的操作,并且请求类型非ajax,则重定向到特定的操作
					$this->no_auth();
				}
			}

		} 
        //获取请求参数并赋值
    	$this->data = $this->request->param();  
        //
         if($this->user_info['is_super'] != 1) {
            //判断是否超过15分钟没有请求
            $login_log_time = session('login_log_time');
            //如果超过15分钟 记录一条日志
            if($_SERVER['REQUEST_TIME'] > ($login_log_time+(config('login_time_out')*60))) {
                $this->set_login_timeout('页面超过'. config('login_time_out') . '分钟没有刷新');
            }
          
          
            //如果超过2分钟 记录一条日志
           if($_SERVER['REQUEST_TIME'] < ($login_log_time+(config('work_time_out')*60))) {
                $work_time = $_SERVER['REQUEST_TIME'] - $login_log_time;
                $this->set_work_statistic($work_time);
                session('login_log_time',$_SERVER['REQUEST_TIME']);
            }
  
           
         }
        
        
	}

	/**
	 * 检测用户是否登录
	 * @return boolean 已登录返回true,否则返回false
	 */
	protected function check_login()
	{  
            //用户信息session 
            $user = session('user_auth');
            //用户信息session加密串
            $sign = session('user_auth_sign');
            //比对session加密串
            if((set_user_session_sign($user) === $sign)) {
                //赋值用户ID 
                $this->user_id = $user['id'];
                //赋值的用户信息
                $this->user_info = $user;
                unset($sign);
                if(empty($user['rand_str']) || substr(md5($user['rand_str']),0,16) != cache('user_rank_'.$this->user_id)) {
                    $this->set_login_timeout('你的账号已被迫的下线了，请即时更改密码');
                    $this->user_id = 0;
                    $this->user_info = [];
                    session('user_auth',null);
                    session('user_auth_sign',null);
                    unset($user);
                    
                    $this->error_code = -1998;
                    $this->error_msg  = '你的账号已被迫的下线了，请即时更改密码！';
                    $this->ajax_return();
                    return false;
                }
                //销毁变量
                unset($user);
                
                

                return true;
            }else {
                $this->user_id = 0;
                $this->user_info = [];
                return false;
            }
	}

	/**
	 * 检测用户是否有权限进行特定的操作
	 * @return boolean 用户有权限进行特定的操作返回true,否则返回false
	 */
	protected function check_auth()
	{
            if($this->user_info['is_super'] != 1) {
                //查看用户组是否被禁用了
                $auth = cache('__auth__'.$this->user_info['id']); 
                if(empty($auth)) {
                    $auth = model('permission/SysGroup')->get_by_id($this->user_info['group_id'],'status');
                    $auth = $auth->toArray();


                    cache('__auth__'.$this->user_info['id'],$auth);
                }

               if(empty($auth) ||  $auth['status'] != 0) {
                       //$this->error_code = -1997;
                       //$this->error_msg  = '你没有权限访问网站！！';
                       //$this->ajax_return();
                       return false;
               } 
            }
            
            return true;
	}

	/**
	 * 用户未登录需要重定向到的操作,子类需要按需重写本方法
	 * @return 
	 */
	protected function no_login()
	{
	     $this->redirect('/user/index/index');
          
	}

	/**
	 * 用户未授权需要重定向到的操作,子类需要重写本方法
	 * @return [type] [description]
	 */
	protected function no_auth()
	{
		$this->redirect('/user/index/index');
                // $this->error_code = -2000;
                // $this->error_msg  = '你无权进行本操作';
                // $this->ajax_return();
//		echo '你无权进行本操作';
//		exit();
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
        
        /**
         * 记录客服操作记录
         * @param type $remark
         */
        protected function set_login_timeout($remark = '页面超过10分钟没有刷新') {
            
            $login_log['data']['uid']                     = $this->user_info['id'];
            $login_log['data']['username']                = $this->user_info['username'];
            $login_log['data']['realname']                = $this->user_info['realname'];
            $login_log['data']['remark']                  = $remark;
            $login_log['data']['create_time']             = $_SERVER['REQUEST_TIME'];
            $login_log['model_name']                      = 'SysUserLoginLog';
            //加入队列
            add_to_queue('',$login_log);
            
            
            return true;
        }
        
        /**
         * 记录客服工作时间
         * @param type $work_time
         * @return type
         */
        protected function set_work_statistic(&$work_time) {
        	if($work_time<=0 ||empty($work_time)){
        		$work_time = 0;
        	}
        	
            $where['sys_uid']     = $this->user_info['id'];
            $where['create_date'] = date('Ymd',$_SERVER['REQUEST_TIME']);
            $model = db('SysWorkStatistic');
            $count = cache('user_count_'.$this->user_info['id']);
            if(empty($count)) {
                $count = $model->where($where)->count('id');
                cache('user_count_'.$this->user_info['id'],$count);
            }
            
            
            if($count > 0) {
                $map['sys_uid'] = $this->user_info['id'];
                return $model->where($map)->setInc('work_time',$work_time);
            }else {
                $arr['sys_uid']      = $this->user_info['id'];
                $arr['create_date']  = $where['create_date'];
                $arr['work_time']    = $work_time;
                
               $flag =  $model->insert($arr);
               if($flag) {
                   cache('user_count_'.$this->user_info['id'],1);
               }
               return $flag;
            }
                
            
        }
}
