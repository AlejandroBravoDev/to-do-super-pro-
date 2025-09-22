<?php
    require_once "../backend/conexion.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="../frontend/style.css">
</head>
<body>
    <?php
        include '../frontend/includes/header.php';
    ?>
    <div class="usuarios_container">
        <h1>Administrar usuarios</h1>

        <?php
            $sql = "SELECT * FROM usuarios";
            $resultado = mysqli_query($conexion, $sql);

            if($resultado -> num_rows > 0){
                echo "<table ' class='tabla_usuarios'>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th colspan='2'>Acciones</th>
                        </tr>";
                while($row = $resultado -> fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['nombre']."</td>";
                        echo "<td>".$row['correo']."</td>";
                        echo "<td>".$row['rol']."</td>";
                        echo "<td>
                                <form action='../frontend/editarUsuario.php' method='POST' >
                                    <input type='hidden' name='id' value='" .$row['id']."'>
                                    <button type='submit'>Editar</button>
                                </form>
                            <td>";
                        echo "<td>
                                <form action='../backend/eliminarUsuario.php' method='POST' onsubmit='return confirmar()'>
                                    <input type='hidden' name='id' value='".$row['id']."'>
                                    <button type='submit'>Eliminar</button>
                                </form>
                            <td>";
                        echo "</tr>";

                }
                echo "</table>";
            }
        ?>
    </div>
    <script>
        function confirmar(){
            return confirm("¿estpas seguro de eliminar este usuario?")
        }
    </script>   

    <?php
        include '../frontend/includes/footer.php';
    ?>
</body>
</html>