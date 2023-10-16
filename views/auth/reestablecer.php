
<div class="contenedor reestablecer">
    
    <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Reestablecer Password</p>

        <?php 
            include_once __DIR__ . "/../templates/alertas.php";

            if($mostrar) :
        ?>

        <form class="formulario" method="post">
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu Password">
            </div>

            <input type="submit" class="boton" value="Guardar Password">
        </form>

        <?php endif; ?>

        <div class="acciones">
            <a href="/crear">¿Aun no tienes una cuenta? Crear Cuenta</a>   
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>

    </div> <!--Contenedor-sm-->
</div>