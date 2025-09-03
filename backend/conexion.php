<?php
    $host = "localhost";
    $usuario = "root"; 
    $contrasena = "12345";  
    $bd = "todopro";

    $conexion = new mysqli($host, $usuario, $contrasena, $bd);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
?>
