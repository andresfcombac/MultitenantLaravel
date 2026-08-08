document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");
    const toggle = document.getElementById("toggleSidebar");

    if (!sidebar || !toggle) {
        return;
    }

    /*
     * Overlay para móviles.
     */
    let overlay = document.querySelector(".sidebar-overlay");

    if (!overlay) {
        overlay = document.createElement("div");
        overlay.className = "sidebar-overlay";
        document.body.appendChild(overlay);
    }


    /*
     * Detectar si estamos en móvil.
     */
    function esMovil() {
        return window.innerWidth <= 767.98;
    }


    /*
     * Estado inicial.
     */
    function configurarSidebar() {

        if (esMovil()) {

            /*
             * En móvil siempre iniciamos cerrado.
             */
            sidebar.classList.remove("collapsed");
            sidebar.classList.remove("mobile-open");

            overlay.classList.remove("active");

        } else {

            /*
             * En escritorio usamos el estado guardado.
             */
            const estado = localStorage.getItem("sidebar");

            sidebar.classList.remove("mobile-open");
            overlay.classList.remove("active");

            if (estado === "collapsed") {

                sidebar.classList.add("collapsed");

            } else {

                sidebar.classList.remove("collapsed");
            }
        }
    }


    configurarSidebar();


    /*
     * Botón principal del sidebar.
     */
    toggle.addEventListener("click", function () {

        if (esMovil()) {

            /*
             * MÓVIL:
             * abrir/cerrar sidebar como panel lateral.
             */
            const abierto =
                sidebar.classList.toggle("mobile-open");

            if (abierto) {

                overlay.classList.add("active");

            } else {

                overlay.classList.remove("active");
            }

        } else {

            /*
             * ESCRITORIO:
             * comportamiento original.
             */
            sidebar.classList.toggle("collapsed");

            if (sidebar.classList.contains("collapsed")) {

                localStorage.setItem("sidebar", "collapsed");

            } else {

                localStorage.setItem("sidebar", "expanded");
            }
        }
    });


    /*
     * Cerrar haciendo clic fuera del sidebar.
     */
    overlay.addEventListener("click", function () {

        if (esMovil()) {

            sidebar.classList.remove("mobile-open");
            overlay.classList.remove("active");
        }
    });


    /*
     * Cerrar con Escape.
     */
    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape" && esMovil()) {

            sidebar.classList.remove("mobile-open");
            overlay.classList.remove("active");
        }
    });


    /*
     * Cuando cambia el tamaño de la ventana:
     * pasar correctamente entre móvil y escritorio.
     */
    window.addEventListener("resize", function () {

        configurarSidebar();
    });

});


/*
 * Vista previa de formularios.
 */
document.addEventListener("DOMContentLoaded", function () {

    const botonVista =
        document.getElementById("btnVistaPrevia");

    const contenedor =
        document.getElementById("contenedorVistaPrevia");

    if (!botonVista || !contenedor) {
        return;
    }

    botonVista.addEventListener("click", function () {

        if (contenedor.style.display === "none") {

            contenedor.style.display = "block";

            botonVista.innerHTML =
                '<i class="fa-solid fa-eye-slash me-2"></i>Ocultar vista previa';

        } else {

            contenedor.style.display = "none";

            botonVista.innerHTML =
                '<i class="fa-solid fa-eye me-2"></i>Mostrar vista previa';
        }

    });

});