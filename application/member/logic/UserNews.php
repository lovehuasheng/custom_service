<?php
/**
 * 消息模板管理逻辑层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */
namespace app\member\logic;
use app\common\logic\Base;
class UserNews extends Base
{


    /**
     * 添加公告
     * @param  array  $params 待添加的消息模板信息数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示添加消息模板成功
     */
    public function append_news($params=[])
    {
      //过滤id
      unset($params['id']);
      //发布者id
      $params['user_id']  = session('user_auth.id');
      //发布者账号
      $params['username'] = session('user_auth.username');

      //二级密码
      $secondary_password = empty($params['secondary_password']) ? '' : trim($params['secondary_password']);

      //发布公告的是否验证二级密码
      if($params['status'] == 1)
      {
        if(empty($secondary_password))
        {
          $this->error_code = 8000;
          $this->error_msg  = '请输入二级密码';
          return $this->result;
        }
        $map['id'] = session('user_auth.id');
        //查询登录用户信息
        $user = model('user/SysUser')->get_user_info($map, 'secondary_password');
        if ($user['secondary_password'] != set_password(md5($secondary_password)))
        {
            //返回结果
            $this->error_code = '-200';
            $this->error_msg = '二级密码错误!';
            return $this->result;
        }
      }
      //公告更新时间默认为发布时间
      $params['update_time'] = time();
      //添加新闻公告
      if(!model('UserNews')->add($params))
      {
          $this->error_code = 41001;
          $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
    }

    /**
     * 获取公告列表
     * @param  array  $params 包含查询条件的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板列表成功
     */
    public function get_news($params=[])
    {    
      //设置要获取的字段列表
      $fields = [
        //模板id
        'id',
        //分类id 1-系统公告，2-审核公告
        'classify_id',
        //公告标题
        'title',
        //发布者账号
        'username',
        //公告内容
        //'content',
        //公告状态 0-未发布 1-已发布
        'status',
        //是否是企业公告 0-个人 1-企业
        'is_company',
        //公告创建时间
        'create_time',
        //公告修改时间
        'update_time'
      ];  

      //搜索条件
      $condition = [];

      //按公告id查询
      if(isset($params['id']))
      {
        $condition['id'] = $params['id'];
      }

      //按分类查询 1-系统公告，2-审核公告
      if(isset($params['classify_id']) && trim($params['classify_id'] != ''))
      {
        $condition['classify_id'] = $params['classify_id'];
      }

      //按标题查询
      if(isset($params['title']) && trim($params['title']) != '')
      {
        $condition['title'] = ['like',"%{$params['title']}%"];
      }

      //按发布状查询 0-未发布 1-已发布
      if(isset($params['status']) && trim($params['status']) != '')
      {
        $condition['status'] = $params['status'];
      }

      //按是否是企业查询 0-个人 1-企业
      if(isset($params['is_company']) && trim($params['is_company'] != ''))
      {
        $condition['is_company'] = $params['is_company'];
      }

      //按发布起始时间查询
      if(!empty($params['create_time_start']))
      {
          $condition['create_time'] = ['>=',strtotime($params['create_time_start'])];
      }

      //按发布截止时间查询
      if(!empty($params['create_time_end']))
      {

        $exp = ['<=',strtotime($params['create_time_end'])];

        if(!empty($condition['create_time']))
        {
          $condition['create_time'] = [$condition['create_time'],$exp,'AND']; 
        }
        else
        {
          $condition['create_time'] = $exp;
        }
      }

      //按公告更新起始时间查询
      if(!empty($params['update_time_start']))
      {
        $condition['update_time'] = ['>=',strtotime($params['update_time_start'])];
      }

      //按公告更新截止时间查询
      if(!empty($params['update_time_end']))
      {
        $exp = ['<=',strtotime($params['update_time_end'])];
        if(!empty($condition['update_time']))
        {
          $condition['update_time'] = [$condition['update_time'],$exp,'AND']; 
        }
        else
        {
          $condition['update_time'] = $exp;
        }
      }

      if(!empty($params['page']))
      {
        //设置页码
        $page = intval($params['page']);
      }

      //设置默认页码
      if(empty($page) || $page <=0)
      {
        $page = 1;
      }

      //排序
      $order = 'DESC';

      if(isset($params['order']) && intval($params['order']) == 1)
      {
        $order = 'ASC';
      }

      //设置每页记录数,默认为20条
      $per_page = config('page_total');
      //设置页码列表,默认为5页
      $page_list = config('page_list');


      $user_news_model = model('UserNews');

      //排序
      $order = [
        'update_time' => $order
      ];

      //查询满足条件的会员数量
      $total = $user_news_model->get_count($condition);

      if($total)
      {
        $news_list = $user_news_model->get_list($condition,$fields,$page,$per_page,$order);
      }

      //获取页码列表
      $pages = get_pagination($total,$page,$per_page,$page_list);

      //返回结果
      $this->body = [
          'news_list' => !empty($news_list) ? $news_list : [],
          'pages'     => $pages,
          'total'     => $total
        ];
      return $this->result;
    } 

    /**
     * 修改公告
     * @param  array  $params 包含查询条件和更新数据的数组
     * @return array          包含响应消息的数组,若数组中的错误码为0,表示修改消息模板成功
     */
    public function modify_news($params=[])
    { 
        //发布者id
        $params['user_id']  = session('user_auth.id');
        //发布者账号
        $params['username'] = session('user_auth.username');
        if(!model('UserNews')->update_by_id($params['id'],$params))
        {
            $this->error_code = 10010;
            $this->error_msg  = '操作失败,请稍后再试';
        }
        return $this->result;
    }


    //删除公告
    public function destroy_news($params=[])
    {
      if(!model('UserNews')->del_by_id($params['id']))
      {
        $this->error_code = 10011;
        $this->error_msg  = '操作失败,请稍后再试';
      }
      return $this->result;
    }

   /**
    * 获取公告详情
    * @param  array  $params  包含查询条件的数组
    * @return array          包含响应消息的数组,若数组中的错误码为0,表示获取消息模板详情成功
    */
   public function acquire_news_detail($params=[])
   {
      //设置要获取的字段列表
      $fields = [
        //模板id
        'id',
        //分类id 1-系统公告，2-审核公告
        'classify_id',
        //模板标题
        'title',
        //模板内容
        'content',
        //模板状态 0-未发布 1-已发布
        'status',
        //是否是企业公告 0-个人 1-企业
        'is_company',
        //公告创建时间
        'create_time',
        //公告修改时间
        'update_time'
      ]; 

      //获取公告详情
      $news = model('UserNews')->get_by_id($params['id'],$fields);

      $news = $news->toArray();

      //print_r($news);exit();
      //设置响应数据
      $this->body = !empty($news) ? $news : [];
      return $this->result;
   }  
}