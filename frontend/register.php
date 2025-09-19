<?php
    require_once '../backend/action-register.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <aside class="aside_register">
        <form method="post" enctype="multipart/form-data" class="form_register">
            <h1>Registrate</h1>
            <input type="text" name="nombre" placeholder="Nombre" required class="input_nombre input_register" />
            <input type="email" name="correo" placeholder="Correo Electrónico" class="input_email input_register" required />
            <input type="password" name="clave" placeholder="Contraseña" class="input_contrasena input_register" required />
            
            <select name="rol" clcass="input_rol input_register"required>
                <option value="usuario">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
            
            <input type="file" name="avatar" accept="image/*" class="input_imagen input_register"/>
            
            <button type="submit" class="button_register">Registrar</button>
            <div class="links">
                <a href="../index.php">Inicie sesion</a>
            </div>
        </form>
    </aside>
</body>
</html>
