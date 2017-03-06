<?php
/**
 * 企业信息管理验证类
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\validate;

use think\Validate;

class CompanyInfo extends Validate
{   

    //验证规则
    protected $rule = [
        'company_id'                => 'require|number|gt:0',
        'username'                  => 'require',
//        'legal_person'              => 'require',
        'mobile'                    => 'require|is:mobile',
//        'company_alipay_account'    => 'require',
//        'public_bank_account'       => 'require',
//        'company_name'              => 'require',
        'status'                    => 'in:0,1,2',
        'verify'                    => 'in:0,1,2',
        'verify_uname'              => 'require',
        'create_time_start'         => 'date',
        'create_time_end'           => 'date',
        'update_time_start'         => 'date',
        'update_time_end'           => 'date'
    ];
    
    //错误消息
    protected $message = [
        'company_id.require'             => '会员id不能为空|60001',
        'company_id.gt'                  => '会员id必须大于0|60002',
        'company_id.number'              => '会员id必须为整数|60003',
        'username.require'               => '会员账号不能为空|60004',
//        'legal_person.require'           => '会员姓名不能为空|60006',        
        'mobile.require'                 => '会员手机号码不能为空|60010',
        'mobile.is'                      => '会员手机号码格式不正确|60011',
//        'company_alipay_account.require' => '会员支付宝账号不能为空|60012',
//        'public_bank_account.require'    => '公司对公账户不能为空|60013',
//        'company_name.require'           => '公司名称不能为空|60014',
        'email.require'                  => '会员电子邮件不能为空|60008',
        'email.email'                    => '会员电子邮件格式不正确|60009',
        'status.in'                      => '激活状态不在给定范围内|60019',
        'verify.in'                      => '审核状态不在给定范围内|60020',
        'create_time_start'              => '注册起始时间格式不正确|60021',
        'create_time_end'                => '注册截至时间格式不正确|60022',
        'update_time_start'              => '资料更新起始时间格式不正确|60023',
        'update_time_end'                => '资料更新截至时间格式不正确|60024',
        'business_license.require'       => '营业执照号码不能为空|60025',
        'legal_alipay_account.require'   => '法人支付宝账号不能为空|60026',
        'legal_bank_account.require'     => '法人银行账户不能为空|60027',
        'legal_bank_name.require'        => '法人账户开户银行不能为空|60028',
        'public_bank_name.require'       => '公司账户开户行不能为空|60029',
        'business_center_id.require'     => '商务中心id不能为空|60030',   
    ]; 

    //验证场景
    protected $scene = [
		//获取用户列表
		'get_user_list'    => ['company_id' => 'number|gt:0','mobile'=>'is:mobile','status','verify','create_time_start','create_time_end','update_time_start','update_time_end'],
        //查看用户详情
        'get_user_info'    => ['company_id'],
        //更新用户信息
        'update_user_info' => ['company_id','company_name'=>'require','business_license'=>'require','legal_person'=>'require','mobile'=>'require|is:mobile','email'=>'require|email','legal_alipay_account'=>'require','company_alipay_account'=>'require','legal_bank_account'=>'require','legal_bank_name'=>'require','public_bank_account'=>'require','public_bank_name'=>'require'],
        //转移推荐人
        'transfer_referee' => ['company_id','business_center_id'=>'require'],
    ];
   
}