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