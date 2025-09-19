<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $nueva = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

    // Buscar token válido que no haya expirado
    $stmt = $conexion->prepare(
        "SELECT id_usuario FROM password_resets 
         WHERE token = ? AND expira > NOW()"
    );
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($user_id);

    if ($stmt->fetch()) {
        $stmt->close();

        // Actualizar contraseña del usuario
        $stmt = $conexion->prepare("UPDATE usuarios SET clave_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $nueva, $user_id);
        $stmt->execute();
        $stmt->close();

        // Borrar el token para que no pueda volver a usarse
        $stmt = $conexion->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();

        echo "Tu contraseña ha sido restablecida correctamente.";
    } else {
        echo "El enlace no es válido o ha expirado.";
    }
}
?>
