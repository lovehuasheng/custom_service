//预加载
$(function () {
	$("#woModal,#jiedanModal").modal({backdrop:"static",show:false});
    //加载数据
    get_list();
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
// 进行传参，点击图片获取相应的name值
var ids;
var sh;
var tgxm;
//var money = 0;
var fou = 1;
$('.t-skf').click(function () {
    $(this).find('.icon-1').hide()
    fou = $(this).find('.icon-2').show().attr('name')
    $('.t-skf1').find('.icon-1').show()
    $('.t-skf1').find('.icon-2').hide()
    // }
})
$('.t-skf1').click(function () {
    fou = $(this).find('.icon-2').show().attr('name')
    $(this).find('.icon-1').hide()
    $('.t-skf').find('.icon-1').show()
    $('.t-skf').find('.icon-2').hide()
})
$('.t-skf2').click(function () {
    $(this).find('.icon-1').hide()
    fou = $(this).find('.icon-2').show().attr('name')
    $('.t-skf3').find('.icon-1').show()
    $('.t-skf3').find('.icon-2').hide()
    // }
})
$('.t-skf3').click(function () {
    fou = $(this).find('.icon-2').show().attr('name')
    $(this).find('.icon-1').hide()
    $('.t-skf2').find('.icon-1').show()
    $('.t-skf2').find('.icon-2').hide()
})
// 单选或多选
function get_dan() {
    // 单选或多选
    $('.check').click(function () {
        // 获取参数值
        ids = $(this).attr('value');
        var times = $(this).attr('_times');
        tgxm = $(this).attr('_tgxm');
        //全局数组变量的长度
        var l = quan.length;//10
        sh = l
        var p =  $(this).attr("y_pp")
        //取消选中
        if (this.checked == false) {
            //批量接单时，单选或多选获取总金额
            mmoney = mmoney - parseInt($(this).attr('_money'));
            dddete.pop(p)
            if (quan.length > 0) {
                var tmp = new Array();
                var j = 0;
                for (var i = 0; i < quan.length; i++) {
                    if (ids != quan[i]) {
                        tmp[j++] = quan[i]
                    }
                }
                quan = tmp;
            }
        } else {
            //选择
            dddete.push(p)
            quan[l++] = ids; 
            mmoney += parseInt($(this).attr('_money'));

        }
        //批量接单
        $('#pl-jiedan').click(function () {
            $('.shu-l').text(quan.length)
            $('.j-money').text(mmoney)
        })
    });
}
//单选接单获取other_name  匹配ID
var mingzi;
var pp;
var flg;
var other_id;
var create_time;
var st;
function xm() {
    $('.jiedan').click(function () {  
        //先判断ajax 是否已经有部分接单了  是的话就不能接单
        other_id  = $(this).attr('other_id'); 
        create_time = $(this).attr('create_time');
        flg = $(this).attr("_id");
        var  url =  "/business/matching/get_jieke";
        var pay =  $(this).parent().prev().prev().children("input").val();
        mingzi = $(this).attr('value');
        pp = $(this).attr('_id')+'|'+$(this).attr('time');

        if(pay>0){
            layer.msg("订单未全部超时或已部分打款!");
            return false;
        }else{
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data:{'other_id':other_id,'create_time':create_time},
                url: url,
                async: true,
                success: function (e) {
                         $('.tgr-name').text(mingzi);
                         // 点击接单默认值为否
                         $('.t-skf1').click();
                },
                error: function (e) {
                    layer.msg('请求失败！', { icon: 5 });

                }
            })
        };     
    })
}


// 单选接单
$("#tijiao").click(function () {
    var zh = $('.inp').val();
    if (zh == "") {
        layer.msg('输入框不能为空！', { icon: 5 });
    } else {
        $(this).attr("disabled", 'disabled');
        data = { "ids": pp, "other_username": zh, "flag": fou,"create_time":create_time,"other_id":other_id }
        order(data)
        $('.inp').val("")
    }
})


