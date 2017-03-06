<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服登录控制器
// +----------------------------------------------------------------------

namespace app\user\controller;
use think\Controller;
class Index extends Controller{

	//登录页面
    public function index()
    {
         //用户信息session 
         $user = session('user_auth');
         //用户信息session加密串
         $sign = session('user_auth_sign');
         //比对session加密串
         if((set_user_session_sign($user) === $sign)) {
               //销毁变量
                unset($user);
                unset($sign);
                return $this->redirect('/member/sys_work/index');
         }
        return view(ROOT_PATH . 'templates/login.html');
    }

    public function login() 
    {   
        $service = \think\Loader::model('User', 'service');
        return $service->login();    
    }

    //发送短信验证码
    public function send_verify()
    {
        $service = \think\Loader::model('User', 'service');
        return $service->send_verify();
    }
}
