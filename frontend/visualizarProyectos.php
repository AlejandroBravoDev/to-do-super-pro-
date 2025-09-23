<?php
require_once "../backend/conexion.php";

// Consulta con JOIN para traer el nombre del propietario
if(!isset($_SESSION["id"])){
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver proyectos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    include("includes/header.php");?>


    <h1>Proyectos existentes</h1>
    <ul class="proyectos-lista">
        
        <?php 
            $sql = "
                SELECT p.id, p.nombre, p.descripcion, p.creado_en, u.nombre AS propietario
                FROM proyectos p
                INNER JOIN usuarios u ON p.id_propietario = u.id
            ";
            $resultado = $conexion->query($sql);
        if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <li>
                    <strong><?= htmlspecialchars($row['nombre']) ?></strong><br>
                    <span class="descripcion_proyectos"><?= htmlspecialchars($row['descripcion']) ?></span><br>
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
    <div class="links">
        <?php
            $sql = "SELECT * FROM usuarios WHERE id = ?";

            if ($usuario && $usuario["rol"] === "admin") {
                echo '<li class="li-class"><a href="proyectos.php" class="vinculos-proyectos">Volver a crear proyectos</a></li>';
                
            }else{
                echo '<li class="li-class"><a href="interfaz.php" class="vinculos-proyectos" style="color:white;">Volver a inicio</a></li>';
            }
        ?>
    </div>

     <?php include("includes/footer.php");?>
</body>
</html>