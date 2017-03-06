//全选
var quanl
var quan = new Array();
var jian = new Array();
var pipei;
var mmoney = 0;
var dddete =new Array();
$('#check').click(function () {
    if (this.checked) {
        $('.check').prop('checked', true);
        var i = 0;
        //var j=0;
        $(".ids1").map(function () {
            v = $(this).text();
            quan[i] = v;
            i++;
        });
        j = 0;
        $(".s-time").map(function () {
            c = $(this).text();
            jian[j] = c;
            j++;
        });
        mmoney = 0;
        $(".other_money").map(function () {
            mmoney += parseInt($(this).text());
        });
        $(".creates").map(function () {
            var k = $(this).attr("y_pp");
            dddete.push(k)
        });
    } else {
        $(this).text("");
        $('.check').prop('checked', false); 
         quan = new Array();
         jian = new Array();
         dddete=new Array()
         mmoney = 0;
         pipei = 0;
    }
     
    $('#pl-jiedan').click(function () {
        $('.shu-l').text(quan.length)
        $('.j-money').text(mmoney)
    })
});

/**
 * 搜索查询
 * @param {type} param
 */
$(".search_submint").click(function () {
    var search_type = $.trim($("select[name='search_type']").val());
    var search_name = $.trim($(".search_name").val());
    if (search_type == '') {
        layer.msg('请求选择类型！', { icon: 5 });
        return false;
    }
    if($("#ages").val()!=""&&$("#jidus").val()==""||$("#ages").val()==""&&$("#jidus").val()!=""){
        layer.msg("年份及季度需全部选择或全部不选或")
    }
     else{
        var num = /^[0-9]*$/;
        if(num.test(search_name)){
            // $('#check').attr('checked',false)
            // quan=""
            // st='';
            quan = new Array();
            st='';
            data = { "search_type": search_type, "search_name": search_name,"year":$("#ages").val(),"quarter":$("#jidus").val() };
            //调用数据
            $('#check').attr('checked',false)
           
            get_list(data);  
        }else{
          layer.msg("请输入纯数字ID")  
        }     
    }
    // else if (search_name == '' || search_name == undefined || search_name == null) {
    //     layer.msg('请求输入搜索ID！', { icon: 5 });
    //     return false;
    // }
    //组装参数
   if($("#jidus").val()==""&&$("#ages").val()==""&&search_name == '' ){
        $('.tishi').show()
   }else{
       $('.tishi').hide()
   }
   
});
/**
 * 分页页码
 * @param {type} d
 * @returns {String}
 */
var maxpage
var currentpage
function get_list_page(d) {
    var str = '';
    maxpage =d.max_page
    currentpage =d.current_page
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
            str +='<span class="tiaozhuan "> 跳转到</span>'+'<input type="text" id="fenye">';
        }
       
    }
    
    return str;
}

// /**
//  * 调用分页
//  * @param {type} p
//  * @returns {undefined}
//  */
// var p
// function set_page(p) {
    
//     var search_type = $.trim($("select[name='search_type']").val());
//     var search_name = $.trim($(".search_name").val());
//     data = { 'page': p,community_id:nub,"data_time": time };
//     get_list(data);
// }
