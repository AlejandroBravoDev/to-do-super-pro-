<?php
    require_once "backend/login.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="frontend/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <form  method="post">
        <h1>Inicio de sesion</h1>
        <label for="">Correo Electronico</label>
        <?=$error_correo?>
        <input type="text" name="correo" placeholder="Correo electronico">
        
        <label for="">Contraseña</label>
        <?=$error_contrasena?>
        <input type="password" name="contrasena" placeholder="contraseña">

        <button type="submit">Iniciar sesion</button>
        <div class="links">
            <a href="frontend/register.php">¿no tienes cuenta?, registrate</a>
        </div>
    </form>
</body>
</html>