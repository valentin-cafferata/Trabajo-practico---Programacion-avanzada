$(function () {
    // Librería DataTables: búsqueda, orden y paginación de la tabla
    new DataTable("#tabla-gatos", {
        language: { url: "https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json" },
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, "asc"]],
        columnDefs: [{ targets: -1, orderable: false, searchable: false }]
    });

    // Librería SweetAlert2: confirmación antes de dar de baja
    $(document).on("submit", ".form-eliminar", function (evento) {
        evento.preventDefault();
        const form = this;

        Swal.fire({
            title: "¿Eliminar a " + form.dataset.nombre + "?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#dc3545",
            reverseButtons: true
        }).then(function (resultado) {
            if (resultado.isConfirmed) {
                form.submit();
            }
        });
    });
});
