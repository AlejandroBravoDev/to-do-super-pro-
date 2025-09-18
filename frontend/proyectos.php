<?php
require_once '../backend/crearProyectos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proyecto</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <form method="POST">
        <h1>Registrar Proyecto</h1>

        <label for="nombre">Nombre del Proyecto:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="4" placeholder="Describe el proyecto" required></textarea>

        <label for="id_propietario">ID del Propietario:</label>
        <input type="number" name="id_propietario" id="id_propietario" required>

        <button type="submit">Guardar Proyecto</button>
        <div class="links">
            <a href="visualizarProyectos.php">Ver proyectos</a>
            <a href="interfaz.php">Volver a inicio</a>
        </div>
        
    </form>
</body>
</html>
