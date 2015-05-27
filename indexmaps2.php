<?php   
if ( isset($_POST["id_template"]) )
  $id_template = $_POST["id_template"];
else
  $id_template = 0;
$templates_array = json_decode( file_get_contents( "templates.json" ), true );

// Buscamos el array template con la id correcta
$template_selected = array();

$temps = $templates_array['templates']; 
foreach ( $temps as $temp ) {
  foreach ( $temp as $key => $val ) {   
    if( $key == 'id' && $val == $id_template )
      $template_selected = $temps['temp'.$id_template];
  }
}  
$items = $template_selected;
$url =  $items['title'];
$pinitial_text = $items['content']['pinitial']['text']; 
$brackets = $items['content']['brackets'];
$pfinal_text = $items['content']['pfinal']['text'];
$pfinal_list = $items['content']['pfinal']['list'];

?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>w+a</title>
	<meta name="description" content="a fast and fully-featured autocomplete library">
	<link rel="shortcut icon" type="image/x-icon" href="icons/favicon.ico">
	<link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" media="screen,projection" href="cssmap-europe/cssmap-europe.css" />
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript" src="js/jquery.cssmap.js"></script>
	<script type="text/javascript">

	$(document).ready(function(){
  
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

  //animacion inicial
  $(".content-start").animate( {"font-size":"35px"},100 ).animate( {"font-size":"25px"},100 );

  <?php if ( $id_template != 0 ) { ?>
      descomp();
  <?php } else { ?>
  
  $(".content-start").bind({
    mouseenter: function() {
      if( $(this).is(":visible") ) {
        $(this).css("font-size", "35px");
      }
    },
    mouseleave: function() {
      if( $(this).is(":visible") ) {
        $(this).css("font-size", "25px");
      }
    },
    click: function() {
      descomp();
      //ver video automaticamente
      $('#video').fadeIn("slow");
      $('video').get(0).play();
      $('#see-video').show().text("HIDE VIDEO").next().show();
    }
  });

  <?php } ?>
  
  // Ver el video
  $("#see-video").click( function verVideo() {
    	if( !$('#video').is(':visible') ) {
        $('#video').slideDown("slow");
        $('video').get(0).play();
        $(this).text('HIDE VIDEO').next().show();
      } else {
        $('#video').slideUp("slow");
        $('video').get(0).pause();
        $(this).text('SEE VIDEO').next().hide();
      } 
  });

  // Aumentar la pantalla del video
  $('#big-screen').click( function() {
    if( $('#pfinal').height('50%') ) { 
      $('#pinitial').slideUp();
      $('#brackets').slideUp();
      $('#pfinal').height('100%');
      $(this).find('span').removeClass('glyphicon glyphicon-resize-full').addClass('glyphicon glyphicon-resize-small');
    } else {
      $('#pinitial').slideDown();
      $('#brackets').slideDown;
      $('#pfinal').height('50%');
      $(this).find('span').removeClass('glyphicon glyphicon-resize-small').addClass('glyphicon glyphicon-resize-full');
    }
  });

  // lista
  <?php if ( !$brackets ) { ?>
    $("#brackets").hide();
    $('#pfinal').height('80%');
    $('#pinitial').height('20%');
    $(".margins").hide();
    $(".center-box").removeClass("col-md-8 col-sm-10 col-xs-12",200).addClass("col-md-12 col-sm-12 col-xs-12",200).delay( 1000 ).height("90%");
  <?php } ?>

  // navegacion
  $(".bracket").bind({
    mouseenter: function() {
      $(this).find(".word").css({"font-size":"20px","color":"#099"});
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

  //Europe map
  $('#map-europe').cssMap({
    size : 960,
    tooltips : "floating",
    onHover : function(e){},          // Callback: function(listItem) - invoked when the mouse pointer enters a region and passing a current list item element;
    unHover : function(e){},          // Callback: function(listItem) - invoked when the mouse pointer leaves a region and passing a current list item element;
    onClick : function(e){},          // Callback: function(listItem) - invoked when region is clicked and passing a current list item element;   
  });



});

	</script>
	<style type="text/css">

	html, body{height:100%; margin:0;padding:0}
@import url(http://fonts.googleapis.com/css?family=Aldrich);

.trans {
	-webkit-transition: all 0.4s ease-out;
    -moz-transition: all 0.4s ease-out;
    -o-transition: all 0.4s ease-out;
    transition: all 0.4s ease-out;
}
.vcenter {
  -webkit-box-align : center;
  -webkit-align-items : center;
  -moz-box-align : center;
  -ms-flex-align : center;
  align-items : center;
  display: flex;
  display: -webkit-flex; /* Safari */
}
.vcenter div{
   -webkit-flex: 1; /* Safari 6.1+ */
   flex: 1; 
        margin: 0 auto;
}
.contents {
  display: none;
  visibility: hidden;
  height: 100%;
	padding:0;
  position: relative;   
}
   
.content-start {
  height: 100%;
	padding:0;
    font-size: 25px;
    letter-spacing: 20px;
    
}
.word {
	font-size: 14px;
}
#title {
	height: 5%;
	margin: 0;
  position: absolute;
  top: 0px;
  vertical-align: text-top;
  font-size: 24px;
}
#body {	
  height: 90%;

 position: absolute;
  top: 5%;
  vertical-align: middle;

}
#pinitial {
  height: 30%;
    padding: 0;
    font-size: 14px;
}

#brackets {
  height: 20%;
    padding: 0;
  
}
#pfinal {
  height: 50%;
  padding: 0;
  overflow: auto;
  
}
#see-video {
  display: none;
}
#video {
    display: none;
    height: 80%;
    padding: 0;
}
video {
  position: absolute;
  left:0;
    right:0;
    margin-left:auto;
    margin-right:auto;
}
#footer {
	height: 5%;

  position: absolute;
  bottom: 0;
  margin: 0;
  vertical-align: text-bottom;
 
}
.squarebrackets {
  font-family: 'Aldrich', sans-serif;
  font-size:20px;
 vertical-align: 50%;
 
}
.c1 {
  height: 100%;
  padding:0;
   border-left:10px solid #000;
   border-top:10px solid #666;
   border-bottom:10px solid #666;
}
.c2 {
  height: 100%;
  padding:0;
  border-right:10px solid #000;
  border-top:10px solid #666;
  border-bottom:10px solid #666; 
}
.green-a {
    color: #099;
}
.green-b {
    border-color: #699 #099;
}
.container-fluid{
  height:100%;
  display:table;
  width: 100%;
  padding: 0;
}
 
