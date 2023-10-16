<?php include_once __DIR__ . "/header-crear-proyectos.php"; ?>

<div class="contenido-sm">
    <div class="contenedor-nueva-tarea">
        <button type="button" class="agregar-tarea" id="agregar-tarea">&#43; Nueva Tarea</button>
    </div>

    <div class="filtros" id="filtros">
        <div class="filtros-inputs">
            <h2>Filtros:</h2>
            <div class="campo">
                <label for="todos">Todos</label>
                <input type="radio" id="todos" name="filtro" value="" checked>
            </div>
            <div class="campo">
                <label for="completadas">Completadas</label>
                <input type="radio" id="completadas" name="filtro" value="1">
            </div>
            <div class="campo">
                <label for="pendientes">Pendientes</label>
                <input type="radio" id="pendientes" name="filtro" value="0">
            </div>
        </div>
    </div>

    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>

<?php include_once __DIR__ . "/footer-crear-proyectos.php"; ?>

<?php 
    $script .= '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="build/js/tareas.js"></script>
    ';
?>