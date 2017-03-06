$(function(){
    $(".send li").click(function(){
        $(this).addClass("active").siblings().removeClass("active")
    });

    // 左侧侧边栏切换
    $(".header_left ul li").click(function(){
        $(this).addClass("active").siblings().removeClass("active")
        $("#toggle").empty();
        var index = $(this).index();
        if(index==0){
            var html = "<iframe src='/permission/sys_group/show_group_list' frameborder='0' id='iframe'</iframe>"
            $("#toggle").html(html)
        }
    });

});