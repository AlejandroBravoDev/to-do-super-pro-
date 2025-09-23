<?php
require_once "../backend/conexion.php";


$id_tarea = $_POST['id_tarea'];
$id_usuario = $_SESSION['id']; // usuario logueado
$estado = 'terminada';

// 1. Verificar a quién pertenece la tarea
$sql = "SELECT id_asignado, id_creador FROM tareas WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_tarea);
$stmt->execute();
$result = $stmt->get_result();
$tarea = $result->fetch_assoc();
$stmt->close();

if (!$tarea) {
    die("Error: tarea no encontrada.");
}

//solo deja completarla si yo soy quien la creo o a quien se la asignaron
if ($tarea['id_asignado'] != $id_usuario && $tarea['id_creador'] != $id_usuario) {
    header("Location: ../frontend/interfaz.php?error=no_autorizado");
    exit;
}

// 3. Si pasa la validación, actualizar el estado
$sql = "UPDATE tareas SET estado = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $estado, $id_tarea);

if ($stmt->execute()) {
    header("Location: ../frontend/interfaz.php?success=1");
    exit;
} else {
    echo "Error al actualizar";
}
?>