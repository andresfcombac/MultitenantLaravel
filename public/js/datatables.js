document.addEventListener("DOMContentLoaded", function () {

    if (typeof DataTable === "undefined") {
        return;
    }

    document.querySelectorAll(".datatable").forEach(function (tabla) {

        const opciones = {

            pageLength: 10,

            lengthMenu: [
                [5, 10, 20, 50, 100, -1],
                [5, 10, 20, 50, 100, 'Todos']
            ],

            ordering: true,

            searching: true,

            responsive: tabla.id !== 'tablaAsistencias',

            language: {
                decimal: "",
                emptyTable: "No hay información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros)",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_ registros",
                loadingRecords: "Cargando...",
                processing: "Procesando...",
                search: "Buscar:",
                zeroRecords: "No se encontraron resultados",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        };

        // Configuración especial para Asistencias
        if (tabla.id === 'tablaAsistencias') {

            opciones.scrollX = true;
            opciones.autoWidth = false;

            // Ocultar columna ID correctamente
            opciones.columnDefs = [
                {
                    targets: 0,
                    visible: false,
                    searchable: false
                }
            ];
        }

        new DataTable(tabla, opciones);

    });

});