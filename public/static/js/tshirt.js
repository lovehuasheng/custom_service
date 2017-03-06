$(function(){
	$("#sousuo,#buttonUpload,#bianji,#shanchu").modal({backdrop:"static",show:false})
    $(".shuaxin").click(function(){
        if($(".num_s").html()!=0){
            $(".looks").trigger("click")
        }
    });
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

    $(".gengxin_str").focus(function(){
        newdate("gengxin_str")
    })
     $(".gengxin_end").focus(function(){
        newdate("gengxin_end")
    })
//初始化默认加载数据
    // $.ajax({
    //     url:"/member/user_clothes/get_clothes_list",
    //     type:"post",
    //     success:function(data){
    //         $(".table-striped tbody").eq(1).empty();
    //         if(data.errorCode==0){
    //             if(data.result.total==0){
    //                 $("#tcd").hide();
    //                 $(".pages_Code").hide();
    //                 layer.msg("暂无数据")
    //             }else{
    //                 $("#tcd").show();
    //                 $(".pages_Code").show();
    //             }
    //             $(".num_s").html(data.result.total)
    //             $.each(data.result.clothes_list,function(i,o){
    //                 times(i,o)
    //                 $(".table-striped tbody").eq(1).append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];})); 
    //             })
    //             paging(data.result.pages.max_page,1);
    //             func(data.result.pages.max_page)             
    //         }
    //     }
    // });  //ajax 结束标签

// 根据条件搜索内容
$(".sousuo").click(function(){
    $(".gengxin_str").val('');
    $(".gengxin_end").val('');
    $(".pho").val("");
    $(".use").val('');
    $(".nam").val('');
    $(".siz").val('');
    $(".logistics").val("");
    $("#whether").val("");
    $(".company").val("")
});

// 提交搜索
$(".looks").unbind("click").click(function(){
    var str = $(".gengxin_str").val();
    str = str.replace(/-/g,'/'); 
    var date = new Date(str).getTime(); //开始时间
    var str2 = $(".gengxin_end").val();
    str2 = str2.replace(/-/g,'/'); 
    var date2 = new Date(str2).getTime(); //结束时间
    // alert($(".logistics").val())
    // alert($("#whether").val())
    // alert($(".company").val())
    if(date2-date>0||str == str2||str==''||str2==""){
        $.ajax({
            url:"/member/user_clothes/get_clothes_list",
            type:"post",
            data:{
                username:$(".use").val(),
                consignee_name:$(".nam").val(),
                consignee_phone:$(".pho").val(),
                size:$(".siz").val(),
                start_time:$(".gengxin_str").val(),  
                end_time:$(".gengxin_end").val(),
                is_shipping: $("#whether").val(),
                shipping_no :$(".logistics").val(),
                shipping_company:$(".company").val()
            },
            success:function(data){
                if(data.errorCode==0){
                    $(".num_s").html(data.result.total);
                    $("#sousuo").modal("hide")
                    $(".table-striped tbody").eq(1).empty();
                    if(data.result.total==0||data.result.total==''){
                        layer.msg("没有查询到相关数据")
                        $(".tcdPageCode").hide();
                        $(".pages_Code").hide();
                    }else{     
                        $(".tcdPageCode").show();              
                        $.each(data.result.clothes_list,function(i,o){
                            times(i,o)
                            $(".table-striped tbody").eq(1).append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
                            paging(data.result.pages.max_page,1,$(".use").val(),$(".nam").val(),$(".pho").val(),$(".siz").val(),$(".gengxin_str").val(),$(".gengxin_end").val());
                            func(data.result.pages.max_page)
                        });
                    }
                }else{
                    layer.msg(data.errorMsg)
                }
            }
        })
    }else{
        layer.msg("开始时间不能大于结束时间或时间间隔大于一周")
    }
});

$(".btns").click(function(){
    $("#user_clothes").click()
    setInterval(function(){
        if($("#user_clothes").val()!=''){
            $(".textname").val($("#user_clothes").val())
        } 
    },200)
})
$(".Upload").click(function(){
    if($("#user_clothes").val()==''){
        layer.msg("请先上传文件")
    }else{
        ajaxFileUpload(); 
    }      
})

//导出模板
$(".daochumuban").click(function(){
     window.location.href="/uploads/template.csv"
});


});/***************function 结束***********/

 function over(id){
    $(id).modal("hide")
 }
var pages;

