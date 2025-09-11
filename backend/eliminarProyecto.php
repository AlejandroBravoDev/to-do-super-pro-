<?php
require_once "../backend/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id']; 

    $stmt = $conexion->prepare("DELETE FROM proyectos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Proyecto eliminado correctamente.";
    } else {
        echo "Error al eliminar el proyecto: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();

    
    header("Location: ../frontend/visualizarProyectos.php");
    exit();
} else {
    echo "Solicitud rechazada";
}
?>