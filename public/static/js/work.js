/**
 * Created by shanfubao on 2016/11/5.
 */
$(function(){
//刷新
$(".update").unbind("click").click(function(){
	history.go(0);   
});
//日期插件
	 $(".datetimepicker3").on("click",function(e){
        e.stopPropagation();
        $(this).lqdatetimepicker({
            css : 'datetime-day',
            dateType : 'D',
            selectback : function(){
            }
        });
    });
	//通知记录
    $('#tianjia').click(function(){
        $('.beizhu').toggle()
    });
	/*鼠标失去焦点变红*/
	 $(document).on("blur",".bh",function(){
        if($(this).val()!=""){
            $(this).parent().prev().find("span").css("background","url('/static/images/jingling.png') 228px 0px");
        }
    })
	 // 日期插件
	/*重置*/
	$(document).on("click",".replacement",function(){
		console.log($("#zuce_end").val())
		$(".bh").val("");
		$(".bh").parent().prev().find("span").css("background","url('/static/images/jingling.png') 0 0");
	});


	//查看任务量
	$(".que").unbind("click").click(function(){
		var dates=$("#zuce_end").val();
		$.ajax({
			url:"/member/sys_work/get_workload",
			type:"post",
			async:true,
			data:{
				create_date:dates
			},
			success:function(data){
				if(data.errorCode){
					layer.msg(data.errorMsg);
				}
				var data=data.result;
				$(".total").html(data.total_num);
				$(".completed").html(data.completed_num);
				$(".unfinished").html(data.unfinished_num);
				//跳转
				$(".nextPage").after("<input type='text'><span>跳转</span>");
			}
		});
		renwu(dates);
	});
	//降序
	$(".down").unbind("click").click(function(){
		var order=$(this).attr("flag");
		jiangxu(order);
	});
	//升序
	$(".up").unbind("click").click(function(){
		var order=$(this).attr("flag");
		shenxu(order);
	});
	$(document).on("click",".sousuo",function(e){
		e.preventDefault();
		$("#common_temp").modal("hide");
		var user_id=$("#firstname1").val();
		var username=$("#firstname2").val();
		var name=$("#firstname3").val();
		var phone=$("#firstname4").val();
		var alipay_account=$("#firstname5").val();
		var weixin_account=$("#firstname6").val();
		var bank_name=$("#firstname7").val();
		var bank_account=$("#firstname8").val();
		var card_id=$("#firstname9").val();
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				user_id:$("#firstname1").val(),
				username:username,
				name:name,
				phone:phone,
				alipay_account:alipay_account,
				weixin_account:weixin_account,
				bank_name:bank_name,
				bank_account:bank_account,
				card_id:card_id,
				verify:0
			},
			success:function(data){
			//分页
				sousuo(data);
				$("#tcd").show();
				if(data.errorCode){
					layer.msg(data.errorMsg);
				}
				var data=data.result.user_list;
				setGrid(data);
		}
	});
	/************提交审核*************/
				$(".look").click(function(e){
					e.preventDefault();
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
				})
				var a;
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag");
				});
				$(".ti").unbind("click").click(function(){
					if(a){
						$.ajax({
							url:"/member/user/update_audit_status",
							type:"post",
							data:{
								id:$(".hide").val(),
								verify:a
							},
							async:true,
							success:function(data){
								if(data.errorCode){
									layer.msg(data.errorMsg);
								}else{
									ajax_allto()
								if(a==2){
									$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
									}else{
										$(".verify").text("未审核").css("color","red");
									}
									a=0;
									$(".hide").val(0);
									layer.msg("提交成功！");
									$("#common_temp").modal("hide");
								}
							}
						})	
					}
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								layer.msg(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
							
						},
						error:function(){
							layer.msg("参数错误")
						}
				});

				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});
			$(".fasong").click(function(){
				$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$("#myModal").modal("hide");
								$(".imgs").removeCalss("img");
								$(".txt").val("");
							}else{
								layer.msg("发送失败")
							}
						}
					})
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				layer.msg(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			console.log("搜索加载搞定了！")
	});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//按审核状态加载
	$(".oppo").change(function(e){
		e.preventDefault();	
		var verify=$(".oppo").val();
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				verify:verify
			},
			success:function(data){
				/*分页*/
				$(".tcdPageCode").unbind("click").createPage({
					pageCount:data.result.pages.max_page,
					current:1,
					backFn:function(p){
/////////////////////////////////////////////////////////////////////////////////////////////
		var verify=$(".oppo").val();
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				verify:verify,
				page:p
			},
			success:function(data){
					$("#tcd").show();
					if(data.errorCode){
						layer.msg(data.errorMsg);
					}
					var data=data.result.user_list;
					setGrid(data);
			/************提交审核*************/
				var a;
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag")
				});
				$(".look").click(function(){
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
				});
				$(".ti").unbind("click").click(function(){
					$.ajax({
						url:"/member/user/update_audit_status",
						type:"post",
						data:{
							id:$(".hide").val(),
							verify:a
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else{
								ajax_allto()
								if(a==2){
								$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
								}else{
									$(".verify").text("未审核").css("color","red");
								}
								a=0;
								$(".hide").val(0);
								layer.msg("提交成功！");
								$("#common_temp").modal("hide");
								
							}
						}
					});
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								layer.msg(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
						},
						error:function(){
							layer.msg("参数错误")
						}
				});
				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});
			$(".fasong").unbind('click').click(function(){
					$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$("#myModal").modal("hide")
								$(".imgs").removeClass("img")
								$(".txt").val("")
							}else{
								layer.msg(data.errorMsg)
							}
						}
					});
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				layer.msg(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			
		}
	})
		console.log("按状态加载搞定了！");
//////////////////////////////////////////////////////////////////////////////////////////////
						}
					})
					$("#tcd").show();
					if(data.errorCode){
						layer.msg(data.errorMsg);
					}
					var data=data.result.user_list;
					setGrid(data);
			/************提交审核*************/
				var a;
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag")
				});
				$(".look").click(function(){
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
				});
				$(".ti").unbind("click").click(function(){
					$.ajax({
						url:"/member/user/update_audit_status",
						type:"post",
						data:{
							id:$(".hide").val(),
							verify:a
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else{
								ajax_allto()
								if(a==2){
								$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
								}else{
									$(".verify").text("未审核").css("color","red");
								}
								a=0;
								$(".hide").val(0);
								layer.msg("提交成功！");
								$("#common_temp").modal("hide");
								
							}
						}
					});
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								layer.msg(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
						},
						error:function(){
							layer.msg("参数错误")
						}
				});
				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});
			$(".fasong").unbind('click').click(function(){
					$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$("#myModal").modal("hide")
								$(".imgs").removeClass("img");
								$(".txt").val("");
							}else{
								layer.msg(data.errorMsg)
							}
						}
					});
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				layer.msg(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			
		}
	})
		console.log("按状态加载搞定了！")
	});
