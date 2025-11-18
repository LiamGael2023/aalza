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

$('.tablaDerechoUso').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-derechouso.ajax.php"
    
    
} );

$('.tablaDerechoUsoAgrario').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-derechousoAgrario.ajax.php"
    
    
} );

$('.tablaDerechoUsoEnergetico').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-derechousoEnergetico.ajax.php"
    
    
} );

$('.tablaDerechoUsoPoblacional').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-derechousoPoblacional.ajax.php"
    
    
} );


$('.tablaDerechoUsoOtrosusos').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-derechousoOtrosusos.ajax.php"
    
    
} );

$('.tableLotesAsignados').DataTable({
        language: idioma_espanol,
        ajax: {
            url: "ajax/datatable-derechousolotes.ajax.php",
            type: "POST",
            data: function(d) {
                d.variable = idderechoAsignado; // Envía la variable a la solicitud
            }
        }
});


$(".mensualizado").on("click", ".btnEditarMensualizado", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/derecho-uso.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			console.log(respuesta);
			$("#enero").val(respuesta["enero"]);
                        $("#febrero").val(respuesta["febrero"]);
                        $("#marzo").val(respuesta["marzo"]);
                        $("#abril").val(respuesta["abril"]);
                        $("#mayo").val(respuesta["mayo"]);
                        $("#junio").val(respuesta["junio"]);
                        $("#julio").val(respuesta["julio"]);
                        $("#agosto").val(respuesta["agosto"]);
                        $("#setiembre").val(respuesta["setiembre"]);
                        $("#octubre").val(respuesta["octubre"]);
                        $("#noviembre").val(respuesta["noviembre"]);
                        $("#diciembre").val(respuesta["diciembre"]);
                        $("#vol_otorgado").val(respuesta["vol_otorgado"]);
                        $("#idDerechoMensualizado").val(respuesta["id"]);
		}

	});

})

$('.RptDerechoUso').DataTable({
    language: idioma_espanol,
    pageLength: 25,
    ajax: "ajax/datatable-rptderechouso.ajax.php",
    rowGroup: {
        dataSrc: 1 // Índice de la columna "Razón Social" (0-indexado)
    },
    order: [[ 1, 'asc' ]] // Ordenar por Razón Social
});