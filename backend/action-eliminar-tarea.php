<?php
    require_once "conexion.php";
    $error_eliminar = "";
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_tarea"])){
        $id_tarea = $_POST["id_tarea"];
        $id_usuario = $_SESSION["id"];

        $sql = "DELETE FROM tareas WHERE id = ? AND id_creador = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $id_tarea, $id_usuario);
        if($stmt->execute()){
            header("Location: ../frontend/interfaz.php");
        }else{
            echo "Hubo un problema al eliminar la tarea";
        }
    }
?>