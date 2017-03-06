$(function () {
    get_list();
	$("#bianji,#shanchu").modal({backdrop:"static",show:false});

});    //结束标签
// 新增公告取消

// 获取name值
var fabu = 0;
var leixing = 2;
$(".prev").click(function () {
    fabu = $(this).addClass('img').attr('name')
    $(".left").removeClass('img')
});
$(".left").click(function () {
    fabu = $(this).addClass('img').attr('name')
    $(".prev").removeClass('img')
});
$(".gr").click(function () {
    leixing = $(this).addClass('img').attr('name')
    $(".qy").removeClass('img')
    $(".qb").removeClass('img')
});
$(".qy").click(function () {
    leixing = $(this).addClass('img').attr('name')
    $(".gr").removeClass('img')
    $(".qb").removeClass('img')
});
$(".qb").click(function () {
    leixing = $(this).addClass('img').attr('name')
    $(".qy").removeClass('img')
    $(".gr").removeClass('img')
});
// 获取二级密码
var mma
$('#quer').click(function () {
    if ($('.mima').val() == "") {
        alert('二级密码不能为空')
        return false;
    } else {
        mma = $('.mima').val()
        data = { "title": bti, "content": content, "is_company": leixing, "status": fabu, " secondary_password": mma }
        xinzeng(data)
    }

})

//二级密码参数感觉不正确，等以后再确定一下具体参数
$('#b-quer').click(function () {
    if ($('.mim').val() == "") {
        alert('二级密码不能为空')
        return false;
    } else {
        var b_bt = $('.b-ipt').val()
        var b_area = $('#customized').html();
        mma = $('.mim').val()
        data = { "id": gid, "title": b_bt, "is_company": leixing, "content": b_area, "status": fabu,"secondary_password":mma }
        bianji(data)
    }
})
// 获取标题
var bti
var content
$("#baocun").click(function () {
    bti = $(".ipt").val()
    content = $('#customized-buttonpane').html();
    if (bti == "" && content == "") {
        alert('标题或内容没有填写')
    } else if (fabu == 1) {
        left()
    }
    else if (fabu == 0) {
        $(this).attr("disabled", 'disabled');
        data = { "title": bti, "content": content, "is_company": leixing, "status": fabu, " secondary_password": mma }
        xinzeng(data)
    }
})
// 点击新增，保证默认值
$('#xz').click(function () {
    $('.prev').click()
    $('.qb').click()
})
// 点击白色箭头表示升序
$('.sheng').click(function () {
    var order = $(this).attr('name')
    data = { "order": order }
    get_list(data)
})
// 点击绿色箭头表示升序
$('.jiang').click(function () {
    var order = $(this).attr('name')
    data = { "order": order }
    get_list(data)
})
// 新增接口
function xinzeng(d, u) {
    d = d ? d : {};
    u = u ? u : "/member/user_news/add_news";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                //    alert('操作成功！');
                quan = new Array();
                $('#woModal').modal('hide')
                layer.alert('操作成功！', {
                    skin: 'layui-layer-demo' //样式类名
                    , closeBtn: 0
                }, function () {
                    get_list();
                });
                $('#left').hide()
                $(".ipt").val("")
                $('#customized-buttonpane').html("")
                $('.mima').val("")
                $(".shandow").hide();
                $('#xinzeng').modal('hide')

            }
            else {
                get_error_to_operation(e);
            }
            $("#baocun").removeAttr("disabled");
        },
        error: function (e) {
            $("#baocun").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}
var cont
//获取列表详情
function xiang(d, u) {
    d = d ? d : {};
    u = u ? u : "/member/user_news/get_news_detail";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                cont = e.result.content;
                $('#customized').html(cont)
            }
            else {
                get_error_to_operation(e);
            }
        },
        error: function (e) {
            $("#baocun").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}
