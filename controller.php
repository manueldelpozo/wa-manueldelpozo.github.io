<?php
// Incluimos el modelo
require_once('model.php');

// Recuperamos los registros
// llamamos a la funcion del modelo y almacenamos los valores que devuelve en una variable
$items = getTemplate(); 
//var_dump($items);

// Incluimos la vista
// la vista tendra que usar la variable $items
//require('index.php');
?>