<?php
    require_once '../backend/action-register.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>nintengames - Register</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    <main class="login">
        <form  method="post" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre" required />
            <input type="email" name="correo" placeholder="Correo Electrónico" required />
            <input type="password" name="clave" placeholder="Contraseña" required />
            
            <select name="rol" required>
                <option value="usuario">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
            
            <input type="file" name="avatar" accept="image/*" />
            
            <button type="submit">Registrar</button>
        </form>
    </main>
</body>
</html>
