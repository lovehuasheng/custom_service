<?php

// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台客服 【接受资助】 数据层
// +----------------------------------------------------------------------

namespace app\business\model;
use app\common\model\Base;


class UserCommunity extends Base
{
    
    /**
     * 获取单条数据
     * @param type $id
     * @return type
     */
     public function getOneData($id) {
         $tmp =  cache('user_community_'.$id);
         if(!$tmp) {
             $res =  $this->where(['id'=>$id])->find();
            if($res) {
                $list = $res->toArray();
                cache('user_community_'.$id,  serialize($list),3600);
            }
         }else {
             $list = unserialize($tmp);
         }
         
         return $list;
     }
}

