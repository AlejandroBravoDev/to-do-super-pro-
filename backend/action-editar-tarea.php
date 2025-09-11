<?php
    require_once "conexion.php";

    $mensaje = "";
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_tarea"])){
        $fecha_actual = date("Y-m-d H:i:s");
        $id_tarea = $_POST["id_tarea"];
        $id_usuario = $_SESSION["id"];

        $titulo = $_POST["titulo"];
        $fecha_vencimiento = $_POST["fecha-vencimiento"];
        $prioridad = $_POST["prioridad"];
        $estado = $_POST["estado"];
        $usuario = $_POST["asignar-usuario"];
        $proyecto = !empty($_POST["asignar-proyecto"]) ? $_POST["asignar-proyecto"] : NULL;

        $sql = "UPDATE tareas SET titulo = ?, nombre_asignado = ?, prioridad = ?, estado = ?, id_proyecto = ?, actualizado_en = ? WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt -> bind_param("ssssisi", $titulo, $usuario, $prioridad, $estado, $proyecto, $fecha_actual, $id_tarea);
        if ($stmt -> execute()){
            header("location: ../frontend/interfaz.php");
        }else{
            echo "error";
        }
    }
?>