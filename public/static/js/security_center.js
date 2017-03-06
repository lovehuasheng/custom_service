$(function(){
	$("#names,#password,#vfppassword").modal({backdrop:"static",show:false});
    var key_a = sessionStorage.getItem('username');
    var key_b = sessionStorage.getItem('loginname');
    $(".readonlys").html(key_a)
    $(".login_name").html(key_b)
    var mun = 2 ;
    $(".bod span").click(function() {
          $(this).css({'color':'#e99f1d','border-bottom':"2px solid #e99f1d"}).siblings().css({"color":"#333",'border-bottom':'none'})
          if($(this).hasClass('loginpassword')){
                $("#newpass").removeClass('new_pass')
                $("#confirmpass").removeClass('new_two_pass')
                mun = 2;
          }else{
                $("#newpass").addClass('new_pass')
                $("#confirmpass").addClass('new_two_pass')
                mun = 3;
          }
    });

    // 阻止浏览器默认加载密码
    $("#newpass").focus(function(){
       $(this).attr("type",'password')
    });
    $("#confirmpass").focus(function(){
       $(this).attr("type",'password')
    });
    var zhengze = /(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,18}$/;
    var flag = 0; 
    var flag2 = 0;
    $("#newpass").blur(function(){
       if(zhengze.test($("#newpass").val())){
            flag = 1;
       }else{
          layer.msg("请按提示填写密码")
       }
    });

    $("#confirmpass").blur(function(){
        if($("#newpass").val()!=$("#confirmpass").val()){
            layer.msg("确认密码与登录密码不一致，请重新输入")
        }else{
            flag2 = 1;
        }
    });
    //获取验证码
    $("#yanzhengma").click(function(){
        if(flag2&&flag){
           yzm(mun) 
       }else{
          layer.msg("请先输入正确密码及确认密码")
       }    
    });
    $(".btn_01").click(function(){
        if($("#newpass").val()==''||$("#confirmpass").val()==''||$("#codes").val()==''){
            layer.msg("请填写相关信息")
        }else if(flag&&flag2&&$("#codes").val()!=''){
            if($("#newpass").hasClass('new_pass')){
                var data = {"secondary_password":$(".new_pass").val(),"code":$("#codes").val()}
                btn(data,'/user/user/set_user_secondary_password')
            }else{
                var data = {"password":$("#newpass").val(),"code":$("#codes").val()}
                btn(data,'/user/user/set_user_password')
            }    
        }else{ 
            layer.msg("密码与确认密码不一致，请重新填写");
        }
    });
});

// 获取验证码
function yzm(mun){
$('#yanzhengma').attr("disabled","disabled");
    $.ajax({
        url:"/user/user/send_tel_sms",
        type:"post",
        data:{
            type:mun
        },
        success:function(data){   
            if(data.errorCode==0){
                layer.msg("请注意查收验证码")
                var i=60;
                var times = setInterval(function(){
                    if(i==1){
                        clearInterval(times)
                        $('#yanzhengma').html("获取验证码");
                        $('#yanzhengma').removeAttr("disabled");
                    }else{ 
                        i--
                        $('#yanzhengma').html(i+"秒后重发")
                    }   
                },1000)
            }else{
                layer.msg(data.errorMsg);
                $('#yanzhengma').removeAttr("disabled");
            }
        }
    }); //短信验证码请求结束   
};

function btn(data,url){    
    $.ajax({
        url:url,
        type:"post",
        data:data,
        success:function(data){
            if(data.errorCode==0){
                layer.msg('修改成功')
                $("#newpass").val('');
                $("#confirmpass").val('');
                $("#codes").val("");
            }else{
                layer.msg(data.errorMsg);
            }
        }
    });
};