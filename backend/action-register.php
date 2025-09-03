<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $clave_hash = password_hash($_POST['clave'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'] ?? 'usuario';
    $fecha = date('Y-m-d H:i:s');

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("Correo inválido.");
    }

    // Manejo de avatar
    $avatarPath = null;
    if (!empty($_FILES['avatar']['name'])) {
        $directorio = "avatares/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = uniqid() . "_" . basename($_FILES['avatar']['name']);
        $rutaArchivo = $directorio . $nombreArchivo;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaArchivo)) {
            $avatarPath = $rutaArchivo;
        }
    }

    try {
        // Verificar si el correo ya está registrado
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("El correo ya está registrado.");
        }

        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, clave_hash, rol, avatar, creado_en, actualizado_en)
                                VALUES (:nombre, :correo, :clave_hash, :rol, :avatar, :creado, :actualizado)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave_hash', $clave_hash);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':avatar', $avatarPath);
        $stmt->bindParam(':creado', $fecha);
        $stmt->bindParam(':actualizado', $fecha);
        $stmt->execute();

        echo "Registro exitoso.";
        exit;
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }
}
?>
