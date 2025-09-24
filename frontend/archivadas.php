<?php
require_once "../backend/conexion.php";

if(!isset($_SESSION["id"])){
    header("Location: ../index.php");
    exit();
}

$id_usuario = $_SESSION['id'];


$sql = "SELECT id, titulo, descripcion, usuario, subtareas, subtareas_completadas FROM archivadas WHERE id_creador = ? OR id_asignado = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_usuario, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas archivadas</title>
    <link rel="stylesheet" href="../frontend/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <?php include("includes/header.php");?>

    <div class="contenedor">
        <h1 class="titulo-archivadas">Tareas archivadas</h1>
        <?php if ($result && $result->num_rows > 0): ?>
            
            <?php while ($tarea = $result->fetch_assoc()): ?>
                <div class="tarea-archivada">
                    <h3><?php echo htmlspecialchars($tarea['titulo']); ?></h3>
                    <p>Descripcion: <?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                    <p>Creada por: <strong><?php echo htmlspecialchars($tarea['usuario']); ?></strong></p>
                    

                    <!-- Mostrar subtareas -->
                    <b>Subtareas completadas</b>
                    <?php
                    $subtareas = !empty($tarea["subtareas"]) ? array_map("trim", explode(",", $tarea["subtareas"])) : [];
                    $completadas = !empty($tarea["subtareas_completadas"]) ? array_map("trim", explode(",", $tarea["subtareas_completadas"])) : [];

                    if (!empty($subtareas)) {
                        echo "<ul>";
                        foreach ($subtareas as $sub) {
                            $sub = htmlspecialchars($sub);
                            if (in_array($sub, $completadas)) {
                                echo "<li><i class='fa-solid fa-circle-check'></i> $sub (Completada)</li>";
                            } else {
                                echo "<li>$sub</li>";
                            }
                        }
                        echo "</ul>";
                    } else {
                        echo "<p><i>No había subtareas en esta tarea.</i></p>";
                    }
                    ?>
                    <b>Tarea completada</b>
                    <form method="post" action="../backend/action-eliminar-archivada.php" style="margin:0;">
                        <input type="hidden" name="id_archivada" value="<?php echo $tarea['id']; ?>">
                        <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar esta tarea archivada?');">
                        Eliminar
                        </button>
                    </form>
                    <hr>
                </div>
                
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes tareas archivadas aún</p>
        <?php endif; ?>

        <a href="interfaz.php" class="btn-volver">Volver</a>
    </div>
    <?php include("includes/footer.php");?>
</body>
</html>