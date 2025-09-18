<?php
    require_once "../backend/conexion.php";
    require_once "../backend/adjuntos.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../frontend/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include("buscar.php"); ?>
   <div style="margin-top:20px;">
    <?php
    if (isset($_GET['query'])) {
        $busqueda = $conexion->real_escape_string($_GET['query']);
        echo "<h2>Opciones:</h2>";

        $opciones = [];

        //Usuarios
        $sqlUsuarios = "SELECT id, nombre FROM usuarios WHERE nombre LIKE '%$busqueda%'";
        $resUsuarios = $conexion->query($sqlUsuarios);
        while ($row = $resUsuarios->fetch_assoc()) {
            $opciones[] = [
                "tipo" => "usuario",
                "id" => $row['id'],
                "nombre" => "Usuario: ".$row['nombre']
            ];
        }

        //Proyectos
        $sqlProyectos = "SELECT id, nombre FROM proyectos WHERE nombre LIKE '%$busqueda%'";
        $resProyectos = $conexion->query($sqlProyectos);
        while ($row = $resProyectos->fetch_assoc()) {
            $opciones[] = [
                "tipo" => "proyecto",
                "id" => $row['id'],
                "nombre" => "Proyecto: ".$row['nombre']
            ];
        }

        //Tareas
        $sqlTareas = "SELECT id, titulo FROM tareas WHERE titulo LIKE '%$busqueda%'";
        $resTareas = $conexion->query($sqlTareas);
        while ($row = $resTareas->fetch_assoc()) {
            $opciones[] = [
                "tipo" => "tarea",
                "id" => $row['id'],
                "nombre" => "Tarea: ".$row['titulo']
            ];
        }

        if (count($opciones) > 0) {
            echo '<form method="GET">';
            echo '<input type="hidden" name="query" value="'.$busqueda.'">';
            echo '<select name="seleccion">';
            foreach ($opciones as $op) {
                echo '<option value="'.$op['tipo'].'-'.$op['id'].'">'.$op['nombre'].'</option>';
            }
            echo '</select>';
            echo '<button type="submit">Ver detalles</button>';
            echo '</form>';
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }

        //Mostrar detalles
        if (isset($_GET['seleccion'])) {
            $valor = explode("-", $_GET['seleccion']);
            $tipo = $valor[0];
            $id = intval($valor[1]);

            echo "<h3>Detalles</h3>";

            //Usuario
            if ($tipo == "usuario") {
                $sql = "SELECT id, nombre, correo FROM usuarios WHERE id=$id";
                $res = $conexion->query($sql);
                if ($fila = $res->fetch_assoc()) {
                    echo "<p><b>Usuario:</b> ".$fila['nombre']."<br>";
                    echo "<b>ID de usuario:</b> ".$fila['id']."<br>";
                    echo "<b>Correo:</b> ".$fila['correo']."</p>";

                    //Proyectos del usuario
                    $sqlP = "SELECT id, nombre FROM proyectos WHERE id_propietario=$id";
                    $resP = $conexion->query($sqlP);
                    echo "<h4>Proyectos:</h4><ul>";
                    while ($p = $resP->fetch_assoc()) {
                        echo "<li>".$p['id']." - ".$p['nombre']."</li>";
                    }
                    echo "</ul>";

                    //Tareas del usuario
                    $sqlT = "SELECT id, titulo, prioridad FROM tareas WHERE id_creador=$id OR id_asignado=$id";
                    $resT = $conexion->query($sqlT);
                    echo "<h4>Tareas:</h4><ul>";
                    while ($t = $resT->fetch_assoc()) {
                        echo "<li>".$t['id']." - ".$t['titulo']." (Prioridad: ".$t['prioridad'].")</li>";
                    }
                    echo "</ul>";
                }
            }

            //Proyecto
            elseif ($tipo == "proyecto") {
                $sql = "SELECT id, nombre, descripcion, id_propietario FROM proyectos WHERE id=$id";
                $res = $conexion->query($sql);
                if ($fila = $res->fetch_assoc()) {
                    echo "<p><b>Proyecto:</b> ".$fila['nombre']."<br>";
                    echo "<b>ID de proyecto:</b> ".$fila['id']."<br>";
                    echo "<b>Descripción:</b> ".$fila['descripcion']."</p>";

                    
                    $sqlU = "SELECT id, nombre FROM usuarios WHERE id=".$fila['id_propietario'];
                    $resU = $conexion->query($sqlU);
                    if ($u = $resU->fetch_assoc()) {
                        echo "<p><b>Propietario:</b>".$u['nombre']."<br><b>ID:</b> ".$u['id']."</p>";
                    }

                    //Tareas del proyecto
                    $sqlT = "SELECT id, titulo, prioridad FROM tareas WHERE id_proyecto=$id";
                    $resT = $conexion->query($sqlT);

                    if ($resT->num_rows > 0) {
                        echo "<h4>Tareas:</h4><ul>";
                        while ($t = $resT->fetch_assoc()) {
                            echo "<li>".$t['id']." - ".$t['titulo']." (Prioridad: ".$t['prioridad'].")</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p><i>Este proyecto aún no tiene tareas</i></p>";
                    }
                }
            }

            //Tarea
            elseif ($tipo == "tarea") {
                $sql = "SELECT id, titulo, prioridad, id_creador, id_asignado, id_proyecto FROM tareas WHERE id=$id";
                $res = $conexion->query($sql);
                if ($fila = $res->fetch_assoc()) {
                    echo "<p><b>Tarea:</b> ".$fila['titulo']."<br>";
                    echo "<b>ID de tarea:</b> ".$fila['id']."<br>";
                    echo "<b>Prioridad:</b> ".$fila['prioridad']."</p>";

                    //Creador
                    $sqlU = "SELECT id, nombre FROM usuarios WHERE id=".$fila['id_creador'];
                    $resU = $conexion->query($sqlU);
                    if ($u = $resU->fetch_assoc()) {
                        echo "<p><b>Creador:</b> ".$u['nombre']."<br>ID: ".$u['id']."</p>";
                    }

                    //Id y nombre
                    if ($fila['id_asignado']) {
                        $sqlA = "SELECT id, nombre FROM usuarios WHERE id=".$fila['id_asignado'];
                        $resA = $conexion->query($sqlA);
                        if ($a = $resA->fetch_assoc()) {
                            echo "<p><b>Asignado a:</b> ".$a['nombre']."<br>ID: ".$a['id']."</p>";
                        }
                    }

                    //Proyecto
                    if ($fila['id_proyecto']) {
                        $sqlP = "SELECT id, nombre FROM proyectos WHERE id=".$fila['id_proyecto'];
                        $resP = $conexion->query($sqlP);
                        if ($p = $resP->fetch_assoc()) {
                            echo "<p><b>Proyecto:</b> ".$p['nombre']."<br>ID: ".$p['id']."</p>";
                        }
                    }
                }
            }
        }
    }
    ?>
    </div>
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
                        echo "<td>" . htmlspecialchars($row["estado"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre_asignado"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre_etiqueta"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre_proyecto"]) . "</td>";
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
                        echo "<td>
                                <form action='../backend/adjuntos.php' method='post' enctype='multipart/form-data'>
                                    <input type='hidden' name='id_tarea' value='" . $row["id"] . "'>
                                    <label>subir archivo adjunto</label>
                                    <input type='file' name='archivo' id='archivo'>
                                    <button type='submit'>subir</button>
                                </form>
                              </td>";
                        echo "<tr>";
                        //Form para comentar
                        echo "<tr><td colspan='7'>";
                        echo "<form method='post' action='../backend/comentarios.php'>";
                        echo "<input type='hidden' name='tarea_id' value='" . $row['id'] . "'>";
                        echo "<input type='text' name='comentario' placeholder='Escribe un comentario...' required>";
                        echo "<button type='submit'>Enviar</button>";
                        echo "</form>";

                         
                        //Mostrar comentarios abajo de cada tarea
                        $archivoComentarios = "../backend/comentarios.json";
                        if (file_exists($archivoComentarios)) {
                        $comentarios = json_decode(file_get_contents($archivoComentarios), true);
                        echo "<ul>";
                        $tieneComentarios = false;
                            foreach ($comentarios as $index => $c) {
                                if ($c["tarea_id"] == $row['id']) {
                                $usuarioComentario = isset($c["usuario"]) ? $c["usuario"] : "Anónimo";
                                echo "<li>";
                                echo "<b>".$usuarioComentario.":</b> ".$c["comentario"];
                                //Botón eliminar
                                echo " <form method='post' action='../backend/eliminar-comentario.php' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este comentario?\");'>";
                                echo "<input type='hidden' name='index' value='".$index."'>";
                                echo "<button type='submit'>Eliminar</button>";
                                echo "</form>";
                                echo "</li>";
                                $tieneComentarios = true;
                                }
                            }
                            if (!$tieneComentarios) {
                                echo "<li>No hay comentarios aún.</li>";
                            }
                            echo "</ul>";
                        }
                    }
                echo "</td></tr>";
                echo "</table>";
                
            }
        ?>
    </div>
    
    <form method="post" class="crearTareas" action="../backend/action-crear-tarea.php">
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
                        echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                    }
                }
            ?>
        </select>

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
        <label for="">etiquetas</label>
        <select name="etiqueta" id="">
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
   
</body>
</html>