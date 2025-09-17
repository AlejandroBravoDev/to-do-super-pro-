<?php
session_start();

$archivo = "../backend/comentarios.json";

// Si existe el archivo de comentarios
if (file_exists($archivo)) {
    $comentarios = json_decode(file_get_contents($archivo), true);

    if (isset($_POST["index"])) {
        $index = intval($_POST["index"]);

        if (isset($comentarios[$index])) {
            unset($comentarios[$index]); 
            $comentarios = array_values($comentarios); 
            file_put_contents($archivo, json_encode($comentarios, JSON_PRETTY_PRINT));
        }
    }
}


header("Location: ../frontend/interfaz.php");
exit;
