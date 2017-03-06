$(function(){
	sessionStorage.setItem('loginname',$(".tu").next().next().html());
    $(document).on("click",".send li",function(){ 
        $(this).addClass("active").siblings().removeClass("active")
    });
	$(document).on("click",".nav-stacked li",function(){ 
        $(this).addClass("active").siblings().removeClass("active")
    });
	$(document).on("click",".send li a",function(e){ 
         e.preventDefault(); 
    });
	//初始化菜单
	$.ajax({
		url:"/permission/sys_operation/get_init_menu",
		type:"post",
		async:true,
		success:function(data){
			if(data.errorCode){
				layer.msg(data.errorMsg);
			}
			$(".send").empty();
			//一级菜单
			$.each(data.result.first_meuns,function(i,o){
				$(".send").append($("#nav_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return o[b];}));
				if(o.is_default==1){
					$(".send").children("li").eq(i).addClass("active").siblings().removeClass("active");
				}
			});
			$(".send").children("li").eq(0).addClass("t1");
			//二级菜单
			$(".nav-stacked").empty();
			$.each(data.result.second_menus,function(i,o){
				$(".nav-stacked").append($("#sub_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return o[b];}));
				if(o.is_default==1){
					$(".nav-stacked").children("li").eq(i).addClass("active").siblings().removeClass("active");
				}
			});
		}
	});
	window._subList=[];
	//一级菜单切换
	
	$(document).on("click",".send li a",function(){
		var id=$(this).parents("li").attr("flag");
		var menu =$('.send').attr('val')
			//判断windwon._subList为不为空 判断是否请求 减少请求次数 
			if(typeof window._subList[id] == 'undefined' || window._subList[id].length == 0){
				$.ajax({
					url:"/permission/sys_operation/get_sub_menu",
					type:"post",
					data:{
						id:id,
						menu:menu
					},
					async:true,
					success:function(data){
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}
						//把请求成功的数据存入window._subList中
						window._subList[id]=data.result;
						$(".nav-stacked").empty();
						$.each(data.result.sub_menus,function(i,o){
							$(".nav-stacked").append($("#sub_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return o[b];}));
							if(o.is_default==1){
								$(".nav-stacked").children("li").eq(i).addClass("active").siblings().removeClass("active")
							}
						});

					}
				})
			}else{//如果已经请求过  那么就把上次请求成功的数据从window._subList拿数据
				   $(".nav-stacked").empty();
				   $.each(window._subList[id].sub_menus,function(i,o){
						$(".nav-stacked").append($("#sub_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){ return o[b];}));
				   		if(o.is_default==1){
							$(".nav-stacked").children("li").eq(i).addClass("active").siblings().removeClass("active");
						}
				   })
			}
	});
	//二级菜单切换
	$(document).on("click",".nav-stacked li a",function(e){
			e.preventDefault(); 
			var $that = $(this);
			var id=$(this).parents("li").attr("flag");
			var menu =$('.nav-stacked').attr('val')
			//判断windwon._subList为不为空 判断是否请求 减少请求次数 
			//if(window._subList.length==0){
				$.ajax({
					url:"/permission/sys_operation/get_sub_menu",
					type:"post",
					data:{
						id:id,
						menu:menu
					},
					async:true,
					success:function(data){
						//layer.msg(12121);
						if(data.errorCode){
							layer.msg(data.errorMsg);
						}
						//把请求成功的数据存入window._subList中
						$("#abs").empty();
						$.each(data.result.sub_menus,function(i,o){
							$("#abs").append($("#list_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return o[b];}));
							/*if(o.is_default==1){
								$("#abs").children("li").eq(i).addClass("active").siblings().removeClass("active");
							}*/
						});
						/*$(".nav-stacked li:eq(4)").mouseenter(function(){
							
						});*/$("#abs").show(300);
						/*$(".nav-stacked li:eq(3)").mouseenter(function(){
							$("#abs").empty();
							$("#abs").show(300);
							$.each(data.result.sub_menus,function(i,o){
								$("#abs").append($("#list_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return o[b];}));
								/*if(o.is_default==1){
									$(".nav-stacked").children("li").eq(i).addClass("active").siblings().removeClass("active");
								}
							});
						});*/
						
						//判断 有三级菜单时 点击三级菜单才做页面跳转（后期如果发现页面跳转有问题，请打印ID值看下）
						var operation; 
						if(id==8||id==7){
							operation;
						}else{
							operation = $that.parent('li').attr('operation');
						}; 
						//替换掉a里面的SRC
						$("#iframe").attr('src',operation);
						$that.attr('target','s1');
						$(document).on("click","#abs li a",function(e){
							e.preventDefault();
							operation = $(this).parent('li').attr('operation');
							$("#iframe").attr('src',operation);
							$(this).attr('target','s1');
							
							
						})
						//匹配交易子菜单隐藏
						$("#abs").mouseleave(function(){
							$("#abs").hide(300);
						});	
					}
				})
			//}//else{//如果已经请求过  那么就把上次请求成功的数据从window._subList拿数据
			//	$("#abs").empty();

			//	$.each(window._subList.[id].sub_menus,function(i,o){
			//		$("#abs").append($("#list_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return o[b];}));
			//	})
			//}	
		});

});   //结束标签

/**
 * 错误操作
 * @returns {undefined}
 */
function  get_error_to_operation(e) {
   
    switch (e.errorCode){
        case -1998://被迫下线
             confirm_html(e.errorMsg);
         break;     
        case -1999://被迫下线
             confirm_html(e.errorMsg);
         break;
     default:
         error_msg_html(e.errorMsg);
         break;
    }
};


function confirm_html(e) {
    layer.confirm(e, {
        btn: ['确认','取消'] //按钮
      }, function(){
        location.href = '/user/index/index';
      }, function(){

      });
};

function error_msg_html(e) {
    layer.msg(e, {
        time: 20000, //20s后自动关闭
        btn: ['明白了', '知道了']
      });
};