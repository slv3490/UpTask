<?php

namespace Model;

class Usuarios extends ActiveRecord{
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->password2 = $args["password2"] ?? null;
        $this->password_actual = $args["password_actual"] ?? null;
        $this->password_nuevo = $args["password_nuevo"] ?? null;
        $this->token = $args["token"] ?? "";
        $this->confirmado = $args["confirmado"] ?? 0;
    }

    public function validarCuentaNueva() {
        if(!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        } else if(strlen($this->password) < 6) {
            self::$alertas["error"][] = "El password debe contener almenos 6 caracteres";
        }
        if($this->password !== $this->password2) {
            self::$alertas["error"][] = "Los passwords deben ser iguales";
        }

        return self::$alertas;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        } else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "El formato del email no es valido";
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        } else if(strlen($this->password) < 6) {
            self::$alertas["error"][] = "El password debe contener almenos 6 caracteres";
        }

        return self::$alertas;
    }

    public function nuevoPassword() {

        if(!$this->password_actual) {
            self::$alertas["error"][] = "El password actual no puede ir vacio";
        }

        if(!$this->password_nuevo) {
            self::$alertas["error"][] = "El password nuevo no puede ir vacio";
        } else if(strlen($this->password_nuevo) < 6) {
            self::$alertas["error"][] = "El password debe contener almenos 6 caracteres";
        }

        return self::$alertas;
    }

    public function validarUsuario() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        } else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "El formato del email no es valido";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        } else if(strlen($this->password) < 6) {
            self::$alertas["error"][] = "El password debe contener almenos 6 caracteres";
        }
        return self::$alertas;
    }
    
    public function validarPerfil() {
        if(!trim($this->nombre)) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }

        return self::$alertas;
    }

    public function comprobarPassword() {
        return password_verify($this->password_actual, $this->password);
    }
}