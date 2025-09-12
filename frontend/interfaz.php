<?php
    require_once "../backend/action-crear-tarea.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Mis Tareas</h1>
    <div class="mostrar_tareas">
        <?php
        $sql = "SELECT * FROM tareas WHERE id_creador = " . $_SESSION['id'];
        $resultado = mysqli_query($conexion, $sql);
            if ($resultado ->num_rows > 0) {
                echo "<table ='1'>";
                $visto = [];
                    while ($row = $resultado -> fetch_assoc()) {
                        if(in_array($row["titulo"], $visto)){
                            continue;
                        }

                        $visto[] = $row["titulo"];

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["titulo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["estado"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["prioridad"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fecha_vencimiento"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre_asignado"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre_etiqueta"]) . "</td>";
                        echo "<td>
                                <form method='post' action='../backend/action-eliminar-tarea.php'>
                                    <input type='hidden' name='id_tarea' value='" . $row["id"] . "'>
                                    <button type='submit' style='width: 100px;'>Eliminar</button>
                                </form>
                              </td>";
                        echo "<td>
                                <form method='post' action='../frontend/editar-tarea.php'>
                                    <input type='hidden' name='id_tarea' value='" . $row["id"] . "'>
                                    <button type='submit' style='width: 100px;'>Editar</button>
                                </form>
                             </td>";
                        echo "<tr>";
                    }
                echo "</table>";
            }
        ?>
    </div>
    <?=$aviso?>
    
    <form method="post" class="crearTareas">
        <h2>Crea tu tarea</h2>
        <label for="">Nombre</label>
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
                $sql = "select nombre from todopro.proyectos";
                $resultado = mysqli_query($conexion, $sql);

                if ($resultado ->num_rows > 0) {
                    while ($row = $resultado -> fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                    }
                }
            ?>
        </select>
        <!--Select para proyectos-->
        <label for="">etiquetas</label>
        <select name="asignar-usuario" id="">
            <option value="">etiquetar</option>
            <?php
                $sql = "select * from todopro.etiquetas";
                $resultado = mysqli_query($conexion, $sql);

                if ($resultado ->num_rows > 0) {
                    while ($row = $resultado -> fetch_assoc()) {
                        echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                    }
                }
            ?>
        </select>
        
        <button type="submit">Agregar</button>
        <div class="links">
            <a href="proyectos.php">Crear nuevo proyecto</a>
            <a href="etiquetas.php">Crear etiqueta</a>
        </div>
    </form>
    <!-- $sql = select * from tareas where id_creador = $_SESSION["id"]-->
   
</body>
</html>