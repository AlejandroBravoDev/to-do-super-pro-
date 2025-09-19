<header class="header">
    <div class="logo">
        <h2>To-Do Super Pro</h2>
    </div>
    <nav class="nav">
        <ul>
            <li><a href="interfaz.php" class="vinculos">Inicio</a></li>
            <li><a href="proyectos.php" class="vinculos">Proyectos</a></li>
            <li><a href="tareas.php" class="vinculos">Tareas</a></li>
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