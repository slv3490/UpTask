<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuarios;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();

        $id = $_SESSION["id"];

        $proyectos = Proyecto::belongsTo("propietarioId", $id);

        $router->render("dashboard/index", [
            "titulo" => "Proyectos",
            "proyectos" => $proyectos
        ]);
    }

    public static function crear_proyectos(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $proyecto = new Proyecto($_POST);

            //Validacion
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)) {
                //Generar una url unica
                $proyecto->url = md5(uniqid());
                //Almacenar el creador de proyectos
                $proyecto->propietarioId = $_SESSION["id"];
                //Guardar el proyecto
                $proyecto->guardar();
                header("location: /proyecto?id=" . $proyecto->url);
            }
        }

        $router->render("dashboard/crear-proyectos", [
            "titulo" => "Crear Proyecto",
            "alertas" => $alertas
        ]);
    }

    public static function proyecto(Router $router) {
        session_start();
        isAuth();

        $url = $_GET["id"];
        if(!$url) header("location: /dashboard");
        //Revisar que el usuario quien creo el proyecto sea el propietario
        $usuario = Proyecto::where("url", $url);

        if($usuario->propietarioId !== $_SESSION["id"]) {
            header("location: /dashboard");
        }

        $router->render("dashboard/proyecto", [
            "titulo" => $usuario->proyecto
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuarios::find($_SESSION["id"]);

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if(empty($alertas)) {

                $existeUsuario = Usuarios::where("email", $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    Usuarios::setAlerta("error", "Usuario ya registrado");
                } else {
                    //Guardar el usuario
                    $usuario->guardar();
                    Usuarios::setAlerta("exito", "Guardado Correctamente");
        
                    //Asignar el nombre nuevo a la barra
                    $_SESSION["nombre"] = $usuario->nombre;
                }
                
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render("dashboard/perfil", [
            "titulo" => "Perfil",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = Usuarios::find($_SESSION["id"]);
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevoPassword();

            if(empty($alertas)) {
                //Comprobar que el password actual sea correcto
                $resultado = $usuario->comprobarPassword();

                if($resultado) {
                    //Guardar el password nuevo
                    $usuario->password = $usuario->password_nuevo;

                    $usuario->hashPassword();

                    $usuario->guardar();

                    Usuarios::setAlerta("exito", "Datos guardados correctamente.");
                } else {
                    Usuarios::setAlerta("error", "El password es incorrecto");
                }

            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render("dashboard/cambiarPassword", [
            "titulo" => "Cambiar Password",
            "alertas" => $alertas
        ]);
    }

}