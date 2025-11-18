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

$('.tablaMarcaMedidor').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-marca-medidor.ajax.php"
    
    
} );

$('.tablaMedidores').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-medidor.ajax.php"
    
    
} );

$('.tableLoteCaptacionsAsignados').DataTable( {
    language: idioma_espanol,
    ajax: {
            url: "ajax/datatable-lotecaptacion-medidor.ajax.php",
            type: "POST",
            data: function(d) {
                d.variable = idlotecaptacionAsignado; // Envía la variable a la solicitud
            }
        }
    
    
} );

$(".tablaMarcaMedidor").on("click", ".btnEditarMarcaMedidor", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/marcamedidor.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			console.log(respuesta);
                        if (respuesta.length > 0) {
                            var marcaMedidor = respuesta[0];
                            $("#editardescripcion").val(marcaMedidor["descripcion"]);
                            $("#editarIdMarcaMedidor").val(marcaMedidor["id"]);
                        }
		},
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})

$('.tablaModeloMedidor').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-modelo-medidor.ajax.php"
    
    
} );

$(".tablaModeloMedidor").on("click", ".btnEditarModeloMedidor", function() {
    var id = $(this).attr("id");

    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/modelomedidor.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            console.log("Respuesta completa:", respuesta); // Verifica la estructura aquí

            // Verifica si `respuesta.modelo` es un array y tiene al menos un elemento
            if (Array.isArray(respuesta.modelo) && respuesta.modelo.length > 0) {
                var modelo = respuesta.modelo[0]; // Accede al primer objeto del array

                console.log("Modelo:", modelo);
                console.log("Marcas:", respuesta.marcas);

                // Vaciar el select antes de llenarlo
                $("#editarmarca").empty();
                
                // Verifica si `respuesta.marcas` es un array antes de iterar
                if (Array.isArray(respuesta.marcas)) {
                    $.each(respuesta.marcas, function(index, marca) {
                        // Convertir el ID de la marca en el modelo a cadena para la comparación
                        var isSelected = (String(marca.id) === String(modelo.idmarca_medidor));
                        var selected = isSelected ? 'selected' : '';
                                                
                        // Agregar la opción al select con el atributo `selected` si es necesario
                        $("#editarmarca").append('<option value="' + marca.id + '" ' + selected + ' aria-selected="true">' + marca.descripcion + '</option>');
                    });
                } else {
                    console.error("respuesta.marcas no es un array");
                }
                
                // Rellenar el campo de descripción con datos del primer objeto del array
                $("#editardescripcion").val(modelo.modelo);
                $("#editarIdModeloMedidor").val(modelo.id);
            } else {
                console.error("respuesta.modelo no es un array o está vacío");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
        }
    });
});


$('.tablaTipoRegistroMedidor').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-tipo-registro-medidor.ajax.php"
    
    
} );