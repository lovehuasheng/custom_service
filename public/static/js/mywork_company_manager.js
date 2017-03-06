$(function (){
	$("#mytuijianren,#mychakan,#mybianji,#myshenhe,#mytongzhi,#mytequan,#myfenghao,#mychongzhi").modal({backdrop:"static",show:false});
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

var maxPages;
/************************已分配 未分配***********************************/ 
var is_assign
$("#xiala").change(function(e){
    e.preventDefault(); 
    is_assign = $(this).val()
    $(".sousuo").trigger("click")
})
/*************************已分配 未分配end***********************************/
//更新未更新
var update_status;
$("#gx_time").change(function(e){
    e.preventDefault(); 
    update_status = $(this).val()
});
$(".shenhe").change(function(e){
    e.preventDefault();
    if($(".shenhe").val()==1){
        $("#gx").show();
    }else{
        $("#gx").hide();
        update_status = '';
    }
});
/************************升序降序***********************************/ 
var order;
var order_field;
$("#oder span").unbind("click").click(function(){
    order = $(this).attr("flag");
    order_field = $(this).parent().attr("flag")
    if($(".num_s").html()==''){}else{
        $(".sousuo").trigger("click")
    }    
})
/*************************升序降序end***********************************/

// 搜索ajax请求  打印结果在页面上
$(".sousuo").unbind("click").click(function(){
    layer.load();
    $("#header_box").hide(300);
    $(".open").show(300);

    // 注册开始时间
    var create_time_start;
    if($(".zuce_str").val()!=''){
        if($(".sel_1").val()=="小时"){
            create_time_start = $(".zuce_str").val()+" 00:00:00";
        }else{
            create_time_start = $(".zuce_str").val()+$(".sel_1").val()+':00:00';   
        };
    }

    // 注册结束时间
    var create_time_end;
    if($(".zuce_end").val()!=''){
        if($(".sel_2").val()=="小时"){
           create_time_end = $(".zuce_end").val()+" 23:59:59"; 
        }else{
           create_time_end = $(".zuce_end").val()+$(".sel_2").val()+':00:00';
        };
    }

    // 资料更新时间
    var update_time_start;
    if($(".gengxin_str").val()!=''){
            if($(".sel_3").val()=="小时"){
           update_time_start = $(".gengxin_str").val()+" 00:00:00"; 
        }else{
           update_time_start = $(".gengxin_str").val()+$(".sel_3").val()+':00:00';
        };
    }

    // 资料更新结束时间
    var update_time_end;
    if($(".gengxin_end").val()!=''){
        if($(".sel_4").val()=="小时"){
           update_time_end = $(".gengxin_end").val()+" 23:59:59"; 
        }else{
           update_time_end = $(".gengxin_end").val()+$(".sel_4").val()+':00:00';
        };
    }
    $.ajax({
        url:"/member/user/get_user_list",
        type:"post",
        data:{
            is_company:1,
            order:order,
            order_field:order_field,
            is_assign:is_assign,
            update_status:update_status,
            status:$(".jihuo").val(),
            verify:$(".shenhe").val(),
            user_id:$(".id").val(),
            username:$(".username").val(),
            name:$(".name").val(),
            phone:$(".phone").val(),
            alipay_account:$(".zhifubao").val(),
            weixin_account:$(".weixin").val(),
            bank_account:$(".back").val(),
            card_id:$(".card").val(),
            verify_uname:$(".caozuoyuan").val(),
            assign_date:$(".zhipai_time").val(),
            create_time_start:create_time_start,
            create_time_end:create_time_end,
            update_time_start:update_time_start,
            update_time_end:update_time_end
        },
        success:function(data){
            layer.closeAll();
            $(".pages_Code").show();
            $(".tab tbody").eq(1).empty();
            if(data.errorCode==0){
                 maxPages = data.result.pages.max_page;
                /****当page=0时，弹出提示消息*******/
                if(data.result.pages.max_page==0){
                    layer.msg("抱歉！没有查询到匹配数据")
                    $("#tcd").hide();
                    $(".pages_Code").hide();
                    $(".num_s").html(0);
                    update_status = '';
                    return false; 
                }else{
                    $("#tcd").show();
                }
                /****当page=0时，弹出提示消息end*******/
                $(".num_s").html(data.result.total)
                var html = "";
                var temp = $("#none").clone();
                 $.each(data.result.user_list,function(i,o){
                    if(o.status==0){
                        o.status = '-'
                    }else if(o.status==1){
                        o.status = '封号'
                    }else if(o.status==2){
                        o.status = '解封'
                    }
                    var html=temp.html();
                    datezhuanhua(i,o)
                    html=html.replace(/\{company_id\}/g,o.company_id);
                    html=html.replace(/\{username\}/g,o.username);
                    html=html.replace(/\{company_name\}/g,o.company_name);
                    html=html.replace(/\{verify\}/g,o.verify);
                    html=html.replace(/\{verify_uname\}/g,o.verify_uname);
                    html=html.replace(/\{operator_name\}/g,o.operator_name);
                    html=html.replace(/\{update_time\}/g,o.update_time);
                    html=html.replace(/\{create_time\}/g,o.create_time);
                    html=html.replace(/\{mobile\}/g,o.mobile);
                    html=html.replace(/\{status\}/g,o.status);
                    $(".tab tbody").eq(1).append(html);
                    judgment(i,o)
                    ajaxs();
                    //全部指派
                    $("#qbzhipai").unbind("click").on("click",function(){ 
                        var today = new Date().getTime();
                        var str = $("#Dateover").val(); 
                        str = str.replace(/-/g,'/'); 
                        var date = new Date(str).getTime();
                        if(date-today>0||today-date<86400000||$("#qbzp").val()!=''){
                            $("#zhipai").modal("hide");
                            layer.msg("指派中，请耐心，请勿再次点击！",{time:2000})
                            $.ajax({
                                url:"/member/sys_work/assign_work",
                                type:"post",
                                data:{
                                    is_company:1,
                                    assign_mode:1,
                                    customname:$("#qbzp").val(),
                                    assign_date:$("#Dateover").val(),
                                    is_assign:is_assign,
                                    status:$(".jihuo").val(),
                                    verify:$(".shenhe").val(),
                                    username:$(".username").val(),
                                    name:$(".name").val(),
                                    phone:$(".phone").val(),
                                    alipay_account:$(".zhifubao").val(),
                                    weixin_account:$(".weixin").val(),
                                    bank_account:$(".back").val(),
                                    card_id:$(".card").val(),
                                    verify_uname:$(".caozuoyuan").val(),
                                    assign_date:$(".zhipai_time").val(),
                                    create_time_start:create_time_start,
                                    create_time_end:create_time_end,
                                    update_time_start:update_time_start,
                                    update_time_end:update_time_end
                                },
                                success:function(data){
                                    if(data.errorCode==0){
                                        layer.msg(data.errorMsg)                      
                                        setTimeout(function(){
                                            $(".sousuo").trigger('click')
                                        },2500)
                                    }else{
                                        layer.msg(data.errorMsg)
                                    }
                                }
                            });
                        }else{
                            layer.msg("指派时间不能小于今天或客服ID不能为空")
                        }
                          
                    });
                 });
    /*********分页*************/
            $(".tcdPageCode").unbind("click").createPage({
                pageCount:data.result.pages.max_page,
                current:1,
                backFn:function(p){
                    layer.load();
                   $.ajax({
                        url:"/member/user/get_user_list",
                        type:"post",
                        data:{
                            is_company:1,
                            order:order,
                            order_field:order_field,
                            is_assign:is_assign,
                            status:$(".jihuo").val(), 
                            verify:$(".shenhe").val(),
                            user_id:$(".id").val(),
                            username:$(".username").val(),
                            name:$(".name").val(),
                            phone:$(".phone").val(),
                            alipay_account:$(".zhifubao").val(),
                            weixin_account:$(".weixin").val(),
                            bank_account:$(".back").val(),
                            card_id:$(".card").val(),
                            verify_uname:$(".caozuoyuan").val(),
                            assign_date:$(".zhipai_time").val(),
                            create_time_start:create_time_start,
                            create_time_end:create_time_end,
                            update_time_start:update_time_start,
                            update_time_end:update_time_end,
                            page:p
                        },
                        success:function(data){
                            layer.closeAll();
                            $(".num_s").html(data.result.total)
                            $(".tab tbody").eq(1).empty();
                            if(data.errorCode==0){
                                var html = "";
                                var temp = $("#none").clone();
                                 $.each(data.result.user_list,function(i,o){
                                    if(o.status==0){
                                        o.status = '-'
                                    }else if(o.status==1){
                                        o.status = '封号'
                                    }else if(o.status==2){
                                        o.status = '解封'
                                    }
                                    var html=temp.html();
                                    datezhuanhua(i,o);
                                    html=html.replace(/\{company_id\}/g,o.company_id);
                                    html=html.replace(/\{username\}/g,o.username);
                                    html=html.replace(/\{company_name\}/g,o.company_name);
                                    html=html.replace(/\{verify\}/g,o.verify);
                                    html=html.replace(/\{verify_uname\}/g,o.verify_uname);
                                    html=html.replace(/\{operator_name\}/g,o.operator_name);
                                    html=html.replace(/\{update_time\}/g,o.update_time);
                                    html=html.replace(/\{create_time\}/g,o.create_time);
                                    html=html.replace(/\{mobile\}/g,o.mobile);
                                    $(".tab tbody").eq(1).append(html);
                                    judgment(i,o)
                                 });
                                    $(".open").click(function(){
                                        $("#header_box").show(300);
                                        $(this).hide(300);
                                    });
                                 ajaxs();  //调用 其他功能函数
                            }else{
                                layer.msg(data.errorMsg)
                            } 
                        }  //success结束标签
                    });  //ajax 结束标签
                }//backFn:function(p) 结束标签
             }); //整个分页结束标签
            /*********分页end*************/
            }else{
                $("#tcd").hide();
                $(".pages_Code").hide();
                $(".num_s").html(0)
                layer.msg(data.errorMsg)
            } //搜索成功AJAX完成
        }
    })
});


// 点击展开时，将搜索条件展开
$(".open").click(function(){
        $("#header_box").show(300);
        $(this).hide(300);
});
// 鼠标失去焦点  按钮变红
$(".ipt_02").blur(function(){
    if($(this).val()!=""){
        $(this).prev().prev().addClass("img")
    }else{
        $(this).prev().prev().removeClass("img")
    }
});
$(".img_0").click(function(){
    if($(this).hasClass("img")){
        $(this).removeClass("img").next().next().val("")
    }
});

$(".shenhe_zhuangtai").click(function(){
    if($(this).hasClass("img")){
        $("#gx").hide();
        $("#gx_time").val("");
        $(this).removeClass("img").next().next().val("")
    }
});

$(".zuce").click(function(){
    $(".zuce_time").addClass("img")
});
$(".gengxin").click(function(){
    $(".gengxin_time").addClass("img")
});
$(".zhipais").click(function(){
    $(".zhipai_time").addClass("img")
});
$(".renwu").click(function(){
    $(".renwu_time").addClass("img")
});
$(".zuce_time").click(function(){
    if($(this).hasClass("img")){
        $(this).removeClass("img")
        $(".zuce").val("")
    }
});
$(".gengxin_time").click(function(){
    if($(this).hasClass("img")){
        $(this).removeClass("img")
        $(".gengxin").val("")
    }
});
$(".zhipai_time").click(function(){
    if($(this).hasClass("img")){
        $(this).removeClass("img")
        $(".zhipais").val("")
    }
});
$(".renwu_time").click(function(){
    if($(this).hasClass("img")){
        $(this).removeClass("img")
        $(".renwu").val("")
    }
});

$(".zp").click(function(){
    layer.msg("请先搜索并选中指派对象")
    return  false;
});
$(".qbzp").click(function(){
   if($(".num_s").html()==''||$(".num_s").html()==0){
        layer.msg("请先搜索并选中指派对象")
        return  false;
   }
});
/**********分页跳转***************/
$(".PagesCode").unbind("click").click(function(){
    sessionStorage.setItem('p', maxPages);
    if($(".pageCode").val()!=''&&$(".pageCode").val()!=0){
        if($(".pageCode").val()<maxPages||$(".pageCode").val()==maxPages){
           $(".tcdPageCode").unbind("click").createPage({
                pageCount:maxPages,
                current:$(".pageCode").val(),
                backFn:function(p){
                 var create_time_start 
                    if($(".zuce_str").val()!=''){
                        if($(".sel_1").val()=="小时"){
                            create_time_start = $(".zuce_str").val()+" 00:00:00";
                        }else{
                            create_time_start = $(".zuce_str").val()+$(".sel_1").val()+':00:00';   
                        };
                    }
                    
                    // 注册结束时间
                    var create_time_end;
                    if($(".zuce_end").val()!=''){
                        if($(".sel_2").val()=="小时"){
                           create_time_end = $(".zuce_end").val()+" 23:59:59"; 
                        }else{
                           create_time_end = $(".zuce_end").val()+$(".sel_2").val()+':00:00';
                        };
                    }
                    
                    // 资料更新时间
                    var update_time_start;
                    if($(".gengxin_str").val()!=''){
                            if($(".sel_3").val()=="小时"){
                           update_time_start = $(".gengxin_str").val()+" 00:00:00"; 
                        }else{
                           update_time_start = $(".gengxin_str").val()+$(".sel_3").val()+':00:00';
                        };
                    }
                    
                    // 资料更新结束时间
                    var update_time_end;
                    if($(".gengxin_end").val()!=''){
                        if($(".sel_4").val()=="小时"){
                           update_time_end = $(".gengxin_end").val()+" 23:59:59"; 
                        }else{
                           update_time_end = $(".gengxin_end").val()+$(".sel_4").val()+':00:00';
                        };
                    }
                   $.ajax({
                        url:"/member/user/get_user_list",
                        type:"post",
                        data:{
                            is_company:1,
                            order:order,
                            order_field:order_field,
                            is_assign:is_assign,
                            status:$(".jihuo").val(),
                            verify:$(".shenhe").val(),
                            user_id:$(".id").val(),
                            username:$(".username").val(),
                            name:$(".name").val(),
                            phone:$(".phone").val(),
                            alipay_account:$(".zhifubao").val(),
                            weixin_account:$(".weixin").val(),
                            bank_account:$(".back").val(),
                            card_id:$(".card").val(),
                            verify_uname:$(".caozuoyuan").val(),
                            assign_date:$(".zhipai_time").val(),
                            create_time_start:create_time_start,
                            create_time_end:create_time_end,
                            update_time_start:update_time_start,
                            update_time_end:update_time_end,
                            page:p
                        },
                        success:function(data){
                            $(".num_s").html(data.result.total)
                            $(".tab tbody").eq(1).empty();
                            if(data.errorCode==0){
                                var html = "";
                                var temp = $("#none").clone();
                                 $.each(data.result.user_list,function(i,o){
                                    if(o.status==0){
                                        o.status = '-'
                                    }else if(o.status==1){
                                        o.status = '封号'
                                    }else if(o.status==2){
                                        o.status = '解封'
                                    }
                                    var html=temp.html();
                                    datezhuanhua(i,o);
                                    html=html.replace(/\{company_id\}/g,o.company_id);
                                    html=html.replace(/\{username\}/g,o.username);
                                    html=html.replace(/\{company_name\}/g,o.company_name);
                                    html=html.replace(/\{verify\}/g,o.verify);
                                    html=html.replace(/\{verify_uname\}/g,o.verify_uname);
                                    html=html.replace(/\{operator_name\}/g,o.operator_name);
                                    html=html.replace(/\{update_time\}/g,o.update_time);
                                    html=html.replace(/\{create_time\}/g,o.create_time);
                                    html=html.replace(/\{mobile\}/g,o.mobile);
                                    $(".tab tbody").eq(1).append(html);
                                    judgment(i,o)
                                 });
                                    $(".open").click(function(){
                                        $("#header_box").show(300);
                                        $(this).hide(300);
                                    });
                                 ajaxs();  //调用 其他功能函数
                            }else{
                                layer.msg(data.errorMsg)
                            } 
                        }  //success结束标签
                    });  //ajax 结束标签
                }//backFn:function(p) 结束标签
            });
            $(".tcdNumber").hide();
            // layer.load();
            ajaxs();
        }else{
            layer.msg("最大为 "+maxPages+"页 请输入小于它的页码数")
        }   
    }else{
        layer.msg("请选择跳转页数")
    }
});
    
});
/**********分页跳转 end***************/

