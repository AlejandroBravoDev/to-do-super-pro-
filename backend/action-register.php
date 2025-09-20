<?php
require_once "conexion.php";
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $rol = $_POST["rol"] ?? "usuario";

    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

    // --------------------------
    // Manejo del avatar
    // --------------------------
    $rutaAvatar = "frontend/avatares/default-avatar.png"; // Avatar por defecto

    if (!empty($_FILES["avatar"]["name"])) {
        $carpetaDestino = "frontend/avatares/";
        $nombreArchivo = time() . "_" . basename($_FILES["avatar"]["name"]);
        $rutaAvatar = $carpetaDestino . $nombreArchivo;

        // Guardar físicamente en la carpeta
        if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], "../" . $rutaAvatar)) {
            $rutaAvatar = "frontend/avatares/default-avatar.png";
        }
    }

    // --------------------------
    // Verificar si el correo ya existe
    // --------------------------
    $check = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $check->bind_param("s", $correo);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        //Si ya existe, redirige con error
        header("Location: ../frontend/register.php?error=El correo ya está registrado");
        exit;
    }
    $check->close();


    $sql = "INSERT INTO usuarios (nombre, correo, clave_hash, rol, avatar) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("sssss", $nombre, $correo, $clave_hash, $rol, $rutaAvatar);

        if ($stmt->execute()) {
            $mensaje = "Usuario registrado correctamente";
        } else {
            echo "Error al registrar usuario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        die("Error al preparar la consulta: " . $conexion->error);
    }
}
?>
