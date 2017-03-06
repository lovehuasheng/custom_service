(function($) {
    $.fn.extend({
        linkSelect: function(options) {
			//参数和默认值
            var defaults = {
                url: '',
                cache: true
            };
            var options = $.extend(defaults, options);
            //定义方法,公用变量,因为特殊性必须同步
            if($._link_select_get_data==undefined){
                    $._link_select_get_data={};
            }
            if($._link_select_get_data[options.url]==undefined){
                    $._link_select_get_data[options.url]={};
            }
            if(!$.isFunction($._link_select_get)){
                    $._link_select_get=function(options,id,cbObj){
                            if(options.cache){
                                    if($._link_select_get_data[options.url][id]!=undefined) {
                                            var o=$._link_select_get_data[options.url];
                                            //callback
                                            cbObj.func(o[id]);
                                            return;
                                    }
                            }
                            $._link_select_req(options,id,cbObj);
                            return;					
                    }
            };
            if(!$.isFunction($._link_select_set_select)){
                $._link_select_set_select=function(e){
                    var options=e.data("options");
                    var toObj=e.data("toObj");
                    e.nextAll().remove();
                    if(e.val()==0){						
                    }else{
                            var ob={};
                            ob.e=e;
                            ob.func=function(data){
                                    if(!$.isArray(data))data=JSON.parse(data);
                                    if(data.length==0) return;
                                    var e=this.e;
                                    e.after("<select></select>");
                                    e.next().data('lock',1).data('options',options).data('toObj',toObj);
                                    $.each(data,function(i,o){
                                            e.next().append("<option value='"+o.id+"'>"+o.label+"</option>");;
                                    });
                                    e.next().data('lock',0);
                                    //增添事件
                                    e.next().on('change',function(){								
                                            var e=$(this);
                                            $._link_select_set_select(e);
                                    });
                            }
                            $._link_select_get(options,e.val(),ob);
                    }
                }
            }
            if(!$.isFunction($._link_select_req)){
                    $._link_select_req=function(options,id,cbObj){
                            cbObj.options=options;
                            cbObj.id=id;
                            $.ajax({
                                    url:options.url,
                                    data:{id:id},
                                    cache:false,
                                    context:cbObj,
                                    success:function(data){
                                            if(this.options.cache){
                                                    $._link_select_get_data[options.url][this.id]=data;
                                            }
                                            cbObj.func(data);
                                    }
                            });
                    }
            };
            //遍历匹配元素的集合
            this.each(function() {
				var obj=$(this);
				obj.data('options',options).data('_linkSelectData_',{});
                obj.hide().after("<span><select t='0'></select></span>");
				var ob={};
				ob.e=obj.next().find("select");
				ob.e.data('lock',1).data("options",options).data("toObj",obj); //锁住，不让其响应变化
				ob.func=function(data){
					if(!$.isArray(data))data=JSON.parse(data);
					var e=this.e;
					$.each(data,function(i,o){
						e.append("<option value='"+o.id+"'>"+o.label+"</option>");
					});
					e.data('lock',0);
				}
				$._link_select_get(options,0,ob);
				//设定事件				
				obj.next().find("select:last").on('change',function(){
					var e=$(this);
					$._link_select_set_select(e);
				});
				obj.next().on("change","select",function(){
					var v=0;
					var toObj=$(this).data('toObj');
					toObj.val(0);
					$.each($(this).parent().find("select"),function(i,o){
						if($(o).val()!=0)toObj.val($(o).val());
					})
				});
				
            });
        }
    });
})(jQuery); 