<?php
// +----------------------------------------------------------------------
// | 善心汇集团 客服管理后台 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 童自扬 <2421886569@qq.com> 
// +----------------------------------------------------------------------
// | Function: 客服后台【接受资助】业务逻辑层
// +----------------------------------------------------------------------


namespace app\statistics\logic;
use app\common\logic\Base;


class Statistics extends Base
{
  
   
   /**
    * 取单条数据
    * @param type $id
    * @return type
    */
    public function get_data(&$data,&$user_info) {
        
        //查询条件   flag 1-超管  2-客服
        $map = [];
        $map['create_date'] = date('Ymd',strtotime('-1 day'));
        //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        //取值字段
        $field = ['total_num','frist_verify','tow_verify','three_verify'];
        if($user_info['is_super'] == 0) {
            $map['sys_uid']   =   $user_info['id'];
        }
        //调取数据
        $result_list = $model->get_statistic($map,$field);
        
        //统计数据
        $verify_data = [];
        if(!empty($result_list)) {
             $result_list = get_array_to_object($result_list);
             //工作量总量
              $total_num = array_unique(array_column($result_list, 'total_num'));
              $verify_data['total_num']   =  array_sum($total_num);
              //一审总量
              $frist_verify = array_unique(array_column($result_list, 'frist_verify'));
              $verify_data['frist_verify']   =  array_sum($frist_verify);
              //二审总量
              $tow_verify = array_unique(array_column($result_list, 'tow_verify'));
              $verify_data['tow_verify']   =  array_sum($tow_verify);
              //三审总量
              $three_verify = array_unique(array_column($result_list, 'three_verify'));
              $verify_data['three_verify']   =  array_sum($three_verify);
              
        }else {
            $verify_data['total_num'] = 0;
            $verify_data['frist_verify'] = 0;
            $verify_data['tow_verify'] = 0;
            $verify_data['three_verify'] = 0;
        }
        
        unset($map);
        unset($field);
        unset($result_list);
        unset($data);
       
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg  = '操作成功！';
        $this->body = [
            'verify_data'      => $verify_data,
            'is_super'         => $user_info['is_super'],
        ];
         unset($user_info);
        unset($result_list);
        return $this->result;
    }
    
    
    public function get_login_log(&$data,$user_info) {
        
        if($user_info['is_super'] == 0) {
             //返回结果
            $this->error_code = '-1';
            $this->error_msg  = '你没有权限操作！';
            $this->body = [];
            return  $this->result;
        }
       //条件
        $map = [];
        $week = date('w');
        switch ($data['flag']) {
                case 1://今天
                    $start_time = strtotime(date('Y-m-d 00:00:00',$_SERVER['REQUEST_TIME']));
                    $end_time   = strtotime(date('Y-m-d 23:59:59',$_SERVER['REQUEST_TIME']));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $_SERVER['REQUEST_TIME'];
                    break;
                 case 2://昨天
                    $start_time = strtotime(date('Y-m-d 00:00:00',strtotime('-1 day')));
                    $end_time   = strtotime(date('Y-m-d 23:59:59',strtotime('-1 day')));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $start_time;
                    break;
                case 3://前天
                    $start_time = strtotime(date('Y-m-d 00:00:00',strtotime('-2 day')));
                    $end_time   = strtotime(date('Y-m-d 23:59:59',strtotime('-2 day')));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $start_time;
                    break;
                case 4://本周
                     //星期一
                    $start_time = strtotime(date('Y-m-d 00:00:00',strtotime('+'. 1-$week .' days')));
                   
                    $end_time   = strtotime(date('Y-m-d 23:59:59',$_SERVER['REQUEST_TIME']));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $start_time;
                    break;
                case 5://上周
                    //星期一
                    $start_time = strtotime(date('Y-m-d 00:00:00',strtotime('-1 week last monday')));
                    //星期天
                    $end_time   = strtotime(date('Y-m-d 23:59:59',strtotime('last sunday')));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $start_time;
                    break;
                case 6://本月
                    //本月1号
                    $start_time = strtotime(date('Y-m-1 00:00:00',$_SERVER['REQUEST_TIME']));
                    $end_time   = strtotime(date('Y-m-d 23:59:59',$_SERVER['REQUEST_TIME']));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $start_time;
                    break;
                case 7://上月
                    $startday = date('Y-m-1 00:00:00',  strtotime('-1 month'));
                    $start_time = strtotime($startday);
                    $end_time   = strtotime(date('Y-m-d 23:59:59', strtotime("{$startday}+1 month -1 day")));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $start_time;
                    break;
                case 8://所以
                    $partition_time = $_SERVER['REQUEST_TIME'];
                    break;
                default:
                    $start_time = strtotime(date('Y-m-d 00:00:00',$_SERVER['REQUEST_TIME']));
                    $end_time   = strtotime(date('Y-m-d 23:59:59',$_SERVER['REQUEST_TIME']));
                    $map['create_time'] = ['between',[$start_time,$end_time]];
                     //分表时间戳
                    $partition_time = $_SERVER['REQUEST_TIME'];
                    break;
        }
         //当前页码 默认为1
        $page = !empty($data['page']) ? $data['page'] : 1;
        //每页条数 默认为20
        $per_page = !empty($data['per_page']) ? $data['per_page'] : config('page_total');
        //设置页码列表,默认为5页
        $page_list = config('page_list');
        //取值字段
        $field = ['realname','remark','create_time'];
        //实例化
        $model = model('SysUserLoginLog');
       
        
        //取总条数
        $total =  $model->get_count($map,$partition_time);
        //取值列表
        $result_list = $model->get_list($map,$partition_time,$field,$page,$per_page);
        
        //获取页码列表
        $pages = get_pagination($total, $page, $per_page, $page_list);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data' => $result_list,
            'pages' => $pages
        ];
       
