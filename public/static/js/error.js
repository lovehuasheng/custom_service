
/**
 * 错误操作
 * @returns {undefined}
 */
function  get_error_to_operation(code,msg) {

    switch (code){
        case '-1998'://被迫下线
             window.parent.confirm_html(msg);
         break;     
        case '-1999'://被迫下线
              window.parent.confirm_html(msg);
         break;
         case '-10000'://被迫下线
              window.parent.error_msg_html(msg);
         break;
     default:
             error_msg_html(msg);
         break;
    }
}


function confirm_html(e) {
    layer.confirm(e, {
        btn: ['确认','取消'] //按钮
      }, function(){
        location.href = '/user/index/index';
      }, function(){

      });
}

function error_msg_html(e) {
    layer.msg(e, {
        time: 2000, //20s后自动关闭
        //btn: ['明白了', '知道了']
        //anim: 2
      });
}
