$(function(){
    // 判断个数
    var m = 0;
    var num = /^[0-9]*$/;

    $(".remark").val("转出善种子")
    $("#bizhong").change(function(){
        if($("#bizhong").val()==1){
            if($("#leixing").val()==1){
                $(".remark").val("转出善种子")
            }else if($("#leixing").val()==2){
                $(".remark").val("回转善种子")
            }           
        }else if($("#bizhong").val()==2){
            if($("#leixing").val()==1){
                $(".remark").val("转出善心币")
            }else if($("#leixing").val()==2){
                $(".remark").val("回转善心币")
            }    
        }    
    });
    $("#leixing").change(function(){
        if($("#leixing").val()==1){
            if($("#bizhong").val()==1){
                $(".remark").val("转出善种子")
            }else if($("#bizhong").val()==2){
                $(".remark").val("转出善心币")
            }           
        }else if($("#leixing").val()==2){
            if($("#bizhong").val()==1){
                $(".remark").val("回转善种子")
            }else if($("#bizhong").val()==2){
                $(".remark").val("回转善心币")
            }    
        }    
    });

    $(".geshu").blur(function(){
        if(num.test($(".geshu").val())){
            if($("#bizhong").val()==1){
                if($(".geshu").val()>500){
                    layer.msg("善种子最多一次转出500个")
                }else{
                    m = 1 ;
                } 
            }else if($("#bizhong").val()==2){
                if($(".geshu").val()>3000){
                    layer.msg("善心币最多一次转出3000个")
                }else{
                    m = 1 ;
                } 
            }else if($("#bizhong").val()==''){
                layer.msg("请选择币种类型")
            }
        }else{
            layer.msg("请输入纯数字")
        }
    });

    $("#bizhong").change(function(){
        if($("#bizhong").val()==1){
            $(".shangxian").html("上限500个")
        }else if($("#bizhong").val()==2){
            $(".shangxian").html("上限3000个")
        }else{
            $(".shangxian").html("")
        }
    })
     // 减善心币善种子
    $(".glyphicon-minus").click(function(){
        if(m){
            var mun = $(".geshu").val();
            if($("#bizhong").val()==1){
                if(mun>0&&mun<501){
                    mun--;
                    $(".geshu").val(mun)
                }else{
                    layer.msg("不能大于500 不能小于0")
                }
            }else if($("#bizhong").val()==2){
                if(mun>0&&mun<3001){
                    mun--;
                    $(".geshu").val(mun)
                }else{
                    layer.msg("不能大于3000 不能小于0")
                }
            }
        }else{
          layer.msg("请输入正确个数") 
        }   
    });
    // 加善心币善种子
    $(".glyphicon-plus").click(function(){
        if(m){
               if($("#bizhong").val()==1){
                var mun = $(".geshu").val();
                if(mun<=499){
                    mun++
                    $(".geshu").val(mun)
                }else{
                    layer.msg("善种子最多一次转出500个")
                }
            }else if($("#bizhong").val()==2){
               var mun = $(".geshu").val();
                if(mun<=2999){
                    mun++
                    $(".geshu").val(mun)
                }else{
                    layer.msg("善心币最多一次转出3000个")
                    } 
                }
        }else{
            layer.msg("请输入正确个数")
        }
    });
    // 点击查看密码
    $(".eye").click(function(){
       if ($(".pass").attr("type") == "password") {
            $(".pass").attr("type", "text")
        }
        else {
            $(".pass").attr("type", "password")
        }
    });
    $(".user").blur(function(){
        if($(".user").val()==''){
            $(".p-name").hide();
        }else{
            $.ajax({
                url:"/member/user_info/get_real_name_by_username",
                type:"post",
                data:{
                    username:$(".user").val()
                },
                success:function(data){
                    if(data.errorCode==0){
                        $(".p-name").show();
                        $(".i-name").html(data.result.name); 
                    }else{
                        $(".p-name").show();
                        $(".i-name").html(data.errorMsg); 
                    }
                    
                }
            })
            
        }
    });
    // 确认完成转币 
    $("#anniu").click(function(){
         var num = /^[0-9]*$/;
        if($("#bizhong").val()==1){          
            if($(".user").val()==''||$(".geshu").val()==''||$(".pass").val()==''||$(".geshu").val()>500||$(".remark").val()==''){
                layer.msg('请补全信息或按提示填写')
                return false;
            }else if(num.test($(".geshu").val())){
                $(".monicker").html($(".user").val());
                if($("#leixing").val()==1){
                  $(".zhuanyi").html('转出'); 
                  $("#myModalLabel").html('转出善种子')
                }else if($("#leixing").val()==2){
                  $(".zhuanyi").html('回转'); 
                  $("#myModalLabel").html('回转善种子')
                }
                $(".numbera").html($(".geshu").val()+"个");
                if($("#bizhong").val()==1){
                     $(".q-ge").html('善种子吗？') 
                }else if($("#bizhong").val()==2){
                     $(".q-ge").html('善心币吗？') 
                } 
            }else{
                layer.msg('请输入纯数字')
                return false;
            }    
        }else if($("#bizhong").val()==2){
            if($(".user").val()==''||$(".geshu").val()==''||$(".pass").val()==''||$(".geshu").val()>3000||$(".remark").val()==''){
            layer.msg('请填写完整信息')
                return false;
            }else if(num.test($(".geshu").val())){
                $(".monicker").html($(".user").val());
                if($("#leixing").val()==1){
                  $(".zhuanyi").html('转出'); 
                  $("#myModalLabel").html('转出善心币') 
                }else if($("#leixing").val()==2){
                  $("#myModalLabel").html('回转善心币') 
                  $(".zhuanyi").html('回转'); 
                }
                $(".numbera").html($(".geshu").val()+"个");
                if($("#bizhong").val()==1){
                     $(".q-ge").html('善种子吗？') 
                }else if($("#bizhong").val()==2){
                     $(".q-ge").html('善心币吗？') 
                } 
            }else{
                layer.msg('请输入纯数字')
                return false;
            }  
        } 
    });  
    $("#queding").unbind("click").click(function(){
        zhuanbi();
    })
    //默认加载前6条记录及善种子 善心币个数
     ajaxs();
     nums();
});//结束标签

