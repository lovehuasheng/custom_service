//2016/12/18
$(function(){
    //查看的显示
	$('#common_temp').modal({backdrop:"static",show:false});
	$('#myModal').modal({backdrop:"static",show:false});
    $(document).on("click","[flag='look_btn']",function(){
        //获取当前的ID
        var userid=$(this).parents("tr").attr("flag");
        var child=$(this).parents("tr").children().eq(1).text();
        layer.load();
        $.ajax({
            url:"/member/user_info/get_user_info",
            type:"post",
            async:true,
            data:{
                user_id:userid
            },
             success:function(data){
                layer.closeAll();
                //处理手机号和银行卡号的显示
                var mun = String(data.result.card_id)
                var mun_2 = String(data.result.bank_account);
                var mobile = String(data.result.phone);
                 data.result.card_id =  mun.substring(0,3)+' '+mun.substring(3,6)+' '+mun.substring(6,10)+' '+mun.substring(10,14)+' '+mun.substring(14,18);
                //data.result.bank_account =  mun_2.substring(0,4)+' '+mun_2.substring(4,8)+' '+mun_2.substring(8,12)+' '+mun_2.substring(12,16)+' '+mun_2.substring(16,18)+' '+mun_2.substring(18,21);
                data.result.bank_account =  mun_2.replace(/\B(?=(\d{4})+(?!\d))/g, " ");
                data.result.phone =  mobile.substring(0,3)+' '+mobile.substring(3,7)+' '+mobile.substring(7,11);
                //处理结束
                $("#common_temp .modal-title").html("查看");
                $("#common_temp .modal-body").html($("#look_temp").html().replace(/\{([^\}]+)\}/g,function(a,b){return data.result[b];}));
                var o=data.result;
                if(data.result.card_type==1){
                    $(".types_ids").html('身份证号:')
                    $(".types_img").html('身份证照:')
                }else if(data.result.card_type==2){
                    $(".types_ids").html('护照编号:')
                    $(".types_img").html('护照证照:')
                }
                //会员账号
                if(o.username=="NULL"||o.username==undefined||o.username==""||o.username==null){
                   $(".sen").html("");
                }
                //名字
                if(o.name=="NULL"||o.name==undefined||o.name==""||o.name==null){
                   $(".mz").html("");
                }
                //手机
                if(mobile=="NULL"||mobile==undefined||mobile==""||mobile==null){
                   $(".sj").html("");
                }
                //电子邮件
                if(o.email=="NULL"||o.email==undefined||o.email==""||o.email==null){
                   $(".yj").html("");
                }
                //支付宝
                if(o.alipay_account=="NULL"||o.alipay_account==undefined||o.alipay_account==""||o.alipay_account==null){
                   $(".zfb").html("");
                }
                //微信
                if(o.weixin_account=="NULL"||o.weixin_account==undefined||o.weixin_account==""||o.weixin_account==null){
                   $(".wx").html("");
                }
                //开户行
                if(o.bank_name=="NULL"||o.bank_name==undefined||o.bank_name==""||o.bank_name==null){
                   $(".khh").html("");
               }
                //银行账户
                if(mun_2=="NULL"||mun_2==undefined||mun_2==""||mun_2==null){
                    $(".yh").html("");
                }
                //身份证号
                if(mun=="NULL"||mun==undefined||mun==""||mun==null){
                   $(".sfz").html("");
                }
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
                    $("#pbImage").before("<div class='users'><label>姓名 :<span id='name'></span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label>"+$(".types_ids").html()+"<span id='identity'></span></label></div>"); 
                    $("#name").html(data.result.name);
                    $("#identity").html(data.result.card_id);
                    $("#main p img").unbind("click").click(function(){
                        $(".users").show();
                    })
                    $("#pbOverlay").click(function(){
                        $(".users").hide(); 
                    });
                });
                //关闭弹窗
                $(".out").click(function(){
                    $("#imgs").hide(300);
                    $(".users").remove();
                })
            }//请求成功结束
        })
    });
    //审核的显示
    $(document).on("click","[flag='veri_btn']",function(){
        //获取当前ID
        var userid=$(this).parents("tr").attr("flag");
        var name=$(this).parents("tr").children().eq(2).text();
        var verify=$(this).parents("tr").children().eq(4).text();
        //获取数据 'k'是把数据变成哈希表
        $("#common_temp .modal-title").html("审核");
        $("#common_temp .modal-body").html($("#veri_temp").html());
        $(".account").html(name);
        $(".state").html(verify);
        $("#common_temp").modal();
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
    //鼠标失去焦点变红
     $(document).on("blur",".bh",function(){
        if($(this).val()!=""){
            $(this).parent().prev().find("span").css("background","url('/static/images/jingling.png') 228px 0px");
        }
    });

    //重置
    $(document).on("click",".replacement",function(){
        $(".bh").val("");
        $(".bh").parent().prev().find("span").css("background","url('/static/images/jingling.png') 0 0");
    });

    //日期
    var dates = new Date();
    var years = dates.getFullYear();
    var months = dates.getMonth()+1;
    var days = dates.getDate();
    var assign_date = years+"-"+months+"-"+days;

    //默认加载
    ajaxs(assign_date);
    $(".que").click(function(){
        var str=$("#zuce_end").val();
        if(str==""){
            layer.msg("请选择时间！");        
        }else{
            var tim = new Date($("#zuce_end").val()).getTime();
            var news = new Date().getTime();
            if(tim>news){
                layer.msg('不能选择未来时间')
            }else{
                $(".oppo").val("");
                ajaxs(str);
                str=="";
            }    
        }
    });

    //审核状态
    var verify;
	var flag = 0;
    $(".oppo").change(function(){
        verify=$(this).val();
        var assign_date;
        if($("#zuce_end").val()==""&&flag!=1){
            var dates = new Date();
            var years = dates.getFullYear();
            var months = dates.getMonth()+1;
            var days = dates.getDate();
            var assign_date1 = years+"-"+months+"-"+days;
            assign_date=assign_date1;
        }else{
			 assign_date=$("#zuce_end").val();
			 flag = 0;
		}
        var user_id="",username="",name="",phone="",alipay_account="",weixin_account="",bank_account="",card_id="",bank_name="";
        ajaxs(assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times);
    });
    //排序
    var order,times;
    $(".order span").unbind("click").click(function(){
        order=$(this).attr("flag");
        times=$(this).parent().attr("flag");
        //选择时间
        var assign_date=$("#zuce_end").val();
        if(assign_date==""){
            var dates = new Date();
            var years = dates.getFullYear();
            var months = dates.getMonth()+1;
            var days = dates.getDate();
            var assign_date1 = years+"-"+months+"-"+days;
            assign_date=assign_date1;
        }
        var user_id="",username="",name="",phone="",alipay_account="",weixin_account="",bank_account="",card_id="",bank_name="";
        ajaxs(assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times);
    });

    var user_id,username,name,phone,alipay_account,weixin_account,bank_name,bank_account,card_id;
    $(document).off("click",".sousuo");
    $(document).on("click",".sousuo",function(e){
        //选择时间
        $("#common_temp").modal("hide");
        e.preventDefault();
        //ID
        user_id=$("#firstname1").val();
        //会员账号
        username=$("#firstname2").val();
        //姓名
        name=$("#firstname3").val();
        //手机号
        phone=$("#firstname4").val();
        //支付宝
        alipay_account=$("#firstname5").val(); 
        //微信
        weixin_account=$("#firstname6").val();
        //开户行
        bank_name=$("#firstname7").val();
        //银行账户
        bank_account=$("#firstname8").val();
        //身份证号
        card_id=$("#firstname9").val();
        assign_date="",verify="",order="",times="";
        ajaxs(assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times);
        $(".oppo").val("");
		$("#zuce_end").val("");
		flag=1;
    });
    //刷新全部
	var c=0;
    $(".update").unbind("click").click(function(){
		var assign_date;
        if($("#zuce_end").val()==""&&c!=1){
            var dates = new Date();
            var years = dates.getFullYear();
            var months = dates.getMonth()+1;
            var days = dates.getDate();
            var assign_date1 = years+"-"+months+"-"+days;
            assign_date=assign_date1;
		}else{
			 assign_date=$("#zuce_end").val();
			 c = 0;
		}
        ajaxs(assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times);
		c=1;
    });
});//function结束

