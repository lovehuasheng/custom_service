/**
 * Created by shanfubao on 2016/11/29.
 */
/**
 * Created by shanfubao on 2016/11/29.
 */
$(function(){
    //全年报表跳转
    $(".yearly").click(function(e){
        e.preventDefault();
        window.location.href="/statistics/templet/yearly_count";
    });
    //审核客服日工作情况表——柱形图
   
    function verify_count_list(d,data1,data2) {
        var canvas = $("#myChart")[0];
        var context = canvas.getContext("2d");
        context.font ="20px Microsoft YaHei";
        var chartData = {
            labels : d,
            datasets : [{
                label : "审核人数",
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
   
   
    //会员审核日通过情况分布表——曲线图
    function verify_month_list(d,data1,data2,data3,data4) {
        var ctx = $("#myChart1").get(0).getContext("2d");
        var data = {
            labels : d,
            datasets : [
                {
                    label:"一次通过",
                    fillColor : "transparent", // 背景色
                    strokeColor : "#ef7c1f", // 线
                    pointColor : "#ef7c1f", // 点
                    pointStrokeColor : "#fff", // 点的包围圈
                    scaleFontSize : 18,
                    data : data1
                },
                {
                    label:"二次通过",
                    data : data2
                },
                {
                    label:"三次及以上通过",
                    data : data3
                },
                {
                    label:"未通过",
                    data : data4
                }
            ]
        };
        new Chart(ctx,{
            type : "line",
            data : data,
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
    
    
    function get_month_count(d) {
        var index = layer.load(0, { shade: false});
   
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/quality_count",
            success:function(e) {
                layer.closeAll();
                if(e.errorCode == '0') { 
                   $(".year").html(get_select_html(e.result.year,e.result.now_date));
                   $(".month").html(get_select_html(e.result.month,e.result.now_month_date));
                   verify_count_list(e.result.day,e.result.total_num,e.result.success_num);
                   verify_month_list(e.result.day,e.result.frist_verify,e.result.tow_verify,e.result.three_verify,e.result.fail_num);
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    $(".year").change(function(){
        var y = $.trim($('.year').val());
        var m = $.trim($('.month').val());
        get_month_count({"year_date":y,"month_date":m});
    });
    
    $(".month").change(function(){
        var y = $.trim($('.year').val());
        var m = $.trim($('.month').val());
        get_month_count({"year_date":y,"month_date":m});
    });
    
    
    get_month_count({"year_date":0,"month_date":0});
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