// 编辑功能 获取name值
var gid
var ti
function bj() {
    $('.bianji').click(function () {
        gid = $(this).attr('_id')
        ti = $(this).attr('biao')
        fabu = $(this).attr('editor')
        leixing = $(this).attr('system')
        data = { "id": gid }
        xiang(data)
        $('.b-ipt').val(ti)
        $('.img_02').removeClass('img')
        if (fabu == 1) {
            $('.left').addClass('img').attr('name')
        } else if (fabu == 0) {
            $('.prev').addClass('img').attr('name')
        }
        if (leixing == 0) {
            $('.gr').addClass('img').attr('name')
        } else if (leixing == 1) {
            $('.qy').addClass('img').attr('name')
        }
        else if (leixing == 2) {
            $('.qb').addClass('img').attr('name')
        }
    })
}
$('#b-baocun').click(function () {
    var b_bt = $('.b-ipt').val()
    var b_area = $('#customized').html();
    if (b_bt == "" || b_area == "") {
        layer.msg('标题和内容不能为空')
    } else if (fabu == 1) {
        erji()
    } else {
        data = { "id": gid, "title": b_bt, "is_company": leixing, "content": b_area, "status": fabu }
        bianji(data)
    }
})
// 编辑接口
function bianji(d, u) {
    d = d ? d : {};
    u = u ? u : "/member/user_news/update_news";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                quan = new Array();
                $('#woModal').modal('hide')
                layer.alert('操作成功！', {
                    skin: 'layui-layer-demo' //样式类名
                    , closeBtn: 0
                }, function () {
                    get_list();
                });
                $(".b-ipt").val("")
                $('.b-area').val("")
                $('.mim').val("")
                $('#bianji').modal('hide')
                $(".shandow").hide();
                $("#erji").hide();
            }
            else {
                get_error_to_operation(e);
            }
            $("#b-baocun").removeAttr("disabled");
        },
        error: function (e) {
            $("#b-baocun").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}
// 删除功能
var shanc
function schu() {
    $('.shanchu').click(function () {
        shanc = $(this).attr('_did')
    })
}
// 模态框隐藏
$('#s-qxiao').click(function () {
    $('#shanchu').modal('hide')
})
$('#s-qr').click(function () {
    data = { "id": shanc }
    shan_chu(data)
})
// 删除接口
function shan_chu(d, u) {
    d = d ? d : {};
    u = u ? u : "/member/user_news/del_news";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                //    alert('操作成功！');
                quan = new Array();
                $('#woModal').modal('hide')
                 layer.msg('操作成功！', {
                    skin: 'layui-layer-demo' //样式类名
                    , closeBtn: 0
                }, function () { 
                    get_list();
                });
                $(".b-ipt").val("")
                $('.b-area').val("")
                $('#shanchu').modal('hide')

            }

            else {
                get_error_to_operation(e);
            }

            $("#s-qr").removeAttr("disabled");
        },
        error: function (e) {
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}

// 确认发布 输入二级密码
function left() {
    $("#xinzeng").modal("hide");
    $("#left").show();
    $(".shandow").show();
};
$('#s-suo').click(function () {
    $('#biaoti').val("")
    $('textarea').val("")
})
function btn_01() {
    $("#left").hide();
    $(".shandow").hide();
    $("#left input").val("");
}
// 确认发布 输入二级密码
function erji() {
    $("#bianji").modal("hide");
    $("#erji").show();
    $(".shandow").show();
};

function btn_03() {
    $("#erji").hide();
    $(".shandow").hide();
    $("#erji input").val("");
    $('#bianji .prev').click()

}

// 分页跳转
var pages

function tiao() {
    $('.tiaozhuan').click(function () {
        pages = $('#fenye').val()
        if (pages > maxpage || pages == 0) {
            layer.msg('请输入正确页数！', { icon: 5 });
            return false;
        } else {
            data = { 'page': pages };
            get_list(data);
        }
    })
}

/**
 * 请求数据
 * @param {type} d data参数这是个对象
 * @param {type} u  请求链接
 * @returns {undefined}
 */
