/**
 * Created by shanfubao on 2016/11/29.
 */
$(function(){
//    //跳转更多动态
//    $(".dynamic_state .row > a").click(function(e){
//        e.preventDefault();
//        window.location.href="more.html";
//    });
   
    function chart(d,data1,data2) {
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
    
    function chart_tow(d,data1,data2,data3,data4) {
        //会员审核日通过情况分布表——曲线图
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
                    scaleShowLabels : true,
                    scaleLabel : "<%=value%>",
                    scaleLineColor : "rgba(0,0,0,.1)",
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
    
    function get_count_data(d) {
        var index = layer.load(0, { shade: false});
        $.ajax({
            type:'POST',
            dataType:'JSON',
            async:true,
            data:d,
            url:"/statistics/statistics/get_count_workload",
            success:function(e) {
                layer.closeAll();
                if(e.errorCode == '0') { 
                   d = e.result.month_arr;
                
                   if(e.result.is_super == 0) {
                       $(".verify_chart").removeClass('hide');
                       chart_tow(d,e.result.frist_verify,e.result.tow_verify,e.result.three_verify,e.result.fail_num);
                   }else {
                       get_user_html(e.result.user);
                       $(".verify_chart").remove();
                   }
                   chart(d,e.result.verify_data,e.result.success_num_data);
                }else {
                    get_error_to_operation(e.errorCode,e.errorMsg);
                }
            },
            error:function(e) {
                get_error_to_operation('-10000','请求超时，请稍后再试！');
            }
          });
    }
    
    $(".select_data").change(function() {
        var v = $.trim($(this).val());
        get_count_data({"uid":v});
    });
    
    get_list();
    get_count_data({});
});



function get_user_html(d) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    
    if(len > 0) {
        for(var i=0;i<len;i++) {
             
            str += '<option value="'+d[i].id+'">'+d[i].realname+'</option>';
        }
    }
    
    $(".select_data").html('<option value="0">全部</option>'+str);
}


function get_list() { 
    var index = layer.load(0, { shade: false});
    $.ajax({
        type:'POST',
        dataType:'JSON',
        async:true,
        data:{"flag":1},
        url:"/statistics/statistics/lists",
        success:function(e) {
            layer.closeAll();
            if(e.errorCode == '0') { 
                var d = e.result.verify_data;
                var str  = '<tr>';
                str     += '<td>'+d.total_num+'</td>';
                str     += '<td>'+d.frist_verify+'</td>';
                str     += '<td>'+d.tow_verify+'</td>';
                str     += '<td>'+d.three_verify+'</td>';
                
                console.log(e.result.is_super);
                if(e.result.is_super == 0) {
                    $(".statistics").removeClass('col-lg-6').removeClass('col-md-6').removeClass('col-sm-6').addClass('col-lg-8').addClass('col-md-8').addClass('col-sm-8');
                    $(".work_time_flag").removeClass('hide');
                    $(".dynamic_state").addClass('hide');
                    $(".choice").addClass('hide');
                    str     += '<td>'+d.three_verify+'</td>';
                }else {
                    get_log_list();
                    $(".dynamic_state").removeClass('hide');
                    $(".choice").removeClass('hide');
                    $(".statistics").addClass('col-lg-6').addClass('col-md-6').addClass('col-sm-6').removeClass('col-lg-8').removeClass('col-md-8').removeClass('col-sm-8');
              
                }
                str     += '<tr>';
                $("#verify_data").html(str);
            }else {
                get_error_to_operation(e.errorCode,e.errorMsg);
            }
        },
        error:function(e) {
            get_error_to_operation('-10000','请求超时，请稍后再试！');
        }
    });
}



function get_log_list() { 
    var index = layer.load(0, { shade: false});
    $.ajax({
        type:'POST',
        dataType:'JSON',
        async:true,
        data:{"per_page":5,"flag":1},
        url:"/statistics/statistics/get_login_log",
        success:function(e) {
            layer.closeAll();
            if(e.errorCode == '0') { 
                    get_log_list_html(e.result.data);
            }else {
                 get_error_to_operation(e.errorCode,e.errorMsg);
                //layer.msg(e.errorMsg, { icon: 5 });
            }
        },
        error:function(e) {
           get_error_to_operation('-10000','请求超时，请稍后再试！');
        }
    });
}

function get_log_list_html(d) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    
    if(len > 0) {
        for(var i=0;i<len;i++) {
             d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<li class="list-group-item">'+d[i].create_time+' '+d[i].realname+'  '+d[i].remark+'。</li>';
        }
    }else {
        str += '<li class="list-group-item"> 没有操作记录 </li>';
    }
    
    $(".list-group").html(str);
}