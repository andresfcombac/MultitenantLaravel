/*
 * Cierre de sesión por inactividad.
 *
 * No existía ningún control de inactividad visible para el usuario:
 * Laravel solo expira la sesión en el servidor según SESSION_LIFETIME
 * (config/session.php), pero sin avisar ni cerrar sesión de forma
 * proactiva en el navegador. Este script:
 *
 *  1. Sigue la actividad del usuario (mouse, teclado, scroll, touch).
 *  2. Un par de minutos antes de que la sesión expire, muestra un
 *     aviso (SweetAlert2, ya cargado en el layout) con la opción de
 *     seguir conectado.
 *  3. Si el usuario no responde, cierra la sesión automáticamente
 *     enviando el mismo formulario de "Cerrar sesión" que ya existe
 *     en el layout (con su token CSRF), evitando así duplicar lógica
 *     de logout.
 *
 * Es un script aditivo: si falta algún elemento esperado, no hace
 * nada y el resto de la aplicación sigue funcionando igual.
 */

document.addEventListener("DOMContentLoaded", function () {

    const cuerpo = document.body;
    const formLogout = document.getElementById("formCerrarSesion");

    if (!cuerpo || !formLogout) {
        return;
    }

    const minutos = parseInt(cuerpo.dataset.sessionLifetime, 10);

    if (!minutos || minutos <= 0) {
        return;
    }

    const TIEMPO_VIDA_MS = minutos * 60 * 1000;

    // Avisar 2 minutos antes de expirar (o a la mitad del tiempo si la
    // sesión es muy corta, para no mostrar el aviso de inmediato).
    const AVISO_ANTES_MS = Math.min(2 * 60 * 1000, TIEMPO_VIDA_MS / 2);

    let ultimaActividad = Date.now();
    let avisoMostrado = false;
    let temporizadorCierre = null;

    function cerrarSesionPorInactividad() {
        formLogout.submit();
    }

    function seguirConectado() {

        ultimaActividad = Date.now();
        avisoMostrado = false;

        if (temporizadorCierre) {
            clearTimeout(temporizadorCierre);
            temporizadorCierre = null;
        }

        // Refresca la sesión en el servidor sin recargar la página ni
        // interrumpir al usuario.
        fetch(window.location.href, {
            method: "GET",
            credentials: "same-origin",
            headers: { "X-Requested-With": "XMLHttpRequest" },
        }).catch(function () {
            // Si falla la petición (sin conexión, etc.) no hacemos nada
            // especial: el temporizador seguirá su curso normal.
        });
    }

    function marcarActividad() {

        ultimaActividad = Date.now();

        // Si el aviso ya está en pantalla, no lo cerramos solo por
        // mover el mouse: que el usuario confirme explícitamente.
    }

    ["mousemove", "mousedown", "keydown", "scroll", "touchstart"]
        .forEach(function (evento) {
            window.addEventListener(evento, marcarActividad, { passive: true });
        });

    function mostrarAviso() {

        if (avisoMostrado) {
            return;
        }

        avisoMostrado = true;

        const segundosRestantes = Math.round(AVISO_ANTES_MS / 1000);

        if (typeof Swal !== "undefined") {

            Swal.fire({
                icon: "warning",
                title: "Tu sesión está por expirar",
                text: "Por inactividad, tu sesión se cerrará en " +
                    Math.ceil(segundosRestantes / 60) +
                    " minutos. ¿Deseas continuar conectado?",
                showCancelButton: true,
                confirmButtonText: "Seguir conectado",
                cancelButtonText: "Cerrar sesión ahora",
                confirmButtonColor: "#0d6efd",
                cancelButtonColor: "#dc3545",
                allowOutsideClick: false,
                timer: AVISO_ANTES_MS,
                timerProgressBar: true,
            }).then(function (resultado) {

                if (resultado.isConfirmed) {
                    seguirConectado();
                } else {
                    cerrarSesionPorInactividad();
                }

            });

        }

        // Si Swal no estuviera disponible por alguna razón, el cierre
        // automático programado más abajo sigue funcionando igual.
        temporizadorCierre = setTimeout(
            cerrarSesionPorInactividad,
            AVISO_ANTES_MS
        );

    }

    setInterval(function () {

        const inactivoPorMs = Date.now() - ultimaActividad;

        if (inactivoPorMs >= TIEMPO_VIDA_MS) {

            cerrarSesionPorInactividad();

        } else if (inactivoPorMs >= TIEMPO_VIDA_MS - AVISO_ANTES_MS) {

            mostrarAviso();

        }

    }, 15 * 1000);

});
