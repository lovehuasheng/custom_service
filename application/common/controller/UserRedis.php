<?php
/* 公共类（不用先登录）
 */

namespace app\common\controller;


class UserRedis extends \Redis{
    static $_instance;
    public $redis;
    
 
    /** 根据id获取用户名
     */
    public function getUsernameById($user_id) {
        return parent::get('sxh_user:id:'.$user_id.':username');
    }
    
    /** 根据用户名获取用户 id (username:admin2:id)
     */
    public function getUserId($username) {
        return parent::get('sxh_user:username:'.$username.':id');
    }
    
    /** Redis set 绑定添加 username（根据id获取用户名）
     */
    public function setUserUsernameById($user_id , $username) {
        return parent::set('sxh_user:id:'.$user_id.':username' , $username);
    }
    
    /** Redis set 绑定添加 username（根据id获取用户名）
     */
    public function getUserIdByUsername($username) {
        return parent::get('sxh_user:username:'.$username);
    }
    
    
    /** set 设置 id（用户名+id绑定）（sxh_user:username:admin2:id 2）
     */
    public function setUserId($username , $id) {
        return parent::set('sxh_user:username:'.$username.':id' , $id);
    }
    
    
    /** set 设置 id（手机号+id绑定）（sxh_user_info:phone:18676606234:id 2）
     */
//    public function setUserPhoneId($phone , $id) {
//        return parent::set('sxh_user_info:phone:'.$phone.':id' , $id);
//    }
    
    
    /** 根据手机号获取用户id (sxh_user_info:phone:18676606234:id)
     */
//    public function getUserIdByPhone($phone) {
//        return parent::get('sxh_user_info:phone:'.$phone.':id');
//    }
    
    
    
    
    /** 根据用户名，判断用户是否存在（存在1，不存在返回0）
     */
    public function existsUserId($username) {
        return parent::exists('sxh_user:username:'.$username.':id');
    }
    
    
    /** sadd 添加集合一条
     */
    public function saddField($field , $value) {
        return parent::sadd($field , $value);
    }
    
    /** smembers 获取集合列表
     */
    public function smembersField($field) {
        return parent::smembers($field);
    }
    
    /** sismember 判断集合 值 是否存在
     */
    public function sismemberFieldValue($field , $value) {
        return parent::sismember($field , $value);
    }
    
    /** 删除 手机号集合
     * username:admin2:id
     */
    public function sremPhoneField($phone) {
        return parent::srem('sxh_user_info:phone' , $phone);
    }
    
    /** 删除 手机号集合
     * username:admin2:id
     */
    public function  sremUserInfoField($field , $val) {
        return parent::srem('sxh_user_info:'.$field , $val);
    }
    
    //删除手机 键
    public function delPhoneField($phone , $user_id) {
        return parent::del('sxh_user_info:phone:'.$phone.':id' , $user_id);
    }
    
    
    public function hExistsUserinfoById($user_id) {
        return parent::hExists('sxh_userinfo:id:'.$user_id);
    }
    
     //根据ID存用户的相关信息（哈希）
    public function hsetUserinfoByID($id,$field,$value){
        return parent::hSet('sxh_userinfo:id:'.$id,$field,$value);
    }
    //根据用户ID和字段获取用户的缓存信息（哈希）
    public function hgetUserinfoByID($id,$field){
        return parent::hGet('sxh_userinfo:id:'.$id,$field);
    }

    
    //为哈希表 key 中的指定字段的整数值加上增量 increment 。
    public function hIncrByUserinfoByID($id,$field,$increment){
        return parent::hIncrBy('sxh_userinfo:id:'.$id,$field,$increment);
    }
    
    
    /** 提供资助表唯一自增id
     */
    public function getUserProvideId($type=0) {
        if($type == 0) {
            return parent::get('sxh_user_provide:id');
        } else if($type == 1) {
            return parent::incr('sxh_user_provide:id');
        }
    }
    
    
    /** 接受资助表唯一自增id
     */
    public function getUserAccepthelpId($type = 0) {
        if($type == 0) {
            return parent::get('sxh_user_accepthelp:id');
        } else if($type == 1) {
            return parent::incr('sxh_user_accepthelp:id');
        }
    }
    
    
    /** 匹配表唯一自增id
     */
    public function getUserMatchhelpId($type = 0) {
        if($type == 0) {
            return parent::get('sxh_user_matchhelp:id');
        } else if($type == 1) {
            return parent::incr('sxh_user_matchhelp:id');
        }
    }
    
    /** 支出表唯一自增id
     */
    public function getUserOutgoId($type = 0) {
        if($type == 0) {
            return parent::get('sxh_user_outgo:id');
        } else if($type == 1) {
            return parent::incr('sxh_user_outgo:id');
        }
    }
    
    /** 收入表唯一自增id
     */
    public function getUserIncomeId($type = 0) {
        if($type == 0) {
            return parent::get('sxh_user_income:id');
        } else if($type == 1) {
            return parent::incr('sxh_user_income:id');
        }
    }
    
    
    
    /**
     * 
     * @param type $table 值为provide或者accepthelp
     * @param type $user_id 用户ID
     * @param type $type 1为未匹配 2为已匹配 3为已完成
     * @param type $data json_encode数据，以分页的形式保存
     * @return 
     */
    public function rPushDataList($table,$user_id,$type,$data){
        return parent::rPush('sxh_user_'.$table.'_list:type:web:user_id:'.$user_id.':type:'.$type,$data,30);
    }
    /**
     * @param type $table 值为provide或者accepthelp
     * @param type $user_id
     * @param type $type
     * @param type $index 索引取出数据
     * @return type
     */
    public function lindexDataList($table,$user_id,$type,$index){
        return parent::lindex('sxh_user_'.$table.'_list:type:web:user_id:'.$user_id.':type:'.$type,$index);
    }
    
    public function delDataList($table,$user_id,$type){
    	parent::del('sxh_user_'.$table.'_list:type:web:user_id:'.$user_id.':type:'.$type);
        parent::del('sxh_user_'.$table.'_list:user_id:'.$user_id.':type:'.$type);
    }
    /**
     * 根据用户ID和单ID获取已匹配数据
     * @param type $table 值为provide 和 accepthelp
     * @param type $user_id
     * @param type $id
     * @return type
     */
    public function getMatchDetail($table,$user_id,$id){
        return parent::get('sxh_user_'.$table.'_detail:type:web:user_id:'.$user_id.':id:'.$id);
    }
    /**
     * 根据用户ID和单ID设置已匹配数据
     * @param type $table 值为provide 和 accepthelp
     * @param type $user_id
     * @param type $id
     * @return type
     */
    public function setMatchDetail($table,$user_id,$id,$data){
        $exr = config('redis_expiration_time');
        return parent::set('sxh_user_'.$table.'_detail:type:web:user_id:'.$user_id.':id:'.$id,$data,$exr);
    }
    public function delMatchDetail($table,$user_id,$id){
    	 parent::set('sxh_user_'.$table.'_detail:type:web:user_id:'.$user_id.':id:'.$id,null);
         parent::set('sxh_user_'.$table.'_detail:user_id:'.$user_id.':id:'.$id,null);
    }
}
