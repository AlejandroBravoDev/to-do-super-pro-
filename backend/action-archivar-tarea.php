<?php
require_once '../backend/conexion.php';


if (isset($_POST['id_tarea'])) {
    $id_tarea = intval($_POST['id_tarea']);

    //Traigo todos los datos de la tarea que voy a archivar
    $sqlTarea = "SELECT * FROM tareas WHERE id = ?";
    $stmt = $conexion->prepare($sqlTarea);
    $stmt->bind_param("i", $id_tarea);
    $stmt->execute();
    $resTarea = $stmt->get_result();
    $tarea = $resTarea->fetch_assoc();
    $stmt->close();

    if ($tarea) {
        $titulo = $tarea['titulo'];
        $descripcion = $tarea['descripcion'];
        $fecha_vencimiento = $tarea['fecha_vencimiento'];
        $id_creador = $tarea['id_creador'];
        $id_asignado = $tarea['id_asignado'];

        //Nombre de el usuario que creo la tarea
        $sqlUsuario = "SELECT nombre FROM usuarios WHERE id = ?";
        $stmt = $conexion->prepare($sqlUsuario);
        $stmt->bind_param("i", $id_creador);
        $stmt->execute();
        $resultadoUsuario = $stmt->get_result();
        $usuario = $resultadoUsuario->fetch_assoc();
        $stmt->close();

        
        $nombreUsuario = $usuario['nombre'];

        //Se inserta la tarea en la tabla
        $sqlInsert = "INSERT INTO archivadas (titulo, descripcion, fecha_vencimiento, usuario, id_creador, id_asignado, fecha_archivada) 
              VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmtI = $conexion->prepare($sqlInsert);
        $stmtI->bind_param("ssssii", $titulo, $descripcion, $fecha_vencimiento, $nombreUsuario, $id_creador, $id_asignado);  
        $stmtI->execute();
        $stmtI->close();

        //Se cambia el estado de esta a terminada
        $sqlUpdate = "UPDATE tareas SET estado = 'terminada' WHERE id = ?";
        $stmtUpt = $conexion->prepare($sqlUpdate);
        $stmtUpt->bind_param("i", $id_tarea);
        $stmtUpt->execute();
        $stmtUpt->close();
        // Eliminar la tarea original después de archivarla
        $delete = $conexion->prepare("DELETE FROM tareas WHERE id = ?");
        $delete->bind_param("i", $id_tarea);
        $delete->execute();
        $delete->close();

        header("Location: ../frontend/archivadas.php");
        exit();
    } else {
        echo "No se encontró la tarea";
    }
} else {
    echo "No se recibió la tarea";
}
?>