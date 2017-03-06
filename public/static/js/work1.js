//2016/12/08
$(function(){
    //查看的显示
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
                });
                //关闭弹窗
                $(".out").click(function(){
                    $("#imgs").hide(300);
                    $(".users").remove();
                })
            }//请求成功结束
        })
    })
     //审核的显示
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
        if($(".state").html()=="未审核"||$(".state").html()=="未通过"){
            $(".s2").addClass("active");
        }else{
            $(".s1").addClass("active");
        }
        //判断方法一
        //$(".state").html()=="已审核"?$(".s1").addClass("active"):$(".s2").addClass("active");
        //判断方法二
        /*$(".state").html()=="已审核"&&$(".s1").addClass("active")
        $(".state").html()=="未审核"&&$(".s2").addClass("active")*/
        //判断方法三
        //$(".state").html()=="已审核"||$(".s2").addClass("active");
        //$(".state").html()=="未审核"||$(".s1").addClass("active");
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
    //刷新
    $(".update").unbind("click").click(function(){
        history.go(0);   
    });
    /*鼠标失去焦点变红*/
     $(document).on("blur",".bh",function(){
        if($(this).val()!=""){
            $(this).parent().prev().find("span").css("background","url('/static/images/jingling.png') 228px 0px");
        }
    });
     /*重置*/
    $(document).on("click",".replacement",function(){
        $(".bh").val("");
        $(".bh").parent().prev().find("span").css("background","url('/static/images/jingling.png') 0 0");
    });
    //默认加载
    var dates = new Date();
    var years = dates.getFullYear();
    var months = dates.getMonth()+1;
    var days = dates.getDate();
    var today_date1 = years+"-"+months+"-"+days;
    //今日任务量
    ajax_allto(today_date1);
    datas1(today_date1);
    //按日期加载
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
    //获取时间查看任务量
    $(".que").unbind("click").click(function(){
        today_date1 = $("#zuce_end").val();
        ajax_allto(today_date1)
        datas2(today_date1);
    });
    //搜索加载
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
        ajax_allto();
        sousuo(user_id,username,name,phone,alipay_account,weixin_account,bank_name,bank_account,card_id);
    });
    //升序
    $(".up").unbind("click").click(function(){
        var order=$(".up").attr("flag");
        datas3(order);
    })
    //降序
    $(".down").unbind("click").click(function(){
        var order=$(".down").attr("flag");
        datas3(order);
    })
    //精确跳转分页
    $(".PagesCode").click(function(){
        datas5(today_date1);
    });
    //审核状态加载
    $(".oppo").change(function(e){
        e.preventDefault();
        var verify=$(".oppo").val();
        window._verify=verify;
        datas6(verify)
    });
});//function结束标签

