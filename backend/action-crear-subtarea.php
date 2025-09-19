<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_tarea"]) && isset($_POST["subtarea"])) {
    $id_tarea = intval($_POST["id_tarea"]);
    $subtarea = trim($_POST["subtarea"]);

    if (!empty($subtarea)) {
        //busca las subtareas existentes
        $sql = "SELECT subtareas FROM tareas WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_tarea);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();

        $subtareas_actuales = $row["subtareas"];

        //agrega la subtarea 
        if (!empty($subtareas_actuales)) {
            $nuevas_subtareas = $subtareas_actuales . ", " . $subtarea;
        } else {
            $nuevas_subtareas = $subtarea;
        }

        //Actualizar la tarea creada
        $sql_update = "UPDATE tareas SET subtareas = ? WHERE id = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("si", $nuevas_subtareas, $id_tarea);

        if ($stmt_update->execute()) {
            header("Location: ../frontend/interfaz.php");
            exit;
        } else {
            echo "Error al guardar la subtarea.";
        }
    }
}
?>
