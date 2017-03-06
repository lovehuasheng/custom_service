<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服用户管理数据层
// +----------------------------------------------------------------------

namespace app\user\model;
use think\Model;

class UserBlacklist extends Model
{
    
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = false;

    
    /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function  update_user_data($map=[],&$param) {
        
        return $this->save($param,$map);
       
    }

    //更具用户id获取一条数据
    public function get_by_uid($uid,$fields=['*'])
    {
        return $this->where(['user_id' => $uid])->field($fields)->limit(1)->find();
    }

    //根据用户id将用户从黑名单中移除
    public function del_by_uid($uid)
    {
        return $this->where(['user_id'=>$uid])->delete();
    }
    
    /**
     * 获得单条数据
     * @param type $map
     * @param type $field
     * @return type
     */
    public function get_user_info($map = [],$field='*') {
        $list = $this->where($map)->field($field)->find();
        if($list) {
            //$list->status_text = $list->status_text;
            $list =  $list->toArray();
            return $list;
        }
        return [];
    }   

    /**
     * 加入一条数据
     * @param array $data 黑名单数组
     */
    public function add($data=[])
    {
        return $this->data($data,true)->isUpdate(false)->save();
    }
    /**
     * 删除一条数据
     * @param  int $id    主键id
     */
    public function del($id)
    {
        return $this->destroy($id);
    }


    public function set_blacklist_to_queue($user_id,$remark='收款封号') {
            $redis = \org\RedisLib::get_instance('sxh_default');
            //取用户的账号
            $username = $redis->get('sxh_user:id:'.$user_id.'username');
            //加入黑名单
            //禁用的用户id
            $blank_arr['data']['user_id']     = $user_id;
            //禁用的用户
            $blank_arr['data']['username']    = $username;
            //描叙
            $blank_arr['data']['remark']      = $remark;
            //创建时间
            $blank_arr['data']['create_time'] = $_SERVER['REQUEST_TIME'];
            //模型名
            $blank_arr['model_name']      = 'UserBlacklist';
            //加入队列
            add_to_queue('sxh_user_blacklist',$blank_arr);
            
            unset($blank_arr);
            
            return true;
    }

    //添加会员到黑名单
    public function add_to_blacklist($user_id,$username,$remark)
    {

      $sql = "INSERT INTO {$this->getTable()}(user_id,username,remark,create_time,update_time)VALUES(:user_id,:username,:remark,:create_time,:update_time)";

      $sql .= " ON DUPLICATE KEY UPDATE remark=VALUES(remark),update_time=VALUES(update_time)";

      return $this->execute($sql,['user_id'=>$user_id,'username'=>$username,'remark'=>$remark,'create_time'=>time(),'update_time'=>time()]);
    }
}