<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre        = trim($_POST['nombre'] ?? '');
    $descripcion   = trim($_POST['descripcion'] ?? '');
    $id_propietario = intval($_POST['id_propietario'] ?? 0);
    $fecha = date('Y-m-d H:i:s');

    if (empty($nombre) || empty($descripcion) || $id_propietario <= 0) {
        die("Todos los campos son obligatorios.");
    }
    // Verificar que el propietario exista
    $check = $conexion->prepare("SELECT id FROM usuarios WHERE id = ? LIMIT 1");
    $check->bind_param("i", $id_propietario);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        die("El ID de propietario no existe en la tabla usuarios.");
    }
    $check->close();

    $stmt = $conexion->prepare("
        INSERT INTO proyectos (nombre, descripcion, id_propietario, creado_en, actualizado_en)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssiss", $nombre, $descripcion, $id_propietario, $fecha, $fecha);

    if ($stmt->execute()) {
        echo "Proyecto creado correctamente.";
    } else {
        echo "Error al crear el proyecto: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
