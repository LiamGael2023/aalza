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

$(".tablaIHM").on("click", ".btnEditarIHM", function() {
    var id = $(this).attr("id");

    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/ihm.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            console.log(respuesta);  // Verifica los datos recibidos
            if (respuesta.length > 0) {
                var redhidrografica = respuesta[0];
                console.log("ProgresivaContinuaVal:", redhidrografica["ProgresivaContinuaVal"]);
                
                // Asignar el valor a #progresivaValEdit
                $("#idEdit").val(redhidrografica["id"]);
                $("#descripcionEdit").val(redhidrografica["Tipo"]);
                $("#progresivaValEdit").val(redhidrografica["ProgresivaContinuaVal"]);
                $("#ProgresivaContinuaEdit").val(redhidrografica["ProgresivaContinua"]);
                $("#progresivaValFinEdit").val(redhidrografica["ProgresivaContinuaValFin"]);
                $("#ProgresivaContinuaFinEdit").val(redhidrografica["ProgresivaContinuaFin"]);
                $("#EsteIniEdit").val(formatearCoordenada(redhidrografica["EsteIni"]));
                $("#NorteIniEdit").val(formatearCoordenada(redhidrografica["NorteIni"]));
                $("#EsteFinEdit").val(formatearCoordenada(redhidrografica["EsteFin"]));
                $("#NorteFinEdit").val(formatearCoordenada(redhidrografica["NorteFin"]));
                
                // Seleccionar la opción en el select de Estructura
                var estructuraId = redhidrografica["estructuraId"];
                $("#estructuraEdit").val(estructuraId).trigger('change');
                
                var paqueteId = redhidrografica["paqueteId"];
                $("#paqueteEdit").val(paqueteId).trigger('change');
                
                
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
});

function formatearCoordenada(coordenada) {
    // Asegurarse de que el valor sea un número
    let valor = parseFloat(coordenada);

    // Verificar si la coordenada es un número válido
    if (!isNaN(valor)) {
        // Formatear a 4 decimales
        return valor.toFixed(4);
    } else {
        // Si no es un número válido, devolver 0.0000
        return '0.0000';
    }
}