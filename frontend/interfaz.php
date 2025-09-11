<?php
    require_once "../backend/action-crear-tarea.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Mis Tareas</h1>
    <?=$aviso?>
    
    <form method="post" >
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
        
        <button type="submit">Agregar</button>
    </form>
    <!-- $sql = select * from tareas where id_creador = $_SESSION["id"]-->
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
                        echo "<td>" . htmlspecialchars($row["id_asignado"]) . "</td>";
                        echo "<td>
                                <form method='post' action='../backend/action-eliminar-tarea.php'>
                                    <input type='hidden' name='id_tarea' value='" . $row["id"] . "'>
                                    <button type='submit'>Eliminar</button>
                                </form>
                              </td>";
                        echo "<td>
                                <form method='post' action='../frontend/editar-tarea.php'>
                                    <input type='hidden' name='id_tarea' value='" . $row["id"] . "'>
                                    <button type='submit'>Editar</button>
                                </form>
                             </td>";
                        echo "<tr>";
                    }
                echo "</table>";
            }
        ?>
    </div>
</body>
</html>