/**
 * Created by shanfubao on 2016/11/29.
 */

$(function(){
    get_list({'page': 1,"per_page":10,"flag":$.trim($(".selected").attr('val'))});
});

$(".options").find('span').click(function() {
   $(this).addClass('selected').siblings('span').removeClass('selected');
   var flag = $.trim($(this).attr('val'));
   data = { 'page': 1,"per_page":10,"flag":flag};
   get_list(data);
});

function get_list(d) { 
    var index = layer.load(0, { shade: false});
    $.ajax({
        type:'POST',
        dataType:'JSON',
        async:true,
        data:d,
        url:"/statistics/statistics/get_login_log",
        success:function(e) {
            layer.closeAll();
            if(e.errorCode == '0') { 
              get_list_html(e.result.data);
              $(".tcdPageCode").html(get_list_page(e.result.pages));
            }else {
               get_error_to_operation(e.errorCode,e.errorMsg);
            }
        },
        error:function(e) {
            get_error_to_operation('-10000','请求超时，请稍后再试！');
        }
    });
}


function get_list_html(d) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    
    if(len > 0) {
        for(var i=0;i<len;i++) {
             d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr>';
            str += '<td>'+d[i].create_time+'</td>';
            str += '<td>'+d[i].realname+'</td>';
            str += '<td colspan="5">'+d[i].remark+'</td>';
            str += '</tr>';
        }
    }else {
        str += '<tr> <td colspan="3">没有操作记录 </td></tr>';
    }
    
    $(".list-group").html(str);
}

function set_page(p) {
    var flag = $.trim($(".selected").attr('val'));
     data = { 'page': p,"per_page":10,"flag":flag};
     get_list(data);
 }