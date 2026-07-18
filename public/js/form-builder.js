console.log("FORM BUILDER CARGADO");

document.addEventListener("DOMContentLoaded", function () {

    const btnAgregar = document.getElementById("btnAgregarCampo");
    const btnGuardar = document.getElementById("btnGuardarFormulario");

    const nombreCampo = document.getElementById("nombreCampo");
    const tipoCampo = document.getElementById("tipoCampo");
    const obligatorioCampo = document.getElementById("obligatorioCampo");
    const opcionesCampo = document.getElementById("opcionesCampo");

const contenedorOpciones = document.getElementById("contenedorOpciones");

    const tabla = document.getElementById("tbodyCampos");
    const filaSinCampos = document.getElementById("filaSinCampos");

    //const preview = document.getElementById("previewFormulario");
    const previewVacio = document.getElementById("previewVacio");

    const camposJson = document.getElementById("camposJson");
    
    let preview = null;

preview = document.getElementById("previewFormulario");

if (
    !btnAgregar ||
    !btnGuardar ||
    !nombreCampo ||
    !tipoCampo ||
    !obligatorioCampo ||
    !tabla ||
    !camposJson
) {
    console.error("Falta uno o más elementos.");
    return;
}

    let campos = [];

if (typeof window.camposExistentes !== "undefined") {

  campos = window.camposExistentes.map(function (campo) {

    return {

        nombre: campo.etiqueta,

        tipo: campo.tipo_campo,

        obligatorio: campo.obligatorio == 1,

        opciones: campo.opciones
            ? JSON.parse(campo.opciones)
            : []

    };

});

}

    let indiceEdicion = -1;

    function limpiarFormulario() {

        nombreCampo.value = "";

        tipoCampo.selectedIndex = 0;

        obligatorioCampo.checked = false;
        opcionesCampo.value = "";

contenedorOpciones.style.display = "none";

        indiceEdicion = -1;
tipoCampo.addEventListener("change", function () {

    if (
        this.value === "select" ||
        this.value === "radio" ||
        this.value === "checkbox"
    ) {

        contenedorOpciones.style.display = "block";

    } else {

        contenedorOpciones.style.display = "none";

        opcionesCampo.value = "";

    }

});
        btnAgregar.innerHTML =
            '<i class="fa-solid fa-plus me-2"></i>Agregar campo';

    }

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
        function renderizar() {

    preview = document.getElementById("previewFormulario");

    if (!preview) {

        console.error("No existe previewFormulario");

        return;

    }

    tabla.innerHTML = "";

    preview.innerHTML = "";

        if (campos.length === 0) {

            tabla.innerHTML = `

                <tr id="filaSinCampos">

                    <td colspan="4" class="text-center text-muted">

                        Aún no hay campos agregados.

                    </td>

                </tr>

            `;

            preview.innerHTML = `

                <div
                    id="previewVacio"
                    class="text-center text-muted py-4">

                    <i class="fa-solid fa-file-lines fa-3x mb-3"></i>

                    <p>

                        Aún no hay campos para mostrar.

                    </p>

                </div>

            `;

            camposJson.value = JSON.stringify(campos);

            return;

        }

        console.log(campos);

        campos.forEach(function (campo, index) {

            const fila = document.createElement("tr");

            fila.innerHTML = `

                <td>${campo.nombre}</td>

                <td>${campo.tipo}</td>

                <td>${campo.obligatorio ? "Sí" : "No"}</td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-warning btn-sm btnEditar"
                        data-index="${index}">

                        <i class="fa-solid fa-pen"></i>

                    </button>

                    <button
                        type="button"
                        class="btn btn-danger btn-sm btnEliminar"
                        data-index="${index}">

                        <i class="fa-solid fa-trash"></i>

                    </button>

                </td>

            `;

            tabla.appendChild(fila);

            preview.insertAdjacentHTML(

                "beforeend",

                `

                <div
                    class="mb-3">

                    <label class="form-label">

                        ${campo.nombre}

                        ${campo.obligatorio
                            ? '<span class="text-danger">*</span>'
                            : ''}

                    </label>

                    ${generarControl(campo.tipo)}

                </div>

                `

            );

        });

        camposJson.value = JSON.stringify(campos);
    }
        btnAgregar.addEventListener("click", function () {

        if (nombreCampo.value.trim() === "") {

            Swal.fire({

                icon: "warning",

                title: "Campo obligatorio",

                text: "Debe escribir el nombre del campo."

            });

            return;

        }
const campo = {

    nombre: nombreCampo.value.trim(),

    tipo: tipoCampo.value,

    obligatorio: obligatorioCampo.checked,

    opciones: opcionesCampo.value
        .split(",")
        .map(op => op.trim())
        .filter(op => op !== "")

};

        if (indiceEdicion === -1) {

            campos.push(campo);

        } else {

            campos[indiceEdicion] = campo;

        }

        renderizar();

        limpiarFormulario();

    });

    tabla.addEventListener("click", function (e) {

        const btnEditar = e.target.closest(".btnEditar");

        const btnEliminar = e.target.closest(".btnEliminar");

        if (btnEditar) {

            const index = parseInt(btnEditar.dataset.index);

            const campo = campos[index];

            indiceEdicion = index;

            nombreCampo.value = campo.nombre;

tipoCampo.value = campo.tipo;

obligatorioCampo.checked = campo.obligatorio;

opcionesCampo.value = (campo.opciones || []).join(",");

tipoCampo.dispatchEvent(new Event("change"));

            btnAgregar.innerHTML =
                '<i class="fa-solid fa-floppy-disk me-2"></i>Actualizar campo';

            return;

        }

        if (btnEliminar) {

            const index = parseInt(btnEliminar.dataset.index);

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

                campos.splice(index, 1);

                renderizar();

                limpiarFormulario();

            });

        }

    });

        const formulario = btnGuardar.closest("form");

    if (formulario) {

        formulario.addEventListener("submit", function (e) {

            camposJson.value = JSON.stringify(campos);

            if (campos.length === 0) {

                e.preventDefault();

                Swal.fire({

                    icon: "warning",

                    title: "Formulario incompleto",

                    text: "Debe agregar al menos un campo al formulario."

                });

                return false;

            }

        });

    }

    renderizar();

});