window._verify;
//数据
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
};
//获取当前的ID
function look(id){
    $(".hide").val(id);
};
//通知
function tongzhi(username,names,ids,status,phone,ms_tpl_id){
    $.ajax({
        url:"/member/sys_msg_tpl/get_msg_tpl_list",
        type:"post",
        data:{
            status:status
        },
        async:true,
        success:function(data){
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            //$(".inform").empty();
            $.each(data,function(i,o){
            var html='<div class="zhangh1">'
                    '<label><span class="img"></span>'+o.title+' : </label>'
                    '<div>'+o.content+'</div>'
                '</div>';
            })
        },
        error:function(){
            layer.msg("参数错误")
        }
    });
    //通知记录
    $(".btnss").click(function(){
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
                phone:phone
            },
            async:true,
            success:function(data){
                layer.closeAll();
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
};
//内容加载1
function datas1(today_date1){
    layer.load();
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        async:true,
        data:{
            assign_date:today_date1
        },
        success:function(data){
             layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data1=data.result.pages.max_page;
            tbas(data1);
            //分页插件显示
            $("#tcd").show();
            $(".pages_Code").show();
            //获取数据加载内容
            var data=data.result.user_list;
            setGrid(data);
            //获取提交审核的请求参数
            var _verify;
            var username;
            $(".look").click(function(){
                $("td").removeClass("verify");
                $(this).parent().parent().children().eq(4).addClass("verify");
                username = $(this).parent().parent().children().eq(1).text();
                var tst=$(this).parent().parent().children().eq(4).text();
                if(tst=="未审核"||tst=="未通过"){
                    _verify=1
                }else{
                    _verify=2
                }
            });
            $(document).on("click",".aaa",function(){
                _verify = $(this).attr("flag");
                $(this).addClass("active").parent().siblings().children("span").removeClass("active");
            });
           
           $(document).off("click",".ti");
            //提交审核
            $(document).on("click",".ti",function(){
                $.ajax({
                    url:"/member/user/update_audit_status",
                    type:"post",
                    data:{
                        id:$(".hide").val(),
                        verify:_verify,
                        username:username
                    },
                    async:true,
                    success:function(data){
                        if(data.errorCode){
                            layer.msg(data.errorMsg);
                        }else{
                            ajax_allto(window._today_date1);
                            if(_verify==2){
                                var id = $(".hide").val();
                                $('.tbody1 tr[flag=' + id + ']').fadeOut(300); 
                               // $(".que").trigger("click") 
                            }else if(_verify==1){
                                $(".verify").text("未通过").css("color","red");
                            }
                            _verify="";
                            $(".hide").val(0);
                            layer.msg("提交成功！");
                            $("#common_temp").modal("hide");
                        }
                    }
                })  
            });


            $(".message").unbind("click").click(function(){//通知
                //获取通知需要的参数
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
                var ms_tpl_id;
                var muns = 1;
                $(".imgs").click(function(){
                    if(muns==1){
                        $(".imgs").removeClass("img");
                        $(this).addClass("img");
                        ms_tpl_id = $(this).attr("flag");
                        muns=0;
                    }else{
                        $(".imgs").removeClass("img");
                        ms_tpl_id = ""; 
                        muns = 1;
                    }
                });
                //通知页面的内容
                $(".user_name").html(username);
                $(".names").html(names);
                tongzhi(username,names,ids,status,phone,ms_tpl_id);
            });
            //通知结束
        } //请求成功结束标签
    });
}
//内容加载2
function datas2(today_date2){
    layer.load();
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        async:true,
        data:{
            assign_date:today_date2
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data2=data.result.pages.max_page;
            tbas2(data2);
            //分页插件显示
            $("#tcd").show();
            $(".pages_Code").show();
            //获取数据加载内容
            var data=data.result.user_list;
            setGrid(data);
            //获取提交审核的请求参数
            var _verify;
            var username;
            $(document).on("click",".aaa",function(){
                _verify = $(this).attr("flag");
                $(this).addClass("active").parent().siblings().children("span").removeClass("active");
            });
            $(".look").click(function(){
                $("td").removeClass("verify");
                $(this).parent().parent().children().eq(4).addClass("verify");
                username = $(this).parent().parent().children().eq(1).text();
                var tst=$(this).parent().parent().children().eq(4).text();
                if(tst=="未审核"||tst=="未通过"){
                    _verify=1
                }else{
                    _verify=2
                }
            });
           
            //提交审核
            $(document).off("click",".ti");
            $(document).on("click",".ti",function(){
                layer.load();
                $.ajax({
                    url:"/member/user/update_audit_status",
                    type:"post",
                    data:{
                        id:$(".hide").val(),
                        verify:_verify,
                        username:username
                    },
                    async:true,
                    success:function(data){
                        layer.closeAll();
                        if(data.errorCode){
                            layer.msg(data.errorMsg);
                        }else{
                            ajax_allto(window._today_date2);
                            if(_verify==2){
                                var id = $(".hide").val();
                                $('.tbody1 tr[flag=' + id + ']').fadeOut(300);   
                            }else if(_verify==1){
                                $(".verify").text("未通过").css("color","red");
                            }
                            _verify="";
                            $(".hide").val(0);
                            layer.msg("提交成功！");
                            $("#common_temp").modal("hide");
                        }
                    }
                })  
            });


            $(".message").unbind("click").click(function(){//通知
                //获取通知需要的参数
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
                var ms_tpl_id;
                var muns = 1;
                $(".imgs").click(function(){
                    if(muns==1){
                        $(".imgs").removeClass("img");
                        $(this).addClass("img");
                        ms_tpl_id = $(this).attr("flag");
                        muns=0;
                    }else{
                        $(".imgs").removeClass("img");
                        ms_tpl_id = ""; 
                        muns = 1;
                    }
                });
                //通知页面的内容
                $(".user_name").html(username);
                $(".names").html(names);
                tongzhi(username,names,ids,status,phone,ms_tpl_id);
            });
            //通知结束
        } //请求成功结束标签
    });
}
//升降序内容加载
function datas3(order){
    var flag=order;
    layer.load();
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        async:true,
        data:{
            order:order
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data4=data.result.pages.max_page;
            tbas4(data4,flag);
            //分页插件显示
            $("#tcd").show();
            $(".pages_Code").show();
            //获取数据加载内容
            var data=data.result.user_list;
            setGrid(data);
            //获取提交审核的请求参数
            var _verify;
            var username;
            $(".look").click(function(){
                $("td").removeClass("verify");
                $(this).parent().parent().children().eq(4).addClass("verify");
                username = $(this).parent().parent().children().eq(1).text();
                var tst=$(this).parent().parent().children().eq(4).text();
                if(tst=="未审核"||tst=="未通过"){
                    _verify=1
                }else{
                    _verify=2
                }
            });
            $(document).on("click",".aaa",function(){
                _verify = $(this).attr("flag");
                $(this).addClass("active").parent().siblings().children("span").removeClass("active");
            });
           
            $(document).off("click",".ti");
            //提交审核
           $(document).on("click",".ti",function(){
                layer.load();
                $.ajax({
                    url:"/member/user/update_audit_status",
                    type:"post",
                    data:{
                        id:$(".hide").val(),
                        verify:_verify,
                        username:username
                    },
                    async:true,
                    success:function(data){
                        layer.closeAll();
                        if(data.errorCode){
                            layer.msg(data.errorMsg);
                        }else{
                            ajax_allto();
                            if(_verify==2){
                                var id = $(".hide").val();
                                $('.tbody1 tr[flag=' + id + ']').fadeOut(300);
                            }else if(_verify==1){
                                $(".verify").text("未通过").css("color","red");
                            }
                            _verify=0;
                            $(".hide").val(0);
                            layer.msg("提交成功！");
                            $("#common_temp").modal("hide");
                        }
                    }
                })  
            });


            $(".message").unbind("click").click(function(){//通知
                //获取通知需要的参数
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
                var ms_tpl_id;
                var muns = 1;
                $(".imgs").click(function(){
                    if(muns==1){
                        $(".imgs").removeClass("img");
                        $(this).addClass("img");
                        ms_tpl_id = $(this).attr("flag");
                        muns=0;
                    }else{
                        $(".imgs").removeClass("img");
                        ms_tpl_id = ""; 
                        muns = 1;
                    }
                });
                //通知页面的内容
                $(".user_name").html(username);
                $(".names").html(names);
                tongzhi(username,names,ids,status,phone,ms_tpl_id);
            });
            //通知结束
        } //请求成功结束标签
    });
}
//精准搜索内容加载
function datas5(today_date1){
    layer.load();
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        async:true,
        data:{
            assign_date:today_date1,
            page:$(".pageCode").val()
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data6=data.result.pages.max_page;
            tbas6(data6);
            //分页插件显示
            $("#tcd").show();
            $(".pages_Code").show();
            //获取数据加载内容
            var data=data.result.user_list;
            setGrid(data);
            //获取提交审核的请求参数
            var _verify;
            var username;
            $(".look").click(function(){
                $("td").removeClass("verify");
                $(this).parent().parent().children().eq(4).addClass("verify");
                username = $(this).parent().parent().children().eq(1).text();
                var tst=$(this).parent().parent().children().eq(4).text();
                if(tst=="未审核"||tst=="未通过"){
                    _verify=1
                }else{
                    _verify=2
                }
            });
            $(document).on("click",".aaa",function(){
                _verify = $(this).attr("flag");
                $(this).addClass("active").parent().siblings().children("span").removeClass("active");
            });
           
            $(document).off("click",".ti");
            //提交审核
            $(document).on("click",".ti",function(){
                layer.load();
                $.ajax({
                    url:"/member/user/update_audit_status",
                    type:"post",
                    data:{
                        id:$(".hide").val(),
                        verify:_verify,
                        username:username
                    },
                    async:true,
                    success:function(data){
                        layer.closeAll();
                        if(data.errorCode){
                            layer.msg(data.errorMsg);
                        }else{
                            ajax_allto();
                            if(_verify==2){
                                var id = $(".hide").val();
                                $('.tbody1 tr[flag=' + id + ']').fadeOut(300);   
                            }else if(_verify==1){
                                $(".verify").text("未通过").css("color","red");
                            }
                            _verify="";
                            $(".hide").val(0);
                            layer.msg("提交成功！");
                            $("#common_temp").modal("hide");
                        }
                    }
                })  
            });


            $(".message").unbind("click").click(function(){//通知
                //获取通知需要的参数
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
                var ms_tpl_id;
                var muns = 1;
                $(".imgs").click(function(){
                    if(muns==1){
                        $(".imgs").removeClass("img");
                        $(this).addClass("img");
                        ms_tpl_id = $(this).attr("flag");
                        muns=0;
                    }else{
                        $(".imgs").removeClass("img");
                        ms_tpl_id = ""; 
                        muns = 1;
                    }
                });
                //通知页面的内容
                $(".user_name").html(username);
                $(".names").html(names);
                tongzhi(username,names,ids,status,phone,ms_tpl_id);
            });
            //通知结束
        } //请求成功结束标签
    });
}
//按审核状态加载
function datas6(verify){
    layer.load();
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        async:true,
        data:{
            verify:verify
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data7=data.result.pages.max_page;
            tbas7(data7);
            //分页插件显示
            $("#tcd").show();
            $(".pages_Code").show();
            //获取数据加载内容
            var data=data.result.user_list;
            setGrid(data);
            //获取提交审核的请求参数
            var _verify;
            var username;
            $(".look").click(function(){
                $("td").removeClass("verify");
                $(this).parent().parent().children().eq(4).addClass("verify");
                username = $(this).parent().parent().children().eq(1).text();
                var tst=$(this).parent().parent().children().eq(4).text();
                if(tst=="未审核"||tst=="未通过"){
                    _verify=1
                }else{
                    _verify=2
                }
            });
            $(document).on("click",".aaa",function(){
                _verify = $(this).attr("flag");
                $(this).addClass("active").parent().siblings().children("span").removeClass("active");
            });
           
            $(document).off("click",".ti");
            //提交审核
            $(document).on("click",".ti",function(){
                layer.load();
                $.ajax({
                    url:"/member/user/update_audit_status",
                    type:"post",
                    data:{
                        id:$(".hide").val(),
                        verify:_verify,
                        username:username
                    },
                    async:true,
                    success:function(data){
                        layer.closeAll();
                        if(data.errorCode){
                            layer.msg(data.errorMsg);
                        }else{
                            ajax_allto();
                            if(_verify==2){
                                var id = $(".hide").val();
                                $('.tbody1 tr[flag=' + id + ']').fadeOut(300); 
                            }else if(_verify==1){
                                $(".verify").text("未通过").css("color","red");
                            }
                            _verify="";
                            $(".hide").val(0);
                            layer.msg("提交成功！");
                            $("#common_temp").modal("hide");
                        }
                    }
                })  
            });


            $(".message").unbind("click").click(function(){//通知
                //获取通知需要的参数
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
                var ms_tpl_id;
                var muns = 1;
                $(".imgs").click(function(){
                    if(muns==1){
                        $(".imgs").removeClass("img");
                        $(this).addClass("img");
                        ms_tpl_id = $(this).attr("flag");
                        muns=0;
                    }else{
                        $(".imgs").removeClass("img");
                        ms_tpl_id = ""; 
                        muns = 1;
                    }
                });
                //通知页面的内容
                $(".user_name").html(username);
                $(".names").html(names);
                tongzhi(username,names,ids,status,phone,ms_tpl_id);
            });
            //通知结束
        } //请求成功结束标签
    });
}
//搜索
function sousuo(user_id,username,name,phone,alipay_account,weixin_account,bank_name,bank_account,card_id){
    layer.load();
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
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data3=data.result.pages.max_page;
            tbas3(data3);
            //分页插件显示
            $("#tcd").show();
            $(".pages_Code").show();
            //获取数据加载内容
            var data=data.result.user_list;
            setGrid(data);
            //获取提交审核的请求参数
            var _verify;
            var username;
            $(".look").click(function(){
                $("td").removeClass("verify");
                $(this).parent().parent().children().eq(4).addClass("verify");
                username = $(this).parent().parent().children().eq(1).text();
                var tst=$(this).parent().parent().children().eq(4).text();
                if(tst=="未审核"||tst=="未通过"){
                    _verify=1
                }else{
                    _verify=2
                }
            });
            $(document).on("click",".aaa",function(){
                _verify = $(this).attr("flag");
                $(this).addClass("active").parent().siblings().children("span").removeClass("active");
            });
           
            $(document).off("click",".ti");
            //提交审核
            $(document).on("click",".ti",function(){
                layer.load();
                $.ajax({
                    url:"/member/user/update_audit_status",
                    type:"post",
                    data:{
                        id:$(".hide").val(),
                        verify:_verify,
                        username:username
                    },
                    async:true,
                    success:function(data){
                        layer.closeAll();
                        if(data.errorCode){
                            layer.msg(data.errorMsg);
                        }else{
                            ajax_allto();
                            if(_verify==2){
                                var id = $(".hide").val();
                                $('.tbody1 tr[flag=' + id + ']').fadeOut(300);    
                            }else if(_verify==1){
                                $(".verify").text("未通过").css("color","red");
                            }
                            _verify="";
                            $(".hide").val(0);
                            layer.msg("提交成功！");
                            $("#common_temp").modal("hide");
                        }
                    }
                })  
            });


            $(".message").unbind("click").click(function(){//通知
                //获取通知需要的参数
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
                var ms_tpl_id;
                var muns = 1;
                $(".imgs").click(function(){
                    if(muns==1){
                        $(".imgs").removeClass("img");
                        $(this).addClass("img");
                        ms_tpl_id = $(this).attr("flag");
                        muns=0;
                    }else{
                        $(".imgs").removeClass("img");
                        ms_tpl_id = ""; 
                        muns = 1;
                    }
                });
                //通知页面的内容
                $(".user_name").html(username);
                $(".names").html(names);
                tongzhi(username,names,ids,status,phone,ms_tpl_id);
            });
            //通知结束
        } //请求成功结束标签
    });
}
//分页内容加载1
function tbas(data1){
    //分页
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data1,
        current:1,
        backFn:function(p){
            var dates = new Date();
            var years = dates.getFullYear();
            var months = dates.getMonth()+1;
            var days = dates.getDate();
            var today = years+"-"+months+"-"+days;
            layer.load();
            $.ajax({
                url:"/member/user/get_user_list",
                type:"post",
                async:true,
                data:{
                    assign_date:today,
                    page:p
                },
                success:function(data){
                    layer.closeAll();
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //获取数据加载内容
                    var data=data.result.user_list;
                    setGrid(data);
                    //获取提交审核的请求参数
                    var _verify;
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        username = $(this).parent().parent().children().eq(1).text();
                        var tst=$(this).parent().parent().children().eq(4).text();
                        if(tst=="未审核"||tst=="未通过"){
                            _verify=1
                        }else{
                            _verify=2
                        }
                    });
                    $(document).on("click",".aaa",function(){
                        _verify = $(this).attr("flag");
                        $(this).addClass("active").parent().siblings().children("span").removeClass("active");
                    });
                   
                
                   $(document).off("click",".ti");
                   //提交审核
                   $(document).on("click",".ti",function(){
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:_verify,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    ajax_allto(window._today_date1);
                                    if(_verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300);  
                                    }else if(_verify==1){
                                         $(".verify").text("未通过").css("color","red");
                                    }
                                    _verify=0;
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        })  
                    });


                    $(".message").unbind("click").click(function(){//通知
                        //获取通知需要的参数
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
                        var ms_tpl_id;
                        var muns = 1;
                        $(".imgs").click(function(){
                            if(muns==1){
                                $(".imgs").removeClass("img");
                                $(this).addClass("img");
                                ms_tpl_id = $(this).attr("flag");
                                muns=0;
                            }else{
                                $(".imgs").removeClass("img");
                                ms_tpl_id = ""; 
                                muns = 1;
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                        tongzhi(username,names,ids,status,phone,ms_tpl_id);
                    });
                    //通知结束
                } //请求成功结束标签
            });
        }
    })
}
//分页内容加载2
function tbas2(data2){
    //分页
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data2,
        current:1,
        backFn:function(p){
            layer.load();
            $.ajax({
                url:"/member/user/get_user_list",
                type:"post",
                async:true,
                data:{
                    assign_date:$("#zuce_end").val(),
                    page:p
                },
                success:function(data){
                    layer.closeAll();
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //获取数据加载内容
                    var data=data.result.user_list;
                    setGrid(data);
                    //获取提交审核的请求参数
                    var _verify;
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        username = $(this).parent().parent().children().eq(1).text();
                        var tst=$(this).parent().parent().children().eq(4).text();
                        if(tst=="未审核"||tst=="未通过"){
                            _verify=1
                        }else{
                            _verify=2
                        }
                    });
                    $(document).on("click",".aaa",function(){
                        _verify = $(this).attr("flag");
                        $(this).addClass("active").parent().siblings().children("span").removeClass("active");
                    });
                   
                
                    $(document).off("click",".ti");
                    //提交审核
                    $(document).on("click",".ti",function(){
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:_verify,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    ajax_allto(window._today_date2);
                                    if(_verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300);   
                                    }else if(_verify==1){
                                        $(".verify").text("未通过").css("color","red");
                                    }
                                    _verify=0;
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        })  
                    });


                    $(".message").unbind("click").click(function(){//通知
                        //获取通知需要的参数
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
                        var ms_tpl_id;
                        var muns = 1;
                        $(".imgs").click(function(){
                            if(muns==1){
                                $(".imgs").removeClass("img");
                                $(this).addClass("img");
                                ms_tpl_id = $(this).attr("flag");
                                muns=0;
                            }else{
                                $(".imgs").removeClass("img");
                                ms_tpl_id = ""; 
                                muns = 1;
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                        tongzhi(username,names,ids,status,phone,ms_tpl_id);
                    });
                    //通知结束
                } //请求成功结束标签
            });
        }
    })
}
//搜索分页内容加载
function tbas3(data3){
    //分页
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data3,
        current:1,
        backFn:function(p){
            var user_id=$("#firstname1").val();
            var username=$("#firstname2").val();
            var name=$("#firstname3").val();
            var phone=$("#firstname4").val();
            var alipay_account=$("#firstname5").val();
            var weixin_account=$("#firstname6").val();
            var bank_name=$("#firstname7").val();
            var bank_account=$("#firstname8").val();
            var card_id=$("#firstname9").val(); 
            layer.load();
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
                    layer.closeAll();
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //获取数据加载内容
                    var data=data.result.user_list;
                    setGrid(data);
                    //获取提交审核的请求参数
                    var _verify;
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        username = $(this).parent().parent().children().eq(1).text();
                        var tst=$(this).parent().parent().children().eq(4).text();
                        if(tst=="未审核"||tst=="未通过"){
                            _verify=1
                        }else{
                            _verify=2
                        }
                    });
                    $(document).on("click",".aaa",function(){
                        _verify = $(this).attr("flag");
                        $(this).addClass("active").parent().siblings().children("span").removeClass("active");
                    });
                   
                
                    $(document).off("click",".ti");
                    //提交审核
                    $(document).on("click",".ti",function(){
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:_verify,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    ajax_allto();
                                    if(_verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300);
                                    }else if(_verify==1){
                                        $(".verify").text("未通过").css("color","red");
                                    }
                                    _verify=0;
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        })  
                    });


                    $(".message").unbind("click").click(function(){//通知
                        //获取通知需要的参数
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
                        var ms_tpl_id;
                        var muns = 1;
                        $(".imgs").click(function(){
                            if(muns==1){
                                $(".imgs").removeClass("img");
                                $(this).addClass("img");
                                ms_tpl_id = $(this).attr("flag");
                                muns=0;
                            }else{
                                $(".imgs").removeClass("img");
                                ms_tpl_id = ""; 
                                muns = 1;
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                        tongzhi(username,names,ids,status,phone,ms_tpl_id);
                    });
                    //通知结束
                } //请求成功结束标签
            });
        }
    })
}
//升序分页内容加载
function tbas4(data4,flag){
    //分页
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data4,
        current:1,
        backFn:function(p){
           var orders=flag;
           layer.load();
            $.ajax({
                url:"/member/user/get_user_list",
                type:"post",
                async:true,
                data:{
                    order:orders,
                    page:p
                },
                success:function(data){
                    layer.closeAll();
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //获取数据加载内容
                    var data=data.result.user_list;
                    setGrid(data);
                    //获取提交审核的请求参数
                    var _verify;
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        usename=$(this).parent().parent().children().eq(1).text();
                        var tst=$(this).parent().parent().children().eq(4).text();
                        if(tst=="未审核"||tst=="未通过"){
                            _verify=1
                        }else{
                            _verify=2
                        }
                    });
                    $(document).on("click",".aaa",function(){
                        _verify = $(this).attr("flag");
                        $(this).addClass("active").parent().siblings().children("span").removeClass("active");
                    });
                   
                
                    $(document).off("click",".ti");
                    //提交审核
                    $(document).on("click",".ti",function(){
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:_verify,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    ajax_allto();
                                    if(_verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300);  
                                    }else if(_verify==1){
                                        $(".verify").text("未通过").css("color","red");
                                    }
                                    _verify=0;
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        })  
                    });


                    $(".message").unbind("click").click(function(){//通知
                        //获取通知需要的参数
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
                        var ms_tpl_id;
                        var muns = 1;
                        $(".imgs").click(function(){
                            if(muns==1){
                                $(".imgs").removeClass("img");
                                $(this).addClass("img");
                                ms_tpl_id = $(this).attr("flag");
                                muns=0;
                            }else{
                                $(".imgs").removeClass("img");
                                ms_tpl_id = ""; 
                                muns = 1;
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                        tongzhi(username,names,ids,status,phone,ms_tpl_id);
                    });
                    //通知结束
                } //请求成功结束标签
            });
        }
    })
}
//精确搜素分页内容加载
function tbas6(data6){
    //分页
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data6,
        current:$(".pageCode").val(),
        backFn:function(p){
           var order_down=$(".down").attr("flag");
           layer.load();
            $.ajax({
                url:"/member/user/get_user_list",
                type:"post",
                async:true,
                data:{
                    page:$(".pageCode").val()
                },
                success:function(data){
                    layer.closeAll();
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //获取数据加载内容
                    var data=data.result.user_list;
                    setGrid(data);
                    //获取提交审核的请求参数
                    var _verify;
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        username = $(this).parent().parent().children().eq(1).text();
                        var tst=$(this).parent().parent().children().eq(4).text();
                        if(tst=="未审核"||tst=="未通过"){
                            _verify=1
                        }else{
                            _verify=2
                        }
                    });
                    $(document).on("click",".aaa",function(){
                        _verify = $(this).attr("flag");
                        $(this).addClass("active").parent().siblings().children("span").removeClass("active");
                    });
                   
                
                    $(document).off("click",".ti");
                    //提交审核
                    $(document).on("click",".ti",function(){
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:_verify,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    ajax_allto();
                                    if(_verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300);  
                                    }else if(_verify==1){
                                        $(".verify").text("未通过").css("color","red");
                                    }
                                    _verify=0;
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        })  
                    });


                    $(".message").unbind("click").click(function(){//通知
                        //获取通知需要的参数
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
                        var ms_tpl_id;
                        var muns = 1;
                        $(".imgs").click(function(){
                            if(muns==1){
                                $(".imgs").removeClass("img");
                                $(this).addClass("img");
                                ms_tpl_id = $(this).attr("flag");
                                muns=0;
                            }else{
                                $(".imgs").removeClass("img");
                                ms_tpl_id = ""; 
                                muns = 1;
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                        tongzhi(username,names,ids,status,phone,ms_tpl_id);
                    });
                    //通知结束
                } //请求成功结束标签
            });
        }
    })
}
//审核状态分页内容加载
function tbas7(data7){
    //分页
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data7,
        current:1,
        backFn:function(p){
            layer.load();
            $.ajax({
                url:"/member/user/get_user_list",
                type:"post",
                async:true,
                data:{
                    page:p,
                    verify:window._verify
                },
                success:function(data){
                    layer.closeAll();
                    if(data.errorCode){
                        layer.msg(data.errorMsg);
                    }
                    //分页插件显示
                    $("#tcd").show();
                    $(".pages_Code").show();
                    //获取数据加载内容
                    var data=data.result.user_list;
                    setGrid(data);
                    //获取提交审核的请求参数
                    var _verify;
                    var username;
                    $(".look").click(function(){
                        $("td").removeClass("verify");
                        $(this).parent().parent().children().eq(4).addClass("verify");
                        username = $(this).parent().parent().children().eq(1).text();
                        var tst=$(this).parent().parent().children().eq(4).text();
                        if(tst=="未审核"||tst=="未通过"){
                            _verify=1
                        }else{
                            _verify=2
                        }
                    });
                    $(document).on("click",".aaa",function(){
                        _verify = $(this).attr("flag");
                        $(this).addClass("active").parent().siblings().children("span").removeClass("active");
                    });
                   
                
                    $(document).off("click",".ti");
                    //提交审核
                    $(document).on("click",".ti",function(){
                        layer.load();
                        $.ajax({
                            url:"/member/user/update_audit_status",
                            type:"post",
                            data:{
                                id:$(".hide").val(),
                                verify:_verify,
                                username:username
                            },
                            async:true,
                            success:function(data){
                                layer.closeAll();
                                if(data.errorCode){
                                    layer.msg(data.errorMsg);
                                }else{
                                    ajax_allto();
                                    if(_verify==2){
                                        var id = $(".hide").val();
                                        $('.tbody1 tr[flag=' + id + ']').fadeOut(300);
                                    }else if(_verify==1){
                                        $(".verify").text("未通过").css("color","red");
                                    }
                                    _verify=0;
                                    $(".hide").val(0);
                                    layer.msg("提交成功！");
                                    $("#common_temp").modal("hide");
                                }
                            }
                        })  
                    });


                    $(".message").unbind("click").click(function(){//通知
                        //获取通知需要的参数
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
                        var ms_tpl_id;
                        var muns = 1;
                        $(".imgs").click(function(){
                            if(muns==1){
                                $(".imgs").removeClass("img");
                                $(this).addClass("img");
                                ms_tpl_id = $(this).attr("flag");
                                muns=0;
                            }else{
                                $(".imgs").removeClass("img");
                                ms_tpl_id = ""; 
                                muns = 1;
                            }
                        });
                        //通知页面的内容
                        $(".user_name").html(username);
                        $(".names").html(names);
                        tongzhi(username,names,ids,status,phone,ms_tpl_id);
                    });
                    //通知结束
                } //请求成功结束标签
            });
        }
    })
}
/*任务量及分配*/
function ajax_allto(tobdy_date1){
    layer.load();
    $.ajax({
        url:"/member/sys_work/get_workload",
        type:"post",
        async:true,
        data:{
            create_date:tobdy_date1
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode){
                layer.msg(data.errorMsg);
            }
            var data=data.result;
            $(".total").html(data.total_num);
            $(".completed").html(data.completed_num);
            $(".unfinished").html(data.unfinished_num);
        }
    });
}

