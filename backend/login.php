<?php
    require_once "conexion.php";
    require_once "action-register.php";

    $error_correo = $error_contrasena = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new database();
        $conn = $db->connect();

        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];

        // Validar correo
        if (empty($correo)) {
            $error_correo = "El correo es obligatorio";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error_correo = "El correo no es válido";
        }

        // Validar contraseña
        if (empty($contrasena)) {
            $error_contrasena = "La contraseña es obligatoria";
        }

        // Solo continuar si no hay errores
        if (empty($error_correo) && empty($error_contrasena)) {
            // Buscar usuario en la BD
            $sql = "SELECT id, nombre, correo, clave_hash FROM usuarios WHERE correo = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows == 1) {
                $usuario = $resultado->fetch_assoc();

                // Verificar contraseña hasheada
                if (password_verify($contrasena, $usuario["clave_hash"])) {
                    session_start();
                    $_SESSION["id"] = $usuario["id"];
                    $_SESSION["nombre"] = $usuario["nombre"];
                    $_SESSION["correo"] = $usuario["correo"];
                    header("Location: index.php");
                    exit;
                } else {
                    $error_contrasena = "La contraseña es incorrecta";
                }
            } else {
                $error_correo = "El correo no está registrado";
            }
        }

        header("location: ../frontend/login.html");
        exit;
    }
?>
