$(function () {
    get_list();
    $(".btn").click(function () {
        $(this).css({ "color": "#fff", "outline": "none" });
    });
    $(".cli").click(function () {
        // $('#motai').show();
        // $(".imgs").show();
        // $(".closes").show();
        // $("#look").modal('hide');
        $("#imgs").show(300); 
        
    });
    $(".closes").click(function () {
         $("#look").modal('show');
         $('#motai').hide();
    });
    $(".xx").click(function () {
        $("#look").modal("hide") ;   
    })
    //关闭弹窗
    $(".out").click(function(){
        $("#imgs").hide(300);
        $(".users").remove();
    })

})
var yijiefeng;
// 同意解封
    var tongyi;
    $(".agree .img_02").click(function () {
            $(this).addClass("img");
            tongyi = $(this).attr("name");
            $(".carry .img_02 ").removeClass("img");
    });
    // 继续冻结
    $(".carry .img_02").click(function () {
            $(this).addClass("img");
            tongyi = $(this).attr("name");
            $(".agree .img_02 ").removeClass("img") ;  
    });
    // 封号原因

    $('.close').click(function(){
        $('textarea').val("");
    })
  
    /**
     * 搜索查询
     * @param {type} param
     */
    $("#query").click(function () {
        //搜索功能
        if($('.ipt_username').val()==""){
            layer.msg('输入框不能为空！');
        }else{
            var query = $('.ipt_username').val()
            data={"deblock_username":query};
            get_list(data);
        }
    });
    /**
     * 刷新
     */
    $("#shuaxin").click(function () {
        
        $('.ipt_username').val("");
        get_list();
    })
  var canshu;
    // 解封申请处理
    $("#tijiao").click(function(){
        $(this).attr("disabled","disabled")
        var bujiefengyuanyin =$('textarea').val();
        if(tongyi==''||tongyi=='undefined'||tongyi=="null"){
            layer.msg('请完善信息');
        }
        else if(tongyi =="0"){
            if(bujiefengyuanyin!=""){
            data={"status":tongyi,"unblock_comtent":bujiefengyuanyin,"apply_id":canshu};
            shenqing(data);
            }else{
                layer.msg('请填写不予解封原因');
                $("#tijiao").removeAttr("disabled");
            }
        }else if(tongyi=='1'){
            // layer.msg("已解封不能再次解封")
            // $("#tijiao").removeAttr("disabled")
            // return false;
            if(yijiefeng =="已解封"){
                layer.msg("已解封不能再次解封")
                 $("#tijiao").removeAttr("disabled");
            }else{
                data={"status":tongyi,"apply_id":canshu,"unblock_comtent":bujiefengyuanyin}
                shenqing(data);
                 $("#tijiao").removeAttr("disabled");
            }
            
        }
    

    })
function shenqing(d, u) {
    d = d ? d : {};
    u = u ? u : '/member/deblocking/update_apply_info';
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: d,
        url: u,
        async: true,
        success: function (e) {
            if (e.errorCode == '0') {
                $("textarea").val("");
                $('#look').modal('hide');
                    layer.msg("操作成功！") ;
                    setTimeout(function(){
                        get_list();  
                        $("#tijiao").removeAttr("disabled");
                    },1000)
                 
                    
            } 
        },
        error: function (e) {
           layer.msg("请求失败",{ icon: 5 });
            $("#tijiao").removeAttr("disabled");
        }
    });
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
    u = u ? u : "/member/deblocking/get_apply_list";
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
            if (e.errorCode == '0') {
                str = get_html(e.result.apply_list);
                p_str = get_list_page(e.result.pages);
            } else {
                str += '<tr>';
                str += '<td colspan="7">没有更多数据 </td>';
                str += '<tr>';
            }
           
            $(".list_text").html(str);
            $(".tcdPageCode").html(p_str); 
            look();
             tiao();
            $('ipt_username').val("")
        },
        error: function (e) {
            layer.msg("请求失败",{ icon: 5 });
            // layer.msg(errorMsg, { icon: 5 });

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
            pipei = d[i].create_time;
            d[i].create_time = new Date(parseInt(d[i].create_time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
            str += '<tr>';
            str +='<td>'+d[i].id +'</td>';
            str += '<td>'+ d[i].deblock_username+'</td>';
            str += '<td>'+ d[i].deblock_name+'</td>';
            if(d[i].status =="0"){
                str +='<td style="color:#FF0000;"> 未解封</td>';
            }else if(d[i].status =="1"){
                 str +='<td class="yijiefeng">已解封</td>';
            }
            str +='<td>'+d[i].service_username +'</td>';
            str +='<td>'+ d[i].create_time+'</td>';
            str += '<td data-toggle="modal" data-target="#look" class="look" val="'+d[i].id +'" style="color:#2ea4eb">查看</td>';
            str += '<tr>';
        }
    } else {
        str += '<tr>';
        str += '<td colspan="7">没有更多数据 </td>';
        str += '<tr>';
    }

    return str;
}
function look() {
    $('.carry >.img_02').click()
    $(".look").click(function(){
     yijiefeng = $(this).parent().children().eq(3).html() 
        canshu =$(this).attr('val');
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            async: true,
            url:"/member/deblocking/get_apply_info",
            data:{apply_id:canshu},
            async: true,
            success: function (e) {
                if (e.errorCode == '0') {
                    var jfshengqing = e.result.deblock_content;
                    var fhyuanyin=e.result.block_reason;
                    var tupian = e.result.image;
                    var times =e.result.deblock_num;
                    
                    $('.fenghaoyuanyin').html(fhyuanyin);
                    $('.application_tit').html(jfshengqing.replace(/\r\n\r\n/g,"<br>"));
                    // console.log(str);
                    // alert(str);
                    //console.log()
                    //alert(jfshengqing.replace(/\\r/g,"<br>").replace(/\\n/g,'<br>'))
                    // $('.imgs').attr("src",tupian);
                    $("#tp1 a").attr("href",tupian);
                    $("#tp4").attr("src",tupian)
                    $('.num').html(times);
                } 
            },
            error: function (e) {
                layer.msg('请求失败！', { icon: 5 });
            }
        });
     })

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
    maxpage =d.max_page;
    currentpage =d.current_page;
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
            str +='<span class="tiaozhuan "> 跳转到</span>'+'<input type="text" id="fenye">';
            //  str += '<span class="dangqian">'+d.current_page+'</span>';
            //  str += '<span> /</span>';
             str +='<span>&#x3000;共&nbsp;</span>' +'<span class="zuida">'+d.max_page+'</span>'+'<span>&#x3000;页</span>';
        } else { 
            str += '<span class="disabled">下一页</span>';
            str +='<span class="tiaozhuan " onclick="tiao()"> 跳转到</span>'+'<input type="text" id="fenye">';
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
// 分页跳转
var pages
function tiao() {
    $('.tiaozhuan').click(function () {
        pages = $('#fenye').val();
        if (pages > maxpage || pages == 0) {
            layer.msg('请输入正确页数！', { icon: 5 });
            return false;
        } else {
            data={'page': pages};
            get_list(data);
        }
    })
}
