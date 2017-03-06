$(function () {
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
        var newDate = new Date();
        var years = newDate.getFullYear();
        var mon = (newDate.getMonth()+1);
        var day = newDate.getDate();
        if($("#form-control")!=''){
          $('#form-control').val(years+"-"+mon+"-"+day); 
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
    })
})

// ////////////////////////////////////////////
// 全选状态下  取消任意一个按钮 全选按钮消失
//获取社区值
var nub = "";
$('#s-fenlei>div').click(function () {
    if ($('.icon-1').show()) {
        $("#xuanze").find('.icon-4').hide()
        $("#xuanze").find('.icon-3').show()
        $("#quxiao").addClass(' btn-defalut').removeClass(' btn-danger')
    }
    $('#s-fenlei .icon-1').hide().next().show();
    $(this).find('img').eq(0).show().next().hide()
    $('#s-fenlei>div:nth-child(2) .icon-1').hide().next().show()

    nub = $(this).attr("id");
});
// 全选
var m = 1;
$('#s-fenlei>div:nth-child(2)').click(function () {
    if (m) {
        $(this).parent().find('div .icon-1').show().next().hide();
        return m = 0;
    } else {
        $(this).parent().find('div .icon-1').hide().next().show();
        return m = 1
    }
});
//出局钱包剩余
var shengyu
// 搜索选择
var sou
sou = $('.icon-3').attr('name');
$('.icon-3').click(function () {
    var nub = ""
    var time = $('.datetimepicker3').val("")
    $('#s-fenlei').hide()
    $('#data-time').hide()
    $("#ages").show();
    $("#jidus").show();
    $(this).hide();
    sou = $('.icon-4').show().attr('name');
    $("#quxiao").addClass('btn-danger').removeClass('btn-defalut')
    $('#audits').show();
})
var check = 0;
$(".audit>.icon-a").click(function(){
   $(this).hide();
   check = $(".audit>.icon-b").show().attr("name")
})
$(".audit>.icon-b").click(function(){
   $(this).hide();
   check = $(".audit>.icon-a").show().attr("name")
})
$(".audits>.icon-a").click(function(){
   $(this).hide();
   check = $(".audits>.icon-b").show().attr("name")
})
$(".audits>.icon-b").click(function(){
   $(this).hide();
   check = $(".audits>.icon-a").show().attr("name")
})
//隐藏
$('.icon-4').click(function () {
    $(this).hide();
    $("#text").val("")
    var nub = "";
    var time = "";
    $("#ages").hide();
    $("#jidus").hide();
    $('#s-fenlei').show()
    $('#data-time').show()
    sou = $('.icon-3').show().attr('name');
    $("#quxiao").addClass(' btn-defalut').removeClass(' btn-danger')
    $('#audits').hide();
})

$('#xuanze').click(function () {
    if($('.check').attr('checked',true)){
        $('.check').click()
    }
    if (sou == 2) {
        nub = ""
        $("#s-fenlei").find('.icon-1').hide()
        $("#s-fenlei").find('.icon-2').show()
        $('.list_text').empty()
       $(".tcdPageCode").empty()
    }
})

/**
 * 搜索查询
 * @param {type} param
 */
