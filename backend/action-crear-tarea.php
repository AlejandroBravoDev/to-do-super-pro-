<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_usuario = $_SESSION["id"];

    $titulo_tarea = $_POST["titulo"] ?? null;
    $fecha = $_POST["fecha-vencimiento"] ?? null;
    $estado = $_POST["estado"] ?? null;
    $prioridad = $_POST["prioridad"] ?? null;
    $id_asignado = $_POST["asignar-usuario"] ?? null;
    $id_proyecto = $_POST["proyecto"] ?? null;
    $etiqueta = $_POST["etiqueta"] ?? null;

    if (empty($titulo_tarea) || empty($estado) || empty($prioridad)) {
        die("Todos los campos obligatorios deben estar completos");
    }

    // ============================
    // 🧍 Verificar usuario asignado
    // ============================
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
            $id_asignado = null; // ⚡ muy importante
        }
    } else {
        $id_asignado = null;
    }

    // ============================
    // 📁 Verificar proyecto
    // ============================
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

    // ============================
    // ✅ Insertar en tareas
    // ============================
    $sql = "INSERT INTO tareas (
        id_creador, titulo, fecha_vencimiento, estado, prioridad,
        id_asignado, nombre_asignado, id_proyecto, nombre_proyecto, nombre_etiqueta
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    // Convertir nulls explícitamente
    $stmt->bind_param(
        "issssissis",
        $id_usuario,
        $titulo_tarea,
        $fecha,
        $estado,
        $prioridad,
        $id_asignado,
        $nombre_asignado,
        $id_proyecto,
        $nombre_proyecto,
        $etiqueta
    );

    // ⚡ Si $id_asignado o $id_proyecto son null, MySQL los guardará como NULL y no dará error
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
