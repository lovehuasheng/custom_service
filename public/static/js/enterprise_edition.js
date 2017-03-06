$(function(){
    // 日期插件
    $(".datetimepicker3").on("click",function(e){
        e.stopPropagation();
        $(this).lqdatetimepicker({
            css : 'datetime-day',
            dateType : 'D',
            selectback : function(){
            }
        });
    });
    var newDate = new Date();
    var str = newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate();
    ajaxs(str)
    workload() //默认加载今日任务量

    // 选择日期加载
    var date;
    $(".ceter").click(function(){
        date = $(".zuce").val();
        if(date==''){
            layer.msg("请选择分派时间")
        }else{
            var tim = new Date($(".zuce").val()).getTime();
            var news = new Date().getTime();
            if(tim>news){
                layer.msg('不能选择未来时间')
            }else{
                $(".oppo").val('');
                $(".bh").val("")
                workload()
                ajaxs(date);
            }    
        }
    });

    // 是否是审核
    $(".oppo").change(function(){
        var verify = $(this).val();
        // if($('.total').html()==0){
        //     layer.msg("暂无数据")
        // }else{
        //     ajaxs($('.zuce').val(),$("#firstname1").val(),$("#firstname2").val(),$("#firstname3").val(),$("#firstname4").val(),$("#firstname5").val(),$("#firstname6").val(),verify)
        // }
        ajaxs($('.zuce').val(),$("#firstname1").val(),$("#firstname2").val(),$("#firstname3").val(),$("#firstname4").val(),$("#firstname5").val(),$("#firstname6").val(),verify)
    });

    // 搜索
    $(".search").click(function(){
        $(".bh").val("");
    })
    $(".ss").click(function(){
        var time = '';
        $(".zuce").val('')
        ajaxs(time,$("#firstname1").val(),$("#firstname2").val(),$("#firstname3").val(),$("#firstname4").val(),$("#firstname5").val(),$("#firstname6").val())
        workload()
        $("#sousuo").modal("hide");     
    });
    // 重置
    $(".cz").click(function(){
        $(".bh").val("")
        workload()
    });
    //刷新
    $(".update").click(function(){
        ajaxs($('.zuce').val(),$("#firstname1").val(),$("#firstname2").val(),$("#firstname3").val(),$("#firstname4").val(),$("#firstname5").val(),$("#firstname6").val(),$(".oppo").val())
    });
    var order_field;
    var order;
    $(".timi span").click(function(){
        order_field = $(this).parent().attr("flag");
        order = $(this).attr("flag")
        ajaxs($(".zuce").val(),$("#firstname1").val(),$("#firstname2").val(),$("#firstname3").val(),$("#firstname4").val(),$("#firstname5").val(),$("#firstname6").val(),$(".oppo").val(),1,order_field,order)
    });
    


}) //function结束标签

var yeshu;
function ajaxs(date,company_id,username,company_name,legal_person,business_license,mobile,verify,p,order_field,order){
    //默认加载
    layer.load();
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        data:{
            is_company:1,
            assign_date:date,  // 选择日期
            company_id:company_id, //公司ID
            username:username, //会员账号
            company_name:company_name, // 公司名称
            legal_person:legal_person, //法人姓名
            business_license:business_license, //营业证编号
            mobile:mobile,  //电话
            verify:verify, //审核状态
            page:p,
            order_field:order_field,
            order:order
        },
        success:function(data){
            layer.closeAll();
            if(data.errorCode==0){
                yeshu = data.result.pages.max_page;
                $(".tab .tbody1").empty();
                $(".unfinished").html(data.result.total);
                if(data.result.total==0){
                    layer.msg('未查询到相关数据')
                    $(".pages_Code").hide();
                    $(".tcdPageCode").hide();
                }else{
                    $(".tcdPageCode").show();
                    $(".pages_Code").show();
                    $.each(data.result.user_list,function(i,o){
                        datetime(o)
                        $(".tab .tbody1").append($("#tr_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];})); 
                        judgment(i,o) 
                    })  
                        func()
                        pages(data.result.pages.max_page,p,date,$("#firstname1").val(),$("#firstname2").val(),$("#firstname3").val(),$("#firstname4").val(),$("#firstname5").val(),$("#firstname6").val(),$(".oppo").val())         
                }
            }else{
                layer.msg(data.errorMsg)
            } // data.errorCode==0结束
        }
    });

};

