<?php
    require_once "../backend/recuperar_contrasena.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recuperar contraseña</title>
    <link rel="stylesheet" href="../frontend/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
</head>
<body>
    <div class="contenedor-recuperar">
        <h1>Recuperar Contraseña</h1>
        <form action="" method="POST">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            <br>
            <?=$mensaje?>
            <br>
            <button type="submit">Enviar</button>
        </form>

        
    </div>
</body>
</html>