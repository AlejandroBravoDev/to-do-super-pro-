<?php
    require_once "../backend/login.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>inicio de sesion</h1>
    <form  method="post">
        <label for="">Correo Electronico</label>
        <?=$error_correo?>
        <input type="text" name="correo" placeholder="Correo electronico">
        
        <label for="">Contraseña</label>
        <?=$error_contrasena?>
        <input type="text" name="contrasena" placeholder="contraseña">

        <button type="submit">Iniciar sesion</button>
    </form>
</body>
</html>