var time;
var st; //请求过来的数据 这个很重要；位置不能随意改变
$('#btn-btn1').click(function () {
    var search_name = $.trim($(".search_name").val());
    time = $('.datetimepicker3').val();
      if(nub=="0" && $('#icon-1').is(":hidden")){
        layer.msg("社区未选择");
        return false;
    }
    if (search_name == "" && nub == "" && time == "") {
        layer.msg('请选择或输入查询条件')
    } else if (nub != "" || time != "") {   
        if($("#age").val()!=''&&$("#jidu").val()==''||$("#age").val()==''&&$("#jidu").val()!=''){
            layer.msg("年份及季度需全部选择或全部不选")
        }else{
            $(this).attr("disabled","disabled")
            st='';
            data = { "community_id": nub, "data_time": time,"year":$("#age").val(),"quarter":$("#jidu").val(),"check":check }
            get_list(data)
        }
    } else if (search_name != "") {
        var search_type = $.trim($("select[name='search_type']").val());
        var search_name = $.trim($(".search_name").val());
        if (search_type == '') {
            layer.msg('请求选择类型！', { icon: 5 });
            return false;
        }
        if (search_name == '' || search_name == undefined || search_name == null) {
            layer.msg('请求输入搜索ID！', { icon: 5 });
            return false;
        }
        var num = /^[0-9]*$/;
        if(num.test(search_name)){
            //组装参数
            $(this).attr("disabled","disabled")
            if($("#ages").val()!=''&&$("#jidus").val()==''||$("#ages").val()==''&&$("#jidus").val()!=''){
                layer.msg("年份及季度需全部选择或全部不选")
            }else{
                st='';
                data = { "search_type": search_type, "search_name": search_name,"year":$("#ages").val(),"quarter":$("#jidus").val() ,"check":check}
                get_list(data)
            }
        }else{
            layer.msg("请输入纯数字ID")
        }
    }
})
//加入手动匹配接口
$('#btn-btn').click(function () {
    if (quan == "") {
        layer.msg('没有选中复选框！', { icon: 5 });
        return false;
    }
    else {
        data = { "ids": quan, "create_time": jian, }
        match(data)


    }
})
// 点击错误图标清楚参数
$('#close').click(function(){
   $('#btn-btn1').click()
   quan.length=""
})
// 获取金额
var sum = $('.sum').text();
// 定义输入金额
var srje
$("#quxiao").click(function () {
    if (quan == "") {
        layer.msg('复选框未选中！', { icon: 5 });
        return false;
    }
    if(ddan ==undefined||ddan ==null||ddan ==""){
        layer.msg('每次只能提交一个订单！', { icon: 5 });
         $("#myModal").modal('hide')
         return false;
    }
    if (sou == 1) {
        return false;
    } else {
        data = { "user_id": userid }
        revise(data)
    }
})
// 取消请求
// 修改金额提交判断
$('#tijiao').click(function () {
    srje = $('.import').val()
    if (srje > shengyu) {
        layer.msg('输入金额不能大于剩余金额！', { icon: 5 });
        return false;
    }
    if (srje <= 0) {
        layer.msg('输入金额不能小于0！', { icon: 5 });
        return false;
    }
    if(ddan ==undefined||ddan ==null||ddan ==""){
        layer.msg('暂不支持全选功能！', { icon: 5 });
         $("#myModal").modal('hide')
         return false;
    }
    if (quan == null || quan == "") {
        layer.msg('没有选中复选框！', { icon: 5 });
    } else if (sou == 2) {
        data = { "ids": ddan, "partition_time": jesj, "amount": srje }
        report(data)
    }
})
//修改金额提交接口
function report(d, u) {
    d = d ? d : {};
    u = u ? u : '/business/accept/set_accepthelp_money_by_account';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                $("#quxiao").removeAttr("disabled");
                var srje = "";
                layer.alert('操作成功！', {
                    skin: 'layui-layer-demo' //样式类名
                    , closeBtn: 0
                }, function () {
                    $('#btn-btn1').click()
                });
                $('.import').val("")
                $('#myModal').modal("hide")
            } else {
                get_error_to_operation(e);
            }
        },
        error: function (e) {
            $("#quxiao").removeAttr("disabled");
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}


// 获取id接口
function revise(d, u) {
    d = d ? d : {};
    u = u ? u : '/member/user_account/get_account_list';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                // 获取剩余钱包
                $('.sum').text(e.result.wallet_currency)
                shengyu = e.result.wallet_currency;
            } else {
                get_error_to_operation(e);
            }
        },
        error: function (e) {
            layer.msg('请求失败！', { icon: 5 });
        }
    });
}
// 多选加入手动匹配列表
// 点击复选框获取当前对应的值

