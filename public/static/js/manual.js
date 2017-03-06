$(function () {
    //加载数据
    get_list();
});
/**
 * 全选
 * @param {type} param
 */
$(".super_check").click(function () {
    $(".list_text").find("input[type='checkbox']").prop('checked', this.checked);
});

$("#del").click(function () {
    var v = $("#del").attr('val');
    var flag = false;
    $("input[type='checkbox']").each(function (index) {
        var v = $(this).prop('checked');
        if (v == true) {
            flag = true;
        }

    });
    if (flag == false) {
        get_error_to_operation('-10005','请选择要将要删除的数据！');
        return false;
    }
    var d = $("#myForm").serialize();
    var index = layer.load(0, { shade: false });
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: '/business/matching/del_manual_match/flag/' + v,
        async: true,
        success: function (e) {
            layer.closeAll();
            if (e.errorCode == '0') {
                $("input[type='checkbox']").each(function (index) {
                    var v = $(this).prop('checked');
                    var a = $(this).val();
                    if (v == true) {
                        $(this).parents('tr').remove();
                        $("#accept" + a).parents('tr').remove();
                    }

                });
                get_error_to_operation(e.errorCode,e.errorMsg);
            } else {
                get_error_to_operation(e.errorCode,e.errorMsg);
            }

        },
        error: function (e) {
           get_error_to_operation('-10000','请求超时，请稍后再试！');
        }
    });
});

/**
 * 刷新
 * @param {type} param
 */
$("#refresh").click(function () {
    $("#set_verify").addClass('btn-danger').removeClass('btn-default');
    $("#set_match").addClass('btn-default').removeClass('btn-danger');
    get_list();
});

/**
 * 审核
 */
$("#set_verify").click(function () {
    var c = $(this).attr('class');
    if (c == 'btn btn-default') {
        get_error_to_operation('-10001','没有可选择审核的匹配数据！');
        return false;
    }
    
    $("#set_verify").addClass('btn-default').removeClass('btn-danger');
    var flag = false;
    $("input[type='checkbox']").each(function (index) {
        var v = $(this).prop('checked');
        if (v == true) {
            flag = true;
        }

    });
    if (flag == false) {
        $("#set_verify").addClass('btn-danger').removeClass('btn-default');
        get_error_to_operation('-10002','没有可选择审核的匹配数据！');
        return false;
    }
    
    var d = $("#myForm").serialize();
    var index = layer.load(0, { shade: false });
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: '/business/matching/set_manual_match',
        async: true,
        success: function (e) {
            layer.closeAll();
            $("#del").attr('val', 1);

            if (e.errorCode == '0') {
                $(".super_check").attr('checked', false);
                $("#set_verify").addClass('btn-default').removeClass('btn-danger');
                $("#set_match").addClass('btn-danger').removeClass('btn-default');
                get_error_to_operation(e.errorCode,e.errorMsg);
                get_list();
            } else {
                get_error_to_operation(e.errorCode,e.errorMsg);
            }
        },
        error: function (e) {
            $("#set_verify").addClass('btn-danger').removeClass('btn-default');
            get_error_to_operation('-10000','请求超时，请稍后再试！');

        }
    });
});

/**
 * 生成匹配列表
 * @param {type} param
 */
$("#set_match").click(function () {

    var c = $(this).attr('class');
    if (c == 'btn  btn-default') {
        get_error_to_operation('-10003','已生成匹配数据列表，不能再次生成了！');
        return false;
    }
    $(this).addClass('btn-default').removeClass('btn-danger');
    var flag = false;
    $("input[type='checkbox']").each(function (index) {
        var v = $(this).prop('checked');
        if (v == true) {
            flag = true;
        }

    });
    if (flag == false) {

        $("#set_match").addClass('btn-danger').removeClass('btn-default');
        get_error_to_operation('-10004','请选择要匹配的订单！');
        return false;
    }

    var d = $("#myForm").serialize();
    var index = layer.load(0, { shade: false });
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: '/business/matching/manual_match',
        async: true,
        success: function (e) {
            layer.closeAll();
            var str = '';
            var str1 = '';
            $("#del").attr('val', 2);
            if (e.errorCode == '0') {
                $(".super_check").attr('checked', false);
                //启用审核选择列表
                $("#set_verify").addClass('btn-danger').removeClass('btn-default');
                $("#set_match").addClass('btn-default').removeClass('btn-danger');
                str = get_html(e.result.provide_list);
                str1 = get_html1(e.result.accept_list);
            } else {
                str += '<tr>';
                str += '<td colspan="6">没有更多数据 </td>';
                str += '<tr>';
                get_error_to_operation(e.errorCode,e.errorMsg);

            }
            $(".match_money_html").html('已匹配金额');
            $(".list_text").html(str);
            $(".lists_text").html(str1);
        },
        error: function (e) {
            get_error_to_operation('-10000','请求超时，请稍后再试！');

        }
    });

});


