<div class="sidebar">
    <div class="contenedor-sidebar">
        <h2>UpTask</h2>
        
        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="Imagen Cerrar Menu">
        </div>
    </div>

    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === "Proyectos") ? "activo" : ""; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === "Crear Proyecto") ? "activo" : ""; ?>" href="/crear-proyectos">Crear Proyecto</a>
        <a class="<?php echo ($titulo === "Perfil") ? "activo" : ""; ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesion</a>
    </div>

</div>