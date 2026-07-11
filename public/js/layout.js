document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");

    const toggle = document.getElementById("toggleSidebar");

    if (!sidebar || !toggle) return;

    const estado = localStorage.getItem("sidebar");

    if (estado === "collapsed") {

        sidebar.classList.add("collapsed");

    }

    toggle.addEventListener("click", function () {

        sidebar.classList.toggle("collapsed");

        if (sidebar.classList.contains("collapsed")) {

            localStorage.setItem("sidebar", "collapsed");

        } else {

            localStorage.setItem("sidebar", "expanded");

        }

    });

});
document.addEventListener("DOMContentLoaded", function () {

    const botonVista = document.getElementById("btnVistaPrevia");

    const contenedor = document.getElementById("contenedorVistaPrevia");

    if (!botonVista || !contenedor) return;

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

