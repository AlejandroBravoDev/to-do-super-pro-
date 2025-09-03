<?php
    $conexion = new mysqli("localhost","root","12345","todopro");
    if($conexion->connect_error){
        die("Error en la conexion: " . $conexion->connect_error);
    }else{
        echo "Conexión exitosa a la base de datos";
    }
?>