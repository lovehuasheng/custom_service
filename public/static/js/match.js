$(function () {
	$("#myModal,#hyModal").modal({backdrop:"static",show:false});
    // 加载数据
    get_list()
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
    // 日历插件
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
        if($(this).val()==''){
            var newDate = new Date();
            var years = newDate.getFullYear();
            var mon = (newDate.getMonth()+1);
            var day = newDate.getDate();
            $(this).val(years+"-"+mon+"-"+day)
        }
    })
})

/**
 * 搜索查询
 * @param {type} param
 */
var riqi;
var search_type;
var search_name;
$(".search_submints").click(function () {
    riqi = $('.datetimepicker3').val()
    search_type = $.trim($("select[name='search_type']").val());
    search_name = $.trim($(".search_name").val());
    if (search_type == '') {
        layer.msg('请求选择类型！', { icon: 5 });
        return false;
    }
     if($("#ages").val()!=""&&$("#jidus").val()==""||$("#ages").val()==""&&$("#jidus").val()!=""){
        layer.msg("年份及季度需全部选择或全部不选或")
    }
    else{
        st= "";
        //组装参数
        data = { "search_type": search_type, "search_name": search_name, "search_date": riqi ,"year":$("#ages").val(),"quarter":$("#jidus").val() };
        //调用数据
        get_list(data);
    }
    
    if (search_name == '' && riqi == ""&&$("#ages").val()==""&&$("#jidus").val()=="") {
        $('.tishi').show();
    }else{
        $('.tishi').hide();
    }
    
});
// 彈出框
var shi;
var flag;
var a;
$('.shi').click(function () {
    if (flag) {
        shi = $(this).find('img').toggle().attr('name')
        a = 1; flag = 0;
    } else {
        shi = $(this).find('img').toggle().attr('name')
        a = 2; flag = 1;
    }
})
$('#t-btn').click(function () {
    var search_type = $.trim($("select[name='search_name']").val());
    var search_date = $.trim($('#form-control').val());
    var search_name = $.trim($('#text').val());
    // var e = show(search_date, search_name, search_type);
})
// 获取name值
var shou;
$('.shoukuan').click(function () {
    $(this).find('.icon-2').hide()
    shou = $(this).find('.icon-1').show().attr('name')
    $('.fou').find('.icon-2').show()
    $('.fou').find('.icon-1').hide()
})


$('.fou').click(function () {
    shou = $(this).find('.icon-1').show().attr('name')
    $(this).find('.icon-2').hide()
    $('.shoukuan').find('.icon-2').show()
    $('.shoukuan').find('.icon-1').hide()

})
// 获取撤单封号name值
var fh;
$('.t-tgr').click(function () {
    $(this).find('.icon-2').hide()
   fh = $(this).find('.icon-1').show().attr('name');
    $('.t-jsr').find('.icon-2').show()
    $('.t-jsr').find('.icon-1').hide()
})

$('.t-jsr').click(function () {
    fh = $(this).find('.icon-1').show().attr('name')
    $(this).find('.icon-2').hide()
    $('.t-tgr').find('.icon-2').show()
    $('.t-tgr').find('.icon-1').hide()
})
var pp = 2
$('.t-skf').click(function () {
    $(this).find('.icon-2').hide()
    pp = $(this).find('.icon-1').show().attr('name')
    $('.t-skf1').find('.icon-2').show()
    $('.t-skf1').find('.icon-1').hide()
})

$('.t-skf1').click(function () {
    pp = $(this).find('.icon-1').show().attr('name')
    $(this).find('.icon-2').hide()
    $('.t-skf').find('.icon-2').show()
    $('.t-skf').find('.icon-1').hide()
})


// 撤销假图
var id
var match_times
function cx() {
    $('.cx').click(function () {
        id = $(this).attr('_id')
        match_times = $(this).attr('_times')
        var huany = $(this).attr('_hy')
        if (huany == "未打款") {
            layer.msg('未打款不能操作撤销假图', { icon: 5 });
            return false;
        }
    })
}

