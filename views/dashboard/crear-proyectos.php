<?php include_once __DIR__ . "/header-crear-proyectos.php"; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

    <form class="formulario" method="post" action="/crear-proyectos">

        <?php include_once __DIR__ . "/formulario-proyectos.php"; ?>

        <input type="submit" value="Crear Proyecto">
    </form>
</div>


<?php include_once __DIR__ . "/footer-crear-proyectos.php"; ?>