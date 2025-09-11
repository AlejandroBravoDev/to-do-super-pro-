<?php
require_once "../backend/conexion.php";

// Consulta con JOIN para traer el nombre del propietario
$sql = "
    SELECT p.id, p.nombre, p.descripcion, p.creado_en, u.nombre AS propietario
    FROM proyectos p
    INNER JOIN usuarios u ON p.id_propietario = u.id
    
";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Proyectos existentes</h1>
    <ul>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <li>
                    <strong><?= htmlspecialchars($row['nombre']) ?></strong><br>
                    <?= htmlspecialchars($row['descripcion']) ?><br>
                    <em>Propietario:</em> <?= htmlspecialchars($row['propietario'] ?? 'Sin propietario') ?><br>
                    <small>Creado en: <?= htmlspecialchars($row['creado_en']) ?></small>
                    <form action="../backend/eliminarProyecto.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este proyecto?')">Eliminar</button>
                    </form>
                </li>
                <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <li>No hay proyectos registrados</li>
        <?php endif; ?>
    </ul>
    <a href="proyectos.php">Volver a proyectos</a>

</body>
</html>