/*搜索*/
	$(".sousuo").click(function(e){
		e.preventDefault();
		console.log(1233);
		$("tbody").empty();
		$("#common_temp").modal("hide");
		var user_id=$("#firstname1").val();
		var username=$("#firstname2").val();
		var name=$("#firstname3").val();
		var phone=$("#firstname4").val();
		var alipay_account=$("#firstname5").val();
		var weixin_account=$("#firstname6").val();
		var bank_name=$("#firstname7").val();
		var bank_account=$("#firstname8").val();
		var card_id=$("#firstname9").val();
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				user_id:$("#firstname1").val(),
				username:username,
				name:name,
				phone:phone,
				alipay_account:alipay_account,
				weixin_account:weixin_account,
				bank_name:bank_name,
				bank_account:bank_account,
				card_id:card_id
			},
			success:function(data){
			//分页
				sousuo(data);
				$("#tcd").show();
				if(data.errorCode){
					alert(data.errorMsg);
				}
				var data=data.result.user_list;
				setGrid(data);
		}
	});
	/************提交审核*************/
				$(".look").click(function(){
					e.preventDefault();
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
				})
				var a;
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag");
				});
				$(".ti").unbind("click").click(function(){
					if(a){
						$.ajax({
							url:"/member/user/update_audit_status",
							type:"post",
							data:{
								id:$(".hide").val(),
								verify:a
							},
							async:true,
							success:function(data){
								if(data.errorCode){
									alert(data.errorMsg);
								}else{
									if(a==2){
										$(".verify").text("已审核");
										ajax_allto();
									}else{
										$(".verify").text("未审核");
										ajax_allto()
									}
									a=0;
									$(".hide").val(0);
									alert("提交成功！");
									$("#common_temp").modal("hide");
								}
							}
						})	
					}
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								alert(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
							
						},
						error:function(){
							alert("参数错误")
						}
				});

				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								alert(data.errorMsg);
							}else if(data.result==''){
								alert("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].content+"</div>"+"<div>"+data.result[i].create_time+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});
			$(".fasong").click(function(){
				$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								alert("发送成功！");
								$("#myModal").modal("hide");
								$(".imgs").removeCalss("img");
								$(".txt").val("");
							}else{
								alert("发送失败")
							}
						}
					})
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				alert(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			console.log("搜索加载搞定了！")
	});
		//////////////////////////////默认加载////////////////////////////////////////////////
	var dates = new Date();
	var years = dates.getFullYear();
    var months = dates.getMonth()+1;
    var days = dates.getDate();
    var today = years+"-"+months+"-"+days;  //今天
	$.ajax({
		url:"/member/user/get_user_list",
		type:"post",
		async:true,
		data:{
			verify:0,
			assign_date:today
		},
		success:function(data){
				//分页
				moren(data);
				$("#tcd").show();
				if(data.errorCode){
					layer.msg(data.errorMsg);
				}
				var data=data.result.user_list;
				setGrid(data);
				var a;
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag")
				});
			/************提交审核*************/
				$(".look").click(function(){
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
					var end=$(this).parent().parent().children().eq(4).text();
					if(end=="未审核"){
						a=0
					}else{
						a=1
					}
				});
				$(document).on("click",".ti",function(){
					$.ajax({
						url:"/member/user/update_audit_status",
						type:"post",
						data:{
							id:$(".hide").val(),
							verify:a
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else{
								ajax_allto();
								if(a==2){
									$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
								}else{
									$(".verify").text("未审核").css("color","red");
								}
								a=0;
								$(".hide").val(0);
								layer.msg("提交成功！");
								$("#common_temp").modal("hide");
							}
						}
					})	
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								layer.msg(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
						},
						error:function(){
							layer.msg("参数错误")
						}
				});
				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});

			$(".fasong").unbind('click').click(function(){ 
					$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$(".txt").val("");
								$("#myModal").modal("hide");
								$(".imgs").removeClass("img");
							}else{
								layer.msg(data.errorMsg)
							}
						}
					});
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				layer.msg(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			console.log("默认加载搞定了！");
		}
	});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(".PagesCode").unbind("click").click(function(){
	$.ajax({
		url:"/member/user/get_user_list",
		type:"post",
		async:true,
		data:{
			verify:0
		},
		success:function(data){
		///*分页*/
	$(".tcdPageCode").unbind("click").createPage({
		pageCount:data.result.pages.max_page,
		current:$(".pageCode").val(),
		backFn:function(p){
	//分页
	/////////////////////////////////////////////////////////////////////////////////////////
			$.ajax({
				url:"/member/user/get_user_list",
				type:"post",
				async:true,
				data:{
					page:p,
					verify:0
				},
				success:function(data){
						$("#tcd").show();
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}
						var data=data.result.user_list;
						setGrid(data);
					/************提交审核*************/
						$(document).on("click",".aaa",function(){
							a = $(this).attr("flag")
						});
						var a 
						$(".look").click(function(){
							$("td").removeClass("verify");
							$(this).parent().parent().children().eq(4).addClass("verify");
							$(this).parent().parent().children().eq(3).text();
						});
						$(".ti").click(function(){
							layer.msg("加载中")
							$.ajax({
								url:"/member/user/update_audit_status",
								type:"post",
								data:{
									id:$(".hide").val(),
									verify:a
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else{
									ajax_allto()
										if(a==2){
										$(".verify").text("已审核");
										var id = $(".hide").val();
										$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
										$(".verify").text("已审核");
										
										}else{
											$(".verify").text("未审核").css("color","red");
										}
										a=0;
										$(".hide").val(0);
										layer.msg("提交成功！");
										$("#common_temp").modal("hide");
									}
								}
							})	
						});
				/*****************审核end******************/

				/*****************通知******************/
				$(".message").click(function(){
						var username = $(this).parent().parent().children().eq(1).text();
						var names = $(this).parent().parent().children().eq(2).text();
						var ids = $(this).parent().parent().children().eq(0).text();
						var status
							if($(this).parent().parent().children().eq(4).text()=="已审核"){
								status = 0
							}else{
								status = 1
							}
						var phone = $(this).parent().parent().children().eq(11).text();
						$(".user_name").html(username);
						$(".names").html(names)
						$.ajax({
								url:"/member/sys_msg_tpl/get_msg_tpl_list",
								type:"post",
								data:{
									status:status
								},
								async:true,
								sucess:function(data){
									if(!data.errorCode){
										layer.msg(data.errorMsg);
									}
									$(".inform").empty();
									$.each(data,function(i,o){
										var html='<div class="zhangh1">'
												'<label><span class="img"></span>'+o.title+' : </label>'
												'<div>'+o.content+'</div>'
											'</div><!-- <br> -->';
									})
								},
								error:function(){
									layer.msg("参数错误")
								}
						});
						/******************通知记录*******************/
						$(".btnss").click(function(){
							$(".record").toggle();
							$.ajax({
								url:"/member/sys_notification/get_notification_list",
								type:"post",
								data:{
									user_id:ids
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else if(data.result==''){
										layer.msg("通知为空")
									}else{
										for(var i=0,html;i<data.result.length;i++){
											html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
										}
										var n=html.substring(9)
										$(".record").html(n);
									}	
								}
							})
						})
					/******************查看通知end*******************/
					/***********发送通知*************/
					var ms_tpl_id;
					var muns = 1;
					$(".imgs").click(function(){
						if(muns==1){
							$(".imgs").removeClass("img")
							$(this).addClass("img")
							ms_tpl_id = $(this).attr("flag")
							muns=0;
						}else{
							$(".imgs").removeClass("img")
							ms_tpl_id = "";	
							muns = 1;
						}
					});
					$(".fasong").unbind('click').click(function(){
							$.ajax({
								url:"/member/sys_notification/notify",
								type:"post",
								data:{
									ms_tpl_id:ms_tpl_id,
									user_id:ids,
									username:username,
									content:$(".txt").val(),
									phone:phone
								},
								async:true,
								success:function(data){
									if(data.errorCode==0){
										layer.msg("发送成功！");
										$("#myModal").modal("hide");
										$(".imgs").removeClass("img")
										$(".txt").val("");
									}else{
										layer.msg(data.errorMsg)
									}
								}
							});
					})
					/***********通知end*************/
					
					/***********查看身份证信息*************/
					$(".chakan_id").click(function(){
						layer.msg(123)
					})
					/***********查看身份证信息end*************/
				})
				/*****************通知end******************/
					console.log("默认加载搞定了！");
				}
			})
	}
});
		/////////////////////////////////////////////////////////////////////////////////
				$("#tcd").show();
				if(data.errorCode){
					layer.msg(data.errorMsg);
				}
				var data=data.result.user_list;
				setGrid(data);
			/************提交审核*************/
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag")
				});
				var a;
				$(".look").click(function(){
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
					$(this).parent().parent().children().eq(3).text();
				});
				$(document).on("click",".ti",function(){
					$.ajax({
						url:"/member/user/update_audit_status",
						type:"post",
						data:{
							id:$(".hide").val(),
							verify:a
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else{
								ajax_allto()
								if(a==2){
									$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
								}else{
									$(".verify").text("未审核").css("color","red");
								}
								a=0;
								$(".hide").val(0);
								layer.msg("提交成功！");
								$("#common_temp").modal("hide");
							}
						}
					})	
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
					url:"/member/sys_msg_tpl/get_msg_tpl_list",
					type:"post",
					data:{
						status:status
					},
					async:true,
					sucess:function(data){
						if(!data.errorCode){
							layer.msg(data.errorMsg);
						}
						$(".inform").empty();
						$.each(data,function(i,o){
							var html='<div class="zhangh1">'
									'<label><span class="img"></span>'+o.title+' : </label>'
									'<div>'+o.content+'</div>'
								'</div><!-- <br> -->';
						})
					},
					error:function(){
						layer.msg("参数错误")
					}
				});
				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});

			$(".fasong").unbind('click').click(function(){ 
					$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$(".txt").val("");
								$("#myModal").modal("hide");
								$(".imgs").removeClass("img");
							}else{
								layer.msg(data.errorMsg)
							}
						}
					});
			})
			/***********通知end*************/
		})
		$(".tcdNumber").hide();
		/*****************通知end******************/
			console.log("默认加载搞定了！");
		}
	});
})
/***************************function 结束标签******************************/
}); 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*任务量及分配*/
function ajax_allto(){
	$.ajax({
		url:"/member/sys_work/get_workload",
		type:"post",
		async:true,
		success:function(data){
			if(data.errorCode){
				layer.msg(data.errorMsg);
			}
			var data=data.result;
			$(".total").html(data.total_num);
			$(".completed").html(data.completed_num);
			$(".unfinished").html(data.unfinished_num);
			//跳转
			$(".nextPage").after("<input type='text'><span>跳转</span>");
		}
	});
}
/*默认数据加载*/
function setGrid(data){
	$(".tbody1").empty();
	$.each(data,function(i,o){
		if(o.status==1){
			o._status='已激活';
		}else{
			o._status='未激活';
		}
		//if(o.status==2)o._status="已冻结"
		if(o.verify == 1)o._verify="未通过";
		if(o.verify == 0)o._verify="未审核";
		if(o.verify == 2)o._verify="已通过";
		o.update_time = new Date(parseInt(o.update_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
		o.create_time = new Date(parseInt(o.create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
		$(".tbody1").append($("#tr_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
		if(o.update_status == 0){
			$(".tbody1 tr").eq(i).children(".emve").css("color","#000");
		}else if(o.update_status == 1 && o.verify == 0 ){
			$(".tbody1 tr").eq(i).children(".emve").css("color","#f00");
		}else if(o.update_status == 2) {
		   $(".tbody1 tr").eq(i).children("td").children(".gen").css('color','#0f0');
		}
	});
}
function look(id){
	$(".hide").val(id);
}
$(document).ready(function(){
//查看的显示
$(document).on("click","[flag='look_btn']",function(){
	//获取当前的ID
	var userid=$(this).parents("tr").attr("flag");
	var child=$(this).parents("tr").children().eq(1).text();
	//获取数据
	$.ajax({
		url:"/member/user_info/get_user_info",
		type:"post",
		async:true,
		data:{
			user_id:userid
		},
		success:function(data){
			if(data.errorCode){
				layer.msg(data.errorMsg);
			}
			//处理手机号和银行卡号的显示
			var mun = String(data.result.card_id)
			var mun_2 = String(data.result.bank_account);
			var mobile = String(data.result.phone);
			var new_mobile = mobile.split("").reverse().join("");
			data.result.card_id =  mun.substring(0,3)+' '+mun.substring(3,6)+' '+mun.substring(6,10)+' '+mun.substring(10,14)+' '+mun.substring(14,18);
			data.result.bank_account = '';
			var tmp_tel  = '';
			var len = Math.ceil((mun_2.length)/4);
			for(var i=0;i<len;i++){
			    data.result.bank_account += mun_2.substring((i*4),((i*4)+4))+' ';
			    tmp_tel += new_mobile.substring((i*4),((i*4)+4))+' ';
		        }
			data.result.phone  = tmp_tel.split("").reverse().join("");
			//处理结束
			$("#common_temp .modal-title").html("查看");
			if(data.result.image_a==null||data.result.image_b==null||data.result.image_c==null){
				$("#chakan").html("照片不全！");
			}
			$("#common_temp .modal-body").html($("#look_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return data.result[b];}));
			$("#common_temp").modal();
			$(".sen").html(child);
			//照片查看
			$("#chakan").click(function(){
				$("#imgs").show(300);	
				$(".users").empty();
				$("#tp1 a").attr("href",data.result.image_a);
				$("#tp2 a").attr("href",data.result.image_b);
				$("#tp3 a").attr("href",data.result.image_c);
				$("#tp4").attr("src",data.result.image_a);
				$("#tp5").attr("src",data.result.image_b);
				$("#tp6").attr("src",data.result.image_c);
		        $("#pbImage").before("<div class='users'><label>姓名 :<span id='name'></span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label>身份证 :<span id='identity'></span></label></div>"); 
		        $("#name").html(data.result.name);
				$("#identity").html(data.result.card_id);
				$("#main p img").click(function(){
					$(".users").show();
				})
				$("#pbOverlay").click(function(){
					$(".users").hide();	
				});
			})
			//关闭弹窗
			$(".out").click(function(){
				$("#imgs").hide(300);
				$(".users").remove();
			})
		}
	})
})
/*审核*/
$(document).on("click","[flag='veri_btn']",function(){
	//获取当前ID
	var userid=$(this).parents("tr").attr("flag");
	var username=$(this).parents("tr").children().eq(1).text();
	var verify=$(this).parents("tr").children().eq(4).text();
	//获取数据 'k'是把数据变成哈希表
	$("#common_temp .modal-title").html("审核");
	$("#common_temp .modal-body").html($("#veri_temp").html());
	$(".account").html(username);
	$(".state").html(verify);
	//判断方法一
	//$(".state").html()=="已审核"?$(".s1").addClass("active"):$(".s2").addClass("active");
	//判断方法二
	/*$(".state").html()=="已审核"&&$(".s1").addClass("active")
	$(".state").html()=="未审核"&&$(".s2").addClass("active")*/
	//判断方法三
	$(".state").html()=="已审核"||$(".s2").addClass("active")
	$(".state").html()=="未审核"||$(".s1").addClass("active")
	$("#common_temp").modal();
});
//审核通过
var verify;
$(document).on("click",".tongg span",function(){
	$(this).addClass("active").parent().siblings().find("span").removeClass("active");
	return verify = $(this).attr("flag");
});
/*搜索弹出框*/
	$(document).on("click","[flag='seek_btn']",function(){
		$("#common_temp .modal-title").html("搜索");
		$("#common_temp .modal-body").html($("#seek_temp").html());
		$("#common_temp").modal();
		//手机号验证 
		var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
		$("#firstname9").blur(function(){
			var id=$("#firstname9").val();
			if (reg.test(id) == false){
			    layer.msg("身份证输入不合法");
			    return false;
			}  
		})
		//身份证号验证
		var re = /^(1[358][0-9]{9})$/;
		$("#firstname4").blur(function(){
			var ss = $("#firstname4").val();
	        if (re.test(ss)==false) {
	            layer.msg("手机号码输入不合法");
	            return false; 
	        }
		});
	});
});
function  sousuo(data){
	/*分页*/
	$(".tcdPageCode").unbind("click").createPage({
		pageCount:data.result.pages.max_page,
		current:1,
		backFn:function(p){
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var user_id=$("#firstname1").val();
		var username=$("#firstname2").val();
		var name=$("#firstname3").val();
		var phone=$("#firstname4").val();
		var alipay_account=$("#firstname5").val();
		var weixin_account=$("#firstname6").val();
		var bank_name=$("#firstname7").val();
		var bank_account=$("#firstname8").val();
		var card_id=$("#firstname9").val();
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				user_id:user_id,
				username:username,
				name:name,
				phone:phone,
				alipay_account:alipay_account,
				weixin_account:weixin_account,
				bank_name:bank_name,
				bank_account:bank_account,
				card_id:card_id,
				page:p
			},
			success:function(data){
				$("#tcd").show();
				if(data.errorCode){
					layer.msg(data.errorMsg);
				}
				var data=data.result.user_list;
				setGrid(data);
		}
	});
	/************提交审核*************/
				$(".look").click(function(){
					e.preventDefault();
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
				})
				var a;
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag");
				});
				$(".ti").unbind("click").click(function(){
					if(a){
						$.ajax({
							url:"/member/user/update_audit_status",
							type:"post",
							data:{
								id:$(".hide").val(),
								verify:a
							},
							async:true,
							success:function(data){
								if(data.errorCode){
									layer.msg(data.errorMsg);
								}else{
								ajax_allto()
									if(a==2){
								$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
									}else{
										$(".verify").text("未审核").css("color","red");
									}
									a=0;
									$(".hide").val(0);
									layer.msg("提交成功！");
									$("#common_temp").modal("hide");
								}
							}
						})	
					}
				});
		/*****************审核end******************/
		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								layer.msg(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
							
						},
						error:function(){
							layer.msg("参数错误")
						}
				});

				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
								layer.msg(123);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});
			$(".fasong").click(function(){
				$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$("#myModal").modal("hide");
								$(".imgs").removeClass("img");
								$(".txt").val("");
							}else{
								layer.msg("发送失败")
							}
						}
					})
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				layer.msg(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			console.log("搜索加载搞定了！")
				}
			});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
