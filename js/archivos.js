var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

$('.tablaArchivos').DataTable({
    language: idioma_espanol,
    ajax: "ajax/datatable-archivos.ajax.php",
    "pageLength": 25,  // Limitar a 25 registros por página
    "lengthMenu": [25, 50, 75, 100],  // Opción para cambiar la cantidad de registros por página
});

$('.tablaArchivosId').DataTable().clear().destroy();

$('.tablaArchivosId').DataTable({
    language: idioma_espanol,
    ajax: "ajax/datatable-archivosid.ajax.php",
    pageLength: 25,
    lengthMenu: [25, 50, 75, 100],
    columnDefs: [
        {
            targets: 0,       // Índice de la primera columna
            visible: false,   // Ocultar columna
            searchable: false // Evitar que se incluya en la búsqueda
        }
    ]
});