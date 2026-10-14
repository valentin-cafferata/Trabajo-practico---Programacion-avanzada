document.addEventListener("DOMContentLoaded", function () {
    // Librería DataTables: búsqueda, orden y paginación de la tabla "Mis publicaciones"
    const tabla = document.getElementById("tabla-gatos");
    if (tabla && typeof DataTable !== "undefined") {
        new DataTable(tabla, {
            language: { url: "https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json" },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[7, "desc"]],
            columnDefs: [
                { targets: [0, -1], orderable: false, searchable: false }
            ]
        });
    }

    // Librería SweetAlert2: confirmación antes de eliminar una publicación
    document.addEventListener("submit", function (evento) {
        const form = evento.target;
        if (!form.classList.contains("form-eliminar")) {
            return;
        }
        evento.preventDefault();

        Swal.fire({
            title: "¿Eliminar la publicación de " + form.dataset.nombre + "?",
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