//获取当前的ID
function look(id){
    $(".hide").val(id);
}

//处理图片错误
 function nofind(obj){
    obj.src="/static/images/default.png"; 
    obj.style.width="300px";
    obj.style.height="200px";
    obj.style.border="1px solid #ccc";
  }

//公共数据加载
function  ajaxs(assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times){
    var tal; 
    ajax_allto(assign_date);
    //请求数据
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
            assign_date:assign_date,
            verify:verify,
            order:order,
            order_field:times
        },
        success:function(data){
            if(data.errorCode==0){
                var datas= data.result.pages.max_page;
                if(datas==0){
                    $("#tcd").hide();
                    $(".pages_Code").hide();
                    layer.msg("没有相关数据")
                }else{ 
                ajax_page(datas,assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times);
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                }
                //当前任务量
                $(".unfinished").html(data.result.total);
                tal = data.result.total;
                var data=data.result.user_list;
                //显示列表
                setGrid(data);
                //查看
                var username;
                $(".look").click(function(){
                    $("td").removeClass("verify");
                    $(this).parent().parent().children().eq(4).addClass("verify");
                    username = $(this).parent().parent().children().eq(1).text();
                });
                $(document).off("click",".ti");
                //提交审核
                $(document).on("click",".ti",function(){
                    var verify=2;
                    layer.load();
                    $.ajax({
                        url:"/member/user/update_audit_status",
                        type:"post",
                        data:{
                            id:$(".hide").val(),
                            verify:2,
                            username:username
                        },
                        async:true,
                        success:function(data){
                            layer.closeAll();
                            if(data.errorCode){
                                layer.msg(data.errorMsg);
                            }else{
                                datas=window._schedule1;
                                ajax_allto(datas);
                                if(verify==2){
                                    var id = $(".hide").val();
                                    $('.tbody1 tr[flag=' + id + ']').fadeOut(300); 
                                }
                                tal--;
                                $(".unfinished").html(tal)
                                $(".hide").val(0);
                                layer.msg("提交成功！");
                                $("#common_temp").modal("hide");
                            }
                        }
                    }) ;
                });
                $(".message").unbind("click").click(function(){//通知
                    //获取通知需要的参数
                     $(".imgs").removeClass("img");
                    var username = $(this).parent().parent().children().eq(1).text();
                    var names = $(this).parent().parent().children().eq(2).text();
                    var ids = $(this).parent().parent().children().eq(0).text();
                    var verify_text=$(this).parent().parent().children().eq(4);
					var update_color=$(this).parent().parent().children().eq(8);
                    var verify=1;
                    var status;
                        if($(this).parent().parent().children().eq(4).text()=="已审核"){
                            status = 0
                        }else{
                            status = 1
                        }
                    var phone = $(this).parent().parent().children().eq(11).text();
                    var ms_tpl_id;
                    $(".imgs").unbind("click").click(function(){
                        if($(this).hasClass("img")){
                            $(this).removeClass("img");
                            ms_tpl_id = '';
                        }else{
                            $(".imgs").removeClass("img");
                            $(this).addClass("img")
                            ms_tpl_id = $(this).attr("flag");
                        }
                    });
                    //通知页面的内容
                    $(".user_name").html(username);
                    $(".names").html(names);
                    layer.load();
                    $.ajax({
                        url:"/member/sys_msg_tpl/get_msg_tpl_list",
                        type:"post",
                        data:{
                            status:status
                        },
                        async:true,
                        success:function(data){
                            layer.closeAll();
                            if(data.errorCode){
                                layer.msg(data.errorMsg);
                            }
                        },
                        error:function(){
                            layer.msg("参数错误");
                        }
                    });
                    //通知记录
                    $(document).off("click",".btnss")
                    $(".record").empty();
                    $(".record").hide();
                    $(".btnss").unbind("click").click(function(){ 
                        $(".record").toggle();
                         layer.load();
                        $.ajax({
                            url:"/member/sys_notification/get_notification_list",
                            type:"post",
                            data:{
                                user_id:ids
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else if(data.result==''){
                                    layer.msg("通知为空");
                                }else{
                                    $(".record").empty();
                                    for(var i=0,html;i<data.result.length;i++){
                                        newDate= new Date(parseInt(data.result[i].create_time) * 1000);
                                        data.result[i].create_time = newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate()+" "+newDate.getHours()+":"+newDate.getMinutes()+":"+newDate.getSeconds();
                                        html+="<div class='tplist'>"+
                                                    "<span>通知"+(i+1)+" :</span>"+
                                                    "<div>"+
														"<b>"+data.result[i].create_time+"</b>"+
														"<p>&nbsp;&nbsp;"+data.result[i].attend+"</p>"+  
                                                    "</div>"+
                                                "</div>";
                                    }
                                    var n=html.substring(9);
                                    $(".record").html(n);
                                }   
                            }
                        })
                    });
                    //发送通知
                    $(".fasong").unbind('click').click(function(){ 
                        layer.load();
                        $.ajax({
                            url:"/member/sys_notification/notify",
                            type:"post",
                            data:{
                                ms_tpl_id:ms_tpl_id,
                                user_id:ids,
                                username:username,
                                content:$(".txt").val(),
                                phone:phone,
                                verify:verify
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode==0){
                                    layer.msg("发送成功!");
                                    $(".txt").val("");
                                    $("#myModal").modal("hide");
                                    $(".imgs").removeClass("img");
                                    verify_text.text("未通过").css("color","red");
									update_color.css("color",'#f00');
                                    ajax_allto();
                                }else{
                                    layer.msg(data.errorMsg);
                                }
                            }
                        });
                    })
                });//通知结束
                //跳页
                $(".PagesCode").unbind("click").click(function(){
                    var zz = /^[0-9]*$/;
                    if(zz.test($(".pageCode").val())){
                        var page=parseInt($(".pageCode").val());
                        var current = page;
                        if(page==0||page==''||page>datas){
                            layer.msg("请输入正确页数")
                        }else{
                            //var user_id="",username="",name="",phone="",alipay_account="",weixin_account="",bank_account="",card_id="",bank_name="";
                            ajax_page(datas,assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,page,current);
                        } 
                    }else{
                        layer.msg("请输入纯数字页数")
                    }    
                });
            }else{
                layer.msg(data.errorMsg);
            }
        },
        error:function(){
            layer.msg("参数错误请重新传参数");
        }
    });                 
}

