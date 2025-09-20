<?php
require_once "conexion.php";
session_start();



$idUsuario = $_SESSION['id'];
$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['correo'] ?? '';
$avatarPath = null;

//Buscamos el avatar que se tenia anteriormente para eliminarlo por si el usuario sube otro nuevo
$sqlAvatar = "SELECT avatar FROM usuarios WHERE id = ?";
$stmtAvatar = $conexion->prepare($sqlAvatar);
$stmtAvatar->bind_param("i", $idUsuario);
$stmtAvatar->execute();
$resultAvatar = $stmtAvatar->get_result();
$usuarioActual = $resultAvatar->fetch_assoc();
$avatarAnterior = $usuarioActual['avatar'] ?? null;


if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $directorio = "../frontend/avatares/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreArchivo = uniqid() . "_" . basename($_FILES["avatar"]["name"]);
    $rutaDestino = $directorio . $nombreArchivo;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $rutaDestino)) {
        $avatarPath = "avatares/" . $nombreArchivo;

        //Eliminamos el avatar anterior si es que el usuario tiene
        if (!empty($avatarAnterior)) {
            $rutaAnterior = "../frontend/" . $avatarAnterior;
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }
        }
    }
}

if ($avatarPath) {
    $sql = "UPDATE usuarios SET nombre=?, correo=?, avatar=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $avatarPath, $idUsuario);
} else {
    $sql = "UPDATE usuarios SET nombre=?, correo=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $correo, $idUsuario);
}

if ($stmt->execute()) {
    //actualizamos los datos de el usuario al cambiarlos en el perfil
    $_SESSION["nombre"] = $nombre;
    $_SESSION["correo"] = $correo;
    if ($avatarPath) {
        $_SESSION["avatar"] = $avatarPath;
    }

    header("Location: ../frontend/perfil.php");
    exit;
} else {
    echo "Error al actualizar perfil: " . $conexion->error;
}
?>