<?php
    require_once "../backend/conexion.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST["id"];

        if($id == $_SESSION["id"]){
            die("no puedes eliminar tu propio usuario");
            echo "<a href='interfazAdmin.php'>Volver</a>'";
        }

        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            header("Location: ../frontend/interfazAdmin.php");
        }
    }