function paging(data,page,use,nam,pho,siz,str,end){
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data,
        current:page,
        backFn:function(p){
             layer.load();
            $.ajax({
                url:"/member/user_clothes/get_clothes_list",
                type:"post",
                data:{
                    username:use,
                    consignee_name:nam,
                    consignee_phone:pho,
                    size:siz,
                    start_time:str,
                    end_time:end,
                    page:p
                },
                success:function(data){
                    layer.closeAll();
                    $(".table-striped tbody").eq(1).empty();
                    if(data.errorCode==0){
                        pages = p 
                        $.each(data.result.clothes_list,function(i,o){
                            times(i,o)
                            $(".table-striped tbody").eq(1).append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
                            func(data.result.pages.max_page)
                        });
                    }
                }
            });  //ajax 结束标签
        }
    });
}

function func(max_p){
    var id,username,phone,consignee_address,size,city,province,shipping_company,shipping_no,is_shipping;
    $('.caozuo').click(function(){
         id = $(this).parent().parent().children().eq(0).text();
         username = $(this).parent().parent().children().eq(1).text();
         name = $(this).parent().parent().children().eq(2).text();
         phone = $(this).parent().parent().children().eq(3).text();
         consignee_address = $(this).parent().parent().children().eq(4).text();
         size = $(this).parent().parent().children().eq(5).text();
         city = $(this).parent().parent().children().eq(11).text();
         province = $(this).parent().parent().children().eq(12).text();
         shipping_company =$(this).parent().parent().children().eq(8).text();
         shipping_no =$(this).parent().parent().children().eq(9).text();
         is_shipping =$(this).parent().parent().children().eq(7).text();
    });
    $(".bianji").click(function(){ 
        var vals;
        if(province==''){
            $.initProv("#pro", "#city", "请选择", "请选择");
        }else{
           $.initProv("#pro", "#city", province,city);
        }

        if(size=='S'){
             vals = 1;
        }else if(size=="M"){
             vals = 2;
        }else if(size=='L'){
             vals = 3;
        }else if(size=='XL'){
             vals = 4;
        }else if(size=="XXL"){
             vals = 5;
        }else if(size=='XXXL'){
             vals = 6;
        }
        $(".xiala").html("");
        $(".Username").val(username);
        $(".Name").val(name);
        $(".Phone").val(phone);
        $(".consignee_address").val(consignee_address);
        $(".logisticss").val(shipping_no);
        $(".companys").val(shipping_company);
        $(".xiala").append("<option value="+vals+">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+size+"</option>"
            +"<option value='1'>&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;&nbsp;&nbsp;&nbsp;</option>"
            +"<option value='2'>&nbsp;&nbsp;&nbsp;&nbsp;M&nbsp;&nbsp;&nbsp;&nbsp;</option>"
            +"<option value='3'>&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;&nbsp;&nbsp;</option>"
            +"<option value='4'>&nbsp;&nbsp;&nbsp;&nbsp;XL&nbsp;&nbsp;&nbsp;&nbsp;</option>"
            +"<option value='5'>&nbsp;&nbsp;&nbsp;&nbsp;XXL&nbsp;&nbsp;&nbsp;&nbsp;</option>"
            +"<option value='6'>&nbsp;&nbsp;&nbsp;&nbsp;XXXL&nbsp;&nbsp;&nbsp;&nbsp;</option>"
        )
         if(is_shipping =="否"){
            $(".whethers").val("0")
        }else if(is_shipping =="是"){
            $(".whethers").val("1")
        }
        
    });
    $(".bianji_tijiao").unbind("click").click(function(){
        var val = $("#pro").val();
        var val2 = $("#city").val();
        var pro = $("#pro option[value='"+val+"']").html();
        var city = $("#city option[value='"+val2+"']").html();
        // alert($(".logisticss").val())
        // alert($("#whethers").val())
        if(val==-1||val2==-1){
            layer.msg("请选择省市")
        }else if($(".Username").val()==''||$(".Name").val()==''||$(".Phone").val()==''){
            layer.msg("收货人信息不完善，请完善后提交")
        }else{
            $.ajax({
                url:"/member/user_clothes/update_clothes",
                type:"post",
                data:{
                    id:id,
                    username:$(".Username").val(),
                    consignee_name:$(".Name").val(),
                    consignee_phone:$(".Phone").val(),
                    province:pro,
                    city:city,
                    consignee_address:$(".consignee_address").val(),
                    size:$(".xiala").val(),
                    is_shipping: $("#whethers").val(),
                    shipping_no :$(".logisticss").val(),
                    shipping_company:$(".companys").val()
                },
                success:function(data){
                    if(data.errorCode==0){
                        layer.msg("编辑成功")
                        $("#bianji").modal("hide");
                        ajaxs(pages,$(".use").val(),$(".nam").val(),$(".pho").val(),$(".siz").val(),$(".gengxin_str").val(),$(".gengxin_end").val());
                    }else{   
                        layer.msg(data.errorMsg)
                    }
                }
            }) 
        }   
    });
    //删除
    $(".queren_shanchu").unbind("click").click(function(){
        $.ajax({
            url:"/member/user_clothes/del_clothes",
            type:"post",
            data:{
                id:id
            },
            success:function(data){
                if(data.errorCode==0){
                    $("#shanchu").modal("hide");
                    layer.msg("删除成功")
                    ajaxs(pages,$(".use").val(),$(".nam").val(),$(".pho").val(),$(".siz").val(),$(".gengxin_str").val(),$(".gengxin_end").val());
                }else{
                    layer.msg(data.errorMsg)
                }
            }
        })
    });

    //导出数据
    $(".daochu").click(function(){ 
            window.location.href="/member/user_clothes/export" ;       
    });
    $(".PagesCode").unbind("click").click(function(){
        var page = $(".pageCode").val();  
        pages = page
        if(page>max_p||page==0||page==''){
            layer.msg("请输入正确页码 最大页码为"+max_p)  
        }else if(page<max_p||page==max_p){
           paging(max_p,page,$(".use").val(),$(".nam").val(),$(".pho").val(),$(".siz").val(),$(".gengxin_str").val(),$(".gengxin_end").val())
           ajaxs(page,$(".use").val(),$(".nam").val(),$(".pho").val(),$(".siz").val(),$(".gengxin_str").val(),$(".gengxin_end").val()) 
           $(".tcdNumber").hide();
        }
    });
}; //func结束标签

