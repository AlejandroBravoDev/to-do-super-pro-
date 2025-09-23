<?php
    require_once "../backend/conexion.php";
    if (isset($_POST['id_tarea'])) {
        $id_tarea = $_POST['id_tarea'];

        // Buscamos la tarea en la BD
        $sql = "SELECT * FROM tareas WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_tarea);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $tarea = $resultado->fetch_assoc();
    }


    if(!isset($_SESSION["id"])){
        header("Location: ../index.php");
        exit();
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include("includes/header.php");?>
    <div class="contenedor-editar-tarea">
    <form method="post" action="../backend/action-editar-tarea.php" class="form-editar-tarea">
        <input type="hidden" name="id_tarea" value="<?=$_POST['id_tarea'] ?? ''?>">
        <label for="">Editar tarea</label>
        <input type="text" name="titulo" placeholder="tarea" value="<?= $tarea['titulo'] ?>">
        <label for="">fecha de vencimineto</label>
        <input type="date" name="fecha-vencimiento">
        <label for="">prioridad</label>
        <select name="prioridad" id="">
            <option value="<?=$tarea['prioridad']?>"><?=$tarea['prioridad']?></option>
            <option value="alta">alta</option>
            <option value="media">media</option>
            <option value="baja">baja</option>
        </select>


        <!--select prioridad (alta, media y baja)-->
        <label for="">estado</label>
        <select name="estado" id="">
            <option value="<?= $tarea['estado']?>"><?= $tarea['estado']?></option>
            <option value="completada">completada</option>
            <option value="enProceso">en proceso</option>
        </select>
        <?php
                if (isset($_SESSION['id'])) {
                    $idUsuario = $_SESSION['id'];
                    $sql_rol = "SELECT rol FROM usuarios WHERE id = $idUsuario";
                    $resultado_rol = mysqli_query($conexion, $sql_rol);
                    $fila_rol = mysqli_fetch_assoc($resultado_rol);

                    if ($fila_rol["rol"] == "admin") {
                        echo '<label for="">asignar</label>';
                        echo '<select name="asignar-usuario" id="">';
                        echo '<option value="">asignar usuario</option>';

                        // Consulta para obtener todos los usuarios
                        $sql_usuarios = "SELECT id, nombre FROM usuarios";
                        $res_usuarios = mysqli_query($conexion, $sql_usuarios);
                        while ($row = mysqli_fetch_assoc($res_usuarios)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                        }
                        echo '</select>';

                        echo '<label for="">proyecto</label>';
                        echo '<select name="asignar-proyecto" id="">';
                        echo '<option value="">asignar proyecto</option>';

                        // Consulta para obtener todos los proyectos
                        $sql_proyectos = "SELECT id, nombre FROM proyectos";
                        $res_proyectos = mysqli_query($conexion, $sql_proyectos);
                        while ($row = mysqli_fetch_assoc($res_proyectos)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                        }
                        echo '</select>';
                    }
                }
            ?>
        <!--Select para proyectos-->
        <label for="">etiquetas</label>
        <select name="etiquetas" id="">
            <option value="">etiquetas</option>

            <?php
                $sql = "SELECT * FROM etiquetas";
                $resultado = $conexion->query($sql);
                while($row = $resultado -> fetch_assoc()){
                    echo "<option value='".$row['id_etiqueta']."'>".$row['nombre']."</option>";
                }
            ?>
        </select>
        <button type="submit">Editar</button>
        <div class="links links_editar_tarea">
            <a href="interfaz.php">Volver a inicio</a>
        </div>


    </form>
    </div>
    <?php include("includes/footer.php");?>
</body>
</html>