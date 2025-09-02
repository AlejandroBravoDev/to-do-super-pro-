<?php
    require_once "conexion.php";
    require_once "action-register.php";

    $error_correo = $error_contrasena = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];
        
        if(empty($correo)){
            $error_correo = "El correo es obligatorio";
        }elseif(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            $error_correo = "El correo no es valido";
        }

        if(empty($contrasena)){
            $error_contrasena = "La contraseña es obligatoria";
        }elseif(password_verify($contrasena, $passwordhash)){
            session_start();
            $_SESSION["id"] = $id;
            $_SESSION["nombre"] = $nombre;
            $_SESSION["correo"] = $correo;
            header("Location: index.php");
        }else{
            $error_contrasena = "La contraseña es incorrecta";
        }
    }
?>