//调用撤销假图接口
$('#tijiao').click(function () {
    if (shi == 2) {
        layer.msg('你选择撤销假图状态为否！', { icon: 5 });
        return false;
    } else {
        $(this).attr("disabled", 'disabled');
        data = { id: id, match_times: match_times, flag: a }
        backout(data)
    }
})
//撤销假图接口
function backout(d, u) {
    var  riqi = $('.datetimepicker3').val()
    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    d = d ? d : {};
    u = u ? u : "/business/matching/undo_img";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            $("#tijiao").removeAttr("disabled");
            if (e.errorCode == '0') {
                layer.msg('操作成功！')
                    st =""
                    data ={"search_type": search_type, "search_name": search_name,"search_date": riqi }
                    get_list(data);
               
                $('#myModal').modal('hide')
                $('.icon-1').hide()
                $('.icon-2').show()
            } else {
                get_error_to_operation(e);
            }

        },
        error: function (e) {
            $("#tijiao").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });
            layer.msg(e.errorMsg, { icon: 5 });
        }
    });
}
// 调用还原订单接口
var hyu
var match
function hy() {
    $('.hy').click(function () {
        $(".icon-1").css("display",'none')
        $(".icon-2").css("display",'inline-block')
        hyu = $(this).attr('_id')
        match = $(this).attr('_times')
        $('.fou>.icon-1').click()
        var huany = $(this).attr('_hy')
        if (huany == "已打款") {
            layer.msg('已打款成功不能操作还原订单', { icon: 5 });
            return false;
        }
    })
}
$('#m-button').click(function () {
    if(shi==2){
        layer.msg('你选择还原订单状态为否', { icon: 5 });
    }else{
    $(this).attr("disabled", 'disabled');
    data = { id: hyu, match_times: match, type: shou }
    restore(data)
 }
})
// 还原订单接口
function restore(d, u) {
    d = d ? d : {};
    u = u ? u : "/business/matching/destroy_match";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                layer.msg("操作成功")
                $('.list_text tr[flag=' + hyu + ']').fadeOut(300);
                $('#hyModal').modal('hide')
                $('.icon-1').hide()
                $('.icon-2').show()
                hyu = "";
                match = "";
                shou = "";
            } else {
                get_error_to_operation(e);
            }
            $("#m-button").removeAttr("disabled");
        },
        error: function (e) {
            layer.msg('请求失败！', { icon: 5 });
            layer.msg(e.errorMsg, { icon: 5 });
            $("#m-button").removeAttr("disabled");
        }
    });
}

// 掉用撤单封号接口
var cdf
var times
function cd() {
    $('.cd').click(function () {
        $(".show_icon>img").show();
        cdf = $(this).attr('_id')
        times = $(this).attr('_times')
        $('.t-skf1>.icon-1').click()
        var huany = $(this).attr('_hy')
        if (huany == "已打款") {
            layer.msg('已打款成功不能操作撤单封号', { icon: 5 });
            return false;
        }
    })
}
$('#match-button1').click(function () {
    $(this).attr("disabled", 'disabled');
    data = { id: cdf, match_times: times, type: pp, 'flags[]': fh }
    order(data)
})

