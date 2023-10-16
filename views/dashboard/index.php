<?php include_once __DIR__ . "/header-crear-proyectos.php"; ?>

    <?php if(count($proyectos) === 0) { ?>
        
        <p class="no-proyectos">Todavia no tienes ningun proyecto. <a href="/crear-proyectos">Comienza creando uno</a></p>
    <?php } else { ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) : ?>
                <li class="proyecto">
                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                        <?php echo $proyecto->proyecto; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__ . "/footer-crear-proyectos.php"; ?>