// }); //结束标签
/***************************************************************************************/
// 重置按钮
function chongzhi(){
    $(".ipt_01").val("");
    $(".ipt_02").val("");
    $(".zuce").val("");
    $(".gengxin").val("");
    $(".img_02").removeClass("img");
    $(".shenhe").val("");
    $("#gx").val("").hide();
    $("#gx_time").val("");
    $(".renwu").val("");
    $(".sel_1").val("小时");
    $(".sel_2").val("小时");
    $(".sel_3").val("小时");
    $(".sel_4").val("小时");
}
// 刷新按钮
function shuaxin(){
    if($(".num_s").html()==''||$(".num_s").html()==0){
        return false;
    }else{
        $(".sousuo").trigger("click")
    }
   
}
function bzs(){
    $(".bzs").toggle();
}
function  ajaxs(){
    $(".tbody1 tr").unbind("click").click(function(){
        $(this).css("background","#ff9").siblings().css("background","#fff")
    });
    var username;
    var user_id;
    var shenhezhuangtai;
    var name;
    var phone;
    var verify;
    var up;
    $(".caozuo").click(function(){
        username = $(this).parent().parent().children().eq(2).text();
        user_id = $(this).parent().parent().children().eq(1).text();
        name = $(this).parent().parent().children().eq(3).text();
        shenhezhuangtai = $(this).parent().parent().children().eq(5).text();
        verify = $(this).parent().parent().children().eq(5);
        up = $(this).parent().parent().children().eq(16);
        phone = $(this).parent().parent().children().eq(20).text();
       $("td").removeClass("verify");
       $(this).parent().parent().children().eq(6).addClass("verify")     
    });

     // 审核
    var shenhe
    $(".xuanze .img_02").click(function(){
        $(".xuanze .img_02").removeClass("img")
        $(this).addClass("img")
        return shenhe = $(this).next().attr("name")
    });

    // 特权
    var tequan;
    $(".rengyi .img_02").click(function(){
        $(".rengyi .img_02").removeClass("img")
        $(this).addClass("img")
        return tequan = $(this).next().attr("name")
    });

    //困难
    var tekun;
    $(".tekun .img_02").click(function(){
        $(".tekun .img_02").removeClass("img")
        $(this).addClass("img")
        return tekun = $(this).next().attr("name")
    });

    // 冻结
    var n;
    $(".img_dongjie").unbind("click").click(function(){
        $(".img_dongjie").removeClass("img");
        $(this).addClass("img");
        n = $(this).next().attr("name")
    });

    // 全选按钮
    var arr;
    var emve = '';
    var sta_tus = '';
    $("#box").unbind("click").click( 
      function(){ 
        if(this.checked){ 
            $("input[name='checkname']").prop('checked', true)
                var i=0;
                $(".ids").map(function(){
                   v = $(this).text();
                   arr += ","+v;
                   i++;
                });
                $(".emve").map(function(){
                    var y = $(this).text();
                    emve +=y;
                    i++;
                });
                $(".fenghao").map(function(){
                    var x = $(this).text();
                    sta_tus +=x;
                    i++;
                });

        }else{ 
            arr = undefined;
            emve = '';
            $("input[name='checkname']").prop('checked', false)
        } 
      } 

    );
      // 单选
    $("input[name='checkname']").unbind("click").click(function(){
        var v = $(this).parent().parent().children().eq(1).text();
        var y = $(this).parent().parent().children().eq(6).text();
        var z = $(this).parent().parent().children().eq(14).text();
        if(this.checked){   
            arr += ","+v;  
            emve += y; 
            sta_tus += z; 
        }else{
            if(arr==undefined){
                arr = undefined;
            }else{
                arr = arr.replace(","+v, "");
            }
            emve = emve.replace(y,'');
            sta_tus = sta_tus.replace(z,'');
            $("#box").prop("checked",false) 
        } 
    });

    //判断指派是否有选中对象 如果没有则不执行弹框
    $(".zp").unbind("click").click(function(){
      if(arr==undefined||arr==""||arr==null){
            layer.msg("请选择指派对象")
            return  false;
      }
    });

    // 特权 ajax请求  
    var tequan_username;
    var tequan_name;
    var tequan_id;
    $(".tequan").unbind("click").click(function(){
        tequan_id = $(this).parent().parent().children().eq(1).text();
        tequan_username = $(this).parent().parent().children().eq(2).text();
        tequan_name = $(this).parent().parent().children().eq(3).text();
        $(".img_02").removeClass("img")
        $("#mytequan .usn").html(tequan_username);
        $("#mytequan .name").html(tequan_name);
        $(".tequan_beizhujilu").hide();
        $(".tequan_beizhu_textarea").val("")
        $.ajax({
            url:"/member/user/get_user",
            type:"post",
            data:{
                is_company:1,
                id:tequan_id
            },
            success:function(data){
                tequan = data.result.is_transfer;
                if(data.result.is_transfer==0){
                    $(".shutDown").addClass("img")
                }else if(data.result.is_transfer==1){
                    $(".opens").addClass("img")
                }
            }
        })
    });
    //特权通知记录
    $(".tequan_beizhu_ck").unbind("click").click(function(){
        $(".tequan_beizhujilu").toggle();
        $(".tequan_tongzhi_jilu").empty();
        $.ajax({
            url:'/member/sys_remark/get_remark_list',
            type:"post",
            data:{
                user_id:tequan_id,
                type_id:2
            },
            success:function(data){
                if(data.errorCode==0){
                    var html ='';
                    if(data.result.remark_list==''){
                        $(".tequan_tongzhi_jilu").html("暂无通知记录")
                    }else{
                       for(var i=0;i<data.result.remark_list.length;i++){
                        html+="<P>"+data.result.remark_list[i].remark+"</P>"
                            +"<p>"+data.result.remark_list[i].create_time+"</p>"
                        }
                        $(".tequan_tongzhi_jilu").html(html) 
                    }    
                }
            }
        })
    });
    $(".tequan_fasong").unbind("click").click(function(){
        $.ajax({
            url:"/member/user/set_privilege",
            type:"post",
            data:{
                is_company:1,
                id:tequan_id,
                is_transfer:tequan,
                remark:$(".tequan_beizhu_textarea").val()
            },
            success:function(data){
                if(data.errorCode==0){
                    layer.msg("操作成功")
                    $(".img_02").removeClass("img")
                    $(".tequan_beizhu_textarea").val("")
                    $("#mytequan").modal("hide")
                }else{
                    layer.msg(data.errorMsg)
                }
            }
        })
    });


    // 封号 ajax 请求  完成
    var fenghao_id;
    var fenghao_username;
    var fenghao_name;
    var fenghao_jihuozhuangtai;
    var fenghao_jiefeng;
    $(".fenghao").unbind("click").click(function(){
        if($(this).parent().parent().children().eq(14).text()=='-'){
            layer.msg("该用户尚未激活")
            return false;
        }else{
        fenghao_id = $(this).parent().parent().children().eq(1).text();
            fenghao_username = $(this).parent().parent().children().eq(2).text();
            fenghao_name = $(this).parent().parent().children().eq(3).text();
            fenghao_jihuozhuangtai = $(this).parent().parent().children().eq(5).text();
            fenghao_jiefeng = $(this).parent().parent().children().eq(14);
            $(".img_dongjie").removeClass("img")
            $("#myfenghao .username").html(fenghao_username);
            $("#myfenghao .name").html(fenghao_name);
            $("#myfenghao .vif").html(fenghao_jihuozhuangtai)
            n = 1; 
            $.ajax({
                url:"/member/user/get_user",
                type:"post",
                data:{
                    is_company:1,
                    id:fenghao_id
                },
                success:function(data){
                   tekun = data.result.flag;
                   // if(data.result.flag==0){
                   //      $(".True").addClass("img")
                   // }else if(data.result.flag==1){
                   //      $(".False").addClass("img")
                   // }
                   if(data.result.status==2){
                        n = 2;
                        $(".tr").addClass("img")
                   }else{
                        n = 1;
                        $(".fa").addClass("img")
                   }
                }
            });
        }
    });
    $(".fenghao_fasong").unbind("click").click(function(){ 
       $.ajax({
            url:"/member/user/update_active_status",
            type:"post",
            data:{
                is_company:1,
                id:fenghao_id,
                status:n,
                username:fenghao_username,
                remark:$(".fenghao_beizhu").val()
            },
            success:function(data){
                if(data.errorCode==0){
                    layer.msg("操作成功")
                    $("#myfenghao").modal("hide");
                    if(n==1){
                        fenghao_jiefeng.children().html("封号").css("color","#31b0d5")
                    }else if(n==2){
                        fenghao_jiefeng.children().html("解封").css("color","#f00")   
                    }
                }else{
                    layer.msg(data.errorMsg)
                }
            },
            error:function(){
                layer.msg("参数错误请重新传参数")
            }
       })
    });
    $(".fenghao_ck").unbind("click").click(function(){
        $(".fenghao_beizhujilu").toggle();
        $(".fenghao_tongzhi_jilu").empty();
        $.ajax({
            url:'/member/sys_remark/get_remark_list',
            type:"post",
            data:{
                user_id:fenghao_id,
                type_id:1
            },
            success:function(data){
                if(data.errorCode==0){
                    var html ='';
                    if(data.result.remark_list==''){
                        $(".fenghao_tongzhi_jilu").html("暂无通知记录")
                    }else{
                       for(var i=0;i<data.result.remark_list.length;i++){
                        html+="<P>"+data.result.remark_list[i].remark+"</P>"
                            +"<p>"+data.result.remark_list[i].create_time+"</p>"
                        }
                        $(".fenghao_tongzhi_jilu").html(html) 
                    }    
                }
            }
        })
    });
     //通知 
    $(".tongzhi").click(function(){
        $("#mytongzhi .username").html(username);
        $(".name").html(name);
        $("#mytongzhi .img_02").removeClass("img")
        $(".tongzhi_beizhu").hide();
        $(".content_text").val("");
    });
    //通知记录
    $(".NoticeText").unbind("click").click(function(){
        $(".tongzhi_beizhu").toggle();
        $.ajax({
            url:"/member/sys_notification/get_notification_list",
            type:"post",
            data:{
                is_company:1,
                user_id:user_id
            },
            success:function(data){
                if(data.errorCode==0){
                    var html = "";
                    if(data.result==''){
                        $(".tongzhi_text").html("暂无通知记录")
                    }else{
                        $.each(data.result,function(i,o){
                            var newDate = new Date(o.create_time*1000);
                            o.create_time = newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate()+" "+newDate.getHours()+":"+newDate.getMinutes()+":"+newDate.getSeconds();
                            html+="<p>"+o.attend+"</p>"+" <p>"+o.create_time+"</p>";
                            $(".tongzhi_text").html(html)
                        }) 
                    }   
                }
            }

        })
    });
    //获取模板ID
    var ms_tpl_id;
    $("#mytongzhi .img_02").unbind("click").click(function(){
        if($(this).hasClass("img")){
            $("#mytongzhi .img_02").removeClass("img") 
            ms_tpl_id = "" 
        }else{
            $("#mytongzhi .img_02").removeClass("img")
            $(this).addClass("img")
            ms_tpl_id = $(this).attr("name")
        }  
    });
    //发送通知ajax
    $(".tongzhi_fasong").unbind("click").click(function(){
        if($(".content_text").val()!=''){
           $.ajax({
                url:"/member/sys_notification/notify",
                type:"post",
                data:{
                    is_company:1,
                    ms_tpl_id:ms_tpl_id,
                    user_id:user_id,
                    phone:phone,
                    username:username,
                    content:$(".content_text").val(),
                    verify:1
                },
                success:function(data){
                    if(data.errorCode==0){
                        layer.msg("发送成功")
                        ms_tpl_id = '';
                        $("#mytongzhi").modal("hide");
                        verify.text("未通过").css("color","#f00");
                        up.css("color",'#f00')
                    }else{
                        layer.msg(data.errorMsg)
                    }
                }
            }) 
        }else{
            layer.msg("请填写具体原因描述")
        }   
    });

    // 点击审核时，获取用户名及审核状态
    $(".shenhe").click(function(){
        $("#myshenhe .usn").html(username)
        $("#myshenhe .vif").html(shenhezhuangtai)
    });
    //审核提交
    $(".shenhe_tijiao").unbind("click").click(function(){
        $.ajax({
            url:"/member/user/update_audit_status",
            type:"post",
            data:{
                is_company:1,
                id:user_id,
                verify:2,
                username:username,
                remark:""
            },
            success:function(data){
                if(data.errorCode==0){
                    layer.msg("操作成功",{time:1000});
                    $("#myshenhe").modal("hide");
                    if($(".shenhe").val()==''){
                        verify.text("已通过").css("color",'#333');
                        up.css("color","#44cef6")
                    }else{
                        $('.tbody1 tr[flag=' + user_id + ']').fadeOut(300);
                        setTimeout(function(){
                            shuaxin();
                        },1300)
                    }   
                }else{
                    layer.msg(data.errorMsg);
                    
                }
            }
        })
    });
    //查看  ajax   (完成) 
    $(".chakan").unbind("click").click(function(){
        var username = $(this).parent().parent().children().eq(2).text();
        var user_id = $(this).parent().parent().children().eq(1).text();
        $(".user_name").html(username);
        $.ajax({
            url:"/member/user_info/get_user_info",
            type:"post",
            data:{
                is_company:1,
                company_id:user_id
            },
            success:function(data){
                var mun = String(data.result.mobile)
                data.result.mobile =  mun.substring(0,3)+' '+mun.substring(3,7)+' '+mun.substring(7);
                var mun_2 = String(data.result.public_bank_account)
                data.result.public_bank_account = mun_2.substring(0,4)+' '+mun_2.substring(4,8)+' '+mun_2.substring(8,12)+' '+mun_2.substring(12,16)+' '+mun_2.substring(16)
                var mun_3 = String(data.result.legal_bank_account)
                data.result.legal_bank_account = mun_3.substring(0,4)+' '+mun_3.substring(4,8)+' '+mun_3.substring(8,12)+' '+mun_3.substring(12,16)+' '+mun_3.substring(16)
               if(data.errorCode==0){
                    $("#mychakan .modal-body").empty();
                    var html = "";
                    var temp = $(".chakanyonghuxinxi").clone();
                    html=temp.html();
                    var o = data.result;
                    //用户名
                    if(o.username=="NULL"||o.username==undefined||o.username==""||o.username==null){
                       html=html.replace(/\{username\}/g,"");
                    }else{
                       html=html.replace(/\{username\}/g,o.username);
                    }
                    //支付宝
                    if(o.alipay_account=="NULL"||o.alipay_account==undefined||o.alipay_account==""||o.alipay_account==null){
                       html=html.replace(/\{alipay_account\}/g,"");
                    }else{
                       html=html.replace(/\{alipay_account\}/g,o.alipay_account);
                    }
                    //公司名称
                    if(o.company_name=="NULL"||o.company_name==undefined||o.company_name==""||o.company_name==null){
                       html=html.replace(/\{company_name\}/g,"");
                    }else{
                       html=html.replace(/\{company_name\}/g,o.company_name);
                    }
                    //手机号码
                    if(o.mobile=="NULL"||o.mobile==undefined||o.mobile==""||o.mobile==null){
                       html=html.replace(/\{mobile\}/g,"");
                    }else{
                       html=html.replace(/\{mobile\}/g,o.mobile);
                    }
                    //企业法人
                    if(o.legal_person=="NULL"||o.legal_person==undefined||o.legal_person==""||o.legal_person==null){
                       html=html.replace(/\{legal_person\}/g,"");
                    }else{
                       html=html.replace(/\{legal_person\}/g,o.legal_person);
                    }
                    //企业对公账户
                    if(o.public_bank_account=="NULL"||o.public_bank_account==undefined||o.public_bank_account==""||o.public_bank_account==null){
                       html=html.replace(/\{public_bank_account\}/g,"");
                    }else{
                       html=html.replace(/\{public_bank_account\}/g,o.public_bank_account);
                    }
                    //企业开户行
                    if(o.public_bank_name=="NULL"||o.public_bank_name==undefined||o.public_bank_name==""||o.public_bank_name==null){
                       html=html.replace(/\{public_bank_name\}/g,"");
                    }else{
                       html=html.replace(/\{public_bank_name\}/g,o.public_bank_name);
                    }
                    //法人银行账户
                    if(o.legal_bank_account=="NULL"||o.legal_bank_account==undefined||o.legal_bank_account==""||o.legal_bank_account==null){
                       html=html.replace(/\{legal_bank_account\}/g,"");
                    }else{
                       html=html.replace(/\{legal_bank_account\}/g,o.legal_bank_account);
                    }
                    //法人开户行
                    if(o.legal_bank_name=="NULL"||o.legal_bank_name==undefined||o.legal_bank_name==""||o.legal_bank_name==null){
                       html=html.replace(/\{legal_bank_name\}/g,"");
                    }else{
                       html=html.replace(/\{legal_bank_name\}/g,o.legal_bank_name);
                    }
                    //法人支付宝
                    if(o.legal_alipay_account=="NULL"||o.legal_alipay_account==undefined||o.legal_alipay_account==""||o.legal_alipay_account==null){
                       html=html.replace(/\{legal_alipay_account\}/g,"");
                    }else{
                       html=html.replace(/\{legal_alipay_account\}/g,o.legal_alipay_account);
                    }
                    //企业支付宝
                    if(o.company_alipay_account=="NULL"||o.company_alipay_account==undefined||o.company_alipay_account==""||o.company_alipay_account==null){
                       html=html.replace(/\{company_alipay_account\}/g,"");
                    }else{
                       html=html.replace(/\{company_alipay_account\}/g,o.company_alipay_account);
                    }
                    //营业执照编号
                    if(o.business_license=="NULL"||o.business_license==undefined||o.business_license==""||o.business_license==null){
                       html=html.replace(/\{business_license\}/g,"");
                    }else{
                       html=html.replace(/\{business_license\}/g,o.business_license);
                    }
                    $("#mychakan .modal-body").append(html) 
                }else{
                    layer.msg(data.errorMsg)
                }
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
                    $("#pbImage").before("<div class='users'><label>法人姓名 :<span id='name'></span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label>营业执照编号 :<span id='identity'></span></label></div>"); 
                    $("#name").html(data.result.legal_person);
                    $("#identity").html(data.result.business_license);
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
            }
        })
    });
    
    //点击编辑时，默认填充资料
    var name_s;
    var bianji_user_id;
    var bianji_username;
    $(".bianji").unbind("click").click(function(){
        bianji_user_id = $(this).parent().parent().children().eq(1).text();
        bianji_username = $(this).parent().parent().children().eq(2).text();
        $(".bzs textarea").val("");
        $(".bianji_hyzh").html(bianji_username);
        $(".bzs").hide();
        name_s = $(this).parent().parent().children().eq(3);
        $.ajax({
            url:"/member/user_info/get_user_info",
            type:"post",
            data:{
                is_company:1,
                company_id:bianji_user_id
            },
            success:function(data){
                if(data.errorCode==0){
                    var data = data.result;
                    NULL(data.company_name,1)
                    NULL(data.business_license,2)
                    NULL(data.legal_person,3)
                    NULL(data.mobile,5)
                    NULL(data.email,6)
                    NULL(data.legal_alipay_account,7)
                    NULL(data.company_alipay_account,8)
                    NULL(data.legal_bank_account,9)
                    NULL(data.legal_bank_name,10)
                    NULL(data.public_bank_account,11)
                    NULL(data.public_bank_name,12)
                }else{
                    layer.msg(data.errorMsg)
                }
                
            }
        });
    });

    // 查看编辑资料备注记录
    $(".tianjiabeizhu").unbind("click").click(function(){
        $(".beizhu").toggle();
        if($(".beizhu").is(':visible')){
            $.ajax({
                url:'/member/sys_remark/get_remark_list',
                type:"post",
                data:{
                    is_company:1,
                    user_id:bianji_user_id,
                    type_id:3
                },
                success:function(data){
                    if(data.errorCode==0){
                        var html = '';
                        if(data.result.remark_list.length==0){
                            $(".bianji_jilu").html('暂无记录')
                        }else{
                            for(var i=0;i<data.result.remark_list.length;i++){
                             html+='<p>'+data.result.remark_list[i].remark+"</p>"
                             +"<p>"+data.result.remark_list[i].create_time+"</p>"
                            }   
                            $(".bianji_jilu").html(html) 
                        }                       
                    }
                }
            })
        }
    });

    //编辑资料 ajax  (完成)
    $(".bianji_tijiao").unbind("click").click(function(){
        $.ajax({
            url:"/member/user_info/update_user_info",
            type:"post",
            data:{
                is_company:1,
                company_id:bianji_user_id,
                company_name:$(".ipt_1").val(),
                business_license:$(".ipt_2").val(),
                legal_person:$(".ipt_3").val(),
                mobile:$(".ipt_5").val(),
                email:$(".ipt_6").val(),
                legal_alipay_account:$(".ipt_7").val(),
                company_alipay_account:$(".ipt_8").val(),
                legal_bank_account:$(".ipt_9").val(),
                legal_bank_name:$(".ipt_10").val(),
                public_bank_account:$(".ipt_11").val(),
                public_bank_name:$(".ipt_12").val(),
                remark:$(".bianji_beizhu").val()
            },
            success:function(data){
                if(data.errorCode==0){
                    layer.msg("操作成功")
                    name_s.text($(".ipt_1").val())
                    clears();
                    $("#mybianji").modal("hide")
                }else{
                    layer.msg(data.errorMsg)
                }
            },
            error:function(data){
                layer.msg("没有查询到数据")
            
            }
        })
    });
  
    // 指派任务
    $(".zhipai_tijiao").unbind('click').on("click",function(){
        var today = new Date().getTime();
        var str = $("#Date").val(); // 日期字符串
        str = str.replace(/-/g,'/'); // 将-替换成/
        var date = new Date(str).getTime();
        var n=arr.substring(10)
        var b = "'"+emve+"'";
        var c = "'"+sta_tus+"'";
        if(b.indexOf("已通过") > 0||c.indexOf("-")>0||c.indexOf("解封")>0){
            layer.msg('存在未激活或已通过账号，请重新选择数据')
        }else{
           if(date-today>0||today-date<86400000||$(".zhipaigei").val()!=''){
                $("#myzhipai").modal("hide");
                layer.msg("指派中，请耐心，请勿再次点击！")
                $.ajax({
                    url:"/member/sys_work/assign_work",
                    type:"post",
                    data:{
                        user_ids:n,
                        customname:$(".zhipaigei").val(),
                        assign_date:$("#Date").val()
                    },
                    success:function(data){
                        if(data.errorCode==0){
                            layer.msg(data.errorMsg,{time:2000})
                            setTimeout(function(){
                                $(".sousuo").trigger('click')
                            },3000)  
                        }else{
                            layer.msg(data.errorMsg)
                        }
                    }
                })  
            }else{
                layer.msg("指派时间不能小于今天或客服ID不能为空")
            }     
        }
    });
    
    
    $(".zhuanyi").click(function(){
        $(".tuijian_beizhujilu").hide();
        $(".tuijianren_beizhu").val('');
    });
    // 转移推荐人 ajax
    $(".zhuanyi_tijiao").unbind("click").on("click",function(){
        if($(".input_tuijian").val()==''){
            layer.msg("商务中心ID不能为空")
        }else{
            $.ajax({
            url:"/member/user_info/transfer_referee",
            type:"post",
                data:{
                    is_company:1,
                    company_id:user_id,
                    business_center_id:$(".input_tuijian").val(),
                    remark:$(".tuijianren_beizhu").val()
                },
                success:function(data){
                    if(data.errorCode==0){
                        layer.msg("操作成功")
                        $("#mytuijianren").modal("hide");
                        $(".tuijianren_beizhu").val('');
                    }else{
                        layer.msg(data.errorMsg)
                    }
                }
            })
            $("#mytuijianren").modal("hide");
        }    
    });
    //获取转移通知记录
    $(".zhuanyibeizhu").unbind("click").click(function(){
        $(".tongzhi_jilu").empty();
        $(".tuijian_beizhujilu").toggle();
        $.ajax({
            url:'/member/sys_remark/get_remark_list',
            type:"post",
            data:{
                user_id:user_id,
                type_id:4
            },
            success:function(data){
                if(data.errorCode==0){
                    var html ='';
                    if(data.result.remark_list==''){
                        $(".tongzhi_jilu").html("暂无通知记录")
                    }else{
                       for(var i=0;i<data.result.remark_list.length;i++){
                        html+="<P>"+data.result.remark_list[i].remark+"</P>"
                            +"<p>"+data.result.remark_list[i].create_time+"</p>"
                        }
                        $(".tongzhi_jilu").html(html) 
                    }    
                }
            }
        })
    }); 
    // 重置密码
    var chongzhi_username;
    var chongzhi_id;
    $(".chongzhi").unbind("click").click(function(){
        $(".chognzhi_denglu").val('')
        $(".chognzhi_erji").val('')
        chongzhi_username = $(this).parent().parent().children().eq(2).text();
        chongzhi_id = $(this).parent().parent().children().eq(1).text();
        $(".chognzhi_name").html(chongzhi_username);
    });
    $("#chongzhi_queding").unbind("click").click(function(){
       if($('.chognzhi_denglu').val()=='123456'||$('.chognzhi_denglu').val()==chongzhi_username||$('.chognzhi_erji').val()=='123456'||$('.chognzhi_erji').val()==chongzhi_username){
            layer.msg("密码不能为123456或用户名")
       }else{
        var mun = /^(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z]{6,16}$/;
            // 登录密码
            if(mun.test($(".chognzhi_denglu").val())&&mun.test($(".chognzhi_erji").val())||mun.test($(".chognzhi_denglu").val())&&$(".chognzhi_erji").val()==''||mun.test($(".chognzhi_erji").val())&&$(".chognzhi_denglu").val()==''){
                $.ajax({
                    url:"/member/user/reset_passwrod_secondary",
                    type:"post",
                    data:{
                        is_company:1,
                        user_id:chongzhi_id,
                        password:$(".chognzhi_denglu").val(),
                        secondary_password:$(".chognzhi_erji").val()
                    },
                    success:function(data){
                        if(data.errorCode==0){
                            layer.msg("重置成功")
                            $(".chognzhi_denglu").val("")
                            $(".chognzhi_erji").val('')
                            $("#mychongzhi").modal("hide");
                        }else{
                            layer.msg(data.errorMsg)
                        }
                    }
                })  
            }else{
                layer.msg('请输入6-18位字符，必须包含数字字母两种')
            }
        }
    });                        
}  