//批量接单
$('#pl-jiedan').click(function () {
     if($('#check').attr('checked',false)){
         $('#check').attr('checked',true)
    }
    if (quan == "") {
        layer.alert('请选择复选框！', {
            skin: 'layui-layer-demo' //样式类名
            , closeBtn: 0
        });
        return false;
    }else{
    // 点击批量接单，设置默认值
    $('.t-skf3>.icon-2').click()
    }
})
//批量接单提交
$('#tijiao1').click(function () {
    if (quan.length <= 0) {
        layer.msg('没有选中复选框！', { icon: 5 });
        return false;
    }
    else if (quan.length > 0) {
        var zh = $('#inp').val()
        if (zh == "") {
            layer.msg('输入框不能为空！', { icon: 5 });
            return false;
        } else {
            $(this).attr("disabled", 'disabled');
            data = { "ids": quan, "other_username": zh, "flag": fou }
            order(data)
        }
    }
});
// 接单接口请求
function order(d, u) {
    d = d ? d : {};
    u = u ? u : "/business/matching/transfer_order_to_user";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
             $("#tijiao").removeAttr("disabled");
             $("#tijiao1").removeAttr("disabled");
                if (e.errorCode == '0') {
                    layer.msg('操作成功！')
                        for(var i=0;i<d.ids.length;i++){
                             $('.list_text tr[flag=' + flag + ']').fadeOut(300);
                        }
                        // get_list();
                    
                    $('#inp').val("")
                    $('.j-money').text("")
                    $('.shu-l').text("")
                    $('#pljiedanModal').modal('hide')
                    $('#jiedanModal').modal('hide')
                } else {
                    get_error_to_operation(e);
                }
            },
        error: function (e) {
            layer.msg('输入框不能为空！', { icon: 5 });
            $("#tijiao1").removeAttr("disabled");
            layer.msg(e.errorMsg, { icon: 5 });
        }
    });
}
//延时接口
// 延时时间显示
$('#ipt').click(function () {
    $('#timeout-date').show()
});
function timeout(d, u) {
    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    d = d ? d : {};
    u = u ? u : "/business/matching/delayed_match";
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
                layer.msg('操作成功！')
                st='';
                if(search_name !=""){
                data = {"search_type": search_type, "search_name": search_name}
                get_list(data);
                dddete =new Array()
                }else{
                    get_list()
                    dddete =new Array()
                }

            } else {
                get_error_to_operation(e);
            }
            $("#queding").removeAttr("disabled");
        },
        error: function (e) {
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}
// 获取时间
var date;
$("#timeout-date>ul li").click(function () {
    $("#ipt").val($(this).html())
    $('#timeout-date').hide()
    num = $(this).index()
    date = num + 1
});
//获取id
function ys() {
    $('.yanshi').click(function () {
        quan = $(this).attr('_ys')
        dddete=$(this).attr('_pipei')
    })

}
//批量延时点击
$('#pl-yanshi').click(function () {
    if($('#check').attr('checked',false)){
         $('#check').attr('checked',true)
    }
    if (quan == "") {
        layer.alert('请选择复选框！', {
            skin: 'layui-layer-demo' //样式类名
            , closeBtn: 0
        });
        return false;
    }
})
//延时接口调用
$('#queding').click(function () {
    var ys = $('#ipt').val()
    if (ys == "" || ys == null || ys == NaN) {
        layer.msg('请填写输入框内容！', { icon: 5 });
        return false;
    } else {
        $(this).attr("disabled", 'disabled');
        data = { "delayed_time": date, "ids": quan,"matchhelp_time":dddete }
        timeout(data)
    }
})
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
// 分页跳转
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
    var index = layer.load(0, { shade: false, });
    d = d ? d : {};
    u = u ? u : "/business/matching/pay_overtime_order_list";
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
            if (e.errorCode == '-10004') {
                layer.msg(e.errorMsg, { icon: 5 });
                return false;
            }
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
                layer.msg($(this).html())
            })
            // $(".tcdPageCode").html(p_str);
            // tiao()//跳转调用
            get_dan()//单选调用
            ys()//延时调用
            xm()
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
    var   pipei    ='';
    var   other_id = '';
    if (len > 0) {
        for (i = 0; i < len; i++) {
            pipei         = d[i].audit_time;
            other_id      = d[i].other_id;
            create_time   = d[i].create_time;
            
            d[i].audit_time = new Date(parseInt(d[i].audit_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr flag="'+d[i].id+'" class="tr_id"><input type="hidden" name="match_times[]" value="' + d[i].create_time + '" >';
            str += '<td><input type="checkbox" class="check" y_pp="'+pipei +'" name="ids[]" value="' + d[i].id + '" _money="' + d[i].other_money + '" ></td>';
            str += '<td >' + d[i].other_id + '</td>';
            str += '<td class="ids1" style="display:none">' + d[i].id + '</td>';
            str += '<td class="tgxm">' + d[i].other_name + '</td>';
            str += '<td>' + d[i].other_user_id + '</td>';
            str += '<td>' + d[i].provide_money + '</td>';
            str += '<td class="sxh_yuanyin">' + d[i].remark + '</td>';
            str += '<td>' + d[i].pid + '</td>';
            str += '<td class="mz">' + d[i].name + '</td>';
            str += '<td>' + d[i].user_id + '</td>';
            str += '<td class="other_money">' + d[i].other_money + '</td>';
            str += '<td class="creates" y_pp="'+pipei+'" >' + d[i].audit_time + '</td>';
            str += '<td class="liy" style="display:none">' + d[i].remark + '</td>';
            //   判断是否为数字，是数字启用倒计时
            if (parseInt(d[i].pay_time_text) > 0) {
                str += '<td class="daojishi"><span>' + getTimeText(d[i].pay_time_text) + '</span><input type="hidden" value="' + d[i].pay_time_text + '"></td>';
            } else {
                str += '<td>' + d[i].pay_time_text + '</td>';
            }
            str += '<td><a class="yanshi" data-toggle="modal" data-target="#woModal" _pipei="'+pipei+'"  _ys="' + d[i].id + '" _mz="' + d[i].other_name + '">延时</a></td>';
            str += '<td><a class="jiedan" data-toggle="modal" data-target="#jiedanModal" other_id="'+other_id+'" create_time="'+create_time+'"  time="'+pipei+'" _id="' + d[i].id + '" value="' + d[i].other_name + '">接单</a></td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="14">没有更多数据 </td>';
        str += '<tr>';
    }
    return str;
}
// 付款倒计时
setInterval(function () {
    $(".daojishi span").each(function (i) {
        var v = parseInt($(".daojishi").eq(i).children('input').val());
        if (v > 0) {

            var shijian = getTimeText(v);
            v--;
            $(".daojishi").eq(i).children('span').html(shijian);
            $(".daojishi").eq(i).children('input').val(v)
        }else {
            $(".daojishi").eq(i).children('span').html('付款已超时');
            $(".daojishi").eq(i).children('input').val(0)
        }
    });
}, 1000);
function getTimeText(v) {
    var day = parseInt(v / 3600 / 24);
    var h = parseInt((v / 3600) % 24);
    var s = parseInt((v / 60) % 60);
    var m = parseInt((v) % 60);
    if (h < 10) {
        h = '0' + h;
    }
    if (s < 10) {
        s = '0' + s;
    }
    if (m < 10) {
        m = '0' + m;
    }
    var shijian = day + "天" + h + '小时' + s + "分" + m + "秒";
    return shijian;
}
/**
 * 刷新
 */
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




