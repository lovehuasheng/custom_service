<?php
/**
 * 用户身份变更
 */
namespace app\change\service;
use app\common\service\Base;
use app\member\model\UserInfo;
use \think\Db;
class Change extends  Base{
    /*用户身份搜索*/
    public function search_action($data=[]){
        $redis = \org\RedisLib::get_instance('sxh_default');
        $id = $redis->get("sxh_user:username:".trim($data['username']).":id");
        if($id){
            $m = \think\Loader::model('member/UserInfo', 'model');
            $field = ['user_id as userid','username','name','classification as c','referee_id as rid','referee as r_name','referee_name as realname'];
            $result = $m->get_by_uid($id,$field);
            if($result){
               $result = $result->toArray();
	            switch($result['c']){
	                case 0:$result['nickname'] = '普通用户';break;
	                case 1:$result['nickname'] = '功德主';break;
	                case 2:$result['nickname'] = 'A轮服务中心';break;
	                case 3:$result['nickname'] = 'B轮服务中心';break;
	               default:$result['nickname'] = '普通用户';break;
	                	 
	            }
            }
            return ['errCode'=>0,'result'=>$result,'errMsg'=>''];
        }else{
            return ['errCode'=>4,'result'=>'','errMsg'=>'用户不存在'];
        }
    }