var ddan
var jesj
var userid
var pipei
function xuan() {
    $('.check').click(function () {
        if (this.checked) {
            var v = $(this).attr('_user')
            ddan = $(this).attr('_user')
            jesj = $(this).attr('_time')
            userid = $(this).attr('userid')
            pipei = $(this).attr('pipei')
            quan.push(v)
            console.log(quan)
        } else {
            quan.pop(v)
            console.log(quan)
        }
    })
}
var jian = new Array()
function date() {
    $('.check').click(function () {
        if (this.checked) {
            var v = $(this).attr('_time')
            jian.push(v);
        } else {
            jian.pop(v);
        }
    });
}
function match(d, u) {
    d = d ? d : {};
    u = u ? u : '/business/accept/set_manual_match';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            //  index.remove();
            if (e.errorCode == '0') {
                $('.tck-cg').show()
                $('.tck-cg1').show()
                setTimeout(function () {
                    $(".tck-cg").hide()
                }, 1000)
                data = { "community_id": nub, }
                for(var i=0;i<d.ids.length;i++){
                    $('.list_text tr[flag=' + d.ids[i] + ']').fadeOut(300);
                }
                // get_list(data);
                quan = new Array();
            } else {
                get_error_to_operation(e);
            }
        },
        error: function (e) {
            layer.msg('请求失败！', { icon: 5 });

        }
    });
}
/**
 * 刷新
 */
$("#shuaxin1").click(function () {
     // $('.check').attr('checked','false')
     // quan=""
    //调用数据
     if (nub != "") {
        //调用数据
        $(".list_text").empty();
        st='';
        data = {community_id: nub, "data_time": time,"check":check  }; //'page': currentpage,
        get_list(data);
    }else{
        return;
    }
});
/**
 * 调用分页
 * @param {type} p
 * @returns {undefined}
 */
var p
function set_page(p) {

    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    data = { 'page': p, community_id: nub, "data_time": time,"check":check };
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
//             data = { 'page': pages, community_id: nub, "data_time": time };
//             get_list(data);
//         }
//     })
// }

// 数据请求
function get_list(d, u) {
    var index = layer.load(0, { shade: false });
    d = d ? d : {};
    u = u ? u : '/business/accept/get_list';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: d,
        url: u,
        async: true,
        success: function (e) {
            layer.closeAll();
            $("#btn-btn1").removeAttr("disabled")
            if (e.errorCode == '0') {
                if(e.result.pages.max_page<d.page){
                    layer.msg("数据已全部加载完毕")
                }else{
                   str = get_html(e.result.data);
                   st+=str;   
                }  
            }
            $(".list_text").html(st);
            xuan()
            date()
            var nub = "";
            var time = ""
        },
        error: function (e) {
            $("#btn-btn1").removeAttr("disabled")
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

            d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr flag="'+d[i].id+'"><input type="hidden" name="match_times[]" value="' + d[i].create_time + '" >';
            str += '<td><input type="checkbox" pipei="' + d[i].money + '"  userid="' + d[i].user_id + '" _user="' + d[i].id + '" _time="' + d[i].create_time + '" class="check" name="ids[]" value="' + d[i].other_id + '" _money="' + d[i].other_money + '" ></td>';
            str += '<td  class="ids1" style="display:none">' + d[i].id + '</td>';
            str += '<td>' + d[i].id + '</td>';
            str += '<td>' + d[i].name + '</td>';
            str += '<td>' + d[i].user_id + '</td>';
            str += '<td>' + d[i].money + '</td>';
            str += '<td>' + d[i].used + '</td>';
            str += '<td class="s-time">' + d[i].create_time + '</td>';
            str += '<td>' + parseInt(parseInt(d[i].money) - parseInt(d[i].used)) + '</td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="8">没有更多数据 </td>';
        str += '<tr>';
    }
return str;

}
