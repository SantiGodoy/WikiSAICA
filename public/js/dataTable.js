$(document).ready( function () {
    $('.dataTable').DataTable({
        "ordering": false,
        "info": false,
        "language": {
            "lengthMenu": "Desplegar _MENU_ artículos por página.",
            "zeroRecords": "No se ha encontrado nada.",
            "infoEmpty": "No hay artículos disponibles",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar: ",
            "paginate": {
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]]
    });
});