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
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <title>Etiquetas</title>
</head>
<body >
    <?php include("includes/header.php");?>
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
    
    <?php include("includes/footer.php");?>
</body>
</html>