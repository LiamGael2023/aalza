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

$('.tablaRedHidrografica').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-redhidrografica.ajax.php"
    
    
} );

$(".TablaCaudalCirculante").on("click", ".btmostrarGrafico", function() {
    var id = $(this).attr("id");
    
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/caudalescirculantes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            if (respuesta.length > 0) {
                var junta = respuesta[0];
                var id = junta.id;
                var fechaCompleta = junta.fecha.date;
                
                var fechaObj = new Date(fechaCompleta);
        var dia = String(fechaObj.getDate()).padStart(2, '0');
        var mes = String(fechaObj.getMonth() + 1).padStart(2, '0'); // Meses en JavaScript son 0-11
        var anio = fechaObj.getFullYear();
        var fechaFormateada = `${dia}/${mes}/${anio}`;

        $("#labelId").text("Ingreso Limnigrafo - " + fechaFormateada);

                // Aquí puedes llamar a otra función para hacer la consulta SQL
                fetchData(id); // Llama a una función para manejar la consulta
            } else {
                console.log("No se encontraron datos en la respuesta.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
});

// Función para manejar la consulta
function fetchData(id) {
    $.ajax({
        url: "ajax/obtener_caudales.php", // Cambia esto al archivo donde ejecutas la consulta
        method: "POST",
        data: { inputId: id }, // Envía el ID
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                drawChart(data); // Llama a la función para dibujar el gráfico
            } else {
                console.log("No se encontraron datos en la respuesta.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
}

$(".tablaRedHidro").on("click", ".btnEditarRed", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("id", id);
        
        

	$.ajax({
    url: "ajax/redhidrografica.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {
        console.log(respuesta);  // Verifica qué datos recibes

        if (respuesta.length > 0) {
            var redhidrografica = respuesta[0];
            
            var tipoRegistro = redhidrografica["idTipo_registro"];  // El valor recibido de la base de datos (1, 2 o 3)
            
            var fechaCompleta = respuesta[0].fechai.date; // '2021-08-05 00:00:00.000000'
            var fechaSolo = fechaCompleta.split(' ')[0]; // Esto te da '2021-08-05'

            // Ahora puedes usar 'fechaSolo' en tu aplicación
            console.log(fechaSolo); // '2021-08-05'
            $("#fechaingresoEdit").val(fechaSolo);

            console.log('Valor recibido de tiporegistroEdit:', tipoRegistro);
            
            $("#tiporegistroEdit").empty();
            $("#tiporegistroEdit").append('<option value="">Seleccionar...</option>');
            
            var opciones = [
                { id: "1", nombre: "Altura" },
                { id: "2", nombre: "Medición" },
                { id: "3", nombre: "Ambos" }
            ];
            
            var idCategoria = redhidrografica["idEstructura"];  // El valor recibido para la categoría
            console.log('ID de Categoria:', idCategoria);  // Verifica el valor recibido
            
            
            // Recorrer las opciones y agregar cada una al select
            $.each(opciones, function(index, opcion) {
                // Verificar si el valor recibido coincide con la opción
                var isSelected = (String(opcion.id) === String(tipoRegistro));
                var selected = isSelected ? 'selected' : '';  // Si coincide, marcar como selected

                // Agregar la opción al select
                $("#tiporegistroEdit").append('<option value="' + opcion.id + '" ' + selected + '>' + opcion.nombre + '</option>');
            });

            // Lógica adicional si el valor es 0 (si es necesario)
            if (tipoRegistro === 0) {
                $('#tiporegistro-container').addClass('disabled-select');
                $("#tiporegistroEdit").val(0).trigger('change');
                $("#editarnotiene").prop("checked", true);  // Marca el checkbox si no hay coincidencia
                $('#tiporegistro-overlay').show();
                $("#tiporegistroEdit").removeAttr('required');
            } else {
                $("#editarnotiene").prop("checked", false);  // Desmarcar si hay coincidencia
                $('#tiporegistro-container').removeClass('disabled-select');
                $('#tiporegistro-overlay').hide();
                $("#tiporegistroEdit").attr('required', true);
            }
            
            // Mostrar la geometría como texto en el campo correspondiente
            $("#geomedit").val(redhidrografica["GeometriaComoTexto"]);
            $("#descripcionEdit").val(redhidrografica["estacion"]);
            $("#ubicacionEdit").val(redhidrografica["ubicacion"]);
            $("#categoriaEdit").val(redhidrografica["idEstructura"]);
            $("#categoriaEdit").html(redhidrografica["nombre"]);
            $("#formulaEdit").val(redhidrografica["idformula"]);
            $("#formulaEdit").html(redhidrografica["formula_texto"]);
            $("#redidEdit").val(redhidrografica["id"]);

            var lat, lng;  // Declaramos las variables fuera del try-catch para que estén disponibles

            // Verificar si es WKT o GeoJSON
            try {
                var geom = JSON.parse(redhidrografica["GeometriaComoTexto"]);  // Intentamos parsear como GeoJSON
                console.log("GeoJSON:", geom);  // Verifica la estructura del GeoJSON recibido
                if (geom.type === "Point") {
                    lat = geom.coordinates[1]; // Latitud
                    lng = geom.coordinates[0]; // Longitud
                }
            } catch (e) {
                // Si no es un GeoJSON válido, intentamos tratarlo como WKT
                console.log("Error al parsear como GeoJSON:", e); // Muestra el error si no es un GeoJSON válido
                var wkt = redhidrografica["GeometriaComoTexto"];
                console.log("WKT recibido:", wkt);  // Verifica la cadena WKT

                if (wkt.startsWith("POINT")) {
                    // Extraemos las coordenadas
                    var coordinates = wkt.slice(6, -1).split(" ");
                    console.log("Coordenadas extraídas de WKT:", coordinates);  // Muestra las coordenadas extraídas
                    
                    // Limpiar los paréntesis y convertir las coordenadas a números
                    lng = parseFloat(coordinates[0].replace(/[()]/g, '').trim()); // Elimina paréntesis y convierte a número
                    lat = parseFloat(coordinates[1].trim()); // Latitud
                }
            }

            // Verifica si las coordenadas son válidas antes de usarlas
            console.log("Latitud:", lat, "Longitud:", lng);  // Muestra las coordenadas antes de usarlas

            if (isNaN(lat) || isNaN(lng)) {
                console.error("Coordenadas no válidas:", lat, lng);  // Si alguna de las coordenadas es NaN
                return;  // Detiene el proceso si las coordenadas no son válidas
            }

            // Mostrar las coordenadas en el campo de texto
            document.getElementById('coordsEdit').textContent = `${lng.toFixed(6)}, ${lat.toFixed(6)}`;

            // Agregar el marcador en el mapa
            if (markerEdit) {
                mapEdit.removeLayer(markerEdit);  // Eliminar el marcador anterior si existe
            }
            markerEdit = L.marker([lat, lng]).addTo(mapEdit);  // Agregar el nuevo marcador
            mapEdit.setView([lat, lng], 13);  // Centrar el mapa en el marcador
        } else {
            console.log("No se encontraron datos en la respuesta.");
        }
    },
    error: function(xhr, status, error) {
        console.error("Error en la solicitud AJAX:", status, error);
    }
});

})