        return $this->result;
    }
    
    
    
    public function get_count_workload(&$data,$user_info) {
        //条件
        //0-启用 1-禁用
        $map['status'] = 0;
        //0-普通用户  1-管理员
        $map['is_super'] = 0;
        //取值字段
        $field = ['id','realname'];
        //客服数据
        $user = model('user/SysUser')->get_list_by_map($map,$field);
        
        $count_map = [];
        //is_supper
        if($user_info['is_super'] == 0 ) {
            $count_map['sys_uid'] = $user_info['id'];
        }else {
             if(!empty($data['uid'])) {
                $count_map['sys_uid'] = $data['uid'];
            }
        }
       
        //条件
        $start = date('Ym01',strtotime('-1 month'));
        $end   = date('Ymd',strtotime("{$start}+1 month -1 day"));
        $count_map['create_date'] = ['between',[$start,$end]];
        //取值字段
        $count_field = ['total_num','success_num','fail_num','frist_verify','tow_verify','three_verify'];
         //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        //统计数据
        $result_list = $model->get_statistic($count_map,$count_field);

        $verify_data = [];
        $success_num_data = [];
        $frist_verify = [];
        $tow_verify = [];
        $three_verify = [];
        $fail_num =[];
        
         //月份
        $month = date('m',strtotime($start));
        //月份最后一天
        $day = date('d',strtotime($end));
        
        $month_arr = [];
        for($i=0; $i<$day; $i++) {
            if(($i+1)<10) {
                $month_arr[$i] = $month.'/0'.($i+1);
            }else {
                $month_arr[$i] = $month.'/'.($i+1);
            }
            $verify_data[$i] = 0;
            $success_num_data[$i] = 0;
            $frist_verify[$i] = 0;
            $tow_verify[$i] = 0;
            $three_verify[$i] = 0;
            $fail_num[$i] = 0;
        }
        
        if(!empty($result_list)) {
            $result_list = get_array_to_object($result_list);
            $verify_data       = array_column($result_list, 'total_num');
            $success_num_data  = array_column($result_list, 'success_num');
            if($user_info['is_super'] == 0) {
                $frist_verify = array_column($result_list, 'frist_verify');
                $tow_verify   = array_column($result_list, 'tow_verify');
                $three_verify = array_column($result_list, 'three_verify');
                $fail_num = array_column($result_list, 'fail_num');
            }
        }
       
        
         //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'verify_data'             => $verify_data,
            'success_num_data'        => $success_num_data,
            'user'                    => $user,
            'is_super'                => $user_info['is_super'],
            'month_arr'               => $month_arr,
            'frist_verify'            => $frist_verify,
            'tow_verify'              => $tow_verify,
            'three_verify'            => $three_verify,
            'fail_num'                => $fail_num,
        ];
       
        return $this->result;
    }
    
    /**
     * 注册质量统计  年统计
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function register_count(&$data,$user_info) {
            $year = get_year();
            $now_date = $data['year_date']?$data['year_date']:date('Y',$_SERVER['REQUEST_TIME']);
            //条件
            $map['year_date'] = $now_date;
            $model = model('SysRegisterCount');
            $list = $model->get_count_list($map,'register_success,register_count,month_date');
            $result         = [0,0,0,0,0,0,0,0,0,0,0,0];
            $register_count = [0,0,0,0,0,0,0,0,0,0,0,0];
            if(!empty($list)) {
                for($i=0;$i<count($list);$i++) {
                    $result[$list[$i]['month_date']-1] += $list[$i]['register_success'];
                    $register_count[$list[$i]['month_date']-1] += $list[$i]['register_count'];
                }
            }
            //返回结果
            $this->error_code = '0';
            $this->error_msg = '请求成功!';
            $this->body = [
                'data'             => $result,
                'year'             => $year,
                'now_date'         => $now_date,
                'register_count'   => $register_count,
                'month'            => get_year(1,12),
            ];

            return $this->result;
            
    }
    
    /**
     * 注册质量统计  月统计
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function register_month_count(&$data,$user_info) {
          
            $year = get_year();
            $now_date = $data['year_date']?$data['year_date']:date('Y',$_SERVER['REQUEST_TIME']);
            $now_month_date = $data['month_date']?$data['month_date']:date('m',strtotime('-1 month'));
            //条件
            $map['year_date'] = $now_date;
            $map['month_date'] = $now_month_date;
            $model = model('SysRegisterCount');
            $list = $model->get_count_list($map,'register_success,register_count,day_date');
            $result         = [];
            $register_count = [];
             //得到上月天数
           // $daynum = cal_days_in_month(CAL_GREGORIAN, $now_month_date, $now_date); 
            $daynum = date('t', strtotime($now_date . '-' . $now_month_date . '-01')); 
         
            for($i=0;$i<$daynum;$i++) {
                $result[$i]         = 0;
                $register_count[$i] = 0;
                 if(($i+1) < 10) {
                     $day[$i] = $now_month_date.'/0'.($i+1);
                }else {
                    $day[$i] = $now_month_date.'/'.($i+1);
                }
             
            }
            if(!empty($list)) {
                for($i=0;$i<count($list);$i++) {
                    $result[$list[$i]['day_date']-1] += $list[$i]['register_success'];
                    $register_count[$list[$i]['day_date']-1] += $list[$i]['register_count'];
                }
                
            }
            //返回结果
            $this->error_code = '0';
            $this->error_msg = '请求成功!';
            $this->body = [
                'data'             => $result,
                'year'             => $year,
                'now_date'         => $now_date,
                'now_month_date'         => $now_month_date,
                'register_count'   => $register_count,
                'month'            => get_year(1,12),
                'day'              => $day,
            ];

            return $this->result;
            
    }
    
    /**
     * 工作有效时间   月统计
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function efficiency_month_count(&$data,$user_info) {
        
            $now_date = date('Y',$_SERVER['REQUEST_TIME']);
            $now_month_date = $data['month_date']?$data['month_date']:date('m',strtotime('-1 month'));
            //条件
            $map['month_date'] = $now_month_date;
             //实例化
            $model = \think\Loader::model('member/SysWorkStatistic', 'model');
            $list = $model->get_statistic($map,'work_time,day_date,sys_uid');
            $list = json_decode(json_encode($list),true);
            $result         = [];
            $user           = [];
             //得到上月天数
           // $daynum = cal_days_in_month(CAL_GREGORIAN, $now_month_date, $now_date); 
            $daynum = date('t', strtotime($now_date . '-' . $now_month_date . '-01')); 
            for($i=0;$i<$daynum;$i++) {
                $result[$i]         = 0;
                if(($i+1) < 10) {
                     $day[$i] = $now_month_date.'/0'.($i+1);
                }else {
                    $day[$i] = $now_month_date.'/'.($i+1);
                }
               
            }
            if(!empty($list)) {
                $result = array_column($list, 'work_time');
                $ids = array_unique(array_column($list, 'sys_uid'));
                $user_map['id'] = ['in',$ids];
                $user = model('user/SysUser')->get_list_by_map($user_map,'id,realname');
            }
            
            
            
            //返回结果
            $this->error_code = '0';
            $this->error_msg = '请求成功!';
            $this->body = [
                'data'             => $result,
                'now_month_date'   => $now_month_date,
                'month'            => get_year(1,12),
                'user'             => $user,
                'user_selected'    => $data['uid'],
                'day'              => $day,
            ];

            return $this->result;
            
    }
    
     /**
     * 工作有效时间统计
     * @param type $data
     * @param type $user_info
     * @return type
     */
    public function efficiency_count(&$data,$user_info) {
        $now_date = $data['year_date']?$data['year_date']:date('Y',$_SERVER['REQUEST_TIME']);
        //条件
        $map['year_date'] = $now_date;
        $daynum = 0;
        if(!empty($data['month_date'])) {
            $map['month_date'] = $data['month_date'];
           // $daynum = get_year(1,cal_days_in_month(CAL_GREGORIAN, $data['month_date'], $now_date)); 
            $daynum = get_year(1, date('t', strtotime($now_date . '-' .  $data['month_date'] . '-01'))); 
        }else {
           // $daynum = get_year(1,cal_days_in_month(CAL_GREGORIAN, date('m',strtotime('-1 month')), $now_date));
            $daynum = get_year(1,date('t', strtotime($now_date . '-' .  date('m',strtotime('-1 month')) . '-01')));
        }
        if(!empty($data['day_date'])) {
             $map['day_date'] = $data['day_date'];
        }
        //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        $list = $model->get_statistic($map,'work_time,day_date,sys_uid');

        $list = json_decode(json_encode($list),true);

        $result         = [];
        $user           = []; 
        $work_time      = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $sys_uid        = ['客服一','客服二','客服三','客服四','客服五','客服六','客服七','客服八','客服九','客服十','客服十一','客服十二','客服十三','客服十四','客服十五'];
        if(!empty($list)) {
            for($i=0;$i<count($list);$i++) {

                $result[$list[$i]['sys_uid']]['work_time'] = isset($result[$list[$i]['sys_uid']]['work_time']) ? $result[$list[$i]['sys_uid']]['work_time'] : 0;
                $result[$list[$i]['sys_uid']]['sys_uid']   = $list[$i]['sys_uid'];
                $result[$list[$i]['sys_uid']]['work_time'] += $list[$i]['work_time'];
            }
            
            $ids = array_unique(array_column($list, 'sys_uid'));

            $user_map['id'] = ['in',$ids];
            $user = model('user/SysUser')->get_list_by_map($user_map,'id,realname');

            unset($list);
            if(!empty($user)) {
                foreach($result as $v) {
                    for($i=0;$i<count($user);$i++) {
                        if($v['sys_uid'] == $user[$i]['id']) {
                            $work_time[$i] = $v['work_time'];
                            $sys_uid[$i]   = $user[$i]['realname'];
                        }
                    }
                }
            }
        }
        
        unset($user);
        unset($ids);
        unset($user_map);
        unset($result);
        unset($model);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'data'             => $work_time,
            'user'             => $sys_uid,
            'now_month_date'   => $data['month_date'],
            'now_day_date'     => $data['day_date'],
            'now_year_date'    => $now_date,
            'month'            => get_year(1,12),
            'year'             => get_year(),
            'day'              => $daynum,
        ];
        unset($data);
        return $this->result;        
    }
    
    
     /**
     * 审核质量统计
     * @param type $user_info
     * @return type
     */
    public function quality_count(&$data,$user_info) {
        $now_date = $data['year_date']?$data['year_date']:date('Y',$_SERVER['REQUEST_TIME']);
        $now_month_date = $data['month_date']?$data['month_date']:date('m',strtotime('-1 month'));
        //条件
        $map['year_date'] = $now_date;
        $map['month_date'] = $now_month_date;
        $field = ['total_num','success_num','fail_num','frist_verify','tow_verify','three_verify','month_date','day_date'];
        //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        $list = $model->get_statistic($map,$field);
        //总人数
        $success_num            = [];
        //审核成功人数
        $total_num              = [];
        //审核失败人数
        $fail_num               = [];
        //一审人数
        $frist_verify           = [];
        //二审人数
        $tow_verify             = [];
        //三审人数
        $three_verify             = [];
          //得到上月天数
        //$daynum = cal_days_in_month(CAL_GREGORIAN, $now_month_date, $now_date); 
        $daynum = date('t', strtotime($now_date . '-' .  date('m',strtotime('-1 month')) . '-01')); 
        for($i=0;$i<$daynum;$i++) {
            $result[$i]         = 0;
            $register_count[$i] = 0;
             if(($i+1) < 10) {
                 $day[$i] = $now_month_date.'/0'.($i+1);
            }else {
                $day[$i] = $now_month_date.'/'.($i+1);
            }
            $success_num[$i] = 0;
            $total_num[$i] = 0;
            $fail_num[$i] = 0;
            $frist_verify[$i] = 0;
            $tow_verify[$i] = 0;
            $three_verify[$i] = 0;
        }
        
        if(!empty($list)) {
            for($i=0;$i<count($list);$i++) {
                $success_num[$list[$i]['day_date']]      = $list[$i]['total_num'];
                $total_num[$list[$i]['day_date']]        = $list[$i]['success_num'];
                $fail_num[$list[$i]['day_date']]         = $list[$i]['fail_num'];
                $frist_verify[$list[$i]['day_date']]     = $list[$i]['frist_verify'];
                $tow_verify[$list[$i]['day_date']]       = $list[$i]['tow_verify'];
                $three_verify[$list[$i]['day_date']]       = $list[$i]['three_verify'];
            }
        }
        unset($list);
        unset($map);
        
            
         //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'success_num'      => $success_num,
            'total_num'        => $total_num,
            'fail_num'         => $fail_num,
            'frist_verify'     => $frist_verify,
            'tow_verify'       => $tow_verify,
            'three_verify'     => $three_verify,
            'now_month_date'   => $now_month_date,
            'now_date'         => $now_date,
            'month'            => get_year(1,12),
            'year'             => get_year(),
            'day'              => $day,
        ];
        unset($data);
        return $this->result;        
    }
    
    
     /**
     * 审核质量统计  年统计
     * @param type $user_info
     * @return type
     */
    public function quality_year_count(&$data,$user_info) {
        $now_date = $data['year_date']?$data['year_date']:date('Y',$_SERVER['REQUEST_TIME']);
        //条件
        $map['year_date'] = $now_date;
        $field = ['total_num','success_num','month_date'];
        //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        $list = $model->get_statistic($map,$field);
        //总人数
        $success_num            = [0,0,0,0,0,0,0,0,0,0,0,0];
        //审核成功人数
        $total_num              = [0,0,0,0,0,0,0,0,0,0,0,0];
        if(!empty($list)) {
            for($i=0;$i<count($list);$i++) {
                $success_num[$list[$i]['month_date']]      = $list[$i]['total_num'];
                $total_num[$list[$i]['month_date']]        = $list[$i]['success_num'];
            }
        }
        unset($list);
        unset($map);
        //返回结果
        $this->error_code = '0';
        $this->error_msg = '请求成功!';
        $this->body = [
            'success_num'      => $success_num,
            'total_num'        => $total_num,
            'now_date'         => $now_date,
            'month'            => get_year(1,12),
            'year'             => get_year(),
        ];
        unset($data);
        return $this->result;      
    }
}