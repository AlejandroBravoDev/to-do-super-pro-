<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_tarea"])) {
    $id_tarea = intval($_POST["id_tarea"]);
    $id_usuario = $_SESSION["id"];
    $rol = $_SESSION["rol"];

    if ($rol === "admin") {
        //Admin puede borrar cualquier tarea
        $sql = "DELETE FROM tareas WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_tarea);
    } else {
        //El usuario solo la borra si el mismo la creo
        $sql = "DELETE FROM tareas WHERE id = ? AND (id_creador = ? OR id_asignado = ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $id_tarea, $id_usuario, $id_usuario);
    }

    if ($stmt->execute()) {
        header("Location: ../frontend/interfaz.php");
        exit;
    } else {
        echo "No se pudo eliminar la tarea";
    }
} else {
    header("Location: ../frontend/interfaz.php");
    exit;
}
?>