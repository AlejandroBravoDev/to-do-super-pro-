<?php
require_once "../backend/conexion.php";


//Buscamos el id del usuario que inicio sesion
$idUsuario = $_SESSION['id'];

//Estamos trayendo los datos de el usuario logueado
$sql = "SELECT nombre, correo, rol, avatar, creado_en FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
if ($fila = $result->fetch_assoc()) {
    $nombre = $fila['nombre'];
    $correo = $fila['correo'];
    $rol = $fila['rol'];
    $creado_en = $fila['creado_en'];
    $avatarPath = $fila['avatar'];
} else {
    echo "Error: usuario no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include("includes/header.php");?>

    <div class="perfil">
        <h1 style="text-align:center;">Mi perfil</h1>
        <form method="post" action="../backend/action-actualizar-perfil.php" enctype="multipart/form-data">
            <div class="avatar-container">
                <?php if (!empty($avatarPath)): ?>
                    <img src="../<?php echo htmlspecialchars($avatarPath); ?>" alt="Avatar de <?php echo htmlspecialchars($nombre); ?>" width="120">
                <?php else: ?>
                    <img src="../frontend/avatares/default-avatar.png" width="150">
                <?php endif; ?>
            </div>
            <div class="datos-container">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" disabled>

            <label>Correo:</label>
            <input type="email" name="correo" value="<?php echo htmlspecialchars($correo); ?>" disabled>


            <label>Rol:</label>
            <input type="text" value="<?php echo htmlspecialchars($rol); ?>" disabled readonly>

            <label>Creado en:</label>
            <input type="text" value="<?php echo htmlspecialchars($creado_en); ?>" disabled readonly>

            <label>Avatar:</label>
            <input type="file" name="avatar" id="avatar" disabled>

            <button type="button" class="btn btn-editar" id="btnEditar">Editar</button>
            <button type="submit" class="btn btn-guardar" id="btnGuardar">Guardar cambios</button>
            </div>
        </form>
    </div>
    <?php include("includes/footer.php");?>
    <script src="script.js"></script>
</body>
</html>