function moren(data){
	/*分页*/
	$(".tcdPageCode").unbind("click").createPage({
		pageCount:data.result.pages.max_page,
		current:1,
		backFn:function(p){
	//分页
	/////////////////////////////////////////////////////////////////////////////////////////
	
			$.ajax({
				url:"/member/user/get_user_list",
				type:"post",
				async:true,
				data:{
					page:p,
					verify:0
				},
				success:function(data){
						$("#tcd").show();
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}
						var data=data.result.user_list;
						setGrid(data);
					/************提交审核*************/
						$(document).on("click",".aaa",function(){
							a = $(this).attr("flag")
						});
						var a 
						$(".look").click(function(){
							$("td").removeClass("verify");
							$(this).parent().parent().children().eq(4).addClass("verify");
							$(this).parent().parent().children().eq(3).text();
						});
						$(".ti").click(function(){
							console.log(213213123)
							layer.msg("加载中")
							$.ajax({
								url:"/member/user/update_audit_status",
								type:"post",
								data:{
									id:$(".hide").val(),
									verify:a
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else{
									ajax_allto()
										if(a==2){
										$(".verify").text("已审核");
										var id = $(".hide").val();
										$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
										$(".verify").text("已审核");
										
										}else{
											$(".verify").text("未审核").css("color","red");
										}
										a=0;
										$(".hide").val(0);
										layer.msg("提交成功！");
										$("#common_temp").modal("hide");
										
									}
								}
							})	
						});
				/*****************审核end******************/

				/*****************通知******************/
				$(".message").click(function(){
						var username = $(this).parent().parent().children().eq(1).text();
						var names = $(this).parent().parent().children().eq(2).text();
						var ids = $(this).parent().parent().children().eq(0).text();
						var status
							if($(this).parent().parent().children().eq(4).text()=="已审核"){
								status = 0
							}else{
								status = 1
							}
						var phone = $(this).parent().parent().children().eq(11).text();
						$(".user_name").html(username);
						$(".names").html(names)
						$.ajax({
								url:"/member/sys_msg_tpl/get_msg_tpl_list",
								type:"post",
								data:{
									status:status
								},
								async:true,
								sucess:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}
									$(".inform").empty();
									$.each(data,function(i,o){
										var html='<div class="zhangh1">'
												'<label><span class="img"></span>'+o.title+' : </label>'
												'<div>'+o.content+'</div>'
											'</div><!-- <br> -->';
									})
								},
								error:function(){
									layer.msg("参数错误")
								}
						});
						/******************通知记录*******************/
						$(".btnss").click(function(){
							$(".record").toggle();
							$.ajax({
								url:"/member/sys_notification/get_notification_list",
								type:"post",
								data:{
									user_id:ids
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else if(data.result==''){
										layer.msg("通知为空")
									}else{
										for(var i=0,html;i<data.result.length;i++){
											html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
										}
										var n=html.substring(9)
										$(".record").html(n);
									}	
								}
							})
						})
					/******************查看通知end*******************/
					/***********发送通知*************/
					var ms_tpl_id;
					var muns = 1;
					$(".imgs").click(function(){
						if(muns==1){
							$(".imgs").removeClass("img")
							$(this).addClass("img")
							ms_tpl_id = $(this).attr("flag")
							muns=0;
						}else{
							$(".imgs").removeClass("img")
							ms_tpl_id = "";	
							muns = 1;
						}
					});
					$(".fasong").unbind('click').click(function(){
							$.ajax({
								url:"/member/sys_notification/notify",
								type:"post",
								data:{
									ms_tpl_id:ms_tpl_id,
									user_id:ids,
									username:username,
									content:$(".txt").val(),
									phone:phone
								},
								async:true,
								success:function(data){
									if(data.errorCode==0){
										layer.msg("发送成功！");
										$("#myModal").modal("hide");
										$(".imgs").removeClass("img")
										$(".txt").val("");
									}else{
										layer.msg(data.errorMsg)
									}
								}
							});
					})
					/***********通知end*************/
					
					/***********查看身份证信息*************/
					$(".chakan_id").click(function(){
						layer.msg(123)
					})
					/***********查看身份证信息end*************/
				})
				/*****************通知end******************/
					console.log("默认加载搞定了！");
				}
			})
	}
});
}
function shenxu(order){
	$.ajax({
		url:"/member/user/get_user_list",
		type:"post",
		async:true,
		data:{
			verify:0,
			order:order
		},
		success:function(data){
	$(".tcdPageCode").unbind("click").createPage({
		pageCount:data.result.pages.max_page,
		current:1,
		backFn:function(p){
	//分页
	/////////////////////////////////////////////////////////////////////////////////////////
	var order=$(".up").attr("flag");
			$.ajax({
				url:"/member/user/get_user_list",
				type:"post",
				async:true,
				data:{
					page:p,
					verify:0,
					order:order
				},
				success:function(data){
						$("#tcd").show();
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}
						var data=data.result.user_list;
						setGrid(data);
					/************提交审核*************/
						$(document).on("click",".aaa",function(){
							a = $(this).attr("flag")
						});
						var a 
						$(".look").click(function(){
							$("td").removeClass("verify");
							$(this).parent().parent().children().eq(4).addClass("verify");
							$(this).parent().parent().children().eq(3).text();
						});
						$(".ti").click(function(){
							console.log(213213123)
							layer.msg("加载中")
							$.ajax({
								url:"/member/user/update_audit_status",
								type:"post",
								data:{
									id:$(".hide").val(),
									verify:a
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else{
									ajax_allto()
									if(a==2){
									$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
										}else{
											$(".verify").text("未审核").css("color","red");
										}
										a=0;
										$(".hide").val(0);
										layer.msg("提交成功！");
										$("#common_temp").modal("hide");
										
									}
								}
							})	
						});
				/*****************审核end******************/

				/*****************通知******************/
				$(".message").click(function(){
						var username = $(this).parent().parent().children().eq(1).text();
						var names = $(this).parent().parent().children().eq(2).text();
						var ids = $(this).parent().parent().children().eq(0).text();
						var status
							if($(this).parent().parent().children().eq(4).text()=="已审核"){
								status = 0
							}else{
								status = 1
							}
						var phone = $(this).parent().parent().children().eq(11).text();
						$(".user_name").html(username);
						$(".names").html(names)
						$.ajax({
								url:"/member/sys_msg_tpl/get_msg_tpl_list",
								type:"post",
								data:{
									status:status
								},
								async:true,
								sucess:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}
									$(".inform").empty();
									$.each(data,function(i,o){
										var html='<div class="zhangh1">'
												'<label><span class="img"></span>'+o.title+' : </label>'
												'<div>'+o.content+'</div>'
											'</div><!-- <br> -->';
									})
								},
								error:function(){
									layer.msg("参数错误")
								}
						});
						/******************通知记录*******************/
						$(".btnss").click(function(){
							$(".record").toggle();
							$.ajax({
								url:"/member/sys_notification/get_notification_list",
								type:"post",
								data:{
									user_id:ids
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else if(data.result==''){
										layer.msg("通知为空")
									}else{
										for(var i=0,html;i<data.result.length;i++){
											html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
										}
										var n=html.substring(9)
										$(".record").html(n);
									}	
								}
							})
						})
					/******************查看通知end*******************/
					/***********发送通知*************/
					var ms_tpl_id;
					var muns = 1;
					$(".imgs").click(function(){
						if(muns==1){
							$(".imgs").removeClass("img")
							$(this).addClass("img")
							ms_tpl_id = $(this).attr("flag")
							muns=0;
						}else{
							$(".imgs").removeClass("img")
							ms_tpl_id = "";	
							muns = 1;
						}
					});
					$(".fasong").unbind('click').click(function(){
							$.ajax({
								url:"/member/sys_notification/notify",
								type:"post",
								data:{
									ms_tpl_id:ms_tpl_id,
									user_id:ids,
									username:username,
									content:$(".txt").val(),
									phone:phone
								},
								async:true,
								success:function(data){
									if(data.errorCode==0){
										layer.msg("发送成功！");
										$("#myModal").modal("hide");
										$(".imgs").removeClass("img")
										$(".txt").val("");
									}else{
										layer.msg(data.errorMsg)
									}
								}
							});
					})
					/***********通知end*************/
					
					/***********查看身份证信息*************/
					$(".chakan_id").click(function(){
						layer.msg(123)
					})
					/***********查看身份证信息end*************/
				})
				/*****************通知end******************/
					console.log("默认加载搞定了！");
				}
			})
	}
});
		$("#tcd").show();
		if(data.errorCode){
			layer.msg(data.errorMsg);
		}
		var data=data.result.user_list;
		setGrid(data);
			/************提交审核*************/
				$(document).on("click",".aaa",function(){
					a = $(this).attr("flag")
				});
				var a;
				$(".look").click(function(){
					$("td").removeClass("verify");
					$(this).parent().parent().children().eq(4).addClass("verify");
					$(this).parent().parent().children().eq(3).text();
				});
				$(document).on("click",".ti",function(){
					$.ajax({
						url:"/member/user/update_audit_status",
						type:"post",
						data:{
							id:$(".hide").val(),
							verify:a
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else{
								ajax_allto()
								if(a==2){
									$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
								}else{
									$(".verify").text("未审核").css("color","red");
								}
								a=0;
								$(".hide").val(0);
								layer.msg("提交成功！");
								$("#common_temp").modal("hide");
							}
						}
					})	
				});
		/*****************审核end******************/

		/*****************通知******************/
		$(".message").click(function(){
				var username = $(this).parent().parent().children().eq(1).text();
				var names = $(this).parent().parent().children().eq(2).text();
				var ids = $(this).parent().parent().children().eq(0).text();
				var status
					if($(this).parent().parent().children().eq(4).text()=="已审核"){
						status = 0
					}else{
						status = 1
					}
				var phone = $(this).parent().parent().children().eq(11).text();
				$(".user_name").html(username);
				$(".names").html(names)
				$.ajax({
						url:"/member/sys_msg_tpl/get_msg_tpl_list",
						type:"post",
						data:{
							status:status
						},
						async:true,
						sucess:function(data){
							if(!data.errorCode){
								layer.msg(data.errorMsg);
							}
							$(".inform").empty();
							$.each(data,function(i,o){
								var html='<div class="zhangh1">'
										'<label><span class="img"></span>'+o.title+' : </label>'
										'<div>'+o.content+'</div>'
									'</div><!-- <br> -->';
							})
						},
						error:function(){
							layer.msg("参数错误")
						}
				});
				/******************通知记录*******************/
				$(".btnss").click(function(){
					$(".record").toggle();
					$.ajax({
						url:"/member/sys_notification/get_notification_list",
						type:"post",
						data:{
							user_id:ids
						},
						async:true,
						success:function(data){
							if(data.errorCode){
								layer.msg(data.errorMsg);
							}else if(data.result==''){
								layer.msg("通知为空")
							}else{
								for(var i=0,html;i<data.result.length;i++){
									html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
								}
								var n=html.substring(9)
								$(".record").html(n);
							}	
						}
					})
				})
			/******************查看通知end*******************/
			/***********发送通知*************/
			var ms_tpl_id;
			var muns = 1;
			$(".imgs").click(function(){
				if(muns==1){
					$(".imgs").removeClass("img")
					$(this).addClass("img")
					ms_tpl_id = $(this).attr("flag")
					muns=0;
				}else{
					$(".imgs").removeClass("img")
					ms_tpl_id = "";	
					muns = 1;
				}
			});

			$(".fasong").unbind('click').click(function(){ 
					$.ajax({
						url:"/member/sys_notification/notify",
						type:"post",
						data:{
							ms_tpl_id:ms_tpl_id,
							user_id:ids,
							username:username,
							content:$(".txt").val(),
							phone:phone
						},
						async:true,
						success:function(data){
							if(data.errorCode==0){
								layer.msg("发送成功！");
								$(".txt").val("");
								$("#myModal").modal("hide");
								$(".imgs").removeClass("img");
							}else{
								layer.msg(data.errorMsg)
							}
						}
					});
			})
			/***********通知end*************/
			
			/***********查看身份证信息*************/
			$(".chakan_id").click(function(){
				layer.msg(123)
			})
			/***********查看身份证信息end*************/
		})
		/*****************通知end******************/
			console.log("默认加载搞定了！");
		}
});
}
function jiangxu(order){
	$.ajax({
		url:"/member/user/get_user_list",
		type:"post",
		async:true,
		data:{
			verify:0,
			order:order
		},
		success:function(data){
				//分页
				/*分页*/
	$(".tcdPageCode").unbind("click").createPage({
		pageCount:data.result.pages.max_page,
		current:1,
		backFn:function(p){
	//分页
	/////////////////////////////////////////////////////////////////////////////////////////
	var order=$(".down").attr("flag");
			$.ajax({
				url:"/member/user/get_user_list",
				type:"post",
				async:true,
				data:{
					page:p,
					verify:0,
					order:order
				},
				success:function(data){
						$("#tcd").show();
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}
						var data=data.result.user_list;
						setGrid(data);
					/************提交审核*************/
						$(document).on("click",".aaa",function(){
							a = $(this).attr("flag")
						});
						var a 
						$(".look").click(function(){
							$("td").removeClass("verify");
							$(this).parent().parent().children().eq(4).addClass("verify");
							$(this).parent().parent().children().eq(3).text();
						});
						$(".ti").click(function(){
							console.log(213213123)
							layer.msg("加载中")
							$.ajax({
								url:"/member/user/update_audit_status",
								type:"post",
								data:{
									id:$(".hide").val(),
									verify:a
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else{
									ajax_allto()
										if(a==2){
										$(".verify").text("已审核");
									var id = $(".hide").val();
									$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
									$(".verify").text("已审核");
										
										}else{
											$(".verify").text("未审核").css("color","red");
										}
										a=0;
										$(".hide").val(0);
										layer.msg("提交成功！");
										$("#common_temp").modal("hide");
										
									}
								}
							})	
						});
				/*****************审核end******************/

				/*****************通知******************/
				$(".message").click(function(){
						var username = $(this).parent().parent().children().eq(1).text();
						var names = $(this).parent().parent().children().eq(2).text();
						var ids = $(this).parent().parent().children().eq(0).text();
						var status
							if($(this).parent().parent().children().eq(4).text()=="已审核"){
								status = 0
							}else{
								status = 1
							}
						var phone = $(this).parent().parent().children().eq(11).text();
						$(".user_name").html(username);
						$(".names").html(names)
						$.ajax({
								url:"/member/sys_msg_tpl/get_msg_tpl_list",
								type:"post",
								data:{
									status:status
								},
								async:true,
								sucess:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}
									$(".inform").empty();
									$.each(data,function(i,o){
										var html='<div class="zhangh1">'
												'<label><span class="img"></span>'+o.title+' : </label>'
												'<div>'+o.content+'</div>'
											'</div><!-- <br> -->';
									})
								},
								error:function(){
									layer.msg("参数错误")
								}
						});
						/******************通知记录*******************/
						$(".btnss").click(function(){
							$(".record").toggle();
							$.ajax({
								url:"/member/sys_notification/get_notification_list",
								type:"post",
								data:{
									user_id:ids
								},
								async:true,
								success:function(data){
									if(data.errorCode){
										layer.msg(data.errorMsg);
									}else if(data.result==''){
										layer.msg("通知为空")
									}else{
										for(var i=0,html;i<data.result.length;i++){
											html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
										}
										var n=html.substring(9)
										$(".record").html(n);
									}	
								}
							})
						})
					/******************查看通知end*******************/
					/***********发送通知*************/
					var ms_tpl_id;
					var muns = 1;
					$(".imgs").click(function(){
						if(muns==1){
							$(".imgs").removeClass("img")
							$(this).addClass("img")
							ms_tpl_id = $(this).attr("flag")
							muns=0;
						}else{
							$(".imgs").removeClass("img")
							ms_tpl_id = "";	
							muns = 1;
						}
					});
					$(".fasong").unbind('click').click(function(){
							$.ajax({
								url:"/member/sys_notification/notify",
								type:"post",
								data:{
									ms_tpl_id:ms_tpl_id,
									user_id:ids,
									username:username,
									content:$(".txt").val(),
									phone:phone
								},
								async:true,
								success:function(data){
									if(data.errorCode==0){
										layer.msg("发送成功！");
										$("#myModal").modal("hide");
										$(".imgs").removeClass("img")
										$(".txt").val("");
									}else{
										layer.msg(data.errorMsg)
									}
								}
							});
					})
					/***********通知end*************/
					
					/***********查看身份证信息*************/
					$(".chakan_id").click(function(){
						layer.msg(123)
					})
					/***********查看身份证信息end*************/
				})
				/*****************通知end******************/
					console.log("默认加载搞定了！");
				}
			})
	}
});
$("#tcd").show();
if(data.errorCode){
	layer.msg(data.errorMsg);
}
var data=data.result.user_list;
setGrid(data);
/************提交审核*************/
$(document).on("click",".aaa",function(){
	a = $(this).attr("flag")
});
var a;
$(".look").click(function(){
	$("td").removeClass("verify");
	$(this).parent().parent().children().eq(4).addClass("verify");
	$(this).parent().parent().children().eq(3).text();
});
$(document).on("click",".ti",function(){
	$.ajax({
		url:"/member/user/update_audit_status",
		type:"post",
		data:{
			id:$(".hide").val(),
			verify:a
		},
		async:true,
		success:function(data){
			if(data.errorCode){
				layer.msg(data.errorMsg);
			}else{
				ajax_allto()
				if(a==2){
					$(".verify").text("已审核");
					var id = $(".hide").val();
					$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
					$(".verify").text("已审核");
						
				}else{
					$(".verify").text("未审核").css("color","red");
				}
				a=0;
				$(".hide").val(0);
				layer.msg("提交成功！");
				$("#common_temp").modal("hide");
			}
		}
	})	
});
	/*****************审核end******************/

	/*****************通知******************/
	$(".message").click(function(){
			var username = $(this).parent().parent().children().eq(1).text();
			var names = $(this).parent().parent().children().eq(2).text();
			var ids = $(this).parent().parent().children().eq(0).text();
			var status
				if($(this).parent().parent().children().eq(4).text()=="已审核"){
					status = 0
				}else{
					status = 1
				}
			var phone = $(this).parent().parent().children().eq(11).text();
			$(".user_name").html(username);
			$(".names").html(names)
			$.ajax({
					url:"/member/sys_msg_tpl/get_msg_tpl_list",
					type:"post",
					data:{
						status:status
					},
					async:true,
					sucess:function(data){
						if(!data.errorCode){
							layer.msg(data.errorMsg);
						}
						$(".inform").empty();
						$.each(data,function(i,o){
							var html='<div class="zhangh1">'
									'<label><span class="img"></span>'+o.title+' : </label>'
									'<div>'+o.content+'</div>'
								'</div><!-- <br> -->';
						})
					},
					error:function(){
						layer.msg("参数错误")
					}
			});
			/******************通知记录*******************/
			$(".btnss").click(function(){
				$(".record").toggle();
				$.ajax({
					url:"/member/sys_notification/get_notification_list",
					type:"post",
					data:{
						user_id:ids
					},
					async:true,
					success:function(data){
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}else if(data.result==''){
							layer.msg("通知为空")
						}else{
							for(var i=0,html;i<data.result.length;i++){
								html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
							}
							var n=html.substring(9)
							$(".record").html(n);
						}	
					}
				})
			})
		/******************查看通知end*******************/
		/***********发送通知*************/
		var ms_tpl_id;
		var muns = 1;
		$(".imgs").click(function(){
			if(muns==1){
				$(".imgs").removeClass("img")
				$(this).addClass("img")
				ms_tpl_id = $(this).attr("flag")
				muns=0;
			}else{
				$(".imgs").removeClass("img")
				ms_tpl_id = "";	
				muns = 1;
			}
		});

		$(".fasong").unbind('click').click(function(){ 
				$.ajax({
					url:"/member/sys_notification/notify",
					type:"post",
					data:{
						ms_tpl_id:ms_tpl_id,
						user_id:ids,
						username:username,
						content:$(".txt").val(),
						phone:phone
					},
					async:true,
					success:function(data){
						if(data.errorCode==0){
							layer.msg("发送成功！");
							$(".txt").val("");
							$("#myModal").modal("hide");
							$(".imgs").removeClass("img");
						}else{
							layer.msg(data.errorMsg)
						}
					}
				});
		})
		/***********通知end*************/
		
		/***********查看身份证信息*************/
		$(".chakan_id").click(function(){
			layer.msg(123)
		})
		/***********查看身份证信息end*************/
	})
	/*****************通知end******************/
		console.log("默认加载搞定了！");
	}
});
}
function renwu(dates){
$.ajax({
	url:"/member/user/get_user_list",
	type:"post",
	async:true,
	data:{
		verify:0,
		assign_date:dates
	},
	success:function(data){
$(".tcdPageCode").unbind("click").createPage({
	pageCount:data.result.pages.max_page,
	current:1,
	backFn:function(p){
//分页
/////////////////////////////////////////////////////////////////////////////////////////
		$.ajax({
			url:"/member/user/get_user_list",
			type:"post",
			async:true,
			data:{
				page:p,
				verify:0,
				assign_date:$("#zuce_end").val()
			},
			success:function(data){
					$("#tcd").show();
					if(data.errorCode){
						layer.msg(data.errorMsg);
					}
					var data=data.result.user_list;
					setGrid(data);
				/************提交审核*************/
					$(document).on("click",".aaa",function(){
						a = $(this).attr("flag")
					});
					var a 
					$(".look").click(function(){
						$("td").removeClass("verify");
						$(this).parent().parent().children().eq(4).addClass("verify");
						$(this).parent().parent().children().eq(3).text();
					});
					$(".ti").unbind("click").click(function(){
						layer.msg("加载中")
						$.ajax({
							url:"/member/user/update_audit_status",
							type:"post",
							data:{
								id:$(".hide").val(),
								verify:a
							},
							async:true,
							success:function(data){
								if(data.errorCode){
									layer.msg(data.errorMsg);
								}else{
								ajax_allto()
									if(a==2){
									$(".verify").text("已审核");
								var id = $(".hide").val();
								$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
								$(".verify").text("已审核");
									
									}else{
										$(".verify").text("未审核").css("color","red");
									}
									a=0;
									$(".hide").val(0);
									layer.msg("提交成功！");
									$("#common_temp").modal("hide");
									
								}
							}
						})	
					});
			/*****************审核end******************/

			/*****************通知******************/
			$(".message").click(function(){
					var username = $(this).parent().parent().children().eq(1).text();
					var names = $(this).parent().parent().children().eq(2).text();
					var ids = $(this).parent().parent().children().eq(0).text();
					var status
						if($(this).parent().parent().children().eq(4).text()=="已审核"){
							status = 0
						}else{
							status = 1
						}
					var phone = $(this).parent().parent().children().eq(11).text();
					$(".user_name").html(username);
					$(".names").html(names)
					$.ajax({
							url:"/member/sys_msg_tpl/get_msg_tpl_list",
							type:"post",
							data:{
								status:status
							},
							async:true,
							sucess:function(data){
								if(data.errorCode){
									layer.msg(data.errorMsg);
								}
								$(".inform").empty();
								$.each(data,function(i,o){
									var html='<div class="zhangh1">'
											'<label><span class="img"></span>'+o.title+' : </label>'
											'<div>'+o.content+'</div>'
										'</div><!-- <br> -->';
								})
							},
							error:function(){
								layer.msg("参数错误")
							}
					});
					/******************通知记录*******************/
					$(".btnss").click(function(){
						$(".record").toggle();
						$.ajax({
							url:"/member/sys_notification/get_notification_list",
							type:"post",
							data:{
								user_id:ids
							},
							async:true,
							success:function(data){
								if(data.errorCode){
									layer.msg(data.errorMsg);
								}else if(data.result==''){
									layer.msg("通知为空")
								}else{
									for(var i=0,html;i<data.result.length;i++){
										html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
									}
									var n=html.substring(9)
									$(".record").html(n);
								}	
							}
						})
					})
				/******************查看通知end*******************/
				/***********发送通知*************/
				var ms_tpl_id;
				var muns = 1;
				$(".imgs").click(function(){
					if(muns==1){
						$(".imgs").removeClass("img")
						$(this).addClass("img")
						ms_tpl_id = $(this).attr("flag")
						muns=0;
					}else{
						$(".imgs").removeClass("img")
						ms_tpl_id = "";	
						muns = 1;
					}
				});
				$(".fasong").unbind('click').click(function(){
						$.ajax({
							url:"/member/sys_notification/notify",
							type:"post",
							data:{
								ms_tpl_id:ms_tpl_id,
								user_id:ids,
								username:username,
								content:$(".txt").val(),
								phone:phone
							},
							async:true,
							success:function(data){
								if(data.errorCode==0){
									layer.msg("发送成功！");
									$("#myModal").modal("hide");
									$(".imgs").removeClass("img")
									$(".txt").val("");
								}else{
									layer.msg(data.errorMsg)
								}
							}
						});
				})
				/***********通知end*************/
				
				/***********查看身份证信息*************/
				$(".chakan_id").click(function(){
					layer.msg(123)
				})
				/***********查看身份证信息end*************/
			})
			/*****************通知end******************/
				console.log("默认加载搞定了！");
			}
		})
}
});
			$("#tcd").show();
			if(data.errorCode){
				layer.msg(data.errorMsg);
			}
			var data=data.result.user_list;
			setGrid(data);
		/************提交审核*************/
			$(document).on("click",".aaa",function(){
				a = $(this).attr("flag")
			});
			var a;
			$(".look").click(function(){
				$("td").removeClass("verify");
				$(this).parent().parent().children().eq(4).addClass("verify");
				$(this).parent().parent().children().eq(3).text();
			});
			$(".ti").unbind("click").click(function(){
				console.log(2134);
				$.ajax({
					url:"/member/user/update_audit_status",
					type:"post",
					data:{
						id:$(".hide").val(),
						verify:a
					},
					async:true,
					success:function(data){
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}else{
							ajax_allto()
							if(a==2){
								$(".verify").text("已审核");
								var id = $(".hide").val();
								$('.tbody1 tr[flag=' + id + ']').fadeOut(300);
								$(".verify").text("已审核");
									
							}else{
								$(".verify").text("未审核").css("color","red");
							}
							a=0;
							$(".hide").val(0);
							layer.msg("提交成功！");
							$("#common_temp").modal("hide");
						}
					}
				})	
			});
	/*****************审核end******************/

	/*****************通知******************/
	$(".message").click(function(){
			var username = $(this).parent().parent().children().eq(1).text();
			var names = $(this).parent().parent().children().eq(2).text();
			var ids = $(this).parent().parent().children().eq(0).text();
			var status
				if($(this).parent().parent().children().eq(4).text()=="已审核"){
					status = 0
				}else{
					status = 1
				}
			var phone = $(this).parent().parent().children().eq(11).text();
			$(".user_name").html(username);
			$(".names").html(names)
			$.ajax({
					url:"/member/sys_msg_tpl/get_msg_tpl_list",
					type:"post",
					data:{
						status:status
					},
					async:true,
					sucess:function(data){
						if(!data.errorCode){
							layer.msg(data.errorMsg);
						}
						$(".inform").empty();
						$.each(data,function(i,o){
							var html='<div class="zhangh1">'
									'<label><span class="img"></span>'+o.title+' : </label>'
									'<div>'+o.content+'</div>'
								'</div><!-- <br> -->';
						})
					},
					error:function(){
						layer.msg("参数错误")
					}
			});
			/******************通知记录*******************/
			$(".btnss").click(function(){
				$(".record").toggle();
				$.ajax({
					url:"/member/sys_notification/get_notification_list",
					type:"post",
					data:{
						user_id:ids
					},
					async:true,
					success:function(data){
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}else if(data.result==''){
							layer.msg("通知为空")
						}else{
							for(var i=0,html;i<data.result.length;i++){
								html+="<div>"+data.result[i].create_time+"</div>"+"<div>"+data.result[i].content+"</div>";	
							}
							var n=html.substring(9)
							$(".record").html(n);
						}	
					}
				})
			})
		/******************查看通知end*******************/
		/***********发送通知*************/
		var ms_tpl_id;
		var muns = 1;
		$(".imgs").click(function(){
			if(muns==1){
				$(".imgs").removeClass("img")
				$(this).addClass("img")
				ms_tpl_id = $(this).attr("flag")
				muns=0;
			}else{
				$(".imgs").removeClass("img")
				ms_tpl_id = "";	
				muns = 1;
			}
		});

		$(".fasong").unbind('click').click(function(){ 
				$.ajax({
					url:"/member/sys_notification/notify",
					type:"post",
					data:{
						ms_tpl_id:ms_tpl_id,
						user_id:ids,
						username:username,
						content:$(".txt").val(),
						phone:phone
					},
					async:true,
					success:function(data){
						if(data.errorCode==0){
							layer.msg("发送成功！");
							$(".txt").val("");
							$("#myModal").modal("hide");
							$(".imgs").removeClass("img");
						}else{
							layer.msg(data.errorMsg)
						}
					}
				});
		})
		/***********通知end*************/
		
		/***********查看身份证信息*************/
		$(".chakan_id").click(function(){
			layer.msg(123)
		})
		/***********查看身份证信息end*************/
	})
	/*****************通知end******************/
		console.log("默认加载搞定了！");
	}
});
}
