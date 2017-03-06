$(function () {
    // 日历插件
    get_list();
    $(".datetimepicker3").on("click", function (e) {
        e.stopPropagation();
        $(this).lqdatetimepicker({
            css: 'datetime-day',
            dateType: 'D',
            selectback: function () {
            }
        });
    });

    $("#form-control").focus(function(){
        var newDate = new Date();
        var years = newDate.getFullYear();
        var mon = (newDate.getMonth()+1);
        var day = newDate.getDate();
        if($("#form-control")!=''){
          $('#form-control').val(years+"-"+mon+"-"+day); 
        } 
    });
    $("#form-controls").focus(function(){
        var newDate = new Date();
        var years = newDate.getFullYear();
        var mon = (newDate.getMonth()+1);
        var day = newDate.getDate();
        if($("#form-controls")!=''){
          $('#form-controls').val(years+"-"+mon+"-"+day); 
        } 
    });
    var winH = $(window).height(); //页面可视区域高度  
    var i = 1;  
    $(window).scroll(function() { 
        var pageH = $(document.body).height();  //页面高度       
        var scrollT = $(window).scrollTop(); //滚动条top
        var aa = pageH - winH - scrollT;
        if(aa<1){
            i++
            set_page(i)
        }
    });
});
var st;
$('#btn-btn1').click(function () {
    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    if (search_name == '' || search_name == undefined || search_name == null) {
            layer.msg('请求输入搜索ID！', { icon: 5 });
            return false;
    }else if (search_name == "") {
      layer.msg("请选择或输入查询条件")
    } else{
         if (search_type == '') {ia
            layer.msg('请求选择类型！', { icon: 5 });
            return false;
        }else{
            st='';
            data = { "search_name":search_name, "search_type":search_type }
            get_list(data)
        }
    } 
    
})
/**
 * 请求数据
 * @param {type} d data参数这是个对象
 * @param {type} u  请求链接
 * @returns {undefined}
 */
function get_list(d, u) {
    var index = layer.load(0, { shade: false, });
    d = d ? d : {};
    u = u ? u : "/business/transfer/get_transfer";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            layer.closeAll();
            var str = '';
            if (e.errorCode == '0') {
                $(".currents").html(e.result.data)
                $(".amounts").html(e.result.data)
              if(e.result.pages.max_page<d.page){
                    layer.msg("数据已全部加载完毕") ;
                }else{
                   str = get_html(e.result.data);
                   st+=str;   
                }  
            } else {
                str += '<tr>';
                str += '<td colspan="7">没有更多数据 </td>';
                str += '<tr>';
            }
            $(".list_text").html(st);
            $(".sxh_yuanyin").mouseover(function(){
                layer.msg($(this).html());
            })
        },
        error: function (e) {
             layer.closeAll();
            layer.msg('请求失败！', { icon: 5 });

        }
    });

}

/**
 * 调用分页
 * @param {type} p
 * @returns {undefined}
 */
var p
function set_page(p) {

    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    data = { 'page': p };
    get_list(data);
}
/**
 * 数据拼装
 * @param {type} d
 * @returns {String}
 */
function get_html(d) {
    var str = '';
    var len = 0;
    if (len != null || len != undefined || len != "") {
        len = d.length;
    }
    if (len > 0) {
        for (i = 0; i < len; i++) {
            
            // d[i].audit_time = new Date(parseInt(d[i].audit_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<td >' + d[i].other_id + '</td>';
            str += '<td>' + d[i].other_name + '</td>';
            str += '<td>' + d[i].other_user_id + '</td>';
            str += '<td>' + d[i].provide_money + '</td>';
            str += '<td>' + d[i].remark + '</td>';
            str += '<td>' + d[i].create_time + '</td>';
            str += '<td>' + d[i].operator_id + '</td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="7">没有更多数据 </td>';
        str += '<tr>';
    }
    return str;
}