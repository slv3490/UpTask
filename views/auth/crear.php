<div class="contenedor crear">
    
    <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crear Cuenta</p>

        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form class="formulario" action="/crear" method="post">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="nombre" id="nombre" name="nombre" value="<?php echo $usuario->nombre ?>" placeholder="Tu Nombre">
            </div>

            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" value="<?php echo $usuario->email ?>" placeholder="Tu Email">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu Password">
            </div>

            <div class="campo">
                <label for="password2">Repetir tu Password</label>
                <input type="password" id="password2" name="password2" placeholder="Tu repite Password">
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Session</a>
            
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>

    </div> <!--Contenedor-sm-->
</div>