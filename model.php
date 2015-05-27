<?php

function getTemplate() {
  $templates_array = json_decode( file_get_contents( "templates.json" ), true );

  if ( isset($_POST["id_template"]) )
    $id_template = $_POST["id_template"];
  else
    $id_template = 0;

  echo $id_template; 
  // Buscamos el array template con la id correcta
  $template_selected = array();

  $temps = $templates_array['templates']; 
  foreach ( $temps as $temp ) {
    foreach ( $temp as $key => $val ) {   
      if( $key == 'id' && $val == $id_template )
        $template_selected = $temps['temp'.$id_template];
    }
  }
    
  return $template_selected;   

}
var_dump(getTemplate());

//require('index.php');
?>
