<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_tarea"]) && isset($_POST["subtarea"])) {
    $id_tarea = intval($_POST["id_tarea"]);
    $subtarea = trim($_POST["subtarea"]);

    //Buscamos las subtareas completadas
    $sql = "SELECT subtareas_completadas FROM tareas WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_tarea);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();

    $completadas_actuales = $row["subtareas_completadas"];

    //Agregamos la nueva subtarea completada
    if (!empty($completadas_actuales)) {
        $nuevas_completadas = $completadas_actuales . ", " . $subtarea;
    } else {
        $nuevas_completadas = $subtarea;
    }

    //Actualizamos la tarea con la lista de completadas
    $sql_update = "UPDATE tareas SET subtareas_completadas = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("si", $nuevas_completadas, $id_tarea);

    if ($stmt_update->execute()) {
        header("Location: ../frontend/interfaz.php?msg=subtarea_completada");
        exit;
    } else {
        echo "Error al completar la subtarea.";
    }
}
?>