// 编辑资料完成清空输入框
 function clears(){
    $(".ipt_1").val('');
    $(".ipt_2").val('');
    $(".ipt_3").val("");
    $(".ipt_4").val("");
    $(".ipt_5").val("");
    $(".ipt_6").val("");
    $(".ipt_7").val("");
    $(".ipt_9").val("");
    $(".ipt_10").val("");
    $(".ipt_11").val("");
    $(".ipt_12").val("");
 }

 function day(mun,times){
    var dates = new Date();
    var date = new Date(dates.getTime() - 7 * 24 * 3600 * 1000);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var day_seven = year + '-' + month + '-' + day; //前7天

    var years = dates.getFullYear();
    var months = dates.getMonth()+1;
    var days = dates.getDate();
    var today = years+"-"+months+"-"+days;  //今天
    var day_01 = days-1;
    var months_01 = dates.getMonth();
    var day_prev = years+"-"+months+"-"+day_01; //前一天
    var day_sanshi = years+"-"+months_01+"-"+days; // 前一个月

    if(times=='zc'){
        $(".zuce_time").addClass("img")
        if(mun==1){
            $(".zuce").val(today) 
        }else if(mun==-1){
            $(".zuce").val(day_prev) 
        }else if(mun==7){
            $(".zuce_str").val(day_seven)
            $(".zuce_end").val(today)
        }else if(mun==30){
            if(months_01==0){
                months_01=12
                years=years-1;
                day_sanshi = years+"-"+months_01+"-"+days; // 当跨年时转化成上一年份的12月
            }
            $(".zuce_str").val(day_sanshi)
            $(".zuce_end").val(today)
        }
    }else if(times=='gx'){
        $(".gengxin_time").addClass("img")
        if(mun==1){
            $(".gengxin").val(today) 
        }else if(mun==-1){
            $(".gengxin").val(day_prev) 
        }else if(mun==7){
            $(".gengxin_str").val(day_seven)
            $(".gengxin_end").val(today)
        }else if(mun==30){
            if(months_01==0){
                months_01=12
                years=years-1;
                day_sanshi = years+"-"+months_01+"-"+days; // 当跨年时转化成上一年份的12月
            }
            $(".gengxin_str").val(day_sanshi)
            $(".gengxin_end").val(today)
        }
    }
 }

