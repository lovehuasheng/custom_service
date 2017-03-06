$(document).ready(function(){
	$("#btn1").on("click",function(){
		var user=$("#userinfo").data("user",''); 
		var msg=[];
		if($("#userinfo [flag='info-tonick']").val()==0){
			msg.push("请选择要变动后的等级");
		}
		/*if($("#userinfo [flag='info-tonick']").val()==user.nickid){
			msg.push("请选择要变动后的等级");
		}*/
		/*if(!/^\d{4}\-\d{2}\-\d{2}$/.test($("#userinfo [flag='info-date']").val())){
			msg.push("请选择变动日期");
		}*/
		if(msg.length>0)return alert(msg.join("\n"));
                user.name=$("#info-name").val();
                user.userid=$("#info-id").val();
                user.nickname=$("#userinfo [flag='info-nickname']").html();
		user.tonickid=$("#userinfo [flag='info-tonick']").val();
		user.changedate=$("#userinfo [flag='info-date']").val();
		user.tonickname=$("#userinfo [flag='info-tonick'] option[value='"+user.tonickid+"']").html();
		confirm(user);		
	});
	$("#btn1").attr("disabled","disabled");
	setUserPanel();
	$("#btnUser").on("click",function(){
		var username=$.trim($("#queryUser").val());
		if(username=="") return alert("请输入用户登录名");
		setUserPanel();
		queryUser($("#queryUser").val(),setUserPanel);
	});
	$("#btnUpdate").on("click",function(){
		var user=$("#confirmDiv").data("user");
		var o={};
		o.userid=user.userid;
		o.tonickid=user.tonickid;
		o.update=user.changedate;
			$.ajax({
				url:window._update_user,
				data:o,
				type:'post',
				success:function(re){
	                $('#confirmDiv').modal('hide');
					if(!__fliter(re)) return;
					setUserPanel();
					$("#queryUser").val('')
					alert("修改用户等级成功");
				}
			});		
	});
});
function queryUser(username,cb){
	var o={};
	o.username=username;
	$.ajax({
		url:window._query_user,
		data:o,
		type:'post',
		context:{options:o,cb:cb},
		success:function(re){
			if(!__fliter(re)) return;
			var data=re.result;
			var o={};
			if(data=='null'||data==undefined||data==''){
				alert("请输入个人用户用户名")
			}else{
				o.userid=data.userid;
				o.name=data.name;
				o.username=this.options.username;
				o.nickid=data.nicknum;
				o.nickname=data.nickname;
			    this.cb(o)
		    }				
		}
	});
}
function setUserPanel(data){
	var o={};
	if(data==undefined){
		o.userid=-1;
		o.username="";
		o.name="";
		o.nickid=-1;
		o.nickname="";
	}else{
		o=data;
	}
	if(o.userid==-1){
		$("#userinfo [flag='info-title']").html("请选择一个用户进行修改");
		$("#userinfo [flag='info-name']").html("未选择用户");
                $("#info-name").val("");
                $("#info-id").val(o.userid);
		$("#userinfo [flag='info-nickname']").html("未选择用户");
		$("#userinfo [flag='info-tonick']").val(0);
		$("#userinfo [flag='info-date']").val("");
		$("#btn1").attr("disabled","false").html('<span class="glyphicon glyphicon-remove"></span> 不可操作');;
		
	}else{
		$("#userinfo [flag='info-title']").html("已选定用户，请进行设置操作");
		$("#userinfo [flag='info-name']").html(o.username + " " + o.name);
                $("#info-name").val(o.name);
                $("#info-id").val(o.userid);
		$("#userinfo [flag='info-nickname']").html(o.nickname);
		$("#userinfo [flag='info-tonick']").val(0);
		$("#userinfo [flag='info-date']").val("");
		$("#btn1").removeAttr("disabled").html('<span class="glyphicon glyphicon-edit"> </span> 变动用户 [<strong>'+o.name+'</strong>] 身份');
	}
}
function confirm(user){
	$("#confirmDiv [flag='name']").html(user.name);
	$("#confirmDiv [flag='nickname']").html(user.nickname);
	$("#confirmDiv [flag='tonickname']").html(user.tonickname);
	$("#confirmDiv [flag='changedate']").html(user.changedate);
	$("#confirmDiv").data("user",user);
	$('#confirmDiv').modal();
}
