<?php
require_once "../backend/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION["id"];
    $id_tarea = $_POST["id_tarea"];

    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === 0) {
        $archivo = $_FILES["archivo"];
        $titulo = $archivo["name"];
        $tipo = $archivo["type"];
        $peso = $archivo["size"];

        // Carpeta donde se guardarán los archivos
        $carpetaDestino = "../backend/archivos_adjuntos/";
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        // Ruta final (única para evitar conflictos de nombres)
        $nombreUnico = uniqid() . "_" . basename($titulo);
        $rutaDestino = $carpetaDestino . $nombreUnico;

        if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
            $sql = "INSERT INTO todopro.adjuntos 
                    (id_tarea, id_usuario, nombre_archivo, ruta, tamano, mime)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("iissis", $id_tarea, $id_usuario, $titulo, $rutaDestino, $peso, $tipo);
            $stmt->execute();

            header('location: ../frontend/interfaz.php');
        } else {
            echo "❌ Error al mover el archivo a la carpeta destino";
        }
    } else {
        echo "❌ No se recibió ningún archivo válido";
    }
}
