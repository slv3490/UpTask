<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;
use MVC\Router;

class TareaController {
    public static function index() {
        session_start();

        $url = $_GET["id"];
        $proyecto = Proyecto::where("url", $url);

        if(!$url || $proyecto->url !== $url) header("Location: /dashboard");

        $tareas = Tarea::belongsTo("proyectoId", $proyecto->id);

        if($proyecto->propietarioId !== $_SESSION["id"]) header("location: /dashboard");

        $tareas = ["tareas" => $tareas];

        echo json_encode($tareas);
        
    }
    public static function crear() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();

            $proyectoId = $_POST["proyectoId"];
            $proyecto = Proyecto::where("url", $proyectoId);
            
            if(!$proyecto || $_SESSION["id"] !== $proyecto->propietarioId) {

                $alerta = [
                    "mensaje" => "Hubo un error al crear la tarea.",
                    "tipo" => "error"
                ];
                echo json_encode($alerta);

                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                "tipo" => "exito",
                "id" => $resultado["id"],
                "mensaje" => "Tarea creada correctamente.",
                "proyectoId" => $tarea->proyectoId
            ];
            echo json_encode($respuesta);
            
        }
    }
    public static function actualizar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $proyecto = Proyecto::where("url", $_POST["proyectoId"]);

            session_start();

            if(!$proyecto || $_SESSION["id"] !== $proyecto->propietarioId) {
                $alerta = [
                    "mensaje" => "Hubo un error al crear la tarea.",
                    "tipo" => "error"
                ];
                echo json_encode($alerta);

                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            if($resultado) {
                $respuesta = [
                    "tipo" => "exito",
                    "id" => $tarea->id,
                    "proyectoId" => $tarea->proyectoId
                ];
                echo json_encode(["respuesta" => $respuesta]);
            }


        }
    }
    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();

            $proyectoId = $_POST["proyectoId"];
            $proyecto = Proyecto::where("url", $proyectoId);
            
            if(!$proyecto || $_SESSION["id"] !== $proyecto->propietarioId) {

                $alerta = [
                    "mensaje" => "Hubo un error al crear la tarea.",
                    "tipo" => "error"
                ];
                echo json_encode($alerta);

                return;
            }

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();

            echo json_encode($resultado);
        }
    }


}