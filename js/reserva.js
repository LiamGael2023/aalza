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

$('.tablaReserva').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-reserva.ajax.php"
    
    
} );

$(".tablaJunta").on("click", ".btnEditarJunta", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/junta.ajax.php",
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
                        var junta = respuesta[0];
                        $("#editarjunta").val(junta["nombre"]);
                        $("#editarabreviatura").val(junta["abreviatura"]);
                        $("#editarIdJunta").val(junta["id"]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})