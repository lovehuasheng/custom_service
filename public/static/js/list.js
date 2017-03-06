$(function(){
    $('#tijiao').click(function(){
        $('#myModal').modal('hide')
    })
     $('#match-button').click(function(){
        $('#hyModal').modal('hide')
    })
     $('#match-button1').click(function(){
        $('#fhModal').modal('hide')
    })
    $('.shi').click(function(){
        $(this).find('img').toggle()
    })
     $('.m-shi1').click(function(){
        $(this).find('img').toggle()
    })
	   // 日历插件
	 $(".datetimepicker3").on("click",function(e){
        e.stopPropagation();
        $(this).lqdatetimepicker({
            css : 'datetime-day',
            dateType : 'D',
            selectback : function(){
            }
        });
    });
    // 封号   提供人 接收人
  $('.t-tgr').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.t-jsr').find('.icon-1').hide()
      $('.t-jsr').find('.icon-2').show()
  })
    $('.t-jsr').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.t-tgr').find('.icon-1').hide()
      $('.t-tgr').find('.icon-2').show()
  })

    $('.t-skf').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.t-skf1').find('.icon-1').hide()
      $('.t-skf1').find('.icon-2').show()
  })
    $('.t-skf1').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.t-skf').find('.icon-1').hide()
      $('.t-skf').find('.icon-2').show()
  })
  $('.chexiao').click(function(){
      $(this).find('img').toggle()
  })

    // 付款收款
      $('.fukuan').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.fukuan1').find('.icon-1').hide()
      $('.fukuan1').find('.icon-2').show()
  })
    $('.fukuan1').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.fukuan').find('.icon-1').hide()
      $('.fukuan').find('.icon-2').show()
  })
      $('.shoukuan').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.shoukuan1').find('.icon-1').hide()
      $('.shoukuan1').find('.icon-2').show()
  })
    $('.shoukuan1').click(function(){
      $(this).find('.icon-1').show()
      $(this).find('.icon-2').hide()
      $('.shoukuan').find('.icon-1').hide()
      $('.shoukuan').find('.icon-2').show()
  })
	//查询
})