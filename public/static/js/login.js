$(function(){
		
		var remain_time = parseInt(getCookie('remain_time'));

		if(remain_time > 0){
			$('.btn_verify').unbind('click');
			var timer = setInterval(function(){
						remain_time--;
						setCookie('remain_time',remain_time);
						if(remain_time > 0){
							$(".btn_verify").html(remain_time+ "秒后重新获取");
						}else{
							clearInterval(timer);
							$(".btn_verify").html("获取验证码");
							$(".btn_verify").bind('click',sendVerify);
						}
						
				},1000)
		}else{
			setCookie('remain_time',0,-1);
			$(".btn_verify").bind('click',sendVerify);
			$(".btn_verify").html("获取验证码");
		}

	// 登录账号
	$("#login").click(function(){
		//用户名
		var username = $.trim($("#username").val());
		//密码
		var password = $.trim($("#password").val());
		//验证码
		var code     = $.trim($("#code").val());

		if(username == ''){
			layer.msg('请输入用户名');
			return false;
		}

		if(password == ''){
			layer.msg('请输入密码');
			return false;
		}

		if(code == ''){
			layer.msg('请输入验证码');
			return false;
		}

		$.ajax({
			url:"/user/index/login",
			type:"post",
			data:{
				username:username,
				password:password,
				code:code
			},
			success:function(data){
				if(data.errorCode==0){
					sessionStorage.setItem('username',$("input[type='text']").val());
					setCookie('remain_time',0,-1);
					window.location.href="/member/sys_work/index"
				}else{
					layer.msg(data.errorMsg);
				}
			}
		})
	})
})

//获取cookie
function getCookie(c_name)
{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=")
	  if (c_start!=-1)
	    { 
	    c_start=c_start + c_name.length+1 
	    c_end=document.cookie.indexOf(";",c_start)
	    if (c_end==-1) c_end=document.cookie.length
	    return unescape(document.cookie.substring(c_start,c_end))
	    } 
	  }
	return ""
}

//设置cookie
function setCookie(c_name,value,expiredays)
{
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

//发送短信验证码
function sendVerify()
{
	//解除事件绑定
	$('.btn_verify').unbind('click');
	var i = 60;
	var func = arguments.callee;
	var username = $.trim($("#username").val());
	if(username == ''){
		layer.msg('请输入用户名');
		return false;
	}

	$.ajax({
		url:"/user/index/send_verify",
		type:"post",
		async:true,
		data:{
			username:username
		},
		success:function(data){
			if(data.errorCode==0){
				
				var time = setInterval(function(){
					i--;
					setCookie('remain_time',i);
					if(i==0){
						  clearInterval(time);
						  setCookie('remain_time',0,-1);
						  $('.btn_verify').bind('click',func);
						  $(".btn_verify").html("获取验证码");
						  
					 }else{
					 		$(".btn_verify").html(i+ "秒后重新获取");
					 }
				 },1000)
			}else{
				layer.msg(data.errorMsg);
			}
		}
	})
}


 

