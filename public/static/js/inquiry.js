$(function(){
    layer.load();
    ajaxs();
    
    $("#bizhong").change(function(){
        var user = $(".user").val();
        var cion = $("#bizhong").val();
        ajaxs(user,cion)
    })
    
    $(".sousuo").click(function(){
        var user = $(".user").val();
        var cion = $("#bizhong").val();
        ajaxs(user,cion)
    })
});


function ajaxs(user,coin){
    layer.load();
    $.ajax({
        url:"/member/transfer_log/get_transfer_list",
        type:"post",
        data:{
            username:user,
            coin_type:coin
        },
        success:function(data){
            $(".tcdPageCode").show();
            layer.closeAll();
            $(".table-striped tbody").eq(1).empty();
            if(data.errorCode==0){
                $(".num_s").html(data.result.total)
                $.each(data.result.transfer_list,function(i,o){
                     date(i,o);
                    $(".table-striped tbody").eq(1).append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));                   
                })
                if(data.result.pages.max_page==0){
                    layer.msg("未查询到匹配数据")
                    $(".tcdPageCode").hide();
                }else{
                    paging(data.result.pages.max_page,$(".user").val(),$("#bizhong").val())
                }
            }
        }
    });
}

function paging(data,user,coin_type){
    $(".tcdPageCode").unbind("click").createPage({
        pageCount:data,
        current:1,
        backFn:function(p){
             layer.load();
            $.ajax({
                url:"/member/transfer_log/get_transfer_list",
                type:"post",
                data:{
                    username:user,
                    coin_type:coin_type,
                    page:p
                },
                success:function(data){
                    $(".table-striped tbody").eq(1).empty();
                    layer.closeAll();
                    if(data.errorCode==0){
                        // pages = p 
                        $(".num_s").html(data.result.total)
                        $.each(data.result.transfer_list,function(i,o){
                            date(i,o);
                            $(".table-striped tbody").eq(1).append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));   
                        });
                    }
                }
            });  //ajax 结束标签
        }
    });
};
function date(i,o){
    if(o.coin_type==1){
        o.coin_type = "善种子";
    }else {
        o.coin_type = "善心币";
    }
    if(o.operation_type==1){
        o.operation_type="转入"
    }else{
        o.operation_type="回转"
    }
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