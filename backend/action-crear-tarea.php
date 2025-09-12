    <?php
        require_once "conexion.php";
        $aviso = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $id_usuario = $_SESSION["id"];

            $titulo_tarea = $_POST["titulo"];
            $fecha = $_POST["fecha-vencimiento"];
            $estado = $_POST["estado"];
            $prioridad = $_POST["prioridad"];
            $usuario_asignado = $_POST["asignar-usuario"];
            $proyecto = $_POST["proyecto"] ?? null;
            $etiqueta = $_POST["etiqueta"] ?? null;

    //        $sql1 = "select nombre from usuario where id_asignado = ?";
    //        $resultado1 = $conexion->prepare($sql1);

            $sql = "INSERT INTO tareas (id_creador, titulo, fecha_vencimiento, estado, prioridad, nombre_asignado, nombre_etiqueta) values (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt -> bind_param("issssss", $id_usuario,$titulo_tarea, $fecha, $estado, $prioridad, $usuario_asignado, $etiqueta);
            if ($stmt -> execute()){
                $aviso = "Tarea creada correctamente";
            }else{
                $aviso = "Error al crear la tarea";
            }
        }
    ?>