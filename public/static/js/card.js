$(function(){
	(function($){
		$.fn.extend({
			pview:function(options){
				var defaults = {
					url: '',
					cache: true
				};
				var options = $.extend(defaults, options);
				this.each(function(){
					var o={w:$(this).width(),h:$(this).height(),preview:$(this).attr('preview')};
					var child=$($("#jstemp").html().replace(/\{([^\}]+)\}/gm,function(a,b){return o[b];}));
					$(this).after(child);
					child.css("top",$(this).offset().top+ "px");
					child.css("left",$(this).offset().left+ "px");	
					$(this).data('child',child);
					child.data('obj',$(this)).data('box',child.find("[f='box']"));
					$(this).hover(function(){
						var child=$(this).data('child');
						child.show();
					},function(){});
					child.hover(function(){
						
					},function(){
						$(this).hide();
						var obj=$(this).data("obj");
						obj.show();
					});
					child.mousemove(function(e){
						var tp1=$(this).data("obj");
						var box=$(this).data("box");
						var h=e.pageY -tp1.offset().top;
						var w=e.pageX-tp1.offset().left;
						var pw= box.width() * w/tp1.width() - w;
						var ph= box.height() * h/tp1.height() - h;
						box.css("left","-" + pw+ "px");
						box.css("top","-" + ph+ "px");
					});
				});
			}	
		});
	})(jQuery); 
});
$(document).ready(function(){
	$("#tp1").pview();
	$("#tp2").pview();
	$("#tp3").pview();
});

