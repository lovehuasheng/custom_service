$(function(){
	$("#tianjia,#bianji,#tingyong").modal({backdrop:"static",show:false});
    ajaxs()
/*************添加客服**************************/
var phone  = /^1[3578]\d{9}$/;
var phone_val ="";
    // $(".tianjia").click(function(){
    //     layer.msg("请优先填写手机号码")
          
    // })
    // var is_super="";
    // $(".img_02").click(function(){
    //     $(".img_02").removeClass("img");
    //     $(this).addClass("img")
    //     is_super = $(this).next().attr("name")
    //     console.log(is_super)

    // })
    $(".phon_e").blur(function(){
        if(phone.test($(".phon_e").val())){
           phone_val = $(".phon_e").val()
        }else{
           layer.msg("手机号码有误")
           phone_val = ""
        }
    })

    $(".tianjia_baocun").click(function(){
      if(phone_val==""){
        layer.msg("请输入正确手机号码和权限组")
      }else{
        $.ajax({
            url:"/user/user/add_user",
            type:"post",
            data:{
                username:$(".user_name").val(),
                password:$(".pass_word").val(),
                realname:$(".name_s").val(),
                mobile:phone_val
                // is_super:is_super
            },
            success:function(data){
                if(data.errorCode==0){
                    layer.msg("添加成功")
                    $("#tianjia").modal("hide")
                    $("input").val("")
                    ajaxs()
                }else{
                    layer.msg(data.errorMsg)
                }
            }
        })
      }  
    });

/*************添加客服end**************************/


});  //结束标签

// 关闭弹框
function over(id){
    $(id).modal("hide");
    $("input").val("")
}

