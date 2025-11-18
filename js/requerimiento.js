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
        "sFirst": "&laquo;",
        "sLast": "&raquo;",
        "sNext": "&gt;",      // >
        "sPrevious": "&lt;"   // <
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

$('.tablaRequerimiento').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-requerimiento.ajax.php",
    responsive: true,
    pagingType: 'simple_numbers', 
    dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>',
    columnDefs: [
        {
            targets: 0, // La primera columna
            responsivePriority: 10001 // Baja prioridad (la primera en ocultarse)
        }
    ],
} );

$('.tablaRequerimientoporJuntas').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-requerimientoporJuntas.ajax.php"
    
    
} );

$('.tableCaptacionesAsignados').DataTable({
        language: idioma_espanol,
        pageLength: 25,
        ajax: {
            url: "ajax/datatable-requerimientodetalle.ajax.php",
            type: "POST",
            data: function(d) {
                d.variable = idrequerimientodetalle; // Envía la variable a la solicitud
            }
        }
});

$(".TablaReqDetalle").on("click", ".btnEditarrequerimiento", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/requerimiento.ajax.php",
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
                        var comision = respuesta[0];
                        
                        //$("#editarjunta").val(comision["idjunta"]);
                        let caudalNeto = parseFloat(comision["caudalneto"]) || 0;
                        caudalNeto = caudalNeto.toFixed(3);
                        
                        let caudalBruto = parseFloat(comision["caudalbruto"]) || 0;
                        caudalBruto = caudalBruto.toFixed(3);
                        
                        let tiempoOperacion = parseFloat(comision["tiempo_operacion"]) || 0;
                        tiempoOperacion = tiempoOperacion.toFixed(4);
                        
                        let volFacturado = parseFloat(comision["volfacturado"]) || 0;
                        let volBruto = parseFloat(comision["volbruto"]) || 0;
                        
                        volFacturado = volFacturado.toFixed(4);
                        volBruto = volBruto.toFixed(4);
                        
                        
                       // Obtener la fecha de comision["fecha_horaini"]
var fechaHoraInicio = comision["fecha_horaini"];

// Verificar que el valor sea un objeto con la estructura esperada
if (fechaHoraInicio && fechaHoraInicio.date) {
    // Extraer la fecha y hora del objeto, y convertirla en formato 'YYYY-MM-DDTHH:MM'
    var formattedFechaHoraInicio = fechaHoraInicio.date.replace(' ', 'T').split('.')[0];
    
    // Asigna el valor al campo input de tipo datetime-local
    $("#fechaHoraInicioEditar").val(formattedFechaHoraInicio);
} else {
    console.error("La fecha 'fecha_horaini' no tiene el formato esperado.");
}

// Obtener la fecha de comision["fecha_horaini"]
var fechaHoraTermino = comision["fecha_horatermino"];

// Verificar que el valor sea un objeto con la estructura esperada
if (fechaHoraTermino && fechaHoraTermino.date) {
    // Extraer la fecha y hora del objeto, y convertirla en formato 'YYYY-MM-DDTHH:MM'
    var formattedFechaHoraTermino = fechaHoraTermino.date.replace(' ', 'T').split('.')[0];
    
    // Asigna el valor al campo input de tipo datetime-local
    $("#fechaHoraFinEditar").val(formattedFechaHoraTermino);
} else {
    console.error("La fecha 'fecha_horatermino' no tiene el formato esperado.");
}

                        $("#idreqdetEditar").val(comision["id"]);
                        $("#captacioneditar").val(comision["idBloqueCaptacion"]);
                        $("#captacioneditar").html(comision["captacion"]);
                        $("#caudalnetoeditar").val(caudalNeto);
                        $("#caudalbrutoeditar").val(caudalBruto);
                        $("#tiempoOperaEditar").val(tiempoOperacion);
                        $("#volfacturadoEditar").val(volFacturado);
                        $("#volbrutoEditar").val(volBruto);
                        $("#tuihmaEditar").val(comision["totalTUIHMA"]);
                        $("#eficienciaEditar").val(comision["eficiencia"]);
                        $("#horassolicitadasEditar").val(comision["horas_solicitadas"]);
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})

$(".TablaReqDetalle").on("click", ".btnEditarrequerimientoH", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url:"ajax/requerimiento.ajax.php",
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
                        var comision = respuesta[0];
                        
                        //$("#editarjunta").val(comision["idjunta"]);
                        let caudalNeto = parseFloat(comision["caudalneto"]) || 0;
                        caudalNeto = caudalNeto.toFixed(3);
                        
                        let caudalBruto = parseFloat(comision["caudalbruto"]) || 0;
                        caudalBruto = caudalBruto.toFixed(3);
                        
                        let tiempoOperacion = parseFloat(comision["tiempo_operacion"]) || 0;
                        tiempoOperacion = tiempoOperacion.toFixed(4);
                        
                        let volFacturado = parseFloat(comision["volfacturado"]) || 0;
                        let volBruto = parseFloat(comision["volbruto"]) || 0;
                        
                        volFacturado = volFacturado.toFixed(4);
                        volBruto = volBruto.toFixed(4);
                        
                        
                       // Obtener la fecha de comision["fecha_horaini"]
var fechaHoraInicio = comision["fecha_horaini"];

// Verificar que el valor sea un objeto con la estructura esperada
if (fechaHoraInicio && fechaHoraInicio.date) {
    // Extraer la fecha y hora del objeto, y convertirla en formato 'YYYY-MM-DDTHH:MM'
    var formattedFechaHoraInicio = fechaHoraInicio.date.replace(' ', 'T').split('.')[0];
    
    // Asigna el valor al campo input de tipo datetime-local
    $("#fechaHoraInicioH").val(formattedFechaHoraInicio);
} else {
    console.error("La fecha 'fecha_horaini' no tiene el formato esperado.");
}

// Obtener la fecha de comision["fecha_horaini"]
var fechaHoraTermino = comision["fecha_horatermino"];

// Verificar que el valor sea un objeto con la estructura esperada
if (fechaHoraTermino && fechaHoraTermino.date) {
    // Extraer la fecha y hora del objeto, y convertirla en formato 'YYYY-MM-DDTHH:MM'
    var formattedFechaHoraTermino = fechaHoraTermino.date.replace(' ', 'T').split('.')[0];
    
    // Asigna el valor al campo input de tipo datetime-local
    $("#fechaHoraFinH").val(formattedFechaHoraTermino);
} else {
    console.error("La fecha 'fecha_horatermino' no tiene el formato esperado.");
}

                        $("#idreqdetEditarH").val(comision["id"]);
                        $("#captacioneditarH").val(comision["idBloqueCaptacion"]);
                        $("#captacioneditarH").html(comision["captacion"]);
                        $("#caudalnetoeditarH").val(caudalNeto);
                        $("#caudalbrutoeditarH").val(caudalBruto);
                        $("#tiempoOperaEditarH").val(tiempoOperacion);
                        $("#volfacturadoEditarH").val(volFacturado);
                        $("#volbrutoEditarH").val(volBruto);
                        $("#tuihmaEditarH").val(comision["totalTUIHMA"]);
                        $("#eficienciaEditarH").val(comision["eficiencia"]);
                        $("#horassolicitadasEditarH").val(comision["horas_solicitadas"]);
                        $("#tuihmaH").val(comision["totalTUIHMA"]);
                        $("#eficienciaH").val(comision["eficiencia"]);
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})