// 加载今日任务量
function workload(){
    $.ajax({
        url:"/member/sys_work/get_workload",
        type:"post",
        data:{
            is_company:1
        },
        success:function(data){
            if(data.errorCode==0){
                $(".total").html(data.result.total_num)
                $(".completed").html(data.result.completed_num)
            }else{
                layer.msg(data.errorMsg)
            }
        }
    })
};
// 数据加载完成 之后功能操作
function func(){
    $(".tbody1 tr").click(function(){
        $(this).css("background","#ff9").siblings().css("background","#fff");      
    });
    var id,company_name,status,verify,username,mobile,vif,update;
    $(".look").click(function(){
        id = $(this).parent().parent().children().eq(0).text();
        username = $(this).parent().parent().children().eq(1).text();
        company_name = $(this).parent().parent().children().eq(2).text();
        status = $(this).parent().parent().children().eq(3).text();
        verify = $(this).parent().parent().children().eq(4).text();
        vif = $(this).parent().parent().children().eq(4);
        update  = $(this).parent().parent().children().eq(8);
        mobile = $(this).parent().parent().children().eq(11).text();
    });
    // 查看信息
    $(".chakan").click(function(){
        $.ajax({
            url:"/member/user_info/get_user_info",
            type:"post",
            data:{
                is_company:1,
                company_id:id
            },
            success:function(data){
                if(data.errorCode==0){
                    $("#looks .modal-body span").empty();
                    var o = data.result;
                    var mun = o.public_bank_account;
                    var mun2 = o.legal_bank_account;
                    var mun3 = o.business_license;
                    o.public_bank_account = mun.substring(0,4)+" "+mun.substring(4,8)+" "+mun.substring(8,12)+" "+mun.substring(12,16)+" "+mun.substring(16,20)+" "+mun.substring(20);
                    o.legal_bank_account = mun2.substring(0,4)+" "+mun2.substring(4,8)+" "+mun2.substring(8,12)+" "+mun2.substring(12,16)+" "+mun2.substring(16,20)+" "+mun2.substring(20);
                    o.business_license = mun3.substring(0,4)+" "+mun3.substring(4,8)+" "+mun3.substring(8,12)+" "+mun3.substring(12,16)+" "+mun3.substring(16,20)+" "+mun3.substring(20)
                    $(".Name").html(o.username);
                    $(".company_name").html(o.company_name);
                    $(".faren_name").html(o.legal_person)
                    $(".company_zh").html(o.public_bank_account);
                    $(".company_account").html(o.public_bank_name);
                    $(".faren_back").html(o.legal_bank_account);
                    $(".bank_name").html(o.legal_bank_name);
                    $(".alipay_account").html(o.legal_alipay_account);
                    $(".company_alipay_account").html(o.company_alipay_account);
                    $(".card_id").html(o.business_license);
                    // 查看图片
                    $("#chakan").click(function(){
                        $("#imgs").show(300);   
                        $(".users").empty();
                        $("#tp1 a").attr("href",data.result.business_license_img);
                        $("#tp2 a").attr("href",data.result.legal_idcard_back);
                        $("#tp3 a").attr("href",data.result.legal_idcard_front);
                        $("#tp7 a").attr("href",data.result.legal_img);
                        $("#tp4").attr("src",data.result.business_license_img);
                        $("#tp5").attr("src",data.result.legal_idcard_back);
                        $("#tp6").attr("src",data.result.legal_idcard_front);
                        $("#tp8").attr("src",data.result.legal_img);
                        $("#pbImage").before("<div class='users'><label>法人姓名 :<span id='name'></span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label>营业执照号码 :<span id='identity'></span></label></div>"); 
                        $("#name").html(data.result.legal_person);
                        $("#identity").html(data.result.business_license);
                        $(".out").click(function(){
                            $("#imgs").hide(300);
                        });
                        $("#main p img").click(function(){
                            $(".users").show();
                        });
                        $("#pbOverlay").click(function(){
                            $(".users").hide(); 
                        });
                    });
                }else{
                    layer.msg(data.errorMsg)
                }   
            }
        });
    });
    $(".shenhe").click(function(){
        $(".account").html(company_name);
        $(".state").html(verify)
    })
    // 审核提交
    $(".ti").unbind("click").click(function(){
        $.ajax({
            url:"/member/user/update_audit_status",
            type:"post",
            data:{
                is_company:1,
                id:id,
                verify:2,
                username:username,
                remark:""
            },
            success:function(data){
                if(data.errorCode==0){
                    layer.msg("操作成功")
                    $('.tbody1 tr[flag=' + id + ']').fadeOut(300);
                    $("#shenhe").modal("hide");
                    ajaxs($(".zuce").val())
                    workload()
                }else{
                    layer.msg(data.errorMsg)
                }
            }
        })
    });

    // 通知
    $(".message").click(function(){
        $(".user_name").html(username);
        $(".names").html(company_name);
        $("#tet").hide();
        $(".imgs").removeClass("img")
    });
    //查看通知记录
    $(".btnss").unbind("click").click(function(){
        $(this).attr("disabled","disabled")
        $("#tet").toggle();
        $("#tet").html("");
        $.ajax({
            url:"/member/sys_notification/get_notification_list",
            type:"post",
            data:{
                is_company:1,
                user_id:id
            },
            success:function(data){
                if(data.errorCode==0){
                    $(".btnss").removeAttr("disabled") 
                    if(data.result==''){
                        $("#tet").html("暂无通知消息")
                    }else{
                        $.each(data.result,function(i,o){
                            var newDate = new Date(o.create_time*1000)
                            o.create_time = newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate()+" "+newDate.getHours()+":"+newDate.getMinutes()+":"+newDate.getSeconds();
                            $("#tet").append($("#temp_content").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];})); 
                        })
                    }  
                }else{
                    layer.msg(data.errorMsg)
                }
            },
            error:function(data){
                layer.msg(data.errorMsg)
                $(".btnss").removeAttr("disabled") 
            }
        })
    });
    //获取通知消息模板ID
    var flag;
    $(".imgs").unbind("click").click(function(){
        if($(this).hasClass("img")){
            $(".imgs").removeClass("img");
            flag = '';
        }else{
            $(".imgs").removeClass("img");
            $(this).addClass("img") 
            flag = $(this).attr("flag")
        }   
    });
    //通知信息发送
    $(".fasong").unbind("click").click(function(){
        $(this).attr("disabled","disabled")
        if($(".txt_ms").val()==''){
            layer.msg("请输入具体原因描述")
        }else{
            $.ajax({
                url:'/member/sys_notification/notify',
                type:"post",
                data:{
                  is_company:1,
                  ms_tpl_id:flag,
                  user_id:id,
                  phone:mobile,
                  content:$(".txt_ms").val(),
                  username:username  
                },
                success:function(data){
                    $(".fasong").removeAttr("disabled")
                    if(data.errorCode==0){
                        layer.msg("操作成功");
                        $("#myModal").modal("hide");
                        $(".txt_ms").val("");
                        vif.text("未通过").css("color",'#f00');
                        update.css("color",'#f00');
                    }else{
                        layer.msg(data.errorMsg)
                    }
                },
                error:function(data){
                    layer.msg(data.errorMsg)
                    $(".fasong").removeAttr("disabled") 
                }   
            })
        }
    });

    //跳页
    $(".PagesCode").unbind("click").click(function(){
        var zz = /^[0-9]*$/
        if(zz.test($(".pageCode").val())){
            sessionStorage.setItem('p',yeshu);
            var num = $(".pageCode").val();
            if(num==0||num==''||num>yeshu){
                layer.msg("请输入正确页数")
            }
        }else{
            layer.msg("只能输入纯数字页数")
        }
        
    })
};
//分页
function pages(page_num,num,date,company_id,username,company_name,legal_person,business_license,mobile,verify){
   $(".tcdPageCode").unbind("click").createPage({
        pageCount:page_num, //最大页数
        current:num, //起始页数
        backFn:function(num){
             layer.load();
            $.ajax({
                url:"/member/user/get_user_list",
                type:"post",
                data:{
                    is_company:1,
                    assign_date:date,  // 选择日期
                    company_id:company_id, //公司ID
                    username:username, //会员账号
                    company_name:company_name, // 公司名称
                    legal_person:legal_person, //法人姓名
                    business_license:business_license, //营业证编号
                    mobile:mobile,  //电话
                    verify:verify,
                    page:num
                },
                success:function(data){
                     layer.closeAll();
                    if(data.errorCode==0){
                        $(".tab .tbody1").empty();
                        $(".unfinished").html(data.result.total);
                        if(data.result.total==0){
                            layer.msg('未查询到相关数据')
                            $(".pages_Code").hide();
                        }else{
                            $.each(data.result.user_list,function(i,o){
                                datetime(o)
                                $(".tab .tbody1").append($("#tr_temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];})); 
                                judgment(i,o)
                            }) 
                                func() 
                        }
                    }else{
                        layer.msg(data.errorMsg)
                    } // data.errorCode==0结束
                }
            });  //ajax 结束标签
        } //backFn:function(p) 结束
    });
}

function judgment(i,o){
    if(o.verify == "未审核"){
        o.verify = 0
    }else if(o.verify=="未通过"){
        o.verify = 1;
        $(".tbody1 tr").eq(i).children().eq(4).css("color","#f00");
    }else if(o.verify=="已通过"){
        o.verify = 2
    }
    if(o.update_status == 0){
        $(".tbody1 tr").eq(i).children().eq(8).css("color","#f00");
    }else if(o.update_status == 1 && o.verify == 1 ){
        $(".tbody1 tr").eq(i).children().eq(8).css("color","#0f0");
    }else{
        $(".tbody1 tr").eq(i).children().eq(8).css("color","#f00");
    }
}

function datetime(o){
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
    if(o.verify==0){
        o.verify='未审核'
    }else if(o.verify==1){
        o.verify='未通过'
    }else if(o.verify==2){
        o.verify='已通过'
    }
    if(o.status==0){
        o.status="未激活"
    }else{
        o.status="已激活"
    }
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