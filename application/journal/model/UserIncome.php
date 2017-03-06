<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【收入流水】数据层
// +----------------------------------------------------------------------

namespace app\journal\model;
use app\common\model\Base;
class UserIncome extends Base
{
    
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = false;
     //分表规则


    protected function initialize() {
        $this->get_month_submeter();
      
    }


   /**
     * 更新数据
     * @param type $map
     * @param type $param
     * @return type
     */
    public function  update_user_data($map=[],&$param) {
        
        return $this->partition($this->info,$this->info_field,$this->rule)->save($param,$map);
       
    }
    

      /**
     * 获取总条数
     * @param type $map
     * @return type
     */
    public function get_count($map = []) {
        return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->count();
        
    }
    
    /**
     * 分页数据
     * @param type $map
     * @param type $page
     * @param type $r
     * @param type $field
     * @param type $order
     * @return type
     */
    public function get_list_info($map, $page = 1, $r = 20, $field = '*', $order = 'id desc') {
       return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->order($order)->page($page,$r)->select();
    }
    
    public function get_data($map, $field = '*') {
       return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();
    }
    
    /**
     * 删除流水记录
     * @param type $data
     * @param type $info
     * @param type $user_info
     * @return boolean
     */
    public function destroy_income_log(&$data,&$info,&$user_info) {
         $this->startTrans();
         try{
             //收入表ID
            $map['id'] = $data['id'];
            //状态 1-删除 0-正常
            $arr['status'] = 1;
            //更新收入表状态为删除
            $income_result = $this->update_user_data($map,$arr);
            //标记类型  1-更新会员钱包，0-不更新
            if($data['type'] == 1) {
                //更改会员钱包
                //组装钱包更改字段
                $account_num = get_user_account_field($info['type']).' = '.get_user_account_field($info['type']).' - '.$info['income'];
                //组装更改数据
                $account_data[get_user_account_field($info['type'])] = [ 'exp', $account_num];
                //调用分表更改会员钱包
                $result_account = model('UserAccount')->update_by_uid($info['user_id'],$account_data);
            }else {
                $result_account = true;
            }
            
             //记录操作日志
            $msg = '删除收入记录【收入记录ID：'.$data['id'].'】，减少会员钱包的数量：【'.get_user_account_name($info['type']).'：-'.$info['income'].'】';
            $log = model('user/SysUserLog')->set_log_data($user_info['id'],$user_info['username'],$user_info['realname'],3,$msg,'journal/income/destroy_income_log');
            
            if($income_result && $result_account && $log) {
                $this->commit();
                 return true;
            }else {
                $this->rollback();
                return false;
            }
         } catch (\Exception $e) {
             \think\Log::error('删除收入流水记录：'.$e->getMessage());
             $this->rollback();
             return false;
         }
        
    }
    
    /**
     * 转让流水
     * @param type $data
     * @param type $info
     * @param type $user_info
     * @return boolean
     */
     public function make_over_log(&$data,&$info,&$user_info) {
         $this->startTrans();
         try{
             //收入表ID
            $map['id'] = $data['id'];
            //状态 1-删除 0-正常
            $arr['status'] = 1;
            //更新收入表状态为删除
            $income_result = $this->update_user_data($map,$arr);
          
           
            //更改原会员钱包
            //组装钱包更改字段
            $account_num = get_user_account_field($info['type']).' = '.get_user_account_field($info['type']).' - '.$info['income'];
            //组装更改数据
            $account_data[get_user_account_field($info['type'])] = [ 'exp', $account_num];
            //调用分表更改会员钱包
            $result_account = model('UserAccount')->update_by_uid($info['user_id'],$account_data);

            //取新用户信息
            $user = model('UserInfo')->update_by_uid($data['user_id'],'name');
            $add_data['type'] = $info['type'];
            $add_data['cid'] = $info['cid'];
            $add_data['user_id'] = $data['user_id'];
            $add_data['username'] = $user['name'];
            $add_data['income'] = $info['income'];
            $add_data['pid'] = $info['pid'];
            $add_data['cat_id'] = $info['cat_id'];
            $add_data['info'] = $info['info'].'【手动】';
            $add_data['create_time'] = $info['create_time'];
            $add_data['status'] = 0;
            $income_add = $this->update_user_data([],$add_data);
            
            //新用户增加钱包数量
            $account_num_new = get_user_account_field($info['type']).' = '.get_user_account_field($info['type']).' + '.$info['income'];
            //组装更改数据
            $account_data_new[get_user_account_field($info['type'])] = [ 'exp', $account_num_new];
            //调用分表更改会员钱包
            $result_account_new = model('UserAccount')->update_by_uid($data['user_id'],$account_data_new);
            
             //记录操作日志
            $msg = '删除收入记录【收入记录ID：'.$data['id'].'】，减少会员钱包的数量：【'.get_user_account_name($info['type']).'：-'.$info['income'].'】';
            $msg .= '增加收入记录【收入记录ID：'.$this->id.'】，增加会员钱包的数量：【'.get_user_account_name($info['type']).'：-'.$info['income'].'】';
            $log = model('user/SysUserLog')->set_log_data($user_info['id'],$user_info['username'],$user_info['realname'],3,$msg,'journal/income/destroy_income_log');
            
            if($income_result && $result_account && $result_account_new && $income_add && $log) {
                $this->commit();
                 return true;
            }else {
                $this->rollback();
                return false;
            }
         } catch (\Exception $e) {
             \think\Log::error('删除收入流水记录：'.$e->getMessage());
             $this->rollback();
             return false;
         }
        
    }

}