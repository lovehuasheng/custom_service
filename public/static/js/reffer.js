$(document).ready(function(){
	$("#btn1").on("click",function(){
		var user=$("#userinfo").data("user",''); 
		var msg=[];
		if($("#rid").val()==$("#r_id").val()){
			msg.push("请选择要变动推荐人");
		}
                if($("#r_id").val() == 'error'){
			msg.push("请选择正确的推荐人");
		}
                if($("#r_id").val() == 0){
			msg.push("请选择正确的推荐人");
		}
		
		/*if(msg.length>0)return alert(msg.join("\n"));*/
                user.name=$("#info-name").val();
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
        $("#rn_id").blur(function(){
            $("#userinfo [flag='i-name']").html(''+':'+'');
            $("#r_id").val(0);
            var o = {};
            o.rn_id =  $(this).val();
            if(o.rn_id == $("#rid").val()){
                alert("变更前后推荐人不能一样");
                return false;
            }
            $.ajax({
                url:window._query_user_ref,
                data:o,
                type:'post',
                success:function(re){
                    var d = re.result;
                    if(!__fliter(re)) return;
                    $("#userinfo [flag='i-name']").html(d.username+':'+d.name);
                    $("#r_id").val(d.userid);
                    $("#r_username").val(d.username);
                    $("#r_realname").val(d.name);
                },
                error:function(){
                    $("#userinfo [flag='i-name']").html("<div style='color:red;'>请填写正确的推荐人ID</div>");
                    $("#r_id").val('error');
                    $("#r_username").val('');
                    $("#r_realname").val('');
                }
            });
        })
	$("#btnUpdate").on("click",function(){
		var user=$("#confirmDiv").data("user");
		var o={};
		o.userid=$("#info-id").val();
        o.o_ref=$("#rid").val();
		o.n_ref=$("#rn_id").val();
        o.update=$("#info-date").val();
		if(!/^\d+$/.test(o.n_ref)){
			alert("请输入推荐ID");
			return false;
		}
       
		$.ajax({
			url:window._update_user,
			data:o,
			type:'post',
			success:function(re){
                $('#confirmDiv').modal('hide');
				if(!__fliter(re)) return;
				setUserPanel();
                $("#queryUser").val("")
                $(".panel [flag='info-name']").html("未选择用户");
                $(".panel [flag='r-name']").html("未选择用户");
                $("#rn_id").val("");
                $(".panel [flag='i-name']").html("未选择用户");
				alert("更改推荐人成功");   
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
            if(data=='null'||data==undefined||data==''){
                alert("请输入个人用户用户名")
            }else{
               var o={};
                o.userid=data.userid;
                            o.rid=data.rid;
                o.name=data.name;
                            o.r_name=data.r_name;
                            o.r_realname=data.realname;
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
                o.rid=0;
		o.r_name="";
                o.r_realname="";
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
                $("#userinfo [flag='r-name']").val("");
                $("#rid").val(0);
		$("#userinfo [flag='info-nickname']").html("未选择用户");
		$("#userinfo [flag='info-tonick']").val(0);
		$("#userinfo [flag='info-date']").val("");
		$("#btn1").attr("disabled","false").html('<span class="glyphicon glyphicon-remove"></span> 不可操作');;
		
	}else{
		$("#userinfo [flag='info-title']").html("已选定用户，请进行设置操作");
		$("#userinfo [flag='info-name']").html(o.username + " " + o.name);
                $("#info-name").val(o.name);
                $("#info-id").val(o.userid);
                $("#userinfo [flag='r-name']").html(o.r_name+":"+o.r_realname);
                $("#rid").val(o.rid);
		$("#userinfo [flag='info-nickname']").html(o.nickname);
		$("#userinfo [flag='info-tonick']").val(0);
		$("#userinfo [flag='info-date']").val("");
		$("#btn1").removeAttr("disabled").html('<span class="glyphicon glyphicon-edit"> </span> 变动用户 [<strong>'+o.name+'</strong>] 的推荐人');
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
