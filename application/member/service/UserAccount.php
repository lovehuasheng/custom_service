<?php
/**
 * 会员管理服务层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\service;
use app\common\service\Base;
class UserAccount extends  Base{


    //获取会员账户列表
    public function fetch_account_list($data=[])
    {
        return model('UserAccount','logic')->get_accounts($data);
    }

    //编辑会员的账户 操作类型 1-增加 2-减少 账户类型 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包
    // 6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
    public function edit_account($data=[])
    {   
        return model('UserAccount','logic')->modify_account($data);
    }


    //转币
    public function transfer_coin($data=[])
    {
        return model('UserAccount','logic')->transfer_coin($data);
    }

    //查询超级管理员剩余的善种子,善心币
    public function get_super_account($data=[])
    {
        return model('UserAccount','logic')->get_accounts($data);
    }
}