var pages; //将页数提取出来
/**************页面加载完成执行下列操作*******************/ 
function caozuo(){
   var phone  = /^1[3578]\d{9}$/;
   var usernames;
   var status;
   var mun;
   var id;
   var name;
   var bumen;
   var mobile;
   var quanxianzu;
   var group_id;
   var flag = false;
    $(".caozuo").click(function(){
        usernames = $(this).attr('_username')
        status = $(this).attr('_status')
        mobile = $(this).attr("_mobile")
        group_id = $(this).attr("_group_id")
        id = $(this).parent().parent().children().eq(0).text()
        name = $(this).parent().parent().children().eq(2).text()
        bumen = $(this).parent().parent().children().eq(3).text()
        quanxianzu = $(this).parent().parent().children().eq(4).text()
        $(".dengluzhanghao").val(usernames)
        $("td").removeClass("status");
        $(this).parent().parent().children().eq(5).addClass("status");
    });

    $(".bianji").click(function(){
        $(".nam").val(name)
        $(".bumen").val(bumen)
        $(".phone").val(mobile)

        $(".phone").blur(function(){
            if(phone.test($(".phone").val())){
                return flag = true;
            }else{
                layer.msg("请输入正确手机号码")
            }
        })

        $.ajax({
            url:"/permission/sys_group/get_group_list",
            success:function(data){
                if(data.errorCode==0){  
                   $(".sel select").empty();
                       if(quanxianzu==''){
                          $(".sel select").append("<option>请选择权限组</option>")  
                       }else{
                          $(".sel select").append("<option>"+quanxianzu+"</option>")
                          mun = group_id
                       }
                        $.each(data.result,function(i,o){
                        $(".sel select").append($("#none2").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
                    }); 
                    $(".sel select").click(function(){
                        $(".sel select option").eq(0).hide();
                    })
                    $(".sel select").change(function(){
                        mun = $(this).val()
                    });
                } 
            }  //获取用户权限组 succsee结束标签
        });  //登录账号AJAX结束标签 
    });  // 编辑完成
    
    $(".bianji_baocun").unbind("click").click(function(){
        if(phone.test($(".phone").val())){
            flag = true;
        }else{
            layer.msg("请输入正确手机号码")
        }
        if(flag){
            $.ajax({
                url:"/user/user/set_user",    
                type:"post",
                data:{
                    id:id,
                    username:usernames,
                    password:$(".psd").val(),
                    realname:$(".nam").val(),
                    remark:$(".bumen").val(),
                    mobile:$(".phone").val(),
                    group_id:mun
                },
                success:function(data){
                    if(data.errorCode==0){
                        layer.msg("操作成功")
                        $("#bianji").modal("hide")
                        $("input").val("")
                        diaoyong(pages)
                    }else if(data.errorCode==-20025){
                        layer.msg('用户权限为必选')
                    }else{
                        layer.msg(data.errorMsg)
                    }
                }
            })
        }else{
            layer.msg("请输入正确手机号码后提交")
        }   
    });
    
    

    /*******************停用启用**********************/
    $(".tingyong_baocun").unbind("click").click(function(){
        if(status=="启用"){
                sta=1
            }else{
                sta=0
            }
           $.ajax({
                url:"/user/user/disable_user",
                type:"post",
                data:{
                    ids:id,
                    pwd:$(".pwd").val(),
                    status:sta
                },
                success:function(data){
                    if(data.errorCode==-200){
                        layer.msg(data.errorMsg)
                        $("#tingyong").modal("hide")
                        $(".pwd").val("")
                        diaoyong(pages)
                        if(sta==1){
                            $(".status").text("停用")
                        }else{
                            $(".status").text("启用") 
                        }
                    }else{
                        layer.msg(data.errorMsg)
                    }
                }
        })
    });
    /*******************停用启用 end**********************/  
}


/*************分页*******************/
function diaoyong(p){
    $.ajax({
        url:"/user/user/user_list",
        type:"post",
        data:{
            page:p
        },
        success:function(data){
            if(data.errorCode==0){
                $(".table-striped tbody").eq(1).empty();
                $.each(data.result.data,function(i,o){
                    date(i,o)
                    $(".table-striped tbody").eq(1).append($("#none").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
                    
                })
            }
        caozuo()
        }
    })
}

/*************ajax*******************/
function ajaxs(){
var maxPages;
$.ajax({
    url:"/user/user/user_list",
    type:"post",
    success:function(data){
        // 分页样式
        $(".tcdPageCode").unbind("click").createPage({
            pageCount:data.result.pages.max_page,
            current:1,
            backFn:function(p){
                diaoyong(p)
                pages = p;
            }
        });
        if(data.errorCode==0){
            $(".table-striped tbody").eq(1).empty();
            maxPages = data.result.pages.max_page;
            $.each(data.result.data,function(i,o){
                date(i,o);
                $(".table-striped tbody").eq(1).append($("#none").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));   
            })
        }
        caozuo()
    } // success 结束标签 
});
   
   // 选择跳转页数
    $(".PagesCode").click(function(){
        if($(".pageCode").val()!=''&&$(".pageCode").val()!=0){
            if($(".pageCode").val()<maxPages||$(".pageCode").val()==maxPages){
                $.ajax({
                    url:"/user/user/user_list",
                    type:"post",
                    data:{
                        page:$(".pageCode").val()
                    },
                    success:function(data){
                        $(".tcdPageCode").unbind("click").createPage({
                            pageCount:maxPages,
                            current:$(".pageCode").val(),
                            backFn:function(p){
                                diaoyong(p) 
                            }
                        });
                        if(data.errorCode==0){
                            $(".table-striped tbody").eq(1).empty();
                            maxPages = data.result.pages.max_page;
                            $.each(data.result.data,function(i,o){
                                date(i,o);
                                $(".table-striped tbody").eq(1).append($("#none").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));   
                            })
                        }
                        caozuo()
                    } // success 结束标签 
                });
            
            }else{
               layer.msg("最大页数 为"+maxPages+" 页") 
            }
        }else{
            layer.msg("请选择正确的跳转页数")
        }
    })
}

function date(i,o){
    if(o.status==0){
        o.status='启用'
    }else{
        o.status='停用' 
    }
    var newDate = new Date(o.last_login_time*1000);
    var mon = (newDate.getMonth()+1);
    var day = newDate.getDate();
    var hour = newDate.getHours();
    var min = newDate.getMinutes();
    var sec = newDate.getSeconds();
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
    o.last_login_time = newDate.getFullYear()+"-"+mon+"-"+day+" "+hour+":"+min+":"+sec;
}