<?php
require_once "conexion.php";

$error_correo = $error_contrasena = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Validaciones
    if (empty($correo)) {
        $error_correo = "El correo es obligatorio";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error_correo = "El correo no es válido";
    }

    if (empty($contrasena)) {
        $error_contrasena = "La contraseña es obligatoria";
    }

    if (empty($error_correo) && empty($error_contrasena)) {
        $sql = "SELECT id, nombre, correo, clave_hash, rol FROM usuarios WHERE correo = ?";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows == 1) {
                $usuario = $resultado->fetch_assoc();

                if (password_verify($contrasena, $usuario["clave_hash"])) {
                    session_start();
                    $_SESSION["id"] = $usuario["id"];
                    $_SESSION["nombre"] = $usuario["nombre"];
                    $_SESSION["correo"] = $usuario["correo"];
                    $_SESSION["rol"] = $usuario["rol"]; // Guardamos el rol aquí

                    header("Location: frontend/interfaz.php");
                    exit;
                } else {
                    $error_contrasena = "La contraseña es incorrecta";
                }
            } else {
                $error_correo = "El correo no está registrado";
            }
            $stmt->close();
        } else {
            die("Error al preparar la consulta: " . $conexion->error);
        }
    }
}
?>

