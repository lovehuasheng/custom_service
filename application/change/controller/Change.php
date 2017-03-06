<?php   
/**
 * 用户身份变更,推荐人更改
 */
namespace app\change\controller;
use app\common\controller\Base;

class Change extends Base{
    public function index()
    {
        if(session('user_auth.is_super'))
        {
            return view(ROOT_PATH . 'templates/changelevel.html');
        }else{
            return view(ROOT_PATH . 'templates/error.html');
        }
        	
    }
    public function reffer()
    {
        if(session('user_auth.is_super'))
        {
            return view(ROOT_PATH . 'templates/reffer.html');
        }else{
            return view(ROOT_PATH . 'templates/error.html');
        }
        	
    }

    public function search(){
        $service = \think\Loader::model('change', 'service');
        return $service->search_action($this->data);
    }

    public function ref_search(){
        $service = \think\Loader::model('change', 'service');
        return $service->ref_search_action($this->data);
    }
    
    /*用户身份变更*/
    public function do_change(){
        if(session('user_auth.is_super'))
        {
            $service = \think\Loader::model('change', 'service');
            return $service->do_change_action($this->data);
        }else{
            $re=new \stdClass();
            $re->errCode=1;
            $re->errMsg='无权限';
            $re->result=array();
            return $re;
        }
    }
    /*推荐人身份变更*/
    public function do_change_ref(){
        set_time_limit(0);
        if(session('user_auth.is_super'))
        {
            $service = \think\Loader::model('change', 'service');
            return $service->do_change_ref_action($this->data);
        }else{
            $re=new \stdClass();
            $re->errCode=1;
            $re->errMsg='无权限';
            $re->result=array();
            return $re;
        }
        
    }
}
