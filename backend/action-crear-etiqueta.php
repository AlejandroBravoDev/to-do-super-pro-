<?php
require_once "conexion.php";

if(isset($_POST["id_etiqueta"])){
    $id_etiqueta = $_POST["id_etiqueta"];

    $sql = "select * from etiqueta where id_etiqueta = '$id_etiqueta'";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_usuario = $_SESSION['id'];
    $etiqueta = $_POST['etiqueta'];

    $sql = "INSERT INTO etiquetas (nombre, id_usuario) VALUES ('$etiqueta', $id_usuario)";
    $stmt = $conexion -> prepare($sql);
    if($stmt->execute()){
        echo "etiqueta creada";
    }else{
        echo "error";
    }
}
?>
