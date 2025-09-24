<?php
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tarea = $_POST['id_tarea'];
    $titulo = $_POST['titulo'];
    $prioridad = $_POST['prioridad'];
    $estado = $_POST['estado'];

    // Manejar la etiqueta
    if (isset($_POST['etiquetas']) && !empty($_POST['etiquetas'])) {
        $id_etiqueta = $_POST['etiquetas'];
        $sql_et = "SELECT nombre FROM etiquetas WHERE id = ?";
        $stmt_et = $conexion->prepare($sql_et);
        $stmt_et->bind_param("i", $id_etiqueta);
        $stmt_et->execute();
        $res_et = $stmt_et->get_result();
        $et = $res_et->fetch_assoc();
        $nombre_etiqueta = $et['nombre'];
    } else {
        $nombre_etiqueta = null;
    }

    $sql = "UPDATE tareas SET titulo=?, prioridad=?, estado=?, nombre_etiqueta=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssi", $titulo, $prioridad, $estado, $nombre_etiqueta, $id_tarea);

    if ($stmt->execute()) {
        header("Location: ../frontend/interfaz.php?success=1");
        exit;
    } else {
        echo "Error al actualizar tarea";
    }
}
?>