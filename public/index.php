<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

//Login
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);
$router->get("/logout", [LoginController::class, "logout"]);

//Crear
$router->get("/crear", [LoginController::class, "crear"]);
$router->post("/crear", [LoginController::class, "crear"]);

//Formulario de olvide mi password
$router->get("/olvide", [LoginController::class, "olvide"]);
$router->post("/olvide", [LoginController::class, "olvide"]);

//Reestablecer
$router->get("/reestablecer", [LoginController::class, "reestablecer"]);
$router->post("/reestablecer", [LoginController::class, "reestablecer"]);

//Confirmacion de cuenta
$router->get("/mensaje", [LoginController::class, "mensaje"]);
$router->get("/confirmar", [LoginController::class, "confirmar"]);


//Zona de proyectos
$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/crear-proyectos", [DashboardController::class, "crear_proyectos"]);
$router->post("/crear-proyectos", [DashboardController::class, "crear_proyectos"]);
$router->get("/proyecto", [DashboardController::class, "proyecto"]);   
$router->get("/perfil", [DashboardController::class, "perfil"]);
$router->post("/perfil", [DashboardController::class, "perfil"]);
$router->get("/cambiar-password", [DashboardController::class, "cambiar_password"]);
$router->post("/cambiar-password", [DashboardController::class, "cambiar_password"]);

//Api para las tareas
$router->get("/api/tareas", [TareaController::class, "index"]);
$router->post("/api/tareas", [TareaController::class, "crear"]);
$router->post("/api/tareas/actualizar", [TareaController::class, "actualizar"]);
$router->post("/api/tareas/eliminar", [TareaController::class, "eliminar"]);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();