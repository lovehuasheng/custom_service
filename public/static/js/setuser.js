$(function(){
	$("#bianji,#shouquan,#shanchu").modal({backdrop:"static",show:false});
    // 页面打开加载AJAX
    $.ajax({
        url:"/permission/sys_group/get_group_list",
        type:"post",
        data:{
            //不需要传参数
        },
        success:function(data){
            $(".table-striped tbody").empty();
            //加载用户数据
            if(data.errorCode==0){ 
                var temp = $("#none").clone();
                var temp2 = $("#tit").clone();
                var html2=temp2.html();
                $(".table-striped tbody").append(html2)
                $.each(data.result,function(i,o){
                    var html=temp.html();
                    if(o.status==0){
                        o.status="启用"
                    }else{
                        o.status="停用"
                    }
                    html=html.replace(/\{id\}/g,o.id);
                    html=html.replace(/\{name\}/g,o.group_name); 
                    html=html.replace(/\{remark\}/g,o.remark);
                    html=html.replace(/\{status\}/g,o.status);
                    $(".table-striped tbody").append(html)
                })     
            }  //加载完成
            contents()   
        }
    });

    // 添加AJAX请求 完成
    $(".tianjia_baocun").click(function(){
        $.ajax({
            url:"/permission/sys_group/add_group",
            type:"post",
            data:{
               group_name:$(".tianjia_name").val(),
               remark:$(".tianjia_remark").val()
            },
            success:function(data){
                if(data.errorCode==0){
                    $.each(data.result,function(i,o){
                        var html = "";   
                        var temp = $("#none").clone();
                        $(".table-striped tbody").append(html2)
                        $.each(data.result,function(i,o){
                            var html=temp.html();
                            html=html.replace(/\{id\}/g,o.id);
                            html=html.replace(/\{name\}/g,o.group_name); 
                            html=html.replace(/\{remark\}/g,o.remark);
                            html=html.replace(/\{status\}/g,o.status);
                            $(".table-striped tbody").append(html)
                        });    
                    })
                    $("#tianjia").modal("hide")
                    ajaxs();
                }else{
                    layer.msg(data.errorMsg)
                }
            }
        })
    });
      
});  
/*****************$(function(){})全部结束*************************/

 // 取消按钮
function btn1(id){
    $(id).modal("hide")
    $(".img_02").removeClass("img")
    $("input").val("")
    $("textarea").val("")
};


// ajax加载
function  ajaxs(){
    $.ajax({
        url:"/permission/sys_group/get_group_list",
        type:"post",
        data:{
            //不需要传参数
        },
        success:function(data){
            $(".table-striped tbody").empty();
            //加载用户数据
            if(data.errorCode==0){ 
                var temp = $("#none").clone();
                var temp2 = $("#tit").clone();
                var html2=temp2.html();
                $(".table-striped tbody").append(html2)
                $.each(data.result,function(i,o){
                    var html=temp.html();
                    if(o.status==0){
                        o.status="启用"
                    }else{
                        o.status="停用"
                    }
                    html=html.replace(/\{id\}/g,o.id);
                    html=html.replace(/\{name\}/g,o.group_name); 
                    html=html.replace(/\{remark\}/g,o.remark);
                    html=html.replace(/\{status\}/g,o.status);
                    $(".table-striped tbody").append(html)
                })    
            } 
            contents() 
        }
    });
}


