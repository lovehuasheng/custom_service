$(function(){
    $(".send li").click(function(){
        $(this).addClass("active").siblings().removeClass("active")
    });

    // 左侧侧边栏切换
    var m = 1;
    $(".header_left ul li").click(function(){
        $(this).addClass("active").siblings().removeClass("active")
        $("#toggle").empty();
        var index = $(this).index();
        if(index==0){
            var html = "<iframe src='/user/user/show_user_list' frameborder='0' id='iframe'</iframe>"
            $("#toggle").html(html)
        }else if(index==1){
            var html = "<iframe src='/user/user/security_center' frameborder='0' id='iframe'</iframe>"
            $("#toggle").html(html)
        }
    });

});