.row-fluid {
    height: 100%; 
    display:table-cell; 
    vertical-align: middle;
    padding: 0;
  }
 
.center-box {
  height: 25%;

  float:none;
  margin:0 auto;
  padding: 0;
}
.margins {
  padding: 0;
}
form {
  height: 100%;
}
.bracket {
  height: 70%;
}
.list{
  height: 100%;
}
 .item {
  height: 22%;
  margin-bottom: 15px;
 }
 .icon {
  height: 100%
 } 
#map-europe {
  position: absolute;
  bottom: -30px;
}
.css-map > li a,.css-map > li a:hover,#map-tooltip,.cssmap-tooltip-content{
  background-color: #099;
  color: #eee;
  padding: .5em 1.2em;
  text-align: center;
  text-shadow: 0 1px 0 #000;
  white-space: nowrap;
  -moz-border-radius: .6em;
  -ms-border-radius: .6em;
  -webkit-border-radius: .6em;
  border-radius: .6em;
 }
 #map-europe .map-visible-list a{
  background-color: red;

 }
#map-europe .map-visible-list a:hover,
#map-europe .map-visible-list a:focus,
#map-europe .map-visible-list li.focus a{
  /* selected link (region) */

 }
#map-europe .map-visible-list a:active,
#map-europe .map-visible-list li.active-region a{
  /* active link (region) */

 }


	</style>
