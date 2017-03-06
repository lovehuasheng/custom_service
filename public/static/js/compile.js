/**
 * Created by shanfubao on 2016/11/7.
 */

$(function(){
	//选择发送通知
    $(document).on("click",".inform div label span",function(){
        $(".inform div label span").removeClass("img")
        $(this).addClass("img");
		console.log($(this).parents("div").attr("flag"));
	})
	//审核通过
	$(document).on("click",".tongg span",function(){
        $(this).addClass("active").parent().siblings().find("span").removeClass("active");
		console.log($(this).attr("flag"));
    });
	//通知记录
    $(document).on("click",'#tianjia',function(){
        $('.beizhu').toggle()
    });
    /*重置*/
	$(".reset").click(function(){
		 $(".username").val("");
		 $(".name").val("");
		 $(".phone").val("");
		 $(".alipay_account").val("");
		 $(".weixin_account").val("");
		 $(".card_id").val("");
		 $(".sun_02").css("background","url('images/jingling.png') 0 0");
	})
	// 鼠标失去焦点  按钮变红
    $(".sun_01").blur(function(){
        if($(this).val()!=""){
            $(this).prev().css("background","url('images/jingling.png') 228px 0px");
        }
    })
	window._data={};
	/*搜索*/
	$(".sousuo").click(function(){
		var username=$(".username").val();
		var name=$(".name").val();
		var phone=$(".phone").val();
		var alipay_account=$(".alipay_account").val();
		var weixin_account=$(".weixin_account").val();
		var card_id=$(".card_id").val();
		window._data={};
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				username:username,
				name:name,
				phone:phone,
				alipay_account:alipay_account,
				weixin_account:weixin_account,
				card_id:card_id
			},
			success:function(data){
				if(data.errorCode){
					alert(data.errorMsg);
				}
				var data=data.result.user_list;
				setGrid(data);
			}
		})
	});
	/**提交编辑*/
	$(document).on("click",".redact",function(){
		var user_id=$(".ipt_01").val();
		var name=$(".ipt_02").val();
		var phone=$(".ipt_03").val();
		var email=$(".ipt_04").val();
		var alipay_account=$(".ipt_05").val();
		var weixin_account=$(".ipt_06").val();
		var bank_name=$(".ipt_07").val();
		var bank_account=$(".ipt_08").val();
		var remark=$(".baizhu1 textarea").val();
		$.ajax({
			url:"/member/user_info/update_user_info",
			type:"post",
			data:{
				user_id:user_id,
				name:name,
				phone:phone,
				email:email,
				alipay_account:alipay_account,
				weixin_account:weixin_account,
				bank_name:bank_name,
				bank_account:bank_account,
				remark:remark
			},
			async:true,
			success:function(data){
				if(data.errorCode){
					alert(data.errorMsg);
				}else{
					alert("提交成功！");
				}
			}
		})
	})
	/*提交审核*/
		$(".present").click(function(){
			$.ajax({
				url:"/member/user/update_audit_status",
				type:"post",
				data:{
					username:dfd,
					id:1,
					varify:1
				},
				async:true,
				success:function(data){
					if(data.errorCode){
						alert("提交成功！");
					}else{
						alert(data.errorMsg);
					}
				}
			});

		})
	/*通知发送*/ 
	$(".send").click(function(){
		$.ajax({
			url:"/member/sys_notification/notify",
			type:"post",
			data:{
				ms_tpl_id:1,
				user_id:1,
				username:xiaoming
			},
			async:true,
			success:function(data){
				if(data.errorCode==0){
					alert("发送成功！");
				}else{
					alert("发送失败")
				}
			}
		})
	});
})
function setGrid(data){
	window._data={};
	$(".tbody1").empty();
	$.each(data,function(i,o){
		if(o.status==1){
			o._status="已激活";
		}else{
		    o._status="未激活";
		}
		if(o.status==2)o._status="已冻结";
		if(o.verify==0)o._verify="已审核";
		if(o.verify==1)o._verify="未通过";
		if(o.verify==2)o._verify="已通过";
		$(".tbody1").append($("#tr_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
	});
}
$(document).ready(function(){
	/*编辑*/
	$(document).on("click","[flag='redact_btn']",function(){
		var userid=$(this).parents("tr").attr("flag");
		$("#common_temp .modal-title").html("编辑");
		$("#common_temp .modal-body").html($("#redact_temp").html());
		$("#common_temp").modal();
		$.ajax({
			url:"/member/user_info/get_user_info",
			type:"post",
			data:{
				user_id:userid
			},
			async:true,
			success:function(data){
				$("")
			}
		})
	});
	/*审核*/
	$(document).on("click","[flag='verify_btn']",function(){
	  var userid=$(this).parents("tr").attr("flag");
	  $("#common_temp .modal-title").html("审核");
	  $("#common_temp .modal-body").html($("#verify_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return user[b];}));
	  $("#common_temp").modal();
	});
	/*通知*/
	$(document).on("click","[flag='inform_btn']",function(){
	  var userid=$(this).parents("tr").attr("flag");
	  var user=window._data['k'+userid];
	  $("#common_temp .modal-title").html("通知");
	  $("#common_temp .modal-body").html($("#inform_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return user[b];}));
	  $("#common_temp").modal();
	});
});