/**
 * 请求数据
 * @param {type} d data参数这是个对象
 * @param {type} u  请求链接
 * @returns {undefined}
 */
function get_list(d, u) {
    var index = layer.load(0, { shade: false });
    d = d ? d : {};
    u = u ? u : "/business/matching/get_manal_match_list";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            layer.closeAll();
            var str = '';
            var str1 = '';
            var p_str = '';
            $("#del").attr('val', 1);
            if (e.errorCode == '0') {
                $(".super_check").attr('checked', false);
                $("#set_verify").addClass('btn-default').removeClass('btn-danger');
                $("#set_match").addClass('btn-danger').removeClass('btn-default');
                str = get_html(e.result.provide_list);
                str1 = get_html1(e.result.accept_list)
                // 
            } else {
                str += '<tr>';
                str += '<td colspan="6">没有更多数据 </td>';
                str += '<tr>';
            }
            $(".match_money_html").html('待匹配金额');
            $(".list_text").html(str);
            $(".lists_text").html(str1);
            // $(".tcdPageCode").html(p_str);

        },
        error: function (e) {
            get_error_to_operation('-10000','请求超时，请稍后再试！');

        }
    });

}

/**
 * 数据拼装
 * @param {type} d
 * @returns {String}
 */
function get_html1(d1) {
    var str1 = '';
    var leng = 0;
    if (leng != null || leng != undefined || leng != "") {
        leng = d1.length;
    }
    if (leng > 0) {
        for (var i = 0; i < leng; i++) {
            // var mon = d1[i].money-d1[i].used;
            str1 += '<tr>';
            if (d1[i].match_id != undefined || d1[i].match_id != null || d1[i].match_id != '') {
                str1 += '<td  class="ids1" style="display:none"><input type="hidden" name="" id="accept' + d1[i].match_id + '" value=""></td>';
            }
            str1 += '<td  class="ids1" style="display:none">' + d1[i].create_time + '</td>';
            str1 += '<td>' + d1[i].id + '</td>';
            str1 += '<td class="s-time">' + d1[i].name + '</td>';
            str1 += '<td>' + d1[i].user_id + '</td>';
            str1 += '<td>' + d1[i].money + '</td>';
            str1 += '<td>' + d1[i].match_money + '</td>';
            // str1 += '<td>' + mon + '</td>';
            str1 += '<tr>';
        }
    } else {
        str1 += '<tr>';
        str1 += '<td colspan="5">没有更多数据 </td>';
        str1 += '<tr>';
    }
    return str1;
}

//提供资助
function get_html(d) {
    var str = '';
    var len = 0;
    if (len != null || len != undefined || len != "") {
        len = d.length;
    }
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            // var mon = d[i].money-d[i].used;
            d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr>';
            str += '<td>';
            if (d[i].match_id == undefined || d[i].match_id == null || d[i].match_id == '') {
                str += '<input type="checkbox" name="ids[]" class="check" value="' + d[i].id + '">';
            } else {
                str += '<input type="checkbox" name="ids[]" class="check" value="' + d[i].match_id + '">';
            }
            str += '<input type="hidden" name="partition_time[]" value="' + d[i].create_time + '"></td>';
            str += '<td>' + d[i].id + '</td>';
            str += '<td class="s-time">' + d[i].name + '</td>';
            str += '<td>' + d[i].user_id + '</td>';
            str += '<td>' + d[i].money + '</td>';
            str += '<td>' + d[i].match_money + '</td>';
            // str += '<td>' + mon + '</td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="6">没有更多数据 </td>';
        str += '<tr>';
    }

    return str;
}

