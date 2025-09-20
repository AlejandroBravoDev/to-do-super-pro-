<header class="header">
    <div class="logo">
        <h2>To Do <span style="color:#0984e3;">Super Pro</span></h2>
    </div>
    <nav class="nav">
        <ul>
            <?php
                $sql = "SELECT * FROM usuarios WHERE id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $_SESSION["id"]);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $usuario = $resultado->fetch_assoc();
                if ($usuario && $usuario["rol"] === "admin") {
                    echo '<li><a href="../frontend/interfazAdmin.php" class="vinculos">Administrar Usuarios</a></li>';
                }
            ?>
            <li><a href="interfaz.php" class="vinculos">Inicio</a></li>
            <li><a href="proyectos.php" class="vinculos">Proyectos</a></li>
            <li><a href="perfil.php" class="vinculos">Mi Perfil</a></li>

            <?php if (isset($_SESSION["id"])): ?>
               
                <li><a href="../backend/logout.php" class="btn-salir">Cerrar sesion</a></li>
            <?php else: ?>
                
                <li><a href="../index.php" class="btn-login">Iniciar sesión</a></li>
                <li><a href="register.php" class="btn-register">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>