    /*推荐人身份搜索*/
    public function ref_search_action($data=[]){
        $redis = \org\RedisLib::get_instance();
        $errMsg=[];
        if(!preg_match("/^\d+$/",$data['rn_id'])){
            $errMsg[]="用户ID不合法";
        }
        if(count($errMsg)>0){ //第1步
            $re=new \stdClass();
            $re->errCode=1;
            $re->errMsg=$errMsg;
            $re->result=array();
            return $re;
        }
        $username = $redis->get("sxh_user:id:".trim($data['rn_id']).":username");   //redis 缓存中存在其信息  缓存中必须有，否则后面查询可能报错
        if($username){
            $m = \think\Loader::model('member/UserInfo', 'model');                  //表中必须也存在其信息
            $field = ['user_id as userid','username','name','classification'];
            $result = $m->get_by_uid(trim($data['rn_id']),$field);
            if($result){
            	$result =$result->toArray();
            
	            switch($result['classification']){
	                case 0:$result['nickname'] = '普通用户';break;
	                case 1:$result['nickname'] = '功德主';break;
	                case 2:$result['nickname'] = 'A轮服务中心';break;
	                case 3:$result['nickname'] = 'B轮服务中心';break;
	            }
            }
	       return ['errCode'=>0,'result'=>$result,'errMsg'=>''];
        }else{
            return ['errCode'=>4,'result'=>'','errMsg'=>'用户不存在'];
        }
    }
    /*变更身份*/
    public function do_change_action($data=[]){
        $errMsg=[];
        if(!preg_match("/^\d+$/",$data['userid'])){
	$errMsg[]="用户ID不合法";
        }
        if(!preg_match("/^\d+$/",$data['tonickid'])){
            $errMsg[]="用户等级不合法";
        }
        if($data['tonickid']==0){
            $errMsg[]="请选择用户等级";
        }
        /*if(!preg_match("/^\d{4}\-\d{2}\-\d{2}$/",$data['update'])){
            $errMsg[]="修改日期不合法";
        }
        if(strtotime($data['update'])>strtotime(date("Y-m-d"))){
            $errMsg[]="修改日期不能超过今天";
        }*/
        if(count($errMsg)>0){ //第1步
            $re=new \stdClass();
            $re->errCode=1;
            $re->errMsg=$errMsg;
            $re->result=array();
            return $re;
        }

		set_time_limit(0);
		Db::startTrans();
		if($data['tonickid'] == 1)$data['tonickid'] = 0;
		/*更改用户等级*/
        $old = $this->updateNodeid($data['userid'],$data['tonickid']);
		if($old == false){
		    Db::rollback();
			return $this->returnResult(0,"修改失败");
		}
		/*更新因用户升级受到影响的节点关系*/
        $update = $this->setUserGroupSetting($data['userid'],$data['tonickid'],$old);
		if($update == false){
			Db::rollback();
			return $this->returnResult(0,"修改失败");
		}
		Db::commit();
        return $this->returnResult(0,"修改成功");
    }
	/*更改用户等级,并且返回更改之前的用户信息*/
    public function updateNodeid($userid,$nickid){
        $data = DB::query("select a,b,c,nickid,plevel,edi from sxh_user_relation where user_id = ".$userid);
		if($data[0]['nickid'] == $nickid){
			return false;
		}
		$m = \think\Loader::model('member/UserInfo', 'model');
		if($nickid == 0){
		    $arr['classification'] = 0;
		}
		if($nickid == 100){
			$arr['classification'] = 1;
		}
		if($nickid == 400){
			$arr['classification'] = 3;
		}
		if($nickid == 800){
			$arr['classification'] = 2;
		}
		$update = $m->update_by_uid($userid,$arr);
		if(!$update){
			return false;
		}
        $return = DB::execute("update sxh_user_relation set nickid = ".$nickid." where user_id = ".$userid);
        if(!$return){
            return false;
        }else{
            return $data[0];
        }
    }
    //更改用户推荐人
    public function do_change_ref_action($data=[]){
		set_time_limit(0);
        $errMsg=[];
        if(!preg_match("/^\d+$/",$data['userid'])){
			$errMsg[]="用户ID不合法";
        }
        if(!preg_match("/^\d+$/",$data['n_ref'])){
			$errMsg[]="推荐人ID不合法";
        }
        /*if(!preg_match("/^\d{4}\-\d{2}\-\d{2}$/",$data['update'])){
            $errMsg[]="修改日期不合法";
        }
        if(strtotime($data['update'])>strtotime(date("Y-m-d"))){
            $errMsg[]="修改日期不能超过今天";
        }*/
        if(count($errMsg)>0){ //第1步
            $re=new \stdClass();
            $re->errCode=1;
            $re->errMsg=$errMsg;
            $re->result=array();
            return $re;
        }
		if($data['o_ref'] == $data['n_ref']){
			return self::returnResult(4,"修改失败");
		}
		/*更改推荐人*/
        $r = $this->changeUserInfoReffer($data['userid'],$data['n_ref']);
        if(!$r){
            return self::returnResult(4,"修改失败");
        }
        /*新推荐人不是自己的子集*/
        $ref = $this->getSonLevel($data['userid'],$data['n_ref']);
        /*更新full_url,plevel*/ 
        $return = $this->changeUserRelationFullurl($data['userid'],$data['o_ref'],$data['n_ref'],$ref);
		/*更新层级所属*/
        $this->changeUserRelationABC($data['userid'],$return,$ref);

        return $this->returnResult(0,"修改成功");
    } 
	/*更改因推荐人变化受到影响的子子孙孙*/
	public function changeUserRelationABC($userid,$topid,$is_son){
		if($is_son['is_son'] == 1){/*推荐人是子集*/
			DB::execute("update sxh_user_relation set a=0,b=0,c=0 where full_url like '%,".$topid.",%'");
			$sql1 = "select user_id,nickid,plevel from sxh_user_relation where  nickid  in(800,100,400) and full_url like '%,".$topid.",%' ";
			$d =DB::query($sql1);
			if(count($d)>0){
				foreach($d as $k=>$v){
					if($v['nickid'] == 800){
						$m = 'a';
					}else if($v['nickid'] == 400){
						$m = 'b';
					}else{
						$m = 'c';
					}
					$this->q($v['user_id'],$v['nickid'],$m);
				}
			}
		}else{/*新推荐人不是子集*/		
			/*更新到新分支之后，原来的用户所属A等级是不会受到影响的，排除A分支一下*/
			$full = DB::query("select user_id from sxh_user_relation where nickid=800 and a>0 and  full_url like '%,".$userid.",%'");
			$sql = " 1 ";
			if(count($full)>0){
				foreach($full as $k=>$v){
					$sql.=" and full_url not like '%,".$v['user_id'].",%'";
				}
			}
			/*把分之中可能受到影响的节点重置*/
			DB::execute("update sxh_user_relation set a=0,b=0,c=0 where full_url like '%,".$userid.",%' and $sql");
			$topdata = DB::query("select user_id,nickid,a,b,c from sxh_user_relation where user_id = ".$topid);
			/*找出受到影响的节点*/
			$sql1 = "select user_id,nickid from sxh_user_relation where  nickid  in(800,400,100) and $sql and full_url like '%,".$userid.",%' ";
			$d =DB::query($sql1);
			if(count($topdata)>0){
				if($topdata[0]['c']>0){
					$c1['user_id'] = $topdata[0]['c'];
					$c1['nickid']  = 100;
					$d[]=$c1;
				}
				if($topdata[0]['b']>0){
					$b1['user_id'] = $topdata[0]['b'];
					$b1['nickid']  = 400;
					$d[]=$b1;
				}
				if($topdata[0]['a']>0){
					$a1['user_id'] = $topdata[0]['a'];
					$a1['nickid']  = 800;
					$d[]=$a1;
				}
			}
			if(count($d)>0){
				foreach($d as $k=>$v){
					if($v['nickid'] == 800){
						$m = 'a';
					}else if($v['nickid'] == 400){
						$m = 'b';
					}else{
						$m = 'c';
					}
					$this->q($v['user_id'],$v['nickid'],$m);
				}
			}
		}
	}

