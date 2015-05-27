
  //visibility
  $.fn.invisible = function() {
    return this.each(function() {
      $(this).css("visibility", "hidden");
    });
  };
  $.fn.visible = function() {
    return this.each(function() {
      $(this).css("visibility", "visible");
    });
  };

  //compresion
  function descomp() {
      $(".margins").removeClass("col-md-4 col-sm-3 col-xs-2",200).addClass("col-md-2 col-sm-1",200);
      $(".center-box").removeClass("col-md-4 col-sm-6 col-xs-8",200).addClass("col-md-8 col-sm-10 col-xs-12",200).delay( 1000 ).height("80%");
      $(".content-start").invisible().delay( 1000 ).hide();
      $(".contents").show().delay( 1000 ).visible();  
  }
  function comp() {
    $(".margins").removeClass("col-md-2 col-sm-1",200).addClass("col-md-4 col-sm-3 col-xs-2",200);
    $(".center-box").removeClass("col-md-8 col-sm-10 col-xs-12",200).addClass("col-md-4 col-sm-6 col-xs-8",200).delay( 1000 ).height("10%");
    $(".contents").hide().delay( 1000 ).invisible();
  }
  function seeVideo() {
    $('video').get(0).play();
    $('#see-video').show().text("HIDE VIDEO").next().show();
    $('#pfinal').css('overflow','hidden');
  }

  //********************//

  
  
  
  
  // Ver el video
  $("#see-video").click( function verVideo() {
    	if( !$('#video').is(':visible') ) {
        $('#video').slideDown("slow");
        seeVideo();
      } else {
        $('#video').slideUp("slow");
        $('video').get(0).pause();
        $(this).text('SEE VIDEO').next().hide();
        $('#pfinal').css('overflow','auto');
      } 
  });

  

  // navegacion
  $(".bracket").bind({
    mouseenter: function() {
      $(this).find(".word").css({"font-size":"18px","color":"#099"});
    },
    mouseleave: function() {
      $(this).find(".word").css({"font-size":"14px","color":"#000"});
    },
    click:  function() {
      //ocultar video
      $('#video').fadeOut("slow");
      $('video').stop();
      $('#see-video').hide(); 
      $('#big-screen').hide();

      var section = $(this).find(".word").text();
      $("#section").html(section);
      $("#pinitial").empty();
      $("#pfinal").empty();
      $(this).siblings().find('input').remove();
      comp();
      if ( $(".center-box").height('10%') )
        $( "#target" ).submit();
      descomp();
    }
  });

  //cuando acaba el video...

  // Direct links
  $("#back2").click(function(){
    $("#target").find('input').val(0);  
    $("#target").submit();
    return true;
  });
  $("#footer").click(function(){
    $("#target").find('input').val(1);  
    $("#target").submit();
    return true;
  });
  $("#link-per").click(function(){
    $("#target").find('input').val(4);  
    $("#target").submit();
    return true;
  });
  $("#link-edu").click(function(){
    $("#target").find('input').val(5);  
    $("#target").submit();
    return true;
  });
  $("#link-tech").click(function(){
    $("#target").find('input').val(6);  
    $("#target").submit();
    return true;
  });
  $("#link-map").click(function(){
    $("#target").find('input').val(7);  
    $("#target").submit();
    return true;
  });
  $("#link-web").click(function(){
    $("#target").find('input').val(8);  
    $("#target").submit();
    return true;
  });
  $("#link-arch").click(function(){
    $("#target").find('input').val(9);  
    $("#target").submit();
    return true;
  });
  
  
