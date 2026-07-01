document.addEventListener("DOMContentLoaded", function () {

    if (typeof DataTable === "undefined") {
        return;
    }

    document.querySelectorAll(".datatable").forEach(function (tabla) {

        new DataTable(tabla, {

            pageLength: 10,

            lengthMenu: [10, 25, 50, 100],

            ordering: true,

            searching: true,

            responsive: true,

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

        });

    });

});