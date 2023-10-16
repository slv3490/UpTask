
<div class="contenedor login">
    
    <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesion</p>

        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form class="formulario" action="/" method="post">
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" placeholder="Tu Email">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu Password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesion">
        </form>
        
        <div class="acciones">
            <a href="/crear">¿Aun no tienes una cuenta? Crear Cuenta</a>   
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>

    </div> <!--Contenedor-sm-->
</div>