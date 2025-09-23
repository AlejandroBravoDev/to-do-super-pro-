<?php
require_once "conexion.php";
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_usuario = $_SESSION["id"];
    $titulo_tarea = $_POST["titulo"] ?? null;
    $fecha = $_POST["fecha-vencimiento"] ?? null;
    $descripcion = $_POST["descripcion"] ?? null;
    $estado = "en_progreso"; //Valor por defecto
    $prioridad = $_POST["prioridad"] ?? null;
    $id_asignado = $_POST["asignar-usuario"] ?? null;
    $id_proyecto = isset($_POST['asignar-proyecto']) ? trim($_POST['asignar-proyecto']) : "";
    $etiqueta = $_POST["etiqueta"] ?? null;
    $usuario = $_POST["rol"];

    //Debe llenar todos los campos requeridos
    if($usuario["rol"] === "admin"){
        if (empty($titulo_tarea) || empty($prioridad) || $id_proyecto === "" || empty($fecha) || empty($descripcion)|| empty($etiqueta)) {
        $_SESSION["mensaje_campos_obligatorios"] = "Llene todos los campos obligatorios!";
        header("Location: ../frontend/interfaz.php");
        exit;
        }

    }else if (empty($titulo_tarea) || empty($prioridad) || empty($fecha) || empty($descripcion)|| empty($etiqueta)) {
            $_SESSION["mensaje_campos_obligatorios"] = "Llene todos los campos obligatorios!";
            header("Location: ../frontend/interfaz.php");
            exit;
        
    }
    
    //No permitira crear tareas con fechas anteriores
    $fecha_actual = date("Y-m-d");
    if ($fecha < $fecha_actual) {
        $_SESSION["mensaje_tarea"] = "No puedes crear una tarea con una fecha anterior a hoy!";
        header("Location: ../frontend/interfaz.php");
        exit;
    }

    //Vefirificamos el usuario 
    $nombre_asignado = null;
    if (!empty($id_asignado)) {
        $stmt1 = $conexion->prepare("SELECT nombre FROM usuarios WHERE id = ?");
        $stmt1->bind_param("i", $id_asignado);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
        $usuario = $res1->fetch_assoc();
        $stmt1->close();

        if ($usuario) {
            $nombre_asignado = $usuario["nombre"];
        } else {

            $id_asignado = null;//Si no existe, es null
        }
    } else {
        $id_asignado = null;
    }


    //Verificamos el proyecto
    $nombre_proyecto = null;
    if (!empty($id_proyecto)) {
        $stmt2 = $conexion->prepare("SELECT nombre FROM proyectos WHERE id = ?");
        $stmt2->bind_param("i", $id_proyecto);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $proyecto = $res2->fetch_assoc();
        $stmt2->close();

        if ($proyecto) {
            $nombre_proyecto = $proyecto["nombre"];
        } else {
            $id_proyecto = null;
        }
    } else {
        $id_proyecto = null;
    }


    //Insertamos la nueva tarea
    $sql = "INSERT INTO tareas (
        id_creador, titulo, descripcion, fecha_vencimiento, estado, prioridad,
        id_asignado, nombre_asignado, id_proyecto, nombre_proyecto, nombre_etiqueta
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "issssssisss",
        $id_usuario,
        $titulo_tarea,
        $descripcion,
        $fecha,
        $estado,
        $prioridad,
        $id_asignado,
        $nombre_asignado,
        $id_proyecto,
        $nombre_proyecto,
        $etiqueta
    );

    if ($stmt->execute()) {
        header("Location: ../frontend/interfaz.php");
        exit();
    } else {
        echo "Error al crear la tarea: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
