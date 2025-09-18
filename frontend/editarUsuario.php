<?php
    require_once "../backend/conexion.php";
    if (isset($_POST['id'])) {
        $id_usuarios = $_POST['id'];

        // Buscamos la tarea en la BD
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuarios);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuarios = $resultado->fetch_assoc();
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar usuario</h1>
    <form action="../backend/editarUsuario.php" method="post">
        <input type="hidden" name="id" value="<?=$usuarios['id']?>">

        <label for="">nombre</label>
        <input type="text" value="<?=$usuarios['nombre']?>" name="nombre">
        <label for="">Correo</label>
        <input type="text" value="<?=$usuarios['correo']?>" name="correo">
        <label for="">rol</label>
        <select name="roles" id="rol">
            <option value="<?=$usuarios['rol']?>"><?=$usuarios['rol']?></option>
            <option value="admin">Administrador</option>
            <option value="usuario">Usuario</option>
        </select>
        <button type="submit">editar</button>
    </form>

</body>
</html>