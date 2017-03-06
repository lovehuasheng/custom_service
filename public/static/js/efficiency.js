/**
 * Created by shanfubao on 2016/11/29.
 */
/**
 * Created by shanfubao on 2016/11/29.
 */
var user_data = [];
var msg_data = [];
$(function(){
    $(".__month").change(function() {
        var m = $.trim($(".__month").val());
        var u = $.trim($(".user").val());
        get_month_count({"month_date":m,"uid":u});
    });
    $(".user").change(function() {
        var m = $.trim($(".__month").val());
        var u = $.trim($(".user").val());
        get_month_count({"month_date":m,"uid":u});
    });
    
    $(".year").change(function() {
        var y = $.trim($('.year').val());
        var m = $.trim($('.month').val());
        var d = $.trim($('.day').val());
        get_count({"year_date":y,"month_date":m,"day_date":d});
    });
    $(".month").change(function() {
        var y = $.trim($('.year').val());
        var m = $.trim($('.month').val());
        var d = $.trim($('.day').val());
        get_count({"year_date":y,"month_date":m,"day_date":d});
    });
    $(".day").change(function() {
        var y = $.trim($('.year').val());
        var m = $.trim($('.month').val());
        var d = $.trim($('.day').val());
        get_count({"year_date":y,"month_date":m,"day_date":d});
    });

    //年注册质量统计表——柱形图
   function efficiency_user(d,data1) {
        var canvas = $("#myChart")[0];
        var context = canvas.getContext("2d");
        context.font ="20px Microsoft YaHei";
        var chartData = {
            labels : d,
            datasets : [{
                data : data1,
                label : "工作时间" ,
                backgroundColor : "#438ac9"
            }
            ]
        };

        new Chart(context,{
            type : "bar",
            data : chartData,
            options : {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderSkipped: 'bottom'
                    }
                }
            }
        });
   }
    //月注册质量统计表——柱形图
    function efficiency_user_month(d,data1){
         var c = $("#myChart1")[0];
        var context1 = c.getContext("2d");
        var chartData1 = {
            labels : d,
            datasets : [{
                label : "工作时间",
                backgroundColor : "#438ac9",
                data : data1
            }
            ]
        };

        new Chart(context1,{
            type : "bar",
            data : chartData1,
            options : {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderSkipped: 'bottom'
                    }
                }
            }
        });
    }
    
    //月统计
    function get_month_count(d) {
        var index = layer.load(0, { shade: false});
   
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/efficiency_month_count",
            success:function(e) {
                layer.closeAll();
                if(e.errorCode == '0') { 
                   $(".__month").html(get_select_html(e.result.month,e.result.now_month_date));
                   $(".user").html('<option value="0">全部</option>'+get_select_to_user_html(e.result.user,e.result.user_selected));
                   efficiency_user_month(e.result.day,e.result.data);
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    
    //统计
    function get_count(d) {
        var index = layer.load(0, { shade: false});
   
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/efficiency_count",
            success:function(e) {
                layer.closeAll();
                if(e.errorCode == '0') { 
                   $(".year").html(get_select_html(e.result.year,e.result.now_year_date));
                   $(".month").html('<option value="0">全部</option>'+get_select_html(e.result.month,e.result.now_month_date));
                   $(".day").html('<option value="0">全部</option>'+get_select_html(e.result.day,e.result.now_day_date));
                   user_data = e.result.user;
                   msg_data = e.result.data;
                   get_page_user(e.result.user,e.result.data);
                   
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    
    function get_page_user(d,u) {
        var total = 15;
        var len = d.length;
        var user = [];
        var datas = [];
        var str = '';
        if(len > total) {
            var p = $.trim($("._page").val());
            var page_total = Math.ceil(len/total);
            for(var i=0;i<page_total;i++) {
                if(parseInt(i+1) == p) {
                    str += '<option value="'+parseInt(i+1)+'" selected="selected">'+parseInt((i*15)+1)+'号~'+parseInt((i+1)*15)+'号</option>';
                }else {
                    str += '<option value="'+parseInt(i+1)+'">'+parseInt((i*15)+1)+'号~'+parseInt((i+1)*15)+'号</option>';
                }
                
            }
            $("._page").html(str);
            console.log(((p-1)*total));
            for(var j=((p-1)*total); j<(total*p); j++) {
                user[j] = d[j];
                datas[j] = u[j];
            }
            
        }else {
            user  = d;
            datas = u;
        }
        efficiency_user(d,u);
    }
    
    $("._page").change(function() {
        get_page_user(user_data,msg_data);
    });
    
    
    get_count({"year_date":0,"month_date":0,"day_date":0});
    get_month_count({"month_date":0,"uid":0});
   
});



function get_select_html(d,s) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    
    if(len > 0) {
        for(var i=0;i<len;i++) {
                if(d[i] == s) {
                    str += '<option value="'+d[i]+'" selected="selected">'+d[i]+'</option>';
                }else {
                    str += '<option value="'+d[i]+'">'+d[i]+'</option>';
                }
        }
    }
    
    return str;
}

function get_select_to_user_html(d,s) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    
    if(len > 0) {
        for(var i=0;i<len;i++) {
           
            if(d[i].id == s) {
                str += '<option value="'+d[i].id+'" selected="selected">'+d[i].realname+'</option>';
            }else {

                str += '<option value="'+d[i].id+'">'+d[i].realname+'</option>';
            }
        }
    }
    
    return str;
}