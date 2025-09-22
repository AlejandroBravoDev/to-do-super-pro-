<?php
require_once "../backend/conexion.php";

if (isset($_POST['id_archivada'])) {
    $id_archivada = intval($_POST['id_archivada']);

    $sql = "DELETE FROM archivadas WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_archivada);

    if ($stmt->execute()) {
        header("Location: ../frontend/archivadas.php?eliminada=1");
        exit;
    } else {
        echo "Error al eliminar la tarea archivada.";
    }
} else {
    echo "No se recibió la tarea.";
}
?>