<?php
    $conexion = new mysqli("localhost","root","","todopro");
    if($conexion->connect_error){
        die("Error en la conexion: " . $conexion->connect_error);
    }
?>