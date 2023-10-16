const menu = document.querySelector("#mobile-menu");
const cerrarMenu = document.querySelector("#cerrar-menu");
const sidebar = document.querySelector(".sidebar");

if(menu) {
    menu.addEventListener("click", function() {
        sidebar.classList.add("mostrar")
    })
}

if(cerrarMenu) {
    cerrarMenu.addEventListener("click", function() {
        sidebar.classList.add("ocultar");
        setTimeout(() => {
            sidebar.classList.remove("mostrar");
            sidebar.classList.remove("ocultar");
        }, 500);
    })
}

//Elimina la clase de mostrar en un tamaño de tablet 


window.addEventListener("resize", function() {
    const anchoPantalla = document.body.clientWidth;
    if(anchoPantalla >= 768) {
        sidebar.classList.remove("mostrar");
    }
})