<?php
    require_once "../backend/conexion.php";

    $id_tarea = $_POST['id_tarea'];
    $estado = 'completada';

    $sql = "UPDATE tareas SET estado = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $estado, $id_tarea);

    if ($stmt->execute()) {
        header("Location: ../frontend/interfaz.php");
        exit;
    } else {
        echo "Error al actualizar";
    }
?>