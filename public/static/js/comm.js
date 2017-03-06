function __fliter(re){
	if(re.errCode==0){
		return true;
	}else if(re.errCode==4){
            alert(re.errMsg);
            return false;
        }else if(re.errCode==3){
            alert(re.errMsg);
            parent.location.href='/index/index';
            return false;
        }else{
		//进行错误处理
		alert("服务端返回错误");
		return false;
	}
}