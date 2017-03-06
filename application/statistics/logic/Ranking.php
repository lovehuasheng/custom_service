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


class Ranking extends Base
{
  
   
   /**
    * 取单条数据
    * @param type $id
    * @return type
    */
    public function get_data(&$data,$user_info) {
        
        //查询条件
        $map = [];
        $map['create_date'] = date('Ymd',strtotime('-1 day'));
        
        //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        //取值字段
        $field = ['sys_uid','sys_uname','total_num','success_num','fail_num','work_time','total_day_rank','success_day_rank','work_time_day_rank','total_month_rank','success_month_rank','work_time_month_rank'];
        
        //调取数据
        $result_list = $model->get_statistic($map,$field);
        if(!empty($result_list)) {
            //工作量排行
            $total_num_sort    =  list_sort_by($result_list,'total_num','desc');
            //通过率排行榜
            $success_num_sort  =  list_sort_by($result_list,'success_num','desc');
            //工作时间排行榜
            $work_time_sort    =  list_sort_by($result_list,'work_time','desc');
        }
        
        unset($map);
        unset($field);
        unset($result_list);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg  = '操作成功！';
        $this->body = [
            'total_num_sort'      => $total_num_sort,
            'success_num_sort'    => $success_num_sort,
            'work_time_sort'      => $work_time_sort,
        ];
        
        unset($result_list);
        return $this->result;
    }
    
    
    
  
     public function get_data_by_month(&$data,$user_info) {
        
        //查询条件
        $map['year_date'] = date('Y',strtotime('-1 month'));
        $map['month_date'] = date('m',strtotime('-1 day'));
        //实例化
        $model = \think\Loader::model('member/SysWorkStatistic', 'model');
        //取值字段
        $field = ['sys_uid','sys_uname','total_num','success_num','fail_num','work_time','total_day_rank','success_day_rank','work_time_day_rank','total_month_rank','success_month_rank','work_time_month_rank'];
        $total_num_sort = [];
        $success_num_sort = [];
        $work_time_sort = [];
        //调取数据
        $result_list = $model->get_statistic($map,$field);
        if(!empty($result_list)) {
            $arr = [];
            for($i=0;$i<count($result_list);$i++) {
                $arr[$result_list[$i]['sys_uid']]['total_num']            = isset($arr[$result_list[$i]['sys_uid']]['total_num'])?$arr[$result_list[$i]['sys_uid']]['total_num']:0;
                $arr[$result_list[$i]['sys_uid']]['total_num']           += $result_list[$i]['total_num'];
                $arr[$result_list[$i]['sys_uid']]['sys_uid']              = $result_list[$i]['sys_uid'];
                $arr[$result_list[$i]['sys_uid']]['sys_uname']            = $result_list[$i]['sys_uname'];
                $arr[$result_list[$i]['sys_uid']]['success_num']          = isset($arr[$result_list[$i]['sys_uid']]['success_num'])?$arr[$result_list[$i]['sys_uid']]['success_num']:0;
                $arr[$result_list[$i]['sys_uid']]['success_num']         += $result_list[$i]['success_num'];
                $arr[$result_list[$i]['sys_uid']]['work_time']            = isset($arr[$result_list[$i]['sys_uid']]['work_time'])?$arr[$result_list[$i]['sys_uid']]['work_time']:0;
                $arr[$result_list[$i]['sys_uid']]['work_time']           += $result_list[$i]['work_time'];
                $arr[$result_list[$i]['sys_uid']]['total_month_rank']     = $result_list[$i]['total_month_rank'];
                $arr[$result_list[$i]['sys_uid']]['success_month_rank']   = $result_list[$i]['success_month_rank'];
                $arr[$result_list[$i]['sys_uid']]['work_time_month_rank']   = $result_list[$i]['work_time_month_rank'];
                
            }
            sort($arr);
            //工作量排行
            $total_num_sort    =  list_sort_by($arr,'total_num','desc');
            //通过率排行榜
            $success_num_sort  =  list_sort_by($arr,'success_num','desc');
            //工作时间排行榜
            $work_time_sort    =  list_sort_by($arr,'work_time','desc');
        }
        
        unset($map);
        unset($field);
        unset($result_list);
        
        //返回结果
        $this->error_code = '0';
        $this->error_msg  = '操作成功！';
        $this->body = [
            'total_num_sort'      => $total_num_sort,
            'success_num_sort'    => $success_num_sort,
            'work_time_sort'      => $work_time_sort,
        ];
        
        unset($result_list);
        return $this->result;
    }
}