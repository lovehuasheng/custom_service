/**
 * 错误操作返回提示
 * @returns {undefined}
 */
function get_error_to_operation(e) {

    switch (e.errorCode) {
        case -1998://被迫下线
            confirm_html(e.errorMsg);
            break;
        case -1999://被迫下线
            confirm_html(e.errorMsg);
            break;
        default:
            error_msg_html(e.errorMsg);
            break;
    }
}
function confirm_html(e) {
    layer.confirm(e, {
        btn: ['确认', '取消'] //按钮
    }, function () {
        location.href = '/user/index/index';
    }, function () {

    });
}
////
function error_msg_html(e) {
    layer.msg(e, {
        time: 20000, //20s后自动关闭
        btn: ['明白了', '知道了']
    });
}
 