<?php
require_once "../backend/conexion.php";

    if(isset($_POST["id_etiqueta"])){
        $id_etiqueta = $_POST["id_etiqueta"];

        $sql = "select * from etiquetas where id = '$id_etiqueta'";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
    }
    $mensaje = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_usuario = $_SESSION['id'];
        $etiqueta = $_POST['etiqueta'];

        if(empty($etiqueta)){
            $error = "no se puede crear la etiqueta sin un nombre";
        }

        if(empty($error)){
            $sql = "INSERT INTO etiquetas (nombre, id_usuario) VALUES ('$etiqueta', $id_usuario)";

            $stmt = $conexion->prepare($sql);
            if ($stmt->execute()) {
                $mensaje="etiqueta creada";
            } else {
                $mensaje="error al crear la etiqueta";
            }

            if (isset($_POST['eliminar'])) {
                $sql = "DELETE FROM etiquetas WHERE id_etiqueta = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $id_etiqueta);
                if ($stmt->execute()) {
                    $mensaje="etiqueta eliminada";
                } else {
                    $mensaje="error al eliminar";
                }
            }
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../frontend/style.css">
    <title>Etiquetas</title>
</head>
<body >
    <div class="container_etiquetas">
        <h1>Crear Etiquetas</h1>
        <form action="" method="post" class="form_crear_etiqueta">
            <input type="hidden" name="id_etiqueta" value='<?=$_POST['id_etiqueta'];?>'>
            <input type="text" name="etiqueta" placeholder="crea tu etiqueta">
            <button type="submit">crear</button>

            <?php
                
                
            ?>
            <?=$mensaje;?>
        </form>

        <div class="mostrar_etiquetas">
            <h1>etiquetas creadas</h1>
            <div class="etiquetas">
                <?php
                    $sql = "SELECT nombre FROM etiquetas";
                    $resultado = mysqli_query($conexion, $sql);
                    if ($resultado ->num_rows > 0) { 
                        while($row = $resultado->fetch_assoc()) {
                            echo "<div class='etiqueta_individual'>".$row['nombre']."</div>";
                        }
                    } else {
                        echo "no hay etiquetas";
                    }
                ?>    
            </div>
            
        </div>
    </div>
</body>
</html>