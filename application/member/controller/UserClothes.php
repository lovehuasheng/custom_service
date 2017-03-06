<?php
/**
 * 会员文化衫控制器层
 * @copyright Copyright (c) 2016 http://www.shanxinhui.com All rights reserved.
 * @author zhankaihui <2787407089@qq.com>
 * @version v1.0
 */

namespace app\member\controller;
use app\common\controller\Base;
class UserClothes extends Base{
	
	public function index()
	{
		return view(ROOT_PATH . 'templates/tshirt.html');
	}


	//查看申请列表
	public function get_clothes_list()
	{
		//验证数据,不通过则返回错误信息
    	if(!$this->verify('UserClothes','get_clothes_list'))
    	{  
    	   return $this->result;
    	}
		return model('UserClothes','service')->fetch_clothes_list($this->data);
	}	

	//编辑申请信息
	public function update_clothes()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('UserClothes','update_clothes'))
        {
            return $this->result;
        }
		return model('UserClothes','service')->edit_clothes($this->data);
	}	


	//删除申请信息
	public function del_clothes()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('UserClothes','del_clothes'))
        {
            return $this->result;
        }

		return model('UserClothes','service')->remove_clothes($this->data);
	}


	//查询申请详情
	public function get_clothes_detail()
	{
		//验证数据,不通过返回错误信息
        if(!$this->verify('UserClothes','get_clothes_detail'))
        {
            return $this->result;
        }
		return model('UserClothes','service')->fetch_clothes_detail($this->data);
	}

	//导出excel表格
	public function export()
	{	
		$result = [];

		//要查询的字段	
		$fields = [
			//会员账号
			'username',
			//收货人姓名
			'consignee_name',
			//收货人电话
			'consignee_phone',
			//省
			'province',
			//市
			'city',
			//收货人地址
			'consignee_address',
			//尺寸
			'size',
			//是否发货
			'is_shipping',
			//物流公司
			'shipping_company',
			//物流单号
			'shipping_no',
			//提交时间
			'create_time'
		];

		$model = model('UserClothes');

		//搜索条件
		$conditon = session('?clothes.search_condition') ? session('clothes.search_condition') : [];

		if(session('?clothes.search_count'))
		{
			$export_num = session('clothes.search_count');
		}
		else
		{
			$export_num = $model->get_count($conditon);
		}

		if($export_num > 0 && $export_num > config('max_export_num'))
		{
			$export_num = config('max_export_num');
		}

		//文件名
 		$filename = date('Y年m月d号') . '文化衫申领报表.csv';
		//表头数组
		$headers = array('申领登录账号','收货人姓名','收货人电话','省','市','收货人地址','尺寸','是否发货','物流公司','物流单号','提交时间');

		foreach($headers as $k=>$v)
		{

			$headers[$k] = "\t{$v}\t";
		}

		header( 'Content-Type: text/csv' );
     	header( 'Content-Disposition: attachment;filename="' . $filename . '"');
        //解决excel打开中文乱码
		echo "\xEF\xBB\xBF";
		$fp = fopen('php://output', 'w');
		fputcsv($fp,$headers);

		if($export_num > 0)
		{
			//一次处理2000条
			$per_page 	=  2000;

			$total_page = ceil($export_num/$per_page);

			for($page=1;$page<=$total_page;$page++)
			{
				$result = $model->get_list($conditon,$fields,$page,$per_page);
				if(!empty($result))
				{
					foreach ($result as $k=>$v)
					{	
						$val = $v->toArray();
						$row = [];
						foreach($val as $key=>$value)
						{
							//格式化尺寸
							if($key == 'size')
							{
								$value = $model->get_size($value);
							}

							//格式化是否发货
							if($key == 'is_shipping')
							{
								$value = $value ? '是' : '否';
							}

							//格式化时间
							if($key == 'create_time')
							{
								$value = date('Y-m-d H:i:s',$value);
							}

							//格式化收货地址
							if($key == 'consignee_address')
							{
								$value = "\t{$value}\t";
							}
							else
							{
								$value = "\t{$value}\t";
							}

							array_push($row, $value);
						}
						fputcsv($fp, $row);
					}	
				}
			}
		}
		fclose($fp);
	}


	//导入excel表格
	public function import()
	{	
		//获取上传文件
		$file = request()->file('user_clothes');	
		if(!$file)
		{
			$this->error_code = 4000; 
			$this->error_msg  = '请选择上传文件';
			return $this->result;
		}

		//检测文件类型是否合法
		if(!$file->checkExt('csv'))
		{
			$this->error_code = 40001;
			$this->error_msg  = '上传文件格式不正确';
			return $this->result;
		}

		//检测文件大小
		if(!$file->checkSize(1024*1024*5))
		{
			$this->error_code = 40002;
			$this->error_msg  = '请上传5M以下的文件';
			return $this->result;
		}

		//上传文件,移动到框架应用根目录/public/uploads/ 目录下
   		 $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

   		 //上传文件失败
   		 if(!$info)
   		 {
   		 	$this->error_code = 40003;
   		 	$this->error_msg  = $file->getError();
   		 	return $this->result;
   		 }

   		$user_model = model('User');

   		$user_clothes_model = model('UserClothes');

   		//获取保存文件的路径
   		$save_file = ROOT_PATH . 'public' . DS . 'uploads/' . $info->getSaveName();

   		$save_file = realpath($save_file);

   		//解析出来的数据
   		$res = [];

   		ini_set('auto_detect_line_endings',true);

   		$handle = fopen($save_file,'r');

   		if(!$handle)
   		{
   			$this->error_code = 40004;
   			$this->error_msg  = '打开上传文件出错';
   			ini_set('auto_detect_line_endings',false);
   			return $this->result;
   		}

   		$i = 0;
   		//读取csv文件
   		while(($data = fgetcsv($handle) ) !== FALSE)
   		{
			$i++;
			//跳过表头
			if($i == 1)
			{
				continue;
			}

			//申领登录账号
			$username = trim($data[0]);
			if($username == '')
			{
				$this->error_code = 40005;
			   	$this->error_msg  = "第{$i}行的申领登录账号为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;
			}
			else
			{
				$res[$i-1]['username'] = $username;
			}

			//收获人姓名
			$consignee_name = trim($data[1]);
			if($consignee_name == '')
			{
				$this->error_code = 40006;
			   	$this->error_msg  = "第{$i}行的收货人姓名为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;	
			}
			else
			{
				$res[$i-1]['consignee_name'] = $consignee_name;
			}

			//收获人电话
			$consignee_phone = trim($data[2]);
			$pattern = '/^1\d{10}$/';
			if($consignee_phone == '')
			{
				$this->error_code = 40007;
			   	$this->error_msg  = "第{$i}行的收货人电话为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;	
			}
			else if(!preg_match($pattern,$consignee_phone))
			{
				$this->error_code = 40008;
			   	$this->error_msg  = "第{$i}行的收货人格式不正确";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;	
			}
			else
			{
				$res[$i-1]['consignee_phone'] = $consignee_phone;
			}

			//省
			$province = trim($data[3]);
			if($province == '')
			{
				$this->error_code = 40009;
			   	$this->error_msg  = "第{$i}行的省不能为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;	
			}
			else
			{
				$res[$i-1]['province'] = $province;
			}

			//市
			$city = trim($data[4]);
			if($city == '')
			{
				$this->error_code = 40010;
			   	$this->error_msg  = "第{$i}行的市不能为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;					
			}
			else
			{
				$res[$i-1]['city'] = $city;
			}

			//收货人地址
			$consignee_address = trim($data[5]);
			if($consignee_address == '')
			{
				$this->error_code = 40011;
			   	$this->error_msg  = "第{$i}行的收货人地址不能为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;				
			}
			else
			{
				$res[$i-1]['consignee_address'] = $consignee_address;
			}

			//尺寸
			$size = trim($data[6]);
			if($size == '')
			{
				$this->error_code = 40012;
			   	$this->error_msg  = "第{$i}行的尺寸不能为空";
			   	ini_set('auto_detect_line_endings',false);
			   	return $this->result;
			}
			else
			{
				$size = $user_clothes_model->get_size_id($size);
				if(!$size)
				{
					$this->error_code = 40013;
			    	$this->error_msg  = "第{$i}行尺寸不合法";
			    	ini_set('auto_detect_line_endings',false);
			    	return $this->result;
				}
				else
				{
					$res[$i-1]['size'] = $size;
				}
			}

			//是否发货
			$is_shipping = trim($data[7]);
			if($is_shipping == '')
			{
				$this->error_code = 40014;
			    $this->error_msg  = "第{$i}行是否发货不能为空";
			    ini_set('auto_detect_line_endings',false);
			    return $this->result;
			}

			$is_shipping = '否' ? 0 : 1;

			if(!in_array($is_shipping,[0,1]))
			{
				$this->error_code = 40015;
			    $this->error_msg  = "第{$i}行是否发货不正确";
			    ini_set('auto_detect_line_endings',false);
			    return $this->result;
			}
			else
			{
				$res[$i-1]['is_shipping'] = $is_shipping;
			}

			//物流公司
			$res[$i-1]['shipping_company'] = trim($data[8]);
			//物流单号
			$res[$i-1]['shipping_no']      = trim($data[9]);

			//提交时间
			$create_time      = trim($data[10]);

			$create_time      = strtotime($create_time);

			if(!$create_time)
			{
				$this->error_code = 40016;
			    $this->error_msg  = "第{$i}行是提交时间不正确";
			    ini_set('auto_detect_line_endings',false);
			    return $this->result;
			}
			else
			{
				$res[$i-1]['create_time'] = $create_time;
			}
			 //会员id
			 $user_id = $user_model->get_id_by_username($username);
			 if(!$user_id)
			 {
			    $this->error_code = 40017;
			    $this->error_msg  = "第{$i}行申领登录账号不存在";
			    ini_set('auto_detect_line_endings',false);
			    return $this->result;
			 }
			 else
			 {
			 	$res[$i-1]['user_id'] = $user_id;
			 }

   		}

		if(empty($res))
		{
			$this->error_code = 40018;
			$this->error_msg  = '表格数据为空或者格式错误';
			ini_set('auto_detect_line_endings',false);
			return $this->result;
		}

		if(!$user_clothes_model->saveAll($res))
		{
			$this->error_code = 40019;
			$this->error_msg  = '导入数据失败';
			ini_set('auto_detect_line_endings',false);
		}

		return $this->result;
	}

}