function judgment(i,o){
    if(o.status=='解封'){
       $(".tbody1 tr").eq(i).children().eq(14).children().css("color","#f00");
    }else if(o.status=='封号'){
        $(".tbody1 tr").eq(i).children().eq(14).children().css("color","#31b0d5");
    }
    if(o.verify == "未审核"){
        o.verify = 0
    }else if(o.verify=="未通过"){
        o.verify = 1;
        $(".tbody1 tr").eq(i).children().eq(5).css("color","#f00");
    }else if(o.verify=="已通过"){
        o.verify = 2
    }
    if(o.update_status == 0 && o.verify== 1){
        $(".tbody1 tr").eq(i).children().eq(16).css("color","#f00");
    }else if(o.update_status == 1 && o.verify == 1 ){
        $(".tbody1 tr").eq(i).children().eq(16).css("color","#0f0");
    }else if(o.verify==0){
        $(".tbody1 tr").eq(i).children().eq(16).css("color","#000");
    }else if(o.verify==2){
        $(".tbody1 tr").eq(i).children().eq(16).css("color","#44cef6");
    }
}

function NULL(data,mun){
    if(data==null||data==undefined||data=="NULL"){
        $('.ipt_'+mun).val("")
    }else{
        $('.ipt_'+mun).val(data)
    } 
}

function nofind(obj){
    obj.src="/static/images/default.png"; 
    obj.style.width="300px";
    obj.style.height="200px";
    obj.style.border="1px solid #ccc";
}

function datezhuanhua(i,o){
    if(o.verify == 0){
        o.verify = "未审核"
    }else if(o.verify==1){
        o.verify = "未通过"
    }else if(o.verify==2){
        o.verify = "已通过"
    }
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