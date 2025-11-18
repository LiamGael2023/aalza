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

$('.tablaObrasPaquetes').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-obras-paquetes.ajax.php"
    
} );
//$('.tablaObrasPaquetes').DataTable({
//    language: idioma_espanol,
//    ajax: {
//        url: "ajax/datatable-obras-paquetes.ajax.php",
//        dataSrc: 'data', // Indica que los datos están en la propiedad 'data'
//        error: function (xhr, error, thrown) {
//            console.log('Respuesta del servidor:', xhr.responseText);
//        },
//        success: function (data) {
//            console.log('Datos recibidos:', data);
//        }
//    }
//});

//$('.tablaObrasPaquetes').DataTable( {
//            "ajax": {
//                "url": "ajax/datatable-obras-paquetes.ajax.php", // Asegúrate de usar la ruta correcta
//                "dataSrc": "data",
//                "error": function(xhr, error, thrown) {
//                    console.error('Error:', error, thrown);
//                }
//            },
//            "columns": [
//                { "data": 0 },
//                { "data": 1 },
//                { "data": 2 }
//            ],
//            "processing": true,
//            "serverSide": false // Cambiar a true si estás usando server-side processing
//        });

$(".tablaObrasPaquetes").on("click", ".btnEditarObra", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/obraspaquetes.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
                    console.log(respuesta);

                    // Asegúrate de que estás accediendo al primer elemento del array
                    if (respuesta.length > 0) {
                        var obraPaquete = respuesta[0];
                        $("#editardescripcion").val(obraPaquete["nombre"]);
                        $("#editarIdObraPaquete").val(obraPaquete["id"]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})

