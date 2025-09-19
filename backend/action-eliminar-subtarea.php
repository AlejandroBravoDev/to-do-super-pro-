<?php
require_once "conexion.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_tarea = intval($_POST["id_tarea"]);
    $subtarea = trim($_POST["subtarea"]);

    //Para buscar las subtareas 
    $sql = "SELECT subtareas FROM tareas WHERE id = $id_tarea";
    $res = mysqli_query($conexion, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $subtareas = explode(",", $row["subtareas"]);

        //La elimino de la lista
        $subtareas = array_filter($subtareas, function($s) use ($subtarea) {
            return trim($s) !== $subtarea;
        });
        $nuevas_subtareas = implode(",", $subtareas);
        //Actualizar la tarea eliminada
        $update = "UPDATE tareas SET subtareas = '" . mysqli_real_escape_string($conexion, $nuevas_subtareas) . "' WHERE id = $id_tarea";
        if (mysqli_query($conexion, $update)) {
            header("Location: ../frontend/interfaz.php");
            exit();
        } else {
            echo "No se pudo eliminar l a subtarea " . mysqli_error($conexion);
        }
    }
}
?>