    /*新推荐人是否是自己的某一个子集*/
    public function getSonLevel($userid,$n_ref){
		/*next_userid 自己的下级，如果新推荐人不是自己的子集，next_userid为空 当新推荐人是自己的子集用户时，树形结构会断，所以自己的下级和上级要链接起来*/
        $sql = "select full_url,a,b,c from sxh_user_relation where user_id = ".$n_ref;
        $data = Db::query($sql);
        $d = explode(',', trim($data[0]['full_url'],','));
        if(in_array($userid, $d)){
            //找出下一代用户ID
            return ['full_url'=>$data[0]['full_url'],'is_son'=>1];
        }else{/*如果不是子集找出新推荐人的顶级节点*/
			$e = 0; 
			$nick = 0;
			if($data[0]['c']>0){
                $e = $data[0]['c'];
				$nick = 100;
            }
			if($data[0]['b']>0){
                $e = $data[0]['b'];
				$nick = 400;
            }
			if($data[0]['a']>0){
                $e = $data[0]['a'];
				$nick = 800;
            }
            return ['full_url'=>$data[0]['full_url'],'is_son'=>0,'e'=>$e,'nick'=>$nick];
        }
    }
    /*更新user_relation*/
    public function changeUserRelationFullurl($userid,$oldpid,$newpid,$is_son ){
		/*更新user_relation 表中的推荐人*/
		DB::execute("update sxh_user_relation set edi = $newpid where user_id = ".$userid);
        
		/*原来的推荐人的额信息*/
        $full_url = DB::query("select full_url,a,b,c from sxh_user_relation where user_id = ".$oldpid." limit 1");
        if(count($full_url)==0){
                return self::returnResult(4,"要修改的用户在relation表中不存在");
        }
        $url1 = $full_url[0]['full_url'];/*原推荐人的*/
        $url2 = $is_son['full_url'];     /*新推荐人的*/
	if(!empty($is_son) && $is_son['is_son'] > 0){
            /*新推荐人是原来自己的子集,断裂的关系需要链接*/
            $sql = "update sxh_user_relation set full_url = replace(full_url,'".$url2."','".$url1.$newpid.",') where full_url like '%,".$newpid.",%'";
            DB::execute($sql);
            /*更新所有受影响的用户的full_url,也就是替换full_url上半部分*/
            $sql = "update sxh_user_relation set full_url = replace(full_url,'".$url1."','".$url1.$newpid.",') where full_url like '%,".$userid.",%'";
            DB::execute($sql);
            /*更新plevel,pevel 等于full_url 中所有的逗号个数-1*/
            $sql = "update sxh_user_relation set plevel = (length(full_url)-length(replace(full_url,',',''))-1) where full_url like '%,".$oldpid.",%'";
            DB::execute($sql);
        }else{
            $sql = "update sxh_user_relation set full_url = replace(full_url,'".$url1."','".$url2."') where full_url like '%,".$userid.",%'";
            DB::execute($sql);
            /*更新plevel,pevel 等于full_url 中所有的逗号个数-1*/
            $sql = "update sxh_user_relation set plevel = (length(full_url)-length(replace(full_url,',',''))-1) where full_url like '%,".$userid.",%'";
            DB::execute($sql);
        }       
        if($is_son['is_son'] == 0){ /*断开之后新的分支与老分支不存在从属关系*/
			$e = $newpid;/*更改推荐人之后。新分支最开始受影响的ID*/	
        }else{/*新的分支是自己原来的子集*/
			$e = $oldpid; 
			if($full_url[0]['c']>0){
                $e = $full_url[0]['c'];
            }
			if($full_url[0]['b']>0){
                $e = $full_url[0]['b'];
            }
            if($full_url[0]['a']>0){
                $e = $full_url[0]['a'];
            }
        }
        return $e;
    }
	/*更新user_info 表中的推荐人信息*/
    public function changeUserInfoReffer($userid,$newpid){
        $redis = \org\RedisLib::get_instance('sxh_default');
        $username = $redis->get("sxh_user:id:".$newpid.":username");
        if($username){
            $m = \think\Loader::model('member/UserInfo', 'model');
            $field = ['username','name' ,'user_id'];
            $result = $m->get_by_uid($newpid,$field)->toArray();
            $d['referee']      = $result['username'];
            $d['referee_id']   = $newpid;
            $d['referee_name'] = $result['name'];
            $r = $m->update_by_uid($userid,$d);
            return $r ;
        }else{
            return 0;
        }
    }
    /*更新开始受到影响的节点*/
    public  function setUserGroupSetting($userid,$tonickid,$old){
		/*更新用户升级或降级之后收到影响的直属用户所属*/
		if($old['nickid']== 100){
			$update1 = DB::execute("update sxh_user_relation set c = 0 where c = ".$old['c']." and full_url like '%,".$userid.",%' ");
			if(!$update1) return false;
		}
		if($old['nickid']== 400){
			$update1 = DB::execute("update sxh_user_relation set b = 0 where b = ".$old['b']." and full_url like '%,".$userid.",%' ");
			if(!$update1) return false;
		}
		if($old['nickid']== 800){
			$update1 = DB::execute("update sxh_user_relation set a = 0 where a = ".$old['a']." and full_url like '%,".$userid.",%' ");
			if(!$update1) return false;
		}
		/*找到上级的开始受到影响的节点，节点直属用户会增多*/
		$pdata    = DB::query("select a,b,c,nickid from sxh_user_relation where user_id = ".$old['edi']);
		$pnickid  = 0;
		if($pdata[0]['c']>0){
			$pnickid = 100;
		}
		if($pdata[0]['b']>0){
			$pnickid =400;	
		}
		if($pdata[0]['a']>0){
			$pnickid =800;	
		}
		/*把开始受影响的最高的节点与*/
		
		if($pnickid == 100){
			$update1 = DB::execute("update sxh_user_relation set c = 0 where c = ".$old['c']." and full_url like '%,".$userid.",%' ");
		}
		if($pnickid == 400){
			$update1 = DB::execute("update sxh_user_relation set b = 0,c=0 where b = ".$old['b']." and full_url like '%,".$userid.",%' ");
		}
		if($pnickid == 800){
			$update1 = DB::execute("update sxh_user_relation set a = 0,b=0,c=0 where a = ".$old['a']." and full_url like '%,".$userid.",%' ");
		}
			
		
		/*排除掉比自己等级高的节点分支*/
		$max = max($pnickid,$tonickid);
		$sql_max = "select user_id from sxh_user_relation where   full_url like '%,".$userid.",%' and  nickid>= ".$max." and user_id !=".$userid;
		$max_data = DB::query($sql_max);
		$sql =' 1 ';
		if(count($max_data)>0){
			foreach($max_data as $k=>$v){
			 $sql .= " and full_url not like '%,".$v['user_id'].",%' ";
			}
		
		}
        $sql1 = "select user_id,nickid from sxh_user_relation where  nickid <= $max and nickid>0 and full_url like '%,".$userid.",%' and $sql";
        $d =DB::query($sql1);
		/*升级节点的上级abc，添加到待更新的数组*/
		if($pdata[0]['c']>0){
			$c1['user_id'] = $pdata[0]['c'];
			$c1['nickid']  = 100;
			$d[]=$c1;
		}
		if($pdata[0]['b']>0){
			$b1['user_id'] = $pdata[0]['b'];
			$b1['nickid']  = 400;
			$d[]=$b1;
		}
		if($pdata[0]['a']>0){
			$a1['user_id'] = $pdata[0]['a'];
			$a1['nickid']  = 800;
			$d[]=$a1;
		}
        foreach($d as $k=>$v){
            if($v['nickid'] == 800){
                $m = 'a';
            }else if($v['nickid'] == 400){
                $m = 'b';
            }else{
                $m = 'c';
            }
			/*更新节点的直属用户*/
            $this->q($v['user_id'],$v['nickid'],$m);
        }
		return true;
    }
    public function q($userid,$nickid ,$m){
		/*排除下级里面比自己等级高的节点分支*/
        $sql1 = "select user_id from sxh_user_relation where full_url like '%,".$userid.",%' and nickid >= ".$nickid." and user_id != ".$userid."";
        $d =DB::query($sql1);
        $sql2 = " full_url like '%,".$userid.",%' ";
        if($d != false || !empty($d)){ //同等级节点
            foreach($d as $k=>$v){
                $sql2 .= " and full_url not like '%,".$v['user_id'].",%' ";
            }
        }
        $sql3 = "update sxh_user_relation set ".$m." =  ".$userid."  where ".$sql2." and is_company = 0";
        DB::execute($sql3);
    }
   
