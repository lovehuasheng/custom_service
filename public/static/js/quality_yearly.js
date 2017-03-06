/**
 * Created by shanfubao on 2016/11/29.
 */
/**
 * Created by shanfubao on 2016/11/29.
 */
$(function(){
    //审核客服日工作情况表——柱形图
    function verify_year_count(d,data1,data2) {
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
    
    
    function get_month_count(d) {
        var index = layer.load(0, { shade: false});
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/quality_year_count",
            success:function(e) {
                layer.closeAll();console.log(e);
                if(e.errorCode == '0') { 
                   $(".year").html(get_select_html(e.result.year,e.result.now_date));
                   verify_year_count(e.result.month,e.result.total_num,e.result.success_num);
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    
    $(".year").change(function() {
        var y = $.trim($(this).val());
         get_month_count({"year_date":y});
    });
    
    get_month_count({"year_date":0});
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