// 加载完成  各功能调用
function contents(){
        // 添加 启用/停用切换  返回name值
        var val; //获取添加是否启用  0 启用 1停用
        $("#tianjia .img_02").click(function(){
            $("#tianjia .img_02").removeClass("img");
            $(this).addClass("img")
            return val = $(this).attr("name")
        });
        var val2;//获取编辑是否启用  0 启用 1停用
        $("#bianji .img_02").click(function(){
            $("#bianji .img_02").removeClass("img");
            $(this).addClass("img")
            return val2 = $(this).attr("name")
        });
        // 获取用户ID
        var id;
        var name;
        var remark;
        var status;
        $(".caozuo").click(function(){
            id = $(this).parent().parent().children().eq(0).text(),
            name = $(this).parent().parent().children().eq(1).text(),
            remark = $(this).parent().parent().children().eq(2).text(),
            status = $(this).parent().parent().children().eq(3).text()
        });
        // 点击编辑进行预加载用户信息
        $(".bianji").click(function(){
            $(".zuming").val(name)
            $(".miaoshu").val(remark)
            if(status=='启用'){
                status = 0
                $(".img_02").removeClass("img")
                $(".left").addClass("img")
            }else{
                status = 1 
                $(".img_02").removeClass("img")
                $(".prev").addClass("img")
            }
        })
        // 编辑用户组信息
        $(".bianji_baocun").unbind("click").click(function(){
           $.ajax({
                url:"/permission/sys_group/update_group",
                type:"post",
                data:{
                   id:id,
                   group_name:$("#bianji .zuming").val(),
                   remark:$("#bianji .miaoshu").val(),
                   status:val2
                },
                success:function(data){
                    if(data.errorCode==0){
                        layer.msg("操作成功")
                        ajaxs()
                        $(".img_02").removeClass("img")
                        $("#bianji").modal("hide") 
                    }else{
                        layer.msg(data.errorMsg)
                    }
                }
            }) 
        }); //编辑用户组信息 end

        /****************删除用户组********************/
        $(".shanchu_baocun").unbind("click").click(function(){
            $.ajax({
                url:"/permission/sys_group/del_group",
                type:"post",
                data:{
                   ids:id,
                   secondary_password:$(".pwd").val()
                },
                success:function(data){
                    if(data.errorCode==0){
                        layer.msg("操作成功")
                        $("#shanchu").modal("hide")
                        ajaxs();
                    }else{
                        layer.msg(data.errorMsg)
                    }
                }
            }) 

        });  
        /***********删除用户组 end****************/
            /**查看用户组权限***/
            var arr=""; 
            $(".shouquan").click(function(){  
                arr = ''; 
                $.ajax({
                    url:"/permission/sys_group/get_group_permission",
                    type:"post",
                    data:{
                        id:id
                    },
                    success:function(data){
                        $("#shouquan .modal-body .row").empty();
                           if(data.errorCode==0){
                                var temp = $("#chakanquanxian").clone();
                                $.each(data.result.operations,function(i,o){
                                    var html=temp.html();
                                    var a = o.id;
                                    html=html.replace(/\{id\}/g,o.id);
                                    html=html.replace(/\{name\}/g,o.name); 
                                    $("#shouquan .modal-body .row").append(html);
                                    $.each(data.result.permissions,function(i,ob){
                                        if(o.id==ob){
                                            $("#"+o.id).addClass("img") 
                                            arr+=","+ob                                        
                                        }
                                    })                                    
                                });   
                            }else{
                                layer.msg(data.errorMsg)
                            } 
                       
                        $("#shouquan .img_02").click(function(){
                            var a = $(this).attr("id")
                            if($(this).hasClass("img")==true){
                                $(this).removeClass("img")
                                arr = arr.replace(","+a, "");
                            }else{
                                $(this).addClass("img")
                                arr += ","+a;
                            }
                        });  

    /*****************选择授权权限end********************/ 

        /**************给用户组授权****************/
        $(".shouquan_baocun").unbind("click").click(function(){
                    var n=arr.substring(1)
                    if(n!=""){
                        $.ajax({
                            url:"/permission/sys_group/set_group_permission",
                            type:"post",
                            data:{
                                id:id,
                                permissions:n
                            },
                            success:function(data){
                                if(data.errorCode==0){
                                    layer.msg("授权成功")
                                    $("#shouquan").modal("hide")
                                    $(".img_02").removeClass("img")
                                    n ="";
                                    arr = '';
                                    ajaxs();
                                }else{
                                     layer.msg(data.errorMsg)
                                }
                            }                                
                        });  //授权ajax end    
                    }else{
                        layer.msg("请选择权限")
                    }      
                });  //授权 end
            }  //查看用户组权限  end
        })
    }); //  获取用户组列表success  end
}



