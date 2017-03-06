$(function () {
    get_list();
    $(".out").click(function(){
        $("#imgs").hide(300);
        $(".users").remove();
    })
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
})
//点击图片获取name值
var st;
var shi
$('.fenghao').click(function () {
    shi = $(this).find('.icon-2').show().attr('name')
    $(this).find('.icon-1').hide()
    $('.fenghao1').find('.icon-2').hide()
    $('.fenghao1').find('.icon-1').show()
})
$('.fenghao1').click(function () {
    shi = $(this).find('.icon-2').show().attr('name')
    $(this).find('.icon-1').hide()
    $('.fenghao').find('.icon-2').hide()
    $('.fenghao').find('.icon-1').show()
})
shi = $('.fenghao1').find('.icon-2').show().attr('name')
$('.fenghao1').find('.icon-1').hide()
// 获取当前值
var user;
var tim;
var id;
var tr;
function shou() {
    $('.shoukuan').click(function () {
        tr = $(this).parent().parent()
        quan = $(this).attr('_id')
        user = $(this).attr('_user')
        tim = $(this).attr('_time')
        $('.ipt').val(user)
        $('.fenghao1>.icon-2').click()
    })
}
$('#tijiao').click(function () {
    if (shi == "undefined" || shi == null || shi == "") {
        layer.msg('没有选择接受人是否封号！', { icon: 5 });
        return false;
    } else {
        $(this).attr("disabled", 'disabled');//禁止重复提交
        data = { id: quan, flag: shi, match_time: tim, user_id: user }
        payee(data)

    }
})
//确认收款接口
function payee(d, u) {
    d = d ? d : {};
    u = u ? u : "/business/matching/accept_collections";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true, 
        data: d,
        url: u,
        async: true,
        success: function (e) {
            
            if (e.errorCode == '0') {
                layer.msg('操作成功！')
                $("#myModal").modal('hide')
                $('.icon-2').hide()
                $('.icon-1').show()
                tr.hide()
            }
            else {
                get_error_to_operation(e);
            }
            $("#tijiao").removeAttr("disabled");
        },
        error: function (e) {
            $("#tijiao").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}

// 页面跳转
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
// // 分页跳转
// var pages
// function tiao() {
//     $('.tiaozhuan').click(function () {
//         pages = $('#fenye').val()
//         if (pages > maxpage || pages == 0) {
//             layer.msg('请输入正确页数！', { icon: 5 });
//             return false;
//         } else {
//             data = { 'page': pages };
//             get_list(data);
//         }
//     })
// }
/**
 * 请求数据
 * @param {type} d data参数这是个对象
 * @param {type} u  请求链接
 * @returns {undefined}
 */
function get_list(d, u) {
    var index = layer.load(0, { shade: false });
    d = d ? d : {};
    u = u ? u : '/business/matching/make_money_overtime_order_list';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            layer.closeAll();
            if (e.errorCode == '0') {
              if(e.result.pages.max_page<d.page){
                    layer.msg("数据已全部加载完毕")
                }else{
                   str = get_html(e.result.data);
                   st+=str;   
                }  
            } else {
                str += '<tr>';
                str += '<td colspan="14">没有更多数据 </td>';
                str += '<tr>';
            }
            $(".list_text").html(st);
            $(".sxh_yuanyin").mouseover(function(){
                layer.msg($(this).html());
            })
            $(".sxh_chakan").click(function(){
                $("#imgs").show(300)
            })
            // $(".tcdPageCode").html(get_list_page(e.result.pages));
            // 单选调用
            // 接单调用
            shou()
            // tiao()

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
        for (var i = 0; i < len; i++) {

            d[i].pay_time = new Date(parseInt(d[i].pay_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr><input type="hidden" name="match_times[]" value="' + d[i].create_time + '" >';
            str += '<td style="display:none"><input type="hidden" class="check" name="ids[]"value="' + d[i].id + '" _money="' + d[i].other_money + '" ></td>';
            str += '<td>' + d[i].other_id + '</td>';
            str += '<td>' + d[i].other_name + '</td>';
            str += '<td>' + d[i].other_user_id + '</td>';
            str += '<td><a class ="sxh_chakan">查看</a></td>';
            str += '<td class="ppei" style ="display:none">' + d[i].id + '</td>';
            str += '<td class="time" style ="display:none">' + d[i].create_time + '</td>';
            str += '<td>' + d[i].pid + '</td>';
            str += '<td class="mz">' + d[i].name + '</td>';
            str += '<td>' + d[i].user_id + '</td>';
            str += '<td>' + d[i].provide_money + '</td>';
            str += '<td>' + d[i].other_money + '</td>';
            str += '<td class="sxh_yuanyin">不确认收款原fasgdsdgdghggfmoherhniga bfuiqbwfuabfubfvbywqfvwqvfvy因</td>';
            str += '<td>' + d[i].pay_time + '</td>';
            str += '<td class="daojishi"><input type="hidden" value="' + d[i].sign_time_text + '"> '+ d[i].sign_time_text +' </td>';
            //   判断是否为数字，是数字启用倒计时
            //   判断是否为数字，是数字启用倒计时
            // if (parseInt(d[i].sign_time_text) > 0) {
            //     str += '<td class="daojishi"><span>' + getTimeText(d[i].sign_time_text) + '</span><input type="hidden" value="' + d[i].sign_time_text + '"></td>';
            // } else {
            //     str += '<td>' + d[i].sign_time_text + '</td>';
            // }     
            str += '<td><a href=""data-toggle="modal" data-target="#myModal" _time="' + d[i].create_time + '" _user="' + d[i].user_id + '"  _id="' + d[i].id + '" class="shoukuan">确认收款</a></td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="12">没有更多数据 </td>';
        str += '<tr>';
    }
    return str;

}

$("#shuaxin").click(function () {
    $(".search_name").val('')
    //调用数据
    if($('#check').attr('checked',true)){
        quan = new Array();
        $('#check').click()
    } 
    data={"page":currentpage}
    $(".list_text").empty();
    st='';
    get_list(data);
    $('.icon-2').show()
    $('.icon-1').hide()
});
// // 付款倒计时
// setInterval(function () {
//     $(".daojishi span").each(function (i) {
//         var v = parseInt($(".daojishi").eq(i).children('input').val());
//         if (v > 0) {

//             var shijian = getTimeText(v);
//             v--;
//             $(".daojishi").eq(i).children('span').html(shijian);
//             $(".daojishi").eq(i).children('input').val(v)
//         }else {
//             $(".daojishi").eq(i).children('span').html('收款已超时');
//             $(".daojishi").eq(i).children('input').val(0)
//         }
//     });
// }, 1000);
// function getTimeText(v) {
//     var day = parseInt(v / 3600 / 24);
//     var h = parseInt((v / 3600) % 24);
//     var s = parseInt((v / 60) % 60);
//     var m = parseInt((v) % 60);
//     if (h < 10) {
//         h = '0' + h;
//     }
//     if (s < 10) {
//         s = '0' + s;
//     }
//     if (m < 10) {
//         m = '0' + m;
//     }
//     var shijian = day + "天" + h + '小时' + s + "分" + m + "秒";
//     return shijian;
// }

