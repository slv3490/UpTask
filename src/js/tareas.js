(function () {

    obtenerTareas();
    let tareas = [];
    let filtradas = [];

    const boton = document.querySelector("#agregar-tarea");
    boton.addEventListener("click", () => {
        mostrarFormulario();
    });
    
    //Filtros de busqueda
    const filtros = document.querySelectorAll("#filtros input[type='radio']");
    filtros.forEach(radio => {
        radio.addEventListener("input", filtrarTareas);
    })

    function filtrarTareas(e) {
        const filtro = e.target.value;

        if(filtro !== "") {
            filtradas = tareas.filter(tarea => tarea.estado === filtro);
        } else {
            filtradas = [];
        }

        mostrarTareas();

    }

    async function obtenerTareas() {
        try {
            const id = obtenerProyecto();
            const url = `/api/tareas?id=${id}`;

            const resultado = await fetch(url);
            const respuesta = await resultado.json();

            tareas = respuesta.tareas;

            mostrarTareas();

        } catch (error) {
            console.log(error)
        }
    }

    const estado = {
        0: "Pendiente",
        1: "Completado"
    }

    function mostrarTareas() {
        limpiarTareas();
        totalPendientes();
        totalCompletadas();

        const arraytareas = filtradas.length ? filtradas : tareas;

        if(arraytareas.length === 0) {
            const contenedorTareas = document.querySelector("#listado-tareas");

            const textoNoTareas = document.createElement("LI");
            textoNoTareas.textContent = "No hay tareas";
            textoNoTareas.classList.add("no-tareas");

            contenedorTareas.appendChild(textoNoTareas);
            return;
        }

        arraytareas.forEach(tarea => {
            const lista = document.createElement("LI");
            lista.dataset.tareaId = tarea.id;
            lista.classList.add("tarea");

            const nombreTarea = document.createElement("P");
            nombreTarea.textContent = tarea.nombre
            nombreTarea.ondblclick = () => {
                mostrarFormulario({...tarea});
            }

            const opcionesDiv = document.createElement("DIV");
            opcionesDiv.classList.add("opciones");

            //Botones
            const btnEstadoTarea = document.createElement("BUTTON");
            btnEstadoTarea.classList.add("estado-tarea", `${estado[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estado[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;
            btnEstadoTarea.ondblclick = function() {
                cambiarEstadoTarea({...tarea});
            }

            const btnEliminarTarea = document.createElement("BUTTON");
            btnEliminarTarea.classList.add("eliminar-tarea");
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = "Eliminar";
            btnEliminarTarea.ondblclick = function() {
                confirmarEliminarTarea({...tarea});
            }

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            lista.appendChild(nombreTarea);
            lista.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector("#listado-tareas");
            listadoTareas.appendChild(lista);
        })
    }

    function totalPendientes() {
        const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
        const pendientesRadio = document.querySelector("#pendientes");

        if(totalPendientes.length === 0) {
            pendientesRadio.disabled = true;
        } else {
            pendientesRadio.disabled = false;
        }
    }

    function totalCompletadas() {
        const totalCompletadas = tareas.filter(tarea => tarea.estado === "1");
        const pendientesRadio = document.querySelector("#completadas");

        if(totalCompletadas.length === 0) {
            pendientesRadio.disabled = true;
        } else {
            pendientesRadio.disabled = false;
        }
    }

    function mostrarFormulario(editar = false) {

        const modal = document.createElement("DIV");
        modal.classList.add("modal");
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? "Editar tarea" : "Añade una nueva tarea"}</legend>
                <div class="campo">
                    <label>Tarea</label>
                    <input 
                    type="text" 
                    name="tarea" 
                    id="tarea" 
                    placeholder="${editar ? "Editar Proyecto" : 'Añadir tarea al proyecto actual' }"
                    value= "${editar ? editar.nombre : '' }"
                    />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="${editar ? "Actualizar Tarea" : 'Añadir Tarea' }" />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `
        setTimeout(() => {
            const formulario = document.querySelector(".formulario");
            formulario.classList.add("animar");
        }, 0);

        modal.addEventListener("click", function(e) {
            e.preventDefault();

            if(e.target.classList.contains("cerrar-modal")) {
                const formulario = document.querySelector(".formulario");
                formulario.classList.add("cerrar");
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            if(e.target.classList.contains("submit-nueva-tarea")) {
                const nombreTarea = document.querySelector("#tarea").value.trim();

                if(nombreTarea === "") {

                    const referencia = document.querySelector(".formulario legend");

                    mostrarAlerta("El nombre de la tarea es obligatorio", "error", referencia);

                    return;
                }
                if(editar) {
                    editar.nombre = nombreTarea;
                    actualizarTarea(editar);
                } else {
                    agregarTarea(nombreTarea);
                }
            }
        })

        document.querySelector(".dashboard").appendChild(modal);
    }


    function mostrarAlerta(mensaje, tipo, referencia) {
        //Prevenir que aparezcan multiples alertas
        const alertaPrevia = document.querySelector(".alertas");
        if(alertaPrevia) {
            alertaPrevia.remove();
        }

        const alerta = document.createElement("DIV");
        alerta.classList.add("alertas", tipo);
        alerta.textContent = mensaje;

        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        //Eliminar la alerta despues de 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 4000);
    }

    //Consultar el servidor para añadir una nueva tarea al proyecto actual
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

    function cambiarEstadoTarea(tarea) {
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;

        actualizarTarea(tarea);
    }

    async function actualizarTarea(tarea) {

        const {estado, id, nombre, proyectoId} = tarea;

        const datos = new FormData();
        datos.append("id", id);
        datos.append("estado", estado);
        datos.append("nombre", nombre);
        datos.append("proyectoId", obtenerProyecto());

        try {
            const url = "/api/tareas/actualizar";
            const respuesta = await fetch(url, {
                method: "POST",
                body: datos
            })
            const resultado = await respuesta.json();

            if(resultado.respuesta.tipo === "exito") {

                const modal = document.querySelector(".modal");
                if(modal) {
                    Swal.fire(
                        "¡Actualizado!",
                        "Has actualizado el nombre",
                        "success"
                    )
                    modal.remove();
                }

                tareas = tareas.map(tareaMemoria => {
                    if(tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }
                    return tareaMemoria;

                })
                mostrarTareas();

            }

        } catch (error) {
            console.log(error);
        }
    }

    async function confirmarEliminarTarea(tarea) {
        Swal.fire({
            title: '¿Eliminar Tarea?',
            showCancelButton: true,
            confirmButtonText: 'Si',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            }
        })
    }

    async function eliminarTarea(tarea) {
        const {estado, id, nombre} = tarea;

        const datos = new FormData();
        datos.append("id", id);
        datos.append("estado", estado);
        datos.append("nombre", nombre);
        datos.append("proyectoId", obtenerProyecto());

        try {
            const url = "/api/tareas/eliminar";
            const respuesta = await fetch(url, {
                method: "POST",
                body: datos
            })

            const resultado = await respuesta.json();

            if(resultado) {
                Swal.fire("¡Eliminado!", "Eliminado Correctamente", "success");

                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== id);
                mostrarTareas();

            }

        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

    function limpiarTareas() {
        const listadoTareas = document.querySelector("#listado-tareas");

        while(listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }

})()