function ajaxs(pages,use,nam,pho,siz,str,end){
    $.ajax({
        url:"/member/user_clothes/get_clothes_list",
        type:"post",
        data:{
            page:pages,
            username:use,
            consignee_name:nam,
            consignee_phone:pho,
            size:siz,
            start_time:str,
            end_time:end
        },
        success:function(data){
            $(".table-striped tbody").eq(1).empty();
            if(data.errorCode==0){
                $(".num_s").html(data.result.total)
                if(data.result.total==0){
                    $("#tcd").hide();
                    $(".pages_Code").hide();
                    layer.msg("暂无数据")
                }else{
                    $("#tcd").show();
                    $(".pages_Code").show(); 
                };
                $.each(data.result.clothes_list,function(i,o){
                    times(i,o);
                    $(".table-striped tbody").eq(1).append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];})); 
                })
                func(data.result.pages.max_page)
            }
        }
    })
}

function ajaxFileUpload() {
    layer.load();
    $(".textname").val("")
    $.ajaxFileUpload
    (
        {
            url: '/member/user_clothes/import', //用于文件上传的服务器端请求地址
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'user_clothes', //文件上传域的ID
            dataType: 'JSON', //返回值类型 一般设置为json
            success: function (data)  //服务器成功响应处理函数
                {
                    layer.closeAll();
                    if(typeof data!='object'){
                        data = $(data).text();
                        data = JSON.parse(data)
                    }
                    if(data.errorCode==0){
                        layer.msg("导入成功")
                        $(".textname").val("");
                        $("#user_clothes").val("");
                        $("#buttonUpload").modal("hide") 
                        ajaxs();
                    }else{
                        layer.msg(data.errorMsg)
                    }
                    
                },
            error: function (data, status, e)//服务器响应失败处理函数
            {
                console.log(e)
            }
        }
    )
    return false; 
}

function buttonUpload(){
    $(".textname").val("")
    $("#user_clothes").val("")
    $("#buttonUpload").modal("hide")
}


function  times(i,o){
    if(o.size==1){
        o.size = "S";
    }else if(o.size==2){
        o.size = "M";
    }else if(o.size==3){
        o.size = "L";
    }else if(o.size==4){
        o.size = "XL";
    }else if(o.size==5){
        o.size = "XXL";
    }else if(o.size==6){
        o.size = "XXXL";
    }else{
        o.size = "请选择";
    }
    if(o.is_shipping==0){
        o.is_shipping="否";
    }else if(o.is_shipping==1){
        o.is_shipping="是";
    }
    // if(o.is_received==0){
    //     o.is_received="否"
    // }else if(o.is_received==1){
    //     o.is_received="是"
    // }
    var newDate = new Date(o.create_time*1000);
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
    o.create_time = newDate.getFullYear()+"-"+mon+"-"+day+" "+hour+":"+min+":"+sec;
}

function newdate(names){
    var newDate = new Date();
    var mon = (newDate.getMonth()+1);
    var day = newDate.getDate();
    time_time = newDate.getFullYear()+"-"+mon+"-"+day;
       if($("."+names).val()==''){
          $("."+names).val(time_time)  
       }
}