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

document.addEventListener("DOMContentLoaded", function () {

    const btnAgregar = document.getElementById("btnAgregarCampo");

    const nombreCampo = document.getElementById("nombreCampo");

    const tipoCampo = document.getElementById("tipoCampo");

    const obligatorioCampo = document.getElementById("obligatorioCampo");

    const tabla = document.querySelector("#tablaCampos tbody");

    const filaSinCampos = document.getElementById("filaSinCampos");

    const preview = document.getElementById("previewFormulario");

    if (
        !btnAgregar ||
        !nombreCampo ||
        !tipoCampo ||
        !obligatorioCampo ||
        !tabla ||
        !preview
    ) {
        return;
    }

    let filaEditando = null;

    let previewEditando = null;

    function generarControl(tipo) {

        switch (tipo) {

            case "texto":
                return '<input type="text" class="form-control">';

            case "numero":
                return '<input type="number" class="form-control">';

            case "fecha":
                return '<input type="date" class="form-control">';

            case "email":
                return '<input type="email" class="form-control">';

            case "checkbox":
                return '<input type="checkbox">';

            case "radio":
                return '<input type="radio">';

            case "select":
                return `
                    <select class="form-control">
                        <option>Opción 1</option>
                    </select>
                `;

            default:
                return '<input type="text" class="form-control">';

        }

    }

    function limpiarFormulario() {

        nombreCampo.value = "";

        tipoCampo.selectedIndex = 0;

        obligatorioCampo.checked = false;

        filaEditando = null;

        previewEditando = null;

        btnAgregar.innerHTML =
            '<i class="fa-solid fa-plus me-2"></i>Agregar campo';

    }

    btnAgregar.addEventListener("click", function () {
         console.log("CLICK");
        if (nombreCampo.value.trim() === "") {

            Swal.fire({

                icon: "warning",

                title: "Campo obligatorio",

                text: "Debe escribir el nombre del campo."

            });

            return;

        }
                if (filaEditando) {

            filaEditando.cells[0].innerText = nombreCampo.value;

            filaEditando.cells[1].innerText = tipoCampo.value;

            filaEditando.cells[2].innerText =
                obligatorioCampo.checked ? "Sí" : "No";

            previewEditando.innerHTML = `

                <label class="form-label">

                    ${nombreCampo.value}

                    ${obligatorioCampo.checked
                        ? '<span class="text-danger">*</span>'
                        : ''}

                </label>

                ${generarControl(tipoCampo.value)}

            `;

            limpiarFormulario();

            return;

        }

        if (filaSinCampos) {

            filaSinCampos.remove();

        }

        if (preview.querySelector(".text-center")) {

            preview.innerHTML = "";

        }

        const idCampo = Date.now();

        const fila = document.createElement("tr");

        fila.dataset.id = idCampo;

        fila.innerHTML = `

            <td>${nombreCampo.value}</td>

            <td>${tipoCampo.value}</td>

            <td>${obligatorioCampo.checked ? "Sí" : "No"}</td>

            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-warning btn-sm btnEditar">

                    <i class="fa-solid fa-pen"></i>

                </button>

                <button
                    type="button"
                    class="btn btn-danger btn-sm btnEliminar">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </td>

        `;

        tabla.appendChild(fila);

        preview.insertAdjacentHTML(

            "beforeend",

            `

            <div
                class="mb-3 campo-preview"
                data-id="${idCampo}">

                <label class="form-label">

                    ${nombreCampo.value}

                    ${obligatorioCampo.checked
                        ? '<span class="text-danger">*</span>'
                        : ''}

                </label>

                ${generarControl(tipoCampo.value)}

            </div>

            `

        );

        const btnEditar = fila.querySelector(".btnEditar");

        const btnEliminar = fila.querySelector(".btnEliminar");
                btnEditar.addEventListener("click", function () {

            filaEditando = fila;

            previewEditando = preview.querySelector(
                '[data-id="' + idCampo + '"]'
            );

            nombreCampo.value = fila.cells[0].innerText;

            tipoCampo.value = fila.cells[1].innerText;

            obligatorioCampo.checked =
                fila.cells[2].innerText === "Sí";

            btnAgregar.innerHTML =
                '<i class="fa-solid fa-floppy-disk me-2"></i>Actualizar campo';

        });

        btnEliminar.addEventListener("click", function () {

            Swal.fire({

                title: "Eliminar campo",

                text: "¿Desea eliminar este campo?",

                icon: "warning",

                showCancelButton: true,

                confirmButtonText: "Sí",

                cancelButtonText: "Cancelar",

                confirmButtonColor: "#dc3545"

            }).then((result) => {

                if (!result.isConfirmed) return;

                fila.remove();

                const previewCampo = preview.querySelector(
                    '[data-id="' + idCampo + '"]'
                );

                if (previewCampo) {

                    previewCampo.remove();

                }

                if (tabla.children.length === 0) {

                    tabla.innerHTML = `

                        <tr id="filaSinCampos">

                            <td colspan="4" class="text-center text-muted">

                                Aún no hay campos agregados.

                            </td>

                        </tr>

                    `;

                }

                if (preview.querySelectorAll(".campo-preview").length === 0) {

                    preview.innerHTML = `

                        <div class="text-center text-muted py-4">

                            <i class="fa-solid fa-file-lines fa-3x mb-3"></i>

                            <p>

                                Aún no hay campos para mostrar.

                            </p>

                        </div>

                    `;

                }

            });

        });

        limpiarFormulario();

    });

});