//加载任务量
function ajax_allto(assign_date){
    layer.load();
     $.ajax({
        url:"/member/sys_work/get_workload",
        type:"post",
        async:true,
        data:{
            create_date:assign_date
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            $(".total").html(data.result.total_num);
            $(".completed").html(data.result.completed_num);
        },
        error:function(){
            layer.msg("参数错误请重新传参数");
        }
    });
}

//数据模板
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
        var newDate = new Date(o.create_time*1000)
        var newTime = new Date(o.update_time*1000)
        var mon = (newDate.getMonth()+1);
        var day = newDate.getDate();
        var hour = newDate.getHours();
        var min = newDate.getMinutes();
        var sec = newDate.getSeconds();
        //资料更新时间转化
        var mon2 = (newTime.getMonth()+1);
        var day2 = newTime.getDate();
        var hour2 = newTime.getHours();
        var min2 = newTime.getMinutes();
        var sec2 = newTime.getSeconds();
        if(mon<10){
            mon = '0'+mon;
        }
        if(day<10){
            day = '0'+day;
        }
        if(hour<10){
            hour = '0'+hour;
        }
        if(min<10){
            min = '0'+min;
        }
        if(sec<10){
            sec = '0'+sec;
        }
        if(mon2<10){
            mon2 = '0'+mon2;
        }
        if(day2<10){
            day2 = '0'+day2;
        }
        if(hour2<10){
            hour2 = '0'+hour2;
        }
        if(min2<10){
            min2 = '0'+min2;
        }
        if(sec2<10){
            sec2 = '0'+sec2;
        }
        o.create_time = newDate.getFullYear()+"-"+mon+"-"+day+" "+hour+":"+min+":"+sec;
        o.update_time = newTime.getFullYear()+"-"+mon2+"-"+day2+" "+hour2+":"+min2+":"+sec2;
        $(".tbody1").append($("#tr_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
        if(o.verify == 0){
            $(".tbody1 tr").eq(i).children(".emve").css("color","#000");
            $(".tbody1 tr").eq(i).children("td").eq(8).css('color','#000');    
        }else{ 
            $(".tbody1 tr").eq(i).children(".emve").css("color","#f00");
            $(".tbody1 tr").eq(i).children("td").eq(8).css('color','#f00');
            if(o.update_status == 1){
                $(".tbody1 tr").eq(i).children("td").eq(8).css('color','#0f0');
            }
        }
        $(document).off("click",".tbody1 tr")
        $(document).on("click",".tbody1 tr",function(){
            $(this).css("background","#ff9").siblings().css("background","#fff");
        });
    });
}

