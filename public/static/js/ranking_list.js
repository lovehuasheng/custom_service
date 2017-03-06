/**
 * Created by shanfubao on 2016/11/29.
 */
$(function(){
    get_list({"flag":1});
});
$(".daily_charts").click(function(){
    get_list({"flag":1});
});
$(".year_charts").click(function(){
    get_list({"flag":2});
});
function get_list(d) {
    $.ajax({
        type:'POST',
        dataType:'JSON',
        async:true,
        data:d,
        url:"/statistics/ranking/lists",
        success:function(e) {
           console.log(e);
            if(e.errorCode == '0') { 
                get_total_num_sort_html(e.result.total_num_sort,d.flag);
                
                get_success_num_sort_html(e.result.success_num_sort,d.flag);
                
                get_work_time_sort_html(e.result.work_time_sort,d.flag);
            }else {
                get_error_to_operation(e.errorCode,e.errorMsg);
            }
        },
        error:function(e) {
             get_error_to_operation('-10000','请求超时，请稍后再试！');
        }
    });
}


function get_total_num_sort_html(d,f) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    if(len > 0) {
        for(var i=0; i<len; i++) {
            str += '<tr>';
            var num = parseInt(i+1);
            switch(i) {
                case 0:
                     str += '<td class="champion"><img src="/static/images/TOP1.png" alt="" class="img-responsive"></td>';	
                     break;
                case 1:
                     str += '<td><img src="/static/images/TOP2.png" alt="" class="img-responsive"></td>';	
                     break; 
                 case 2:
                     str += '<td><img src="/static/images/TOP3.png" alt="" class="img-responsive"></td>';	
                     break;
                 default : 
                     str += '<td>'+num+'</td>';	
                     break;
            }
	   			
            str += '<td>'+d[i].sys_uname+'</td>'; 
            if(f == 1) {
                var  t_sort = d[i].total_day_rank;
            }else {
                var  t_sort = d[i].total_month_rank;
            }
            
            //工作量
            if(num > t_sort) {
               str += '<td class="top1"><img src="/static/images/top.png" alt="" class="img-responsive"><span>'+parseInt(num - t_sort)+'</span></td>';
            }else if(num == t_sort){
               str += '<td class="top1"><img src="/static/images/null.png" alt="" class="img-responsive"></td>';
            }else {
               str += '<td class="top1"><img src="/static/images/bottom.png" alt="" class="img-responsive"><span>'+parseInt(t_sort - num)+'</span></td>';
            }
            str += '<td><span>'+d[i].total_num+'</span>人</td>';         			
	    str += '</tr>';
            
        }
    }else {
        str += '<tr>';
        str += '<td colspan="4">加油，啥都会有滴</td>';  
        str += '</tr>';
    }
    
    $(".total_num_sort").html(str);
}

//通过率
function get_success_num_sort_html(d,f) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    if(len > 0) {
        for(var i=0; i<len; i++) {
            str += '<tr>';
            var num = parseInt(i+1);
            switch(i) {
                case 0:
                     str += '<td class="champion"><img src="/static/images/TOP1.png" alt="" class="img-responsive"></td>';	
                     break;
                case 1:
                     str += '<td><img src="/static/images/TOP2.png" alt="" class="img-responsive"></td>';	
                     break; 
                 case 2:
                     str += '<td><img src="/static/images/TOP3.png" alt="" class="img-responsive"></td>';	
                     break;
                 default : 
                     str += '<td>'+num+'</td>';	
                     break;
            }
	   			
            str += '<td>'+d[i].sys_uname+'</td>'; 
            if(f == 1) {
                var  t_sort = d[i].success_day_rank;
            }else {
                var  t_sort = d[i].success_month_rank;
            }
         
            //通过率
            if(num > t_sort) {
               str += '<td class="top1"><img src="/static/images/top.png" alt="" class="img-responsive"><span>'+parseInt(num - t_sort)+'</span></td>';
            }else if(num == t_sort){
               str += '<td class="top1"><img src="/static/images/null.png" alt="" class="img-responsive"></td>';
            }else {
               str += '<td class="top1"><img src="/static/images/bottom.png" alt="" class="img-responsive"><span>'+parseInt(t_sort - num)+'</span></td>';
            }
            str += '<td><span>'+d[i].success_num+'</span>人</td>';         			
	    str += '</tr>';
            
        }
    }else {
        str += '<tr>';
        str += '<td colspan="4">加油，啥都会有滴</td>';  
        str += '</tr>';
    }
    
    $(".success_num_sort").html(str);
}


//工作时间
function get_work_time_sort_html(d,f) {
    var str = '';
    var len = 0;
    if(d != null && d != undefined && d != '') {
        len = d.length;
    }
    if(len > 0) {
        for(var i=0; i<len; i++) {
            str += '<tr>';
            var num = parseInt(i+1);
            switch(i) {
                case 0:
                     str += '<td class="champion"><img src="/static/images/TOP1.png" alt="" class="img-responsive"></td>';	
                     break;
                case 1:
                     str += '<td><img src="/static/images/TOP2.png" alt="" class="img-responsive"></td>';	
                     break; 
                 case 2:
                     str += '<td><img src="/static/images/TOP3.png" alt="" class="img-responsive"></td>';	
                     break;
                 default : 
                     str += '<td>'+num+'</td>';	
                     break;
            }
	   			
            str += '<td>'+d[i].sys_uname+'</td>'; 
           var t = d[i].work_time;
           if(f == 1) {
                var  t_sort = d[i].work_time_day_rank;
            }else {
                var  t_sort = d[i].work_time_month_rank;
            }
            //通过率
            if(num > t_sort) {
               str += '<td class="top1"><img src="/static/images/top.png" alt="" class="img-responsive"><span>'+parseInt(num - t_sort)+'</span></td>';
            }else if(num == t_sort){
               str += '<td class="top1"><img src="/static/images/null.png" alt="" class="img-responsive"></td>';
            }else {
               str += '<td class="top1"><img src="/static/images/bottom.png" alt="" class="img-responsive"><span>'+parseInt(t_sort - num)+'</span></td>';
            }
        
             var h = parseInt(t / 3600);
             var s = parseInt((t / 60) % 60);
             if(s < 10) {
                 s = '0'+s;
             }
             var m = parseInt(t % 60);
             if(m<10) {
                 m = '0'+m;
             }
            str += '<td><span>'+h+'小时'+s+'分'+m+'秒</span></td>';         			
	    str += '</tr>';
            
        }
    }else {
        str += '<tr>';
        str += '<td colspan="4">加油，啥都会有滴</td>';  
        str += '</tr>';
    }
    
    $(".work_time_sort").html(str);
}