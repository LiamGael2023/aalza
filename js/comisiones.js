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

$('.tablaComisiones').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-comision.ajax.php"
    
    
} );

$(".tablaComisiones").on("click", ".btnEditarComision", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/comision.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
                    console.log(respuesta);
                    
                    
                    if (Array.isArray(respuesta.comision) && respuesta.comision.length > 0) {
                        var comision = respuesta.comision[0]; // Accede al primer objeto del array

                        console.log("Comision:", comision);
                        console.log("Juntas:", respuesta.junta);

                        // Vaciar el select antes de llenarlo
                        $("#editarjunta").empty();
                        $("#editarjunta").append('<option value="0">Seleccionar Junta...</option>');

                        // Verifica si `respuesta.marcas` es un array antes de iterar
                        if (Array.isArray(respuesta.junta)) {
                            $.each(respuesta.junta, function(index, juntas) {
                                // Convertir el ID de la marca en el modelo a cadena para la comparación
                                var isSelected = (String(juntas.id) === String(comision.idjunta));
                                var selected = isSelected ? 'selected' : '';

                                // Agregar la opción al select con el atributo `selected` si es necesario
                                $("#editarjunta").append('<option value="' + juntas.id + '" ' + selected + ' aria-selected="true">' + juntas.nombre + '</option>');
                                
                                if (comision.idjunta === 0) {
                                    $('#junta-containereditar').addClass('disabled-select');
                                    $("#editarjunta").val(0).trigger('change'); 
                                    $("#editarnotiene").prop("checked", true); // Marca el checkbox si no hay coincidencia
                                    $('#junta-overlayeditar').show();
                                    $("#editarjunta").removeAttr('required');
                                } else {
                                    $("#editarnotiene").prop("checked", false); // Desmarca si hay coincidencia
                                    $('#junta-containereditar').removeClass('disabled-select');
                                    $('#junta-overlayeditar').hide();
                                    $("#editarjunta").attr('required', true);
                                }
                            });
                        } else {
                            console.error("respuesta.junta no es un array");
                        }

                        // Rellenar el campo de descripción con datos del primer objeto del array
                        $("#editarnombre").val(comision.comision);
                        $("#editarabreviatura").val(comision.comisionabreviatura);
                        $("#editarIdComision").val(comision.id);
                    } else {
                        console.error("respuesta.modelo no es un array o está vacío");
                    }
                    // Asegúrate de que estás accediendo al primer elemento del array
                    if (respuesta.length > 0) {
                        var comision = respuesta[0];
                        
                        //$("#editarjunta").val(comision["idjunta"]);
                        
                        $("#editarnombre").val(comision["comision"]);
                        $("#editarabreviatura").val(comision["comisionabreviatura"]);
                        $("#editarIdComision").val(comision["id"]);
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})