</head>
<body>
			
	<div class="container-fluid">
	<div class="row-fluid">
      	<div class="col-md-4 col-sm-3 col-xs-2 margins trans"></div>
      	<div class="col-md-4 col-sm-6 col-xs-8 center-box trans">
           
          	<div class="col-md-1 col-xs-1 c1"></div>
          	<div class="col-md-10 col-xs-10 content-start trans text-center vcenter">
              <div>w + <span class="green-a">a</span></div>
          	</div>
          
          	<div class="col-md-10 col-xs-10 contents trans">
           
              <div class="col-md-12 col-xs-12 text-center lead green-a" id="title"><samp>://w+a/<span><?php echo $url; ?></span>/</samp></div>
              
                <div class="col-md-12 col-xs-12 squarebrackets text-center" id="body">
                  
                    <div class="col-md-12 col-xs-12 vcenter" id="pinitial"> 
                      <div><?php echo $pinitial_text; ?></div> 
                    </div>
                  
                    <div class="col-md-12 col-xs-12 trans" id="brackets">
                      <form id='target' action='indexmaps2.php' method="post">

                        <?php 
                        if( $brackets ) {
                          foreach ( $brackets as $bracket ) { ?>
                        <div class="col-md-4 col-xs-4 bracket trans">
                          <div class="col-md-2 col-xs-2 c1 green-b"></div>
                          <div class="col-md-8 col-xs-8 contents vcenter">
                            <span class='<?php echo $bracket["icon"]; ?>' aria-hidden="true"></span>
                            <div class="word trans text-center"><?php echo $bracket['word']; ?></div>
                            <input type="hidden" name="id_template" value="<?php echo $bracket['id_temp']; ?>">
                          </div>  
                          <div class="col-md-2 col-xs-2 c2 green-b"></div>
                        </div> 
                        <?php 
                          } 
                        }
                        ?>

                      </form>
                    </div>
                  
                    <div class="col-md-12 col-xs-12 trans" id="pfinal">
                         
                        <div class="col-md-12 col-xs-12 embed-responsive-16by9" id="video">
                            <video class="embed-responsive-item" height='100%' width="auto">
                              <source src="video/videowebCV.webm" type="video/webm">
                              <source src="video/videowebCV.mp4" type="video/mp4">
                              <source src="video/videowebCV.ogv" type="video/ogg">
                              Your browser does not support the video tag.
                            </video>
                        </div>

                      	<div class="col-md-12 col-xs-12 list">
                            <a class="btn btn-default" role="button" align="center" href="#video" id="see-video">SEE VIDEO</a>
                            <a class="btn btn-default" role="button" align="center" href="#" id="big-screen" style='display:none'><span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span></a>
                            <?php 
                              if( $pfinal_text ) {
                                if( $pfinal_text == 'map' ) {
                                  echo ' <div id="map-europe">
                                            <ul class="europe">
                                              <li class="eu13"><a href="#france">France</a></li>
                                              <li class="eu16"><a href="#germany">Germany</a></li>
                                              <li class="eu20"><a href="#ireland">Ireland</a></li>
                                              <li class="eu35"><a href="#poland">Poland</a></li>
                                              <li class="eu42">
                                              <a href="#spain">
                                              <img src="icons/per-team.png" width="80%" height="auto" style="margin:0 auto" />
                                              Murcia
                                              </a>
                                              </li>
                                              <li class="eu47"><a href="#united-kingdom">United Kingdom</a></li>
                                            </ul>
                                          </div>';
                                }
                                else
                                  echo "<div>".$pfinal_text."</div>";
                              } else if( $pfinal_list ) {
                                foreach ( $pfinal_list as $list ) {
                                  echo "<div class='row item'>";
                                    echo "<div class='col-md-3 icon'>";
                                      echo "<div class='col-md-2 col-xs-2 c1 green-b'></div>";
                                      echo "<div class='col-md-8 col-xs-8 vcenter' style='height:100%'>";
                                      if( is_array($list['link']) )
                                        echo "<img src='".$list['icon']."' width='80%' height='auto' style='margin:0 auto' />";
                                      else {
                                        echo "<a href='".$list['link']."' class='vcenter' style='height:100%'>";
                                          echo "<img src='".$list['icon']."' width='80%' height='auto' style='margin:0 auto' />";
                                        echo "</a>";
                                      }
                                      echo "</div>";
                                      echo "<div class='col-md-2 col-xs-2 c2 green-b'></div>";
                                    echo "</div>";
                                    echo "<div class='col-md-9'>";
                                      echo "<div class='green-a' style='font-size:16px'>".$list['title']."</div>";
                                      if( is_array($list['text']) && is_array($list['link']) ) {
                                        foreach ($list['text'] as $key => $value) {
                                          echo "<a href='".$list['link'][$key]."' style='font-size:15px'>".$value."</a><br>";
                                        }
                                      } else {
                                        echo "<div style='font-size:12px; margin-bottom:0;'>".$list['text']."</div>";
                                        echo "<a href='".$list['link']."' style='font-size:12px'>".$list['link']."</a>";
                                      }
                                    echo "</div>";
                                  echo "</div>";
                                }
                              }
                            ?>
                        </div>
                        
                       
                          
                    </div>
                    
                 </div>
                  
                 <div class="col-md-12 col-xs-12 text-center lead" id="footer">
                      <strong>Manuel del Pozo</strong> || web-developer + architect
                 </div>
                
             </div>
                
             <div class="col-md-1 col-xs-1 c2"></div>
               
      	</div>
      	<div class="col-md-4 col-sm-3 col-xs-2 margins trans"></div>
  	</div>
</div>

</body>
</html>                                		