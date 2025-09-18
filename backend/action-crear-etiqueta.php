<?php
    require_once "conexion.php";

    if(isset($_POST["id_etiqueta"])){
        $id_etiqueta = $_POST["id_etiqueta"];

        $sql = "select * from etiquetas where id_etiqueta = '$id_etiqueta'";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_usuario = $_SESSION['id'];
        $etiqueta = $_POST['etiqueta'];

        if(empty($etiqueta)){
            $mensaje = "tiene que ponerle un nombre a la etiqueta";
        }

        if(empty($mensaje)){

            $sql = "INSERT INTO etiquetas (nombre, id_usuario) VALUES ('$etiqueta', $id_usuario)";
            $stmt = $conexion -> prepare($sql);
            if($stmt->execute()){
                $mensaje = "etiqueta creada";
            }else{
                $mensaje = "error";
            }
        }
    }
?>