function get_list(d, u) {
    var index = layer.load(0, { shade: false, });
    d = d ? d : {};
    u = u ? u : "/member/user_news/get_news_list";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            layer.closeAll();
            var str = '';
            var p_str = '';
            var zongshu
            if (e.errorCode == '-10004') {
                layer.msg(e.errorMsg, { icon: 5 });
                return false;
            }
            if (e.errorCode == '0') {
                str = get_html(e.result.news_list);
                p_str = get_list_page(e.result.pages);
                zongshu = e.result.total
                $('.n-z').text(zongshu)
            } else {
                str += '<tr>';
                str += '<td colspan="8">没有更多数据 </td>';
                str += '<tr>';
            }
            $(".list_text").html(str);
            $(".tcdPageCode").html(p_str);
            tiao()
            bj()
            schu()
        },
        error: function (e) {
            layer.msg('请求失败！', { icon: 5 });

        }
    });

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
            date(d,i)
            // d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            // d[i].update_time = new Date(parseInt(d[i].update_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr>';
            str += '<td >' + d[i].id + '</td>';

            if (d[i].is_company == 0) {
                str += '<td>个人</td>';

            } else if (d[i].is_company == 1) {
                str += '<td> 企业</td>';
            }
            else if (d[i].is_company == 2) {
                str += '<td> 全部 </td>';
            }
            str += '<td>' + d[i].title + '</td>';
            str += '<td>' + d[i].username + '</td>';
            if (d[i].status == 0) {
                str += '<td>未发布</td>';
            } else {
                str += '<td> 已发布</td>';
            }
            str += '<td>' + d[i].create_time + '</td>';
            str += '<td>' + d[i].update_time + '</td>';
            str += '<td><a class="bianji" data-toggle="modal" data-target="#bianji" system="' + d[i].is_company + '"  editor="' + d[i].status + '"  biao="' + d[i].title + '" _id="' + d[i].id + '">编辑</a></td>';
            str += '<td><a class="shanchu" data-toggle="modal" data-target="#shanchu" _did="' + d[i].id + '">删除</a></td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="8">没有更多数据 </td>';
        str += '<tr>';
    }
    return str;
}
/**
 * 分页页码
 * @param {type} d
 * @returns {String}
 */
var maxpage
var currentpage
function get_list_page(d) {
    var str = '';
    maxpage = d.max_page
    currentpage = d.current_page
    if (d.max_page > 1) {
        if (d.current_page > 1) {
            str += '<a href="javascript:;" class="upPage"  onclick="set_page(' + parseInt(d.current_page - 1) + ')">上一页</a>';
        } else {
            str += '<span class="disabled">上一页</span>';
        }

        //循环页码
        var pages = d.page_list;
        for (var i = 0; i < pages.length; i++) {
            if (d.current_page == pages[i]) {
                str += '<span class="current">' + pages[i] + '</span>';
            } else {
                str += '<a href="javascript:;" class="tcdNumber" onclick="set_page(' + pages[i] + ')">' + pages[i] + '</a>';
            }
        }
        if (d.current_page < d.max_page) {
            str += '<a href="javascript:;" class="nextPage"  onclick="set_page(' + parseInt(Number(d.current_page) + Number(1)) + ')">下一页</a>';
            str += '<span class="tiaozhuan "> 跳转到</span>' + '<input type="text" id="fenye">';
            str += '<span>&#x3000;共&nbsp;</span>' + '<span class="zuida">' + d.max_page + '</span>' + '<span>&#x3000;页</span>';
        } else {
            str += '<span class="disabled">下一页</span>';
            str += '<span class="tiaozhuan "> 跳转到</span>' + '<input type="text" id="fenye">';
        }
    }
    return str;
}
/**
 * 调用分页
 * @param {type} p
 * @returns {undefined}
 */
var p
function set_page(p) {
    data = { 'page': p };
    get_list(data);
}
/**
 * 刷新当前页
 */
$("#shuaxin").click(function () {
    //调用数据
    data = { "page": currentpage }
    get_list(data);
});


function date(d,i){
    var newDate = new Date(d[i].create_time*1000)
    var newTime = new Date(d[i].update_time*1000)
    var mon = (newDate.getMonth()+1);
    var day = newDate.getDate();
    var hour = newDate.getHours();
    var min = newDate.getMinutes();
    var sec = newDate.getSeconds();
    //资料更新时间转化
    var mon2 = (newTime.getMonth()+1);
    var day2 = newTime.getDate();
    var hour2 = newTime.getHours();
    var min2 = newTime.getMinutes();
    var sec2 = newTime.getSeconds();
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
    if(mon2<10){
        mon2 = '0'+mon2;
    }
    if(day2<10){
        day2 = '0'+day2;
    }
    if(hour2<10){
        hour2 = '0'+hour2;
    }
    if(min2<10){
        min2 = '0'+min2;
    }
    if(sec2<10){
        sec2 = '0'+sec2;
    }
    d[i].create_time = newDate.getFullYear()+"-"+mon+"-"+day+" "+hour+":"+min+":"+sec;
    d[i].update_time = newTime.getFullYear()+"-"+mon2+"-"+day2+" "+hour2+":"+min2+":"+sec2;
}