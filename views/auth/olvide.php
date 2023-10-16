<div class="contenedor olvide">
    
    <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu cuenta de UpTask</p>

        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form class="formulario" action="/olvide" method="post">
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" placeholder="Tu Email">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesion">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Session</a>   
            <a href="/crear">¿Aun no tienes una cuenta? Crear Cuenta</a>
        </div>

    </div> <!--Contenedor-sm-->
</div>