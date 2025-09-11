<?php
require_once '../backend/crearProyectos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proyecto</title>
</head>
<body>
    <form method="POST">
        <h2>Registrar Proyecto</h2>

        <label for="nombre">Nombre del Proyecto:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="4" placeholder="Describe el proyecto" required></textarea>

        <label for="id_propietario">ID del Propietario:</label>
        <input type="number" name="id_propietario" id="id_propietario" required>

        <button type="submit">Guardar Proyecto</button>
    </form>
</body>
</html>
