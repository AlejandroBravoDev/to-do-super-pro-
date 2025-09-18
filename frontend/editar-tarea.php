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

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <form method="post" action="../backend/action-editar-tarea.php">
        <input type="hidden" name="id_tarea" value="<?=$_POST['id_tarea'] ?? ''?>">
        <label for="">Crear Tarea</label>
        <input type="text" name="titulo" placeholder="tarea">
        <label for="">fecha de vencimineto</label>
        <input type="date" name="fecha-vencimiento">
        <label for="">prioridad</label>
        <select name="prioridad" id="">
            <option value="">prioridad</option>
            <option value="alta">alta</option>
            <option value="media">media</option>
            <option value="baja">baja</option>
        </select>


        <!--select prioridad (alta, media y baja)-->
        <label for="">estado</label>
        <select name="estado" id="">
            <option value="">seleccionar estado</option>
            <option value="completada">completada</option>
            <option value="enProceso">en proceso</option>
        </select>
        <label for="">asignar</label>
        <select name="asignar-usuario" id="">
            <option value="">asignar usuario</option>
            <?php
            $sql = "select * from todopro.usuarios";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado ->num_rows > 0) {
                while ($row = $resultado -> fetch_assoc()) {
                    echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                }
            }
            ?>
        </select>
        <!-- select de usuarios -->

        <label for="">proyecto</label>
        <select name="asignar-proyecto" id="">
            <option value="">asignar proyecto</option>
            <?php
            $sql = "select *     from todopro.proyectos";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado ->num_rows > 0) {
                while ($row = $resultado -> fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                }
            }
            ?>
        </select>
        <!--Select para proyectos-->

        <button type="submit">Editar</button>


    </form>
</body>
</html>