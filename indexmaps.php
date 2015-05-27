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
$pfinal_map = $items['content']['pfinal']['map'];

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
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

	<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
<script
src="http://maps.googleapis.com/maps/api/js">
</script>
  
	<script type="text/javascript">

	$(document).ready(function(){

  var map;
  var markers = [];

  function initialize() {
    var styles = [
      {
        stylers: [
          { hue: "#00ffe5" },
          { saturation: -20 }
        ]
      },{
        featureType: "road",
        elementType: "geometry",
        stylers: [
          { lightness: 100 },
          { visibility: "simplified" }
        ]
      },{
        featureType: "road",
        elementType: "labels",
        stylers: [
          { visibility: "off" }
        ]
      },{
        featureType: "administrative.country",
        elementType: "labels.text",
        stylers: [
          { visibility: "off" }
        ]
      },{
        featureType: "administrative.locality",
        elementType: "labels.text",
        stylers: [
          { visibility: "off" }
        ]
      },{
        featureType: "water",
        elementType: "labels.text",
        stylers: [
          { visibility: "off" }
        ]
      },
      {
        featureType: "landscape.natural.landcover",
        elementType: "geometry",
        stylers: [
          { visibility: "off" }
        ]
      },
      {
        featureType: "water",
        elementType: "geometry.fill",
        stylers: [
          { color: "#009999" },
          { visibility: "on" }
        ]
      }
    ];
    var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

    var mapProp = {
      center:new google.maps.LatLng(52,2),
      zoom:4,
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style'],
      mapTypeControl: false,
      panControl: false,
      zoomControl: false,
      scaleControl: false,
      streetViewControl: false
    };

    map = new google.maps.Map( document.getElementById("googleMap"),mapProp);

    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');

    //markers
    <?php 
    foreach ( $pfinal_map as $city ) {
    ?>
    addMarker( <?php echo $city['lat']; ?>,<?php echo $city['lng']; ?>, <?php echo '"'.$city['info'].'"'; ?>, <?php echo '"'.$city['icon'].'"'; ?>);
    <?php } ?>
  }

  function addMarker( lat, lng, contents, icon ) {
      var latLng = new google.maps.LatLng(lat,lng);
      var marker = new google.maps.Marker({
          position: latLng,
          map: map,
          icon: icon
      });
      var infowindow = new google.maps.InfoWindow({
        content: contents
      });
      google.maps.event.addListener(marker, 'mouseover', function() {
        infowindow.open(map,marker);
      });
      google.maps.event.addListener(marker, 'mouseout', function() {
        infowindow.close();
      });

      markers.push(marker);
  }

  google.maps.event.addDomListener(window, 'load', initialize);
  
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

  //animacion inicial
  $(".content-start").animate( {"font-size":"35px"},100 ).animate( {"font-size":"25px"},100 );

  <?php if ( $id_template != 0 ) { ?>
      descomp();
  <?php } else { ?>
  
  $(".content-start").bind({
    mouseenter: function() {
      if( $(this).is(":visible") ) {
        $(this).css("font-size", "32px");
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
      seeVideo();
    }
  });

  <?php } ?>
  
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

  // enlaces directos
  var back;
  $("#back1").click(function(){
    <?php if( $id_template>6 ) { ?>
      back = 3
    <?php } else { ?>
      back = 2;
    <?php } ?>
    $("#target").find('input').val(back);  
    $("#target").submit();
    return true;
  });
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
    letter-spacing: 17px;
    cursor:pointer;
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
  font-size: 18px;
}
#body {	
  height: 90%;
margin-top: 20px;
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
  font-size: 14px;
  position: absolute;
  bottom: -15px;
  margin: 0;
  vertical-align: text-bottom;
 
}
.squarebrackets {
  font-family: 'Aldrich', sans-serif;
  font-size:16px;
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
  cursor:pointer;
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

#map-canvas {
  width: 500px;
  height: 400px;
}
#back1, #back2 {
  cursor:pointer;
  color:black
}
strong {
  cursor:pointer;
}
#hire-me {
  margin-top: 15px;
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
           
              <div class="col-md-12 col-xs-12 text-center lead green-a" id="title"><samp>://<span id="back2">w+a</span>/<span id="back1"><?php echo $url; ?></span>/</samp></div>
              
                <div class="col-md-12 col-xs-12 squarebrackets text-center" id="body">
                  
                    <div class="col-md-12 hidden-xs vcenter" id="pinitial"> 
                      <div class="col-md-12 hidden-xs"><?php echo $pinitial_text; ?></div> 
                    </div>
                  
                    <div class="col-md-12 col-xs-12 trans" id="brackets">
                      <form id='target' action='indexmaps.php' method="post">

                        <?php 
                        if( $brackets ) {
                          foreach ( $brackets as $bracket ) { ?>
                        <div class="col-md-4 col-xs-4 bracket trans">
                          <div class="col-md-2 hidden-xs c1 green-b"></div>
                          <div class="col-md-8 col-xs-8 contents vcenter">
                            <span class='<?php echo $bracket["icon"]; ?>' aria-hidden="true"></span>
                            <div class="word trans text-center"><?php echo $bracket['word']; ?></div>
                            <input id="id_templ" type="hidden" name="id_template" value="<?php echo $bracket['id_temp']; ?>">
                          </div>  
                          <div class="col-md-2 hidden-xs c2 green-b"></div>
                        </div> 
                        <?php 
                          } 
                        }
                        ?>

                      </form>
                    </div>
                  
                    <div class="col-md-12 col-xs-12 trans" id="pfinal">
                         
                        <div class="col-md-12 col-xs-12 embed-responsive-16by9" id="video">
                            <video class="embed-responsive-item" height='100%' width="100%" controls>
                              <source src="video/videowebCV.webm" type="video/webm">
                              <source src="video/videowebCV.mp4" type="video/mp4">
                              <source src="video/videowebCV.ogv" type="video/ogg">
                              Your browser does not support the video tag.
                            </video>
                        </div>
                      	<div class="col-md-12 col-xs-12 list">
                            <a class="btn btn-default" role="button" align="center" href="#video" id="see-video">SEE VIDEO</a>
                            <?php 
                              if( $pfinal_text ) {
                                if( $pfinal_text == 'map' )
                                  echo '<div id="googleMap" style="width:100%;height:100%;margin:0 auto;"></div>';
                                else {
                                  echo "<div style='margin-top:15px;'>".$pfinal_text."</div>";
                                  echo '<a class="btn btn-default" role="button" align="center" href="mailto:mdp.webdeveloper@gmail.com?cc=mndelpozo@gmail.com&subject=I%20would%20like%20to%20hire%20you&body=Hello,%0D%0A%0D%0AI am really interested in your profile." target="_top" id="hire-me">HIRE ME</a>';
                                }
                              } else if( $pfinal_list ) {
                                foreach ( $pfinal_list as $list ) {
                                  echo "<div class='row item'>";
                                    echo "<div class='col-md-3 col-sm-4 hidden-xs icon'>";
                                      echo "<div class='col-md-2 col-sm-2 col-xs-2 c1 green-b'></div>";
                                      echo "<div class='col-md-8 col-sm-8 col-xs-8 vcenter' style='height:100%'>";
                                      if( is_array($list['link']) )
                                        echo "<img src='".$list['icon']."' width='80%' height='auto' style='margin:0 auto' />";
                                      else {
                                        echo "<a href='".$list['link']."' class='vcenter' style='height:100%'>";
                                          echo "<img src='".$list['icon']."' width='80%' height='auto' style='margin:0 auto' />";
                                        echo "</a>";
                                      }
                                      echo "</div>";
                                      echo "<div class='col-md-2 col-sm-2 col-xs-2 c2 green-b'></div>";
                                    echo "</div>";
                                    echo "<div class='col-md-9 col-sm-8 col-xs-12' style='margin-bottom:10px;'>";
                                      echo "<div class='green-a' style='font-size:16px;'>".$list['title']."</div>";
                                      if( is_array($list['text']) && is_array($list['link']) ) {
                                        foreach ($list['text'] as $key => $value) {
                                          echo "<a href='".$list['link'][$key]."' style='font-size:15px'>".$value."</a><br>";
                                        }
                                      } else {
                                        echo "<div style='font-size:12px; margin-bottom:0;'>".$list['text']."</div>";
                                        echo "<a href='".$list['link']."' style='font-size:12px; '>".$list['link']."</a>";
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
                      <strong>Manuel del Pozo</strong> || web-developer + architect = <a class='green-a' href='http://www.adaptivepath.com/ideas/what-makes-a-design-technologist/'>design technologist</a>
                 </div>
                
             </div>
                
             <div class="col-md-1 col-xs-1 c2"></div>
               
      	</div>
      	<div class="col-md-4 col-sm-3 col-xs-2 margins trans"></div>
  	</div>
</div>  

</body>
</html>                                		