function ajax_page(datas,assign_date,verify,order,user_id,username,name,phone,alipay_account,weixin_account,bank_account,card_id,bank_name,times,page,current){
    var tal;
    if(page==undefined)page=1;
    if(current==undefined)current=1; 
    //分页
    sessionStorage.setItem('p', datas); 
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:datas,
        current:current,
        backFn:function(page){
            //请求数据
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
                    assign_date:assign_date,
                    verify:verify,
                    order:order,
                    order_field:times,
                    page:page
                },
                success:function(data){
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //当前任务量
                    $(".unfinished").html(data.result.total);
                    tal = data.result.total;
                    var data=data.result.user_list;
                    //显示列表
                    setGrid(data);
                    //查看
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        username = $(this).parent().parent().children().eq(1).text();
                    });
                    $(document).off("click",".ti");
                    //提交审核
                    $(document).on("click",".ti",function(){
                       var verify=2;
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:2,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    datas=window._schedule1;
                                    ajax_allto(datas);
                                    if(verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300); 

                                    }
                                    tal--;
                                    $(".unfinished").html(tal)
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        }) ;
                    });
                    $(".message").unbind("click").click(function(){//通知
                        $(".imgs").removeClass("img");
                        //获取通知需要的参数
                        var username = $(this).parent().parent().children().eq(1).text();
                        var names = $(this).parent().parent().children().eq(2).text();
                        var ids = $(this).parent().parent().children().eq(0).text();
                        var verify_text=$(this).parent().parent().children().eq(4);
						var update_color=$(this).parent().parent().children().eq(8);
                        var verify=1;
                        var status;
                            if($(this).parent().parent().children().eq(4).text()=="已审核"){
                                status = 0
                            }else{
                                status = 1
                            }
                        var phone = $(this).parent().parent().children().eq(11).text();
                        var ms_tpl_id;
                         $(".imgs").unbind("click").click(function(){
                            if($(this).hasClass("img")){
                                $(".imgs").removeClass("img");
                                ms_tpl_id = '';
                            }else{
                                $(".imgs").removeClass("img");
                                $(this).addClass("img")
                                ms_tpl_id = $(this).attr("flag");
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                          layer.load();
                        $.ajax({
                            url:"/member/sys_msg_tpl/get_msg_tpl_list",
                            type:"post",
                            data:{
                                status:status
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }
                            },
                            error:function(){
                                layer.msg("参数错误");
                            }
                        });
                        //通知记录
                       //通知记录
                        $(document).off("click",".btnss")
                        $(".record").empty();
                        $(".record").hide();
                        $(".btnss").unbind("click").click(function(){ 
                            $(".record").toggle();
                             layer.load();
                            $.ajax({
                                url:"/member/sys_notification/get_notification_list",
                                type:"post",
                                data:{
                                    user_id:ids
                                },
                                async:true,
                                success:function(data){
                                    layer.closeAll();
                                    if(data.errorCode){
                                        layer.msg(data.errorMsg);
                                    }else if(data.result==''){
                                        layer.msg("通知为空");
                                    }else{
                                        $(".record").empty();
                                        for(var i=0,html;i<data.result.length;i++){
                                            //newDate= new Date(parseInt(data.result[i].create_time) * 1000);
                                            //data.result[i].create_time = newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate()+" "+newDate.getHours()+":"+newDate.getMinutes()+":"+newDate.getSeconds();
                                            html+="<div class='tplist'>"+
                                                        "<span>通知"+(i+1)+" :</span>"+
                                                        "<div>"+
                                                            "<b>"+data.result[i].create_time+"</b>"+
                                                            "<p>"+data.result[i].content+"</p>"+
                                                        "</div>"+
                                                    "</div>";
                                        }
                                        var n=html.substring(9);
                                        $(".record").html(n);
                                    }   
                                }
                            })
                        });
                        //发送通知
                        $(".fasong").unbind('click').click(function(){ 
                            layer.load();
                            $.ajax({
                                url:"/member/sys_notification/notify",
                                type:"post",
                                data:{
                                    ms_tpl_id:ms_tpl_id,
                                    user_id:ids,
                                    username:username,
                                    content:$(".txt").val(),
                                    phone:phone,
                                    verify:verify
                                },
                                async:true,
                                success:function(data){
                                    layer.closeAll();
                                    if(data.errorCode==0){
                                        layer.msg("发送成功!");
                                        $(".txt").val("");
                                        $("#myModal").modal("hide");
                                        $(".imgs").removeClass("img");
                                        verify_text.text("未通过").css("color","red");
										update_color.css("color","#f00");
                                        ajax_allto();
                                    }else{
                                        layer.msg(data.errorMsg);
                                    }
                                }
                            });
                        })
                    });
                    //通知结束
                },
                error:function(){
                    layer.msg("参数错误请重新传参数");
                }
            });//请求结束   
        }
    });//分页结束
}

//点击时 默认加载今天时间
function newday(cla){
  if($('.'+cla).val()==''){
    var newDate = new Date();
    var years = newDate.getFullYear();
    var mon = (newDate.getMonth()+1);
    var day = newDate.getDate();
    $('.'+cla).val(years+"-"+mon+"-"+day)
  }
}