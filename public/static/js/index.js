$(function(){
    // 登录账号
    $(".login").click(function(){
        $.ajax({
            url:"/user/index/login",
            type:"post",
            data:{
                username:$("#firstname").val(),
                password:$("#lastname").val()
            },
            success:function(data){
                if(data.errorCode==0){
                    window.location.href="/member/sys_work/index"
                }else{
                    alert(data.errorMsg)
                }
            }
        })
        
    })
})
