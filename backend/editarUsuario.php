<?php
    require_once("../backend/conexion.php");
    $_SESSION["mensajeAdmin"] = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id_usuarios = $_POST["id"];
        $nombre = $_POST['nombre'];
        $rol = $_POST['roles'];
        $correo = $_POST['correo'];

        if(empty($nombre) || empty($rol) || empty($correo)){
            $_SESSION["mensajeAdmin"] = "no pueden haber campos vacios";
        }

        if(empty($_SESSION["mensajeAdmin"])){
            $sql = "UPDATE usuarios SET nombre = ?, correo = ?, rol = ? WHERE id = ?";

            $stmt = $conexion->prepare($sql);
            $stmt -> bind_param("sssi", $nombre, $correo, $rol, $id_usuarios);
            if($stmt -> execute()){
                $_SESSION["mensajeAdmin"] = "Se editó correctamente";
                header("location: ../frontend/interfazAdmin.php");
                exit();
            }else{
                $_SESSION["mensajeAdmin"] = "hubo un error al hacer la consulta";
            }
        }
    }