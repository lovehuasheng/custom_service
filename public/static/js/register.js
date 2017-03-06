/**
 * Created by shanfubao on 2016/11/29.
 */
/**
 * Created by shanfubao on 2016/11/29.
 */
$(function(){
    //年注册质量统计表——柱形图
   
   function register_month_count(d,data1,data2) {
        var canvas = $("#myChart")[0];
        var context = canvas.getContext("2d");
        context.font ="20px Microsoft YaHei";
        var chartData = {
            labels : d,
            datasets : [{
                label : "注册人数",
                backgroundColor : "#438ac9",
                data : data1
            },{
                label:"通过人数",
                backgroundColor:"#7dcef4",
                data:data2
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
   function register_day_count(d,data1,data2) {
        var c = $("#myChart1")[0];
        var context1 = c.getContext("2d");
        var chartData1 = {
            labels : d,
            datasets : [{
                label : "注册人数",
                backgroundColor : "#438ac9",
                data : data1
            },{
                label:"通过人数",
                backgroundColor:"#7dcef4",
                data:data2
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
    
   
    
    
   $(".year").change(function() {
       var v = $.trim($(this).val());
       get_month_count({"year_date":v});
   }); 
   
   $(".__year").change(function() {
       var v = $.trim($(this).val());
       var m = $.trim($('.month').val());
       get_day_count({"year_date":v,"month_date":m});
   }); 
   $(".month").change(function() {
       var m = $.trim($(this).val());
       var v = $.trim($('.__year').val());
       get_day_count({"year_date":v,"month_date":m});
   });  
 function get_month_count(d) {
        var index = layer.load(0, { shade: false});
   
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/register_count",
            success:function(e) {
                layer.closeAll();
                if(e.errorCode == '0') { 
                   $(".year").html(get_select_html(e.result.year,e.result.now_date));
                   register_month_count(e.result.month,e.result.register_count,e.result.data);
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    
    
   function get_day_count(d) {
        var index = layer.load(0, { shade: false});
   
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/register_month_count",
            success:function(e) {
                layer.closeAll();
                if(e.errorCode == '0') { 
                   
                   $(".__year").html(get_select_html(e.result.year,e.result.now_date));
                   $(".month").html(get_select_html(e.result.month,e.result.now_month_date));
                   register_day_count(e.result.day,e.result.register_count,e.result.data);
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    
    get_month_count({"year_date":0});
    get_day_count({"year_date":0,"month_date":0});
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