<?php
    require_once "../backend/conexion.php";

    if(isset($_POST["id_etiqueta"])){
        $id_etiqueta = $_POST["id_etiqueta"];

        $sql = "SELECT * FROM etiquetas WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_etiqueta);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
    }

    $mensaje = "";
    $error = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "DELETE FROM etiquetas WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_etiqueta);
        if ($stmt->execute()) {
            $mensaje="etiqueta eliminada";
            header("Location: ../frontend/etiquetas.php");
            exit;
        } else {
            $mensaje="error al eliminar";
        }
    }
?>