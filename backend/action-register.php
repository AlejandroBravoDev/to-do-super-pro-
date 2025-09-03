<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Recibir y limpiar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $clave  = $_POST['clave'] ?? '';
    $rol    = $_POST['rol'] ?? 'usuario';
    $fecha  = date('Y-m-d H:i:s');
    $avatarPath = null;

    //Validaciones
    if (empty($nombre) || empty($correo) || empty($clave)) {
        die("Todos los campos son obligatorios.");
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("El correo no es válido.");
    }

    //Manejo de avatar
    if (!empty($_FILES['avatar']['name'])) {
        $directorio = "avatares/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = uniqid() . "_" . basename($_FILES['avatar']['name']);
        $rutaArchivo   = $directorio . $nombreArchivo;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaArchivo)) {
            $avatarPath = $rutaArchivo;
        }
    }

    //Comprobar si el correo ya existe
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("El correo ya está registrado.");
    }
    $stmt->close();

    //Insertar el nuevo usuario
    $clave_hash = password_hash($clave, PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("
        INSERT INTO usuarios (nombre, correo, clave_hash, rol, avatar, creado_en, actualizado_en)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssss", $nombre, $correo, $clave_hash, $rol, $avatarPath, $fecha, $fecha);

    if ($stmt->execute()) {
        header('Location: ../frontend/login.php');
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