    public static function returnResult($errCode,$errMsg,$result=array()){
        $re=new \stdClass();
        $re->errCode=$errCode;
        $re->errMsg=$errMsg;
        $re->result=$result;
        return $re;
    }


    //转移推荐中心
    public function do_change_company_ref_action($data=[])
    {
       $r = $this->changeCompanyInfoReffer($data['user_id'],$data['referee_id'],$data['update_time']);
       if(!$r){
            return self::returnResult(5,"修改失败");
       }
       return self::returnResult(0,"修改成功");
    }

    //企业会员推荐人变更
    public function changeCompanyInfoReffer($user_id,$referee_id,$update_time)
    {

        //查询新推荐人的关系链
        $sql = "SELECT `edi`,`url`,`create_time`,`full_url`,`plevel` FROM `sxh_user_relation` WHERE `user_id`={$referee_id} AND `is_company`=1  LIMIT 1";

        //查询会员原始的关系链
        $sql1 = "SELECT `edi`,`url`,`create_time`,`full_url`,`plevel` FROM `sxh_user_relation` WHERE `user_id`={$user_id} AND `is_company`=1  LIMIT 1";

        //新推荐人关系链
        $referee = $this->query($sql);

        //原始关系链
        $old_referee = $this->query($sql1);


        //新的5级父节点, 将推荐人的url字段与当前会员的id进行组合
        $new_url =  "{$referee[0]['url']}{$user_id},";

        //保证父级节点为5级
        $new_url_arr = explode(',', trim($new_url,','));

        //大于5级就从后向前截取5级
        if(count($new_url_arr) > 5)
        {
            $truncated_new_url_arr = array_slice($new_url_arr,-5);
            $new_url               = ',' . implode(',',$truncated_new_url_arr) . ',';
        }

        //新的所有的父级节点
        $new_full_url = "{$referee[0]['url']}{$user_id},";

        //新的plevel
        $plevel       =  substr_count($new_full_url,',')-1;

        //更新该会员本身relation
        $sql2 = "UPDATE `sxh_user_relation` SET `edi`={$referee_id},`url`='{$new_url}',`full_url`='{$new_full_url}',`update_time`={$update_time},`plevel`={$plevel} WHERE `user_id`={$user_id}  AND `is_company`=1  LIMIT 1";

        //更新下级的relation
        $sql3 = "UPDATE sxh_user_relation AS c INNER JOIN sxh_user_relation AS p ON c.`edi`=p.`user_id` SET c.`url`= SUBSTRING_INDEX(CONCAT(p.`url`,c.`user_id`,','),',',-6),c.`full_url`=CONCAT(p.`full_url`,c.`user_id`,','),c.`update_time`=UNIX_TIMESTAMP(),c.`plevel`=LENGTH(p.`full_url`)-LENGTH(REPLACE(p.`full_url`,',',''))  WHERE `is_company`=1 AND  c.`url` LIKE '%,{$user_id},%'";

        \think\Db::startTrans();
        try{
                $this->query($sql2);
                $this->query($sql3);
                // 提交事务
                \think\Db::commit();

                return true;
            } catch (\Exception $e) {
                // 回滚事务
                \think\Db::rollback();
                return false;
            }
    }
   /* public static function valid($userid,$tonickid,$updatetime){//校验用户
        $sql="select * from sxh_user_belong where userid=$userid limit 1";
        $r=DB::query($sql);
        if(count($r)==0){
                return self::returnResult(2,"用户不存在");
        }
        if($r[0]["nickid"]==$tonickid){ //变动等级如果不变，允许改变最初的申请时间,后台人员操作时
                $time = strtotime($updatetime);
                $sql = "update sxh_account_point_log set create_time = ".$time." where userid = ".$userid." limit 1";
                DB::execute($sql);
                return self::returnResult(4,"时间修改成功");
        }
        $sql="select * from sxh_user_nick where nickid=$tonickid";
        $r=DB::query($sql);
        if(count($r)==0){
                return self::returnResult(4,"要修改的用户等级不存在");
        }
        return self::returnResult(0,"",$r);
    }
    public static function changeUserGroup($userid,$tonickid,$tonickname){	
        $sql="update sxh_user_belong set nickid=$tonickid,nickname='$tonickname' where userid=$userid";
        DB::execute($sql);
        $m = \think\Loader::model('Member/UserInfo', 'model');
        switch($tonickid){
            case 1:$c = 0;break;
            case 100:$c = 1;break; //功德主
            case 400:$c = 3;break; //B轮服务中心
            case 800:$c = 2;break; //A轮服务中心
        }
        $field = ['classification'=>$c];
        $result = $m->update_by_uid($userid,$field);
        /*$sql="update sxh_userinfo set nickname='$tonickname' where id=$userid";
        DB::execute($sql);
    }*/
    /*public static function getUserGroup($userid){
        $sql="select userid from sxh_user_belong where nickid in (100,400,800) and full_url like '%,$userid,%' order by belong";
        $r=DB::query($sql);
        $re=[$userid];
        sort($re);
        foreach($r as $v)$re[]=$v['userid'];
        return $re;
    }*/
    /*public static function setUserGroupSetting($nodeGroups,$updateDate){
        sort($nodeGroups);//狗日的这个非常关键！！！！
        foreach($nodeGroups as $v){
                if($v==0)continue;
                self::_setUserGroupSetting($v,$updateDate);
        }
    }
    private static function _setUserGroupSetting($userid,$updateDate){
        $time=strtotime($updateDate);		
        //先处理sxh_user_belong 表
        $sql="select * from sxh_user_belong where userid=$userid";
        $r=DB::query($sql);
        $user=$r[0];
        //获取belong
        $nodeArray=self::getBelongByNodes($user['full_url']);		
        //修改top_id,pid
        if(count($nodeArray)==0){
                $top_id=0;
                $pid=0;
        }else{
                $top_id=$nodeArray[count($nodeArray)-1];
                $pid=$nodeArray[0];
        }
        $belong=",". join(',',$nodeArray).",";
        //if($belong==$user['belong']) return;
        self::updateSelfChild($userid,$top_id,$pid,$belong);//只能改自身和自营团队
        //然后开始坑爹的做法 
        //todo
        self::setPoint($userid,$belong);
        self::addPointLog($userid,$belong,$updateDate);
    }
    private static function updateSelfChild($userid,$top_id,$pid,$belong){//修改自身直营团队的belong
        $sql="select userid,nickid from sxh_user_belong where nickid>1 and full_url like '%,$userid,%' and userid!=$userid";
        $r=DB::query($sql);
        $sql="update sxh_user_belong set top_id=$top_id,pid=$pid,belong='". $belong ."' where full_url like '%,$userid,%'  ";
        foreach($r as $v){
                $sql.=" and full_url not like '%,".$v['nickid'].",%'";
        }
        DB::execute($sql);
    }
    public static function getBelongByNodes($full_url){
        $sql="select userid ,nickid,full_url from sxh_user_belong where userid in(".trim($full_url,",").")";
        $r=DB::query($sql);
        $nodes=new \stdClass();
        foreach($r as $v){
                $k="k". $v['userid'];
                $nodes->$k=$v['nickid'];
        }
        $re=array();
        $current=1;
        $tree=explode(",",$full_url);
        $tree= array_reverse($tree);
        foreach($tree as $v){
                $k='k' . $v;
                if(!empty($nodes->$k)){
                        if($nodes->$k>$current){
                                $re[]=$v;
                                $current=$nodes->$k;
                        }
                }
        }
        return $re;
    }
    public static function setPoint($userid,$belong){
        $sql="delete from sxh_account_point where userid=$userid";
        DB::query($sql);
        $ids=explode(',',$belong);
        $ids=array_diff($ids,array(''));
        if(count($ids)==0) return;
        $sql="select * from sxh_user_belong where userid in (".join(",",$ids).") order by nickid asc";
        $r=DB::query($sql);	
        $fields=["userid","nick_id"];
        $values=[$r[0]['userid'],$r[0]['nickid']];
        for($i=0;$i<count($r);$i++){
                $v=$r[$i];
                if($v['nickid']==100){
                        $fields[]="gdzhu";
                        $values[]=$v['userid'];
                        $fields[]="to_gdzhu";
                        $values[]=0.3;
                }
                if($v['nickid']==400){
                        $fields[]="service_b";
                        $values[]=$v['userid'];
                        $fields[]="to_b";
                        if($r[0]['nickid']==400){
                                $values[]=0.4;
                        }else{
                                $values[]=0.1;
                        }				
                }
                if($v['nickid']==800){
                        $fields[]="service_a";
                        $values[]=$v['userid'];
                        $fields[]="to_a";
                        $t=0.1;
                        if($r[0]['nickid']==800){
                                $t=0.5;
                        }
                        if($r[0]['nickid']==100 && count($r)==2)$t=0.2;
                        $values[]=$t;
                }
        }
        $sql="delete from sxh_account_point where userid=".$r[0]['userid'];
        DB::query($sql);
        $sql="insert into sxh_account_point (" .join(",",$fields).") values(" . join(",",$values). ")";
        DB::execute($sql);
    }
    public static function addPointLog($userid,$belong,$updateDate){
        $t=strtotime($updateDate);
        $sql="update sxh_account_point_log set status=0, end_time=$t where userid=$userid and status = 1";
        DB::execute($sql);
        $ids=explode(',',$belong);
        $ids=array_diff($ids,array(''));
        if(count($ids)==0) return;
        $sql="select * from sxh_user_belong where userid in (".join(",",$ids).") order by nickid asc";
        $r=DB::query($sql);	
        $start=$r[0];
        $sql="update sxh_account_point_log set status=0, end_time=$t where userid=".$start['userid']." and status = 1";
        DB::execute($sql);
        for($i=0;$i<count($r);$i++){
            $v=$r[$i];
            $fields=['userid','nick_id','create_time','belong','status','to_userid','to_nick_id','to_nick_name','nick_name'];
            $values=[$start['userid'],$start['nickid'],$t,$belong,1,$v['userid'],$v['nickid'],$v['nickname'],$start['nickname']];
            if($v['nickid']==100){
                    $fields[]='rebate';
                    $values[]=0.3;
            }
            if($v['nickid']==400){
                    if(count($r)==1){
                            $fields[]='rebate';
                            $values[]=0.4;
                    }else{
                            $fields[]='rebate';
                            $values[]=0.1;
                    }
            }
            if($v['nickid']==800){
                    if(count($r)==1){
                            $fields[]='rebate';
                            $values[]=0.5;
                    }
                    if(count($r)==3){
                            $fields[]='rebate';
                            $values[]=0.1;
                    }
                    if(count($r)==2){
                            $fields[]='rebate';
                            if($start['nickid']==100){
                                    $values[]=0.2;
                            }else{
                                    $values[]=0.1;
                            }
                    }
            }
            $_v=[];
            foreach($values as $v1){
                    $_v[]="'". $v1."'";
            }
            $sql="insert into sxh_account_point_log (".join(",",$fields).") values(".join(",",$_v).")";
            DB::execute($sql);
        }		
    }*/
    
}
