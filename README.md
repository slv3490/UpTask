# Sobre el proyecto UpTask 📑
Es un proyecto tipo lista en el cual se puede especificar proyectos junto a sus respectivas tareas donde poder marcar estas como pendientes o completadas, ademas de tambien poder actualizar su nombre y eliminarlas.
## Funcionalidades
- Validación para todas las funcionalidades relacionadas al back-end
- Login
- Creacion de usuarios
- Recuperar password mediante el email
- Filtro por tareas pendientes y/o completadas
- Actualización de perfil

## Instalacíon
#### Dependencias
Para instalar las dependencias se debera escribir los siguientes comandos

`npm install`

`composer install`

#### Base de datos
Este proyecto cuenta con una base de datos por lo que se debera cambiar las variables de entorno de la misma que se encuentran en la carpeta **includes/database.php**. 

Las **tablas** y **columnas** se encontraran en la carpeta de modelos.


###### Proyecto
    protected static $tabla = "proyectos";
    protected static $columnasDB = ["id", "proyecto", "url", "propietarioId"];
###### Tarea
    protected static $tabla = "tareas";
    protected static $columnasDB = ["id", "nombre", "estado", "proyectoId"];
###### Usuarios
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

#### Email
Este proyecto cuenta con envíos de emails por medio de **PHPMailer** por lo que se deberá cambíar las variables de entorno dentro de la carpeta **classes/Email.php** para que la creación y recuperación de la cuenta de usuarios funcionen correctamente.

## Estructura

#### Consulta el servidor para añadir una nueva tarea al proyecto actual
###### JavaScript
````
    async function agregarTarea(tarea) {
        const datos = new FormData();
        datos.append("nombre", tarea);
        datos.append("proyectoId", obtenerProyecto());

        try {
            const url = "/api/tareas";
            const respuesta = await fetch(url, {
                method: "POST",
                body: datos
            });

            const resultado = await respuesta.json();
            
            const referencia = document.querySelector(".formulario legend");

            mostrarAlerta(resultado.mensaje, resultado.tipo, referencia);

            if(resultado.tipo === "exito") {
                const modal = document.querySelector(".modal");
                setTimeout(() => {
                    modal.remove();
                }, 1500);


                const arrayObj = {
                    id: String(resultado.id),
                    estado: "0",
                    nombre: tarea,
                    proyectoId: resultado.proyectoId
                }

                tareas = [...tareas, arrayObj];

                mostrarTareas()
            }

        } catch (error) {
            console.log(error);
        }

    }
````
#### Su controllador:
###### Php
````
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
````

## 🛠 Skills
**Html, Css, Javascript, Php y MySQL**

## 🔗 Links
[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://github.com/slv3490/Portfolio) (En Proceso)

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/leonel-silvera-5a9a75286/)

[![gmail](https://img.shields.io/badge/gmail-EA4335?style=for-the-badge&logo=gmail&logoColor=white)](https://mail.google.com/mail/u/0/?tab=rm&ogbl#search/leonelsilvera9%40gmail.com)

## Conclusión
Este es mi proyecto favorito ya que me ayudo a reforzar conceptos y tener una mejor comprensión de la lógica de programacion.
