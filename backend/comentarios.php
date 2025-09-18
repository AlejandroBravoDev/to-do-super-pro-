<?php
session_start();
//Ruta de el archivo
$archivo = "../backend/comentarios.json";

//Crea el archivo json si este no existe
if (!file_exists($archivo)) {
    file_put_contents($archivo, json_encode([]));
}

$comentarios = json_decode(file_get_contents($archivo), true);

//Guardar el nuevo comentario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comentario"]) && isset($_POST["tarea_id"])) {
    $tarea_id = $_POST["tarea_id"];
    $comentario = trim($_POST["comentario"]);

    if ($comentario !== "") {
        $comentarios[] = [
            "tarea_id" => $tarea_id,
            "comentario" => $comentario,
            "usuario" => $_SESSION["nombre"] ?? "Usuario"
        ];

        file_put_contents($archivo, json_encode($comentarios, JSON_PRETTY_PRINT));
    }

    header("Location: ../frontend/interfaz.php");
    exit;
}
