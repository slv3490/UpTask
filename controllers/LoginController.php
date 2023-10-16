<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuarios;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = new Usuarios($_POST);
            
            $alertas = $usuario->validarUsuario();

            if(empty($alertas)) {
                //verificar que el usuario exista
                $usuario = Usuarios::where("email", $usuario->email);

                if($usuario || $usuario->confirmado) {
                    //verificar la contraseña
                    $password = password_verify($_POST["password"], $usuario->password);

                    if($password) {
                        //iniciar la session
                        session_start();

                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        header("location: /dashboard");
                    } else {
                        Usuarios::setAlerta("error", "Password Incorrecto");
                    }

                } else {
                    Usuarios::setAlerta("error", "El usuario no existe");
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render("auth/login", [
            "titulo" => "Iniciar Session",
            "alertas" => $alertas
        ]);
    }
    public static function logout() {
        session_start();
        $_SESSION = [];
        header("location: /");
    }
    public static function crear(Router $router) {

        $usuario = new Usuarios;
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCuentaNueva();

            if(empty($alertas)) {
                $existeUsuario = Usuarios::where("email", $usuario->email);

                if($existeUsuario) {
                    Usuarios::setAlerta("error", "El usuario ya esta registrado");
                    $alertas = Usuarios::getAlertas();
                } else {
                    //Hashear el password
                    $usuario->hashPassword();

                    //Eliminar el password2
                    unset($usuario->password2);

                    //Generar el token
                    $usuario->crearToken();

                    //Crear un nuevo usuario
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header("location: /mensaje");
                    }
                }
            }
        }
        $router->render("auth/crear", [
            "titulo" => "Crear Cuenta",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }
    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = new Usuarios($_POST);
            $alertas = $usuario->validarEmail();
            if(empty($alertas)) {
                $usuario = Usuarios::where("email", $usuario->email);
                if($usuario && $usuario->confirmado) {
                    //Crear un token nuevo
                    $usuario->crearToken();
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    //Mensaje de alerta
                    Usuarios::setAlerta("exito", "Hemos enviado las instrucciones a tu mail");

                } else {
                    Usuarios::setAlerta("error", "El usuario no existe o no esta confirmado");
                }
                $alertas = Usuarios::getAlertas();
            }
        }
        
        $router->render("auth/olvide", [
            "titulo" => "Recuperar Password",
            "alertas" => $alertas
        ]);
    }
    public static function reestablecer(Router $router) {

        $alertas = [];
        $token = s($_GET["token"]);

        if(!$token) header("Location: /");
        
        $usuario = Usuarios::where("token", $token);
        $mostrar = true;

        if(empty($usuario)) {
            Usuarios::setAlerta("error", "Token no valido");
            $mostrar = false;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                $usuario->token = null;

                unset($usuario->password2);
                
                $usuario->hashPassword();
                
                $resultado = $usuario->guardar();
                if($resultado) {
                    header("location: /");
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render("auth/reestablecer", [
            "alertas" => $alertas,
            "mostrar" => $mostrar
        ]);
    }
    public static function mensaje(Router $router) {
        $router->render("auth/mensaje", [

        ]);
    }
    public static function confirmar(Router $router) {

        $alertas = [];
        $token = s($_GET["token"]);

        if(!$token) header("Location: /");

        $usuario = Usuarios::where("token", $token);
        if($usuario) {
            $usuario->token = null;
            $usuario->confirmado = 1;
            //Eliminar el password2
            unset($usuario->password2);
    
            $usuario->guardar();

            Usuarios::setAlerta("exito", "cuenta comprobada correctamente");
        } else {
            Usuarios::setAlerta("error", "Token no válido");
        }

        $alertas = Usuarios::getAlertas();

        $router->render("auth/confirmar", [
            "alertas" => $alertas
        ]);
    }
}