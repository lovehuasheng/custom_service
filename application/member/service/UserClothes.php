<?php
/**
 * 会员文化衫管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class UserClothes extends  Base{


    //获取申领列表
    public function fetch_clothes_list($data=[])
    {
        return model('UserClothes','logic')->get_clothes($data);
    }

    //编辑公告
    public function edit_clothes($data=[])
    {
        return model('UserClothes','logic')->modify_clothes($data); 
    }

    public function remove_clothes($data=[])
    {
        return model('UserClothes','logic')->destroy_clothes($data);    
    } 

    //获取详情
    public function fetch_clothes_detail($data=[])
    {
        return model('UserClothes','logic')->acquire_clothes_detail($data);   
    }
}