// 撤单封号
function order(d, u) {
    d = d ? d : {};
    u = u ? u : "/business/matching/disable_no";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            $("#match-button1").removeAttr("disabled");
            if (e.errorCode == '0') {
                layer.msg('操作成功！')
                $(".btn-success").removeClass('btn-success').addClass('btn-danger').html('未打款')
                $('#fhModal').modal('hide')
                $('.icon-1').hide()
                $('.icon-2').show()
                cdf = "";
                times = "";
                fh = "";
                pp = "";
            }else if(e.errorCode == '-10009'){
                layer.msg('封号人不能为空！', { icon: 5 });
            } else {
                get_error_to_operation(e);
            }
        },
        error: function (e) {
            $("#match-button1").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });

        }
    });
}
// 图片显示查看    
function look() {
    $('.payment').click(function () {
        if ($(this).hasClass("btn-danger")) {
            return
        } else {
            var pay = $(this).attr('value')
            var proceeds = $(this).attr('proceeds')
            if (pay == 'null') {
                layer.msg('图片不存在！', { icon: 5 });
            }
            else if (proceeds) {
                alert(proceeds)
                return
            } else {
                $('#clude').show()
                $(".t-img img").attr("src", pay)

            }
            $('.cuo').click(function () {
                $('#clude').hide()
            })
        }

    })

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
//             data = { 'page': pages,"search_type": search_type, "search_name": search_name, "search_date": riqi  };
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
var st;
function get_list(d, u) {
    layer.closeAll(); //疯狂模式，关闭所有层 load加载
    var index = layer.load(0, { shade: false });
    d = d ? d : {};
    u = u ? u : "/business/matching/get_list";
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            layer.closeAll();
            if(e.result.pages.max_page<d.page){
                layer.msg("数据已全部加载完毕")
            }else{
              if (e.errorCode == '0' ) {
                    str = get_html(e.result.data);
                    st+=str;                
                }else{
                    layer.msg(e.errorMsg)
                }
            } 
            $(".list_text").html(st);
            cx()
            hy()
            cd()
            look()
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
    var str;
    var len = 0;
    if (len != null || len != undefined || len != "") {
        len = d.length;
    }
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr flag ='+d[i].id+'>';
            str += '<td>' + d[i].other_id + '</td>';
            str += '<td>' + d[i].other_name + '</td>';
            str += '<td>' + d[i].other_user_id + '</td>';
            str += '<td>' + d[i].provide_money + '</td>';
            str += '<td >' + d[i].pid + '</td>';
            str += '<td>' + d[i].name + '</td>';
            str += '<td>' + d[i].user_id + '</td>';
            str += '<td>' + d[i].other_money + '</td>';
            str += '<td>' + d[i].create_time + '</td>';
            if (d[i].status_text == '未打款' && d[i].sign_text == '未收款') {
                str += '<td>' + '<button class="btn btn-danger payment" value="' + d[i].pay_image + '"" >' + d[i].status_text + '</button>' + '<button value="' + d[i].pay_image + '"" class="btn btn-danger payment" >' + d[i].sign_text + '</button>' + '</td>';
            } else if (d[i].status_text == '已打款' && d[i].sign_text == '已收款') {
                str += '<td>' + '<button value="' + d[i].pay_image + '" class="btn btn-success payment" >' + d[i].status_text + '</button>' + '<button  proceeds="' + d[i].sign_text + '" value="' + d[i].pay_image + '" class="btn btn-success payment">' + d[i].sign_text + '</button>' + '</td>';
            }
            else if (d[i].status_text == '已打款' && d[i].sign_text == '未收款') {
                str += '<td>' + '<button value="' + d[i].pay_image + '" class="btn btn-success payment" >' + d[i].status_text + '</button>' + '<button value="' + d[i].pay_image + '"" class="btn btn-danger payment">' + d[i].sign_text + '</button>' + '</td>';
            }

            str += '<td><a _times="' + d[i].create_time + '"  _id="' + d[i].id + '"  _hy="' + d[i].status_text + '" href="" class="cx" data-toggle="modal" data-target="#myModal">撤销假图</a></td>';
            str += '<td><a _times="' + d[i].create_time + '"  _id="' + d[i].id + '" _hy="' + d[i].status_text + '" href="" class="hy"data-toggle="modal" data-target="#hyModal">还原订单</a></td>';          
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="13">没有更多数据 </td>';
        str += '<tr>';
    }

    return str;
}
// /**
//  * 调用分页
//  * @param {type} p
//  * @returns {undefined}
//  */
var p
function set_page(p) {     
    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    data = { 'page': p,"search_type": search_type, "search_name": search_name, "search_date": riqi  };
    get_list(data);
}
/**
 * 刷新
 */


