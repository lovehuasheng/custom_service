$(function (){
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
            start_assign_date:$(".renwu_str").val(),
            end_assign_date:$(".renwu_end").val(),
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
                    var html=temp.html();
                    datezhuanhua(i,o);
                    html=html.replace(/\{user_id\}/g,o.user_id);
                    html=html.replace(/\{username\}/g,o.username);
                    html=html.replace(/\{name\}/g,o.name);
                    html=html.replace(/\{verify\}/g,o.verify);
                    html=html.replace(/\{verify_uname\}/g,o.verify_uname);
                    html=html.replace(/\{operator_name\}/g,o.operator_name); 
                    html=html.replace(/\{update_time\}/g,o.update_time);
                    html=html.replace(/\{create_time\}/g,o.create_time);
                    html=html.replace(/\{phone\}/g,o.phone);
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
                            layer.msg("指派中，请耐心，请勿再次点击")
                            $.ajax({
                                url:"/member/sys_work/assign_work",
                                type:"post",
                                data:{ 
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
                                    start_assign_date:$(".renwu_str").val(),
                                    end_assign_date:$(".renwu_end").val(),
                                    create_time_start:create_time_start,
                                    create_time_end:create_time_end,
                                    update_time_start:update_time_start,
                                    update_time_end:update_time_end
                                },
                                success:function(data){
                                    if(data.errorCode==0){
                                        layer.msg(data.errorMsg,{time:2000})                      
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
                            start_assign_date:$(".renwu_str").val(),
                            end_assign_date:$(".renwu_end").val(),
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
                                    var html=temp.html();
                                    datezhuanhua(i,o);                           
                                    html=html.replace(/\{user_id\}/g,o.user_id);
                                    html=html.replace(/\{username\}/g,o.username);
                                    html=html.replace(/\{name\}/g,o.name);
                                    html=html.replace(/\{verify\}/g,o.verify);
                                    html=html.replace(/\{verify_uname\}/g,o.verify_uname);
                                    html=html.replace(/\{operator_name\}/g,o.operator_name);
                                    html=html.replace(/\{update_time\}/g,o.update_time);
                                    html=html.replace(/\{create_time\}/g,o.create_time);
                                    html=html.replace(/\{phone\}/g,o.phone);
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
                            start_assign_date:$(".renwu_str").val(),
                            end_assign_date:$(".renwu_end").val(),
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
                                    var html = temp.html();
                                    datezhuanhua(i,o)
                                    html=html.replace(/\{user_id\}/g,o.user_id);
                                    html=html.replace(/\{username\}/g,o.username);
                                    html=html.replace(/\{name\}/g,o.name);
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
        user_id = $(this).parent().parent().children().eq(1).text();
        sessionStorage.setItem('user_id',user_id);
        username = $(this).parent().parent().children().eq(2).text();
        name = $(this).parent().parent().children().eq(3).text();
        shenhezhuangtai = $(this).parent().parent().children().eq(6).text();
        verify = $(this).parent().parent().children().eq(6);
        up = $(this).parent().parent().children().eq(14);
        phone = $(this).parent().parent().children().eq(17).text();
       $("td").removeClass("verify");
       $(this).parent().parent().children().eq(6).addClass("verify");  
    });

     // 审核
    var shenhe
    $(".xuanze .img_02").unbind("click").click(function(){
        $(".xuanze .img_02").removeClass("img")
        $(this).addClass("img")
        return shenhe = $(this).next().attr("name")
    });

    // 特权
    var tequan;
    $(".rengyi .img_02").unbind("click").click(function(){
        $(".rengyi .img_02").removeClass("img")
        $(this).addClass("img")
        return tequan = $(this).next().attr("name")
    });

    //困难
    var tekun;
    $(".tekun .img_02").unbind("click").click(function(){
        $(".tekun .img_02").removeClass("img")
        $(this).addClass("img")
        tekun = $(this).next().attr("name")
    });

    // 冻结
    var n;
    $(".dongjie .img_dongjie").unbind("click").click(function(){
        $(".dongjie .img_dongjie").removeClass("img")
        $(this).addClass("img");
        n = $(this).next().attr("name");
    });

    // 全选按钮
    var arr;
    $("#box").click( 
      function(){ 
        if(this.checked){ 
            $("input[name='checkname']").prop('checked', true)
                var i=0;
                $(".ids").map(function(){
                   v = $(this).text();
                   arr += ","+v;
                   i++;
                });
        }else{ 
            arr = undefined;
            $("input[name='checkname']").prop('checked', false)
        } 
      } 
    );
      // 单选
    $("input[name='checkname']").click(function(){
        var v =$(this).parent().parent().children().eq(1).text()
        if(this.checked){   
            arr += ","+v;  
        }else{
            if(arr==undefined){
                arr = undefined;
            }else{
                arr = arr.replace(","+v, "");
            }
            
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

    //查看推荐人和隶属组
    $(".look").unbind("click").click(function(){
        var user_id = $(this).parent().parent().children().eq(1).text();
        $.ajax({
            url:"/member/user_info/get_group_referee",
            type:"post",
            data:{
                user_id:user_id
            },
            success:function(data){
                if(data.errorCode==0){
                    $(".tuijianren_zhanghao").html(data.result.referee)
                    $(".tuijianren_name").html(data.result.referee_name)
                    $(".tuijianren_lishuzu").html(data.result.group_name)
                    $(".tuijianren_zushuxing").html(data.result.group)
                }
            }
        })
    });


    // // 特权 ajax请求 
    // var tequan_user_id;
    // var is_poor; 
    // $(".tequan").unbind("click").click(function(){
    //     tequan_user_id = $(this).parent().parent().children().eq(1).text();
    //     var username = $(this).parent().parent().children().eq(2).text();
    //     var name = $(this).parent().parent().children().eq(3).text();
    //     $(".img_02").removeClass("img")
    //     $("#mytequan .usn").html(username);
    //     $("#mytequan .name").html(name)
    //     $(".tequan_beizhujilu").hide();
    //     $(".tequan_beizhu_textarea").val("")
    //     $.ajax({
    //         url:"/member/user/get_user",
    //         type:"post",
    //         data:{
    //             id:tequan_user_id
    //         },
    //         success:function(data){
    //             tequan = data.result.is_transfer;
    //             if(data.result.is_transfer==0){
    //                 $(".shutDown").addClass("img")
    //             }else if(data.result.is_transfer==1){
    //                 $(".opens").addClass("img")
    //             }
    //             is_poor = data.result.is_poor;
    //             if(data.result.is_poor==0){
    //                 $(".notPoor").addClass("img")
    //                 tekun = 0 
    //             }else if(data.result.is_poor==1){
    //                 $(".poor").addClass("img")
    //                 tekun = 1
    //             }
    //         }
    //     })
    // });

    // //特权通知记录
    // $(".tequan_beizhu_ck").unbind("click").click(function(){
    //     $(".tequan_beizhujilu").toggle();
    //     $(".tequan_tongzhi_jilu").empty();
    //     $.ajax({
    //         url:'/member/sys_remark/get_remark_list',
    //         type:"post",
    //         data:{
    //             user_id:tequan_user_id,
    //             type_id:2
    //         },
    //         success:function(data){
    //             if(data.errorCode==0){
    //                 var html ='';
    //                 if(data.result.remark_list==''){
    //                     $(".tequan_tongzhi_jilu").html("暂无通知记录")
    //                 }else{
    //                    for(var i=0;i<data.result.remark_list.length;i++){
    //                     html+="<P>备注内容"+data.result.remark_list[i].remark+"</P>"
    //                         +"<p>备注时间"+data.result.remark_list[i].create_time+"</p>"
    //                     }
    //                     $(".tequan_tongzhi_jilu").html(html) 
    //                 }    
    //             }else{
    //                 layer.msg(data.errorMsg)
    //             }
    //         }
    //     })
    // });
     
    // $(".tequan_fasong").unbind("click").click(function(){
    //     $.ajax({
    //         url:"/member/user/set_privilege",
    //         type:"post",
    //         data:{
    //             id:tequan_user_id,
    //             is_transfer:tequan,
    //             is_poor:tekun,
    //             remark:$(".tequan_beizhu_textarea").val()
    //         },
    //         success:function(data){
    //             if(data.errorCode==0){
    //                 layer.msg("操作成功")                
    //                 $(".img_02").removeClass("img")
    //                 $(".tequan_beizhu_textarea").val("")
    //                 $("#mytequan").modal("hide")
    //             }else{
    //                 layer.msg(data.errorMsg)
    //             }
    //         }
    //     })
    // });
    // // 封号 ajax 请求  完成
    // var fenghao_user_id;
    // var fenghao_username;
    // var fegnhao_shenhezhuangtai;
    // $(".fenghao").unbind("click").click(function(){
    //     fenghao_user_id = $(this).parent().parent().children().eq(1).text();
    //     fenghao_username = $(this).parent().parent().children().eq(2).text();
    //     fegnhao_shenhezhuangtai = $(this).parent().parent().children().eq(6).text();
    //     var name = $(this).parent().parent().children().eq(3).text();
    //     $(".img_dongjie").removeClass("img")
    //     $("#myfenghao .username").html(fenghao_username);
    //     $("#myfenghao .name").html(name);
    //     $("#myfenghao .vif").html(fegnhao_shenhezhuangtai);
    //     $(".fenghao_beizhujilu").hide();
    //     $(".fenghao_beizhu").val("");
    //     $.ajax({
    //         url:"/member/user/get_user",
    //         type:"post",
    //         data:{
    //             id:fenghao_user_id
    //         },
    //         success:function(data){
    //            tekun = data.result.flag;
    //            if(data.result.flag==0){
    //                 $(".True").addClass("img")
    //            }else if(data.result.flag==1){
    //                 $(".False").addClass("img")
    //            }
    //            if(data.result.status==2){
    //                 $(".tr").addClass("img")
    //                 n = 2; 
    //            }else{
    //                 $(".fa").addClass("img")
    //                 n = 1; 
    //            }
    //         }
    //     })
    // });

    // //封号发送
    // $(".fenghao_fasong").unbind("click").click(function(){ 
    //    $.ajax({
    //         url:"/member/user/update_active_status",
    //         type:"post",
    //         data:{
    //             id:fenghao_user_id,
    //             status:n,
    //             flag:tekun,
    //             username:fenghao_username,
    //             remark:$(".fenghao_beizhu").val()
    //         },
    //         success:function(data){
    //             if(data.errorCode==0){
    //                 layer.msg("操作成功")
    //                 $("#myfenghao").modal("hide");
    //             }else{
    //                 layer.msg(data.errorMsg)
    //             }
    //         },
    //         error:function(){
    //             layer.msg("参数错误请重新传参数")
    //         }
    //    })
    // });
    // //  封号通知记录
    // $(".fenghao_ck").unbind("click").click(function(){
    //     $(".fenghao_beizhujilu").toggle();
    //     $(".fenghao_tongzhi_jilu").empty();
    //     $.ajax({
    //         url:'/member/sys_remark/get_remark_list',
    //         type:"post",
    //         data:{
    //             user_id:fenghao_user_id,
    //             type_id:1
    //         },
    //         success:function(data){
    //             if(data.errorCode==0){
    //                 var html ='';
    //                 if(data.result.remark_list==''){
    //                     $(".fenghao_tongzhi_jilu").html("暂无通知记录")
    //                 }else{
    //                    for(var i=0;i<data.result.remark_list.length;i++){
    //                     html+="<P>备注内容: "+data.result.remark_list[i].remark+"</P>"
    //                         +"<p>备注时间: "+data.result.remark_list[i].create_time+"</p>"
    //                     }
    //                     $(".fenghao_tongzhi_jilu").html(html) 
    //                 }    
    //             }
    //         }
    //     })
    // });
     //通知 
    $(".tongzhi").click(function(){
        $("#mytongzhi .username").html(username);
        $(".name").html(name);
        $("#mytongzhi .img_02").removeClass("img")
        $(".tongzhi_jilus").hide();
        $(".tongzhi_text").val("");
        $(".content_text").val("");
    });
    //通知记录
    $(".NoticeText").unbind("click").click(function(){
        $(".tongzhi_jilus").toggle();
        $.ajax({
            url:"/member/sys_notification/get_notification_list",
            type:"post",
            data:{   
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
                            html+="<p>通知内容:"+o.attend+"</p>"+" <p>通知时间:"+o.create_time+"</p>";
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
                        $("#mytongzhi").modal("hide");
                        ms_tpl_id = "";
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
    //审核 ajax  完成  第一页审核状态*********************************************/
    $(".shenhe_tijiao").unbind("click").click(function(){
        $.ajax({
            url:"/member/user/update_audit_status",
            type:"post",
            data:{
                
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
                        verify.text("已通过").css("color","#333");
                    }else{
                        $('.tbody1 tr[flag=' + user_id + ']').fadeOut(300);
                        setTimeout(function(){
                            shuaxin(); //刷新页面
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
                user_id:user_id
            },
            success:function(data){
                var mun = String(data.result.phone)
                data.result.phone =  mun.substring(0,3)+' '+mun.substring(3,7)+' '+mun.substring(7);
                var mun_2 = String(data.result.bank_account)
                data.result.bank_account = mun_2.substring(0,4)+' '+mun_2.substring(4,8)+' '+mun_2.substring(8,12)+' '+mun_2.substring(12,16)+' '+mun_2.substring(16,20)+' '+mun_2.substring(20)
                var mun_3 = String(data.result.card_id)
                data.result.card_id = mun_3.substring(0,6)+' '+mun_3.substring(6,14)+' '+mun_3.substring(14);
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
                    //姓名
                    if(o.name=="NULL"||o.name==undefined||o.name==""||o.name==null){
                       html=html.replace(/\{name\}/g,"");
                    }else{
                       html=html.replace(/\{name\}/g,o.name);
                    }
                    //手机号码
                    if(o.phone=="NULL"||o.phone==undefined||o.phone==""||o.phone==null){
                       html=html.replace(/\{phone\}/g,"");
                    }else{
                       html=html.replace(/\{phone\}/g,o.phone);
                    }
                    //微信
                    if(o.weixin_account=="NULL"||o.weixin_account==undefined||o.weixin_account==""||o.weixin_account==null){
                       html=html.replace(/\{weixin_account\}/g,"");
                    }else{
                       html=html.replace(/\{weixin_account\}/g,o.weixin_account);
                    }
                    //银行账号
                    if(o.bank_account=="NULL"||o.bank_account==undefined||o.bank_account==""||o.bank_account==null){
                       html=html.replace(/\{bank_account\}/g,"");
                    }else{
                       html=html.replace(/\{bank_account\}/g,o.bank_account);
                    }
                    //开户行
                    if(o.bank_name=="NULL"||o.bank_name==undefined||o.bank_name==""||o.bank_name==null){
                       html=html.replace(/\{bank_name\}/g,"");
                    }else{
                       html=html.replace(/\{bank_name\}/g,o.bank_name);
                    }
                    //身份证号
                    if(o.card_id=="NULL"||o.card_id==undefined||o.card_id==""||o.card_id==null){
                       html=html.replace(/\{card_id\}/g,"");
                    }else{
                       html=html.replace(/\{card_id\}/g,o.card_id);
                    }
                    //邮箱
                    if(o.email=="NULL"||o.email==undefined||o.email==""||o.email==null){
                       html=html.replace(/\{email\}/g,"");
                    }else{
                       html=html.replace(/\{email\}/g,o.email);
                    }
                    $("#mychakan .modal-body").append(html) 
                }else{
                    layer.msg(data.errorMsg)
                }
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
            }
        })
    });
    
    //点击编辑时，默认填充资料
    var name_s;
    var bianji_id;
    var bianji_username;
    $(".bianji").unbind("click").click(function(){
        bianji_id = $(this).parent().parent().children().eq(1).text();
        bianji_username = $(this).parent().parent().children().eq(2).text();
        $(".bianji_hyzh").html(bianji_username)
        $(".beizhu").hide();
        $(".bianji_beizhu").val('');
        $(".bzs textarea").val("");
        $(".bzs").hide();
        name_s = $(this).parent().parent().children().eq(3);
        $.ajax({
            url:"/member/user_info/get_user_info",
            type:"post",
            data:{
                user_id:bianji_id
            },
            success:function(data){
                if(data.errorCode==0){
                    var data = data.result;
                    NULL(data.name,1)
                    NULL(data.phone,2)
                    NULL(data.email,3)
                    NULL(data.alipay_account,4)
                    NULL(data.weixin_account,5)
                    NULL(data.card_id,6)
                    NULL(data.bank_name,7)
                    NULL(data.bank_account,8)
                }else{
                    layer.msg(data.errorMsg)
                }
                
            }
        });
    });

    $(".tianjiabeizhu").unbind("click").click(function(){
        $(".beizhu").toggle();
    })
    //编辑资料 ajax  (完成)
    $(".bianji_tijiao").unbind("click").click(function(){
        $.ajax({
            url:"/member/user_info/update_user_info",
            type:"post",
            data:{
                user_id:bianji_id,
                name:$(".ipt_1").val(),
                phone:$(".ipt_2").val(),
                email:$(".ipt_3").val(),
                alipay_account:$(".ipt_4").val(),
                weixin_account:$(".ipt_5").val(),
                card_id:$(".ipt_6").val(),
                bank_name:$(".ipt_7").val(),
                bank_account:$(".ipt_8").val()
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
    });
    
    
    // $(".zhuanyi").click(function(){
    //     $(".tuijian_beizhujilu").hide();
    //     $(".tuijianren_beizhu").val('');
    //     $(".input_tuijian").val('');
    // });
    // // 转移推荐人 ajax
    // $(".zhuanyi_tijiao").unbind("click").on("click",function(){
    //     if($(".input_tuijian").val()==''){
    //         layer.msg("ID不能为空")
    //     }else{
    //         $.ajax({
    //         url:"/member/user_info/transfer_referee",
    //         type:"post",
    //             data:{ 
    //                 user_id:user_id,
    //                 referee_id:$(".input_tuijian").val(),
    //                 remark:$(".tuijianren_beizhu").val()
    //             },
    //             success:function(data){
    //                 if(data.errorCode==0){
    //                     layer.msg("操作成功")
    //                     $("#mytuijianren").modal("hide");
    //                     $(".tuijianren_beizhu").val('');
    //                 }else{
    //                     layer.msg(data.errorMsg)
    //                 }
    //             }
    //         })
    //         $("#mytuijianren").modal("hide");
    //     }    
    // });
    // //获取转移通知记录
    // $(".zhuanyibeizhu").unbind("click").click(function(){
    //     $(".tongzhi_jilu").empty();
    //     $(".tuijian_beizhujilu").toggle();
    //     $.ajax({
    //         url:'/member/sys_remark/get_remark_list',
    //         type:"post",
    //         data:{
    //             user_id:user_id,
    //             type_id:4
    //         },
    //         success:function(data){
    //             if(data.errorCode==0){
    //                 var html ='';
    //                 if(data.result.remark_list==''){
    //                     $(".tongzhi_jilu").html("暂无通知记录")
    //                 }else{
    //                    for(var i=0;i<data.result.remark_list.length;i++){
    //                     html+="<P>备注内容: "+data.result.remark_list[i].remark+"</P>"
    //                         +"<p>备注时间: "+data.result.remark_list[i].create_time+"</p>"
    //                     }
    //                     $(".tongzhi_jilu").html(html) 
    //                 }    
    //             }
    //         }
    //     })
    // });                         
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
    $(".ipt_8").val("");
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
    if(o.verify == "未审核"){
        o.verify = 0
    }else if(o.verify=="未通过"){
        o.verify = 1;
        $(".tbody1 tr").eq(i).children().eq(6).css("color","#f00");
    }else if(o.verify=="已通过"){
        o.verify = 2
    }
    if(o.update_status == 0){
        $(".tbody1 tr").eq(i).children().eq(14).css("color","#f00");
    }else if(o.update_status == 1 && o.verify == 1 ){
        $(".tbody1 tr").eq(i).children().eq(14).css("color","#0f0");
    }else{
        $(".tbody1 tr").eq(i).children().eq(14).css("color","#f00");
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