$('.success').click(function(){
    $('.success').hide()
    $('.tanchu').hide()
})
// $('.success').mouseover(function () {
//     setTimeout(function () {
//         $('.success').hide()
//         $('.tanchu').hide()
//     }, 1000)
// })
// $('.tanchu').mouseover(function () {
//     setTimeout(function () {
//         $('.success').hide()
//         $('.tanchu').hide()
//     }, 1000)
// })

// 默认加载前6条转币记录
function ajaxs(){
    layer.load();
    $.ajax({
        url:"/member/transfer_log/get_transfer_list",
        type:"post",
        success:function(data){
            layer.closeAll();
            $(".tabs tbody").empty();
            if(data.errorCode==0){
                $.each(data.result.transfer_list,function(i,o){
                    date(i,o);
                    if(i>5){
                        return false;
                    }else{
                      /* if(o.operation_type==1){
                            o.operation_type = '转出'
                        }else{
                            o.operation_type = '回转'
                        }*/
                      $(".tabs tbody").append($("#temp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
                    }
                })               
            }
        }
    });
}
// 时间转换
function date(i,o){
    var newDate = new Date(o.create_time*1000);
    var mon = (newDate.getMonth()+1);
    var day = newDate.getDate();
    var hour = newDate.getHours();
    var min = newDate.getMinutes();
    var sec = newDate.getSeconds();
    if(mon<10){
        mon = '0'+mon;
    }
    if(day<10){
        day = '0'+day;
    }
    if(hour<10){
        hour = '0'+hour;
    }
    if(min<10){
        min = '0'+min;
    }
    if(sec<10){
        sec = '0'+sec;
    }
    o.create_time = newDate.getFullYear()+"-"+mon+"-"+day+" "+hour+":"+min+":"+sec;
}

// 获取善种子善心币接口
function nums(){
    $.ajax({
        url:"/member/user_account/get_super_account",
        type:"post",
        success:function(data){
            if(data.errorCode==0){ 
                if(data.result==''){
                   $(".zhongzi").html(0+" ")
                   $(".xinbi").html(0+" ") 
                }else{
                   $(".zhongzi").html(data.result.activate_currency)
                   $(".xinbi").html(data.result.guadan_currency) 
                }                 
            }
        }
    })
}

//转币接口
function zhuanbi(){
    $.ajax({
        url:"/member/user_account/transfer_coin",
        type:"post",
        data:{
            coin_type:$("#bizhong").val(),
            operation_type:$("#leixing").val(),
            username:$(".user").val(),
            num:$(".geshu").val(),
            secondary_password:$(".pass").val(),
            remark:$(".remark").val()
        },
        success:function(data){
            if(data.errorCode==0){
                $("#myModal").modal("hide")
                $(".p-name").hide();
                $(".user").val("");
                $(".geshu").val("");
                $(".pass").val('');
                $(".pass").attr("type", "password")
                if($("#leixing").val()==1){
                    $(".zhuanbi").html('转出成功')
                }else if($("#leixing").val()==2){
                   $(".zhuanbi").html('转出成功') 
                }
                $('.success').show()
                $('.tanchu').show()
                setTimeout(function(){
                   $('.success').hide()
                   $('.tanchu').hide() 
                },1000)
                ajaxs();
                nums();
            }else{
                $(".pass").val('');
                layer.msg(data.errorMsg)
            }
        }
    })
}