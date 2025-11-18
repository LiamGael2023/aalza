<?php
require_once "controladores/expediente.controlador.php";
require_once "modelos/expediente.modelo.php";

$id_test = 6; // Usa un ID que exista en tu BD

echo "<h2>Test de Edición de Expediente</h2>";

echo "<h3>1. Probar obtener expediente desde el controlador</h3>";

$item = "id_expediente";
$valor = $id_test;
$respuesta = ControladorExpediente::ctrMostrarExpediente($item, $valor);

echo "<pre>";
print_r($respuesta);
echo "</pre>";

if (!empty($respuesta)) {
    echo "<p style='color: green;'>✓ Datos obtenidos correctamente</p>";
    
    echo "<h3>2. Simular respuesta AJAX</h3>";
    $response = array(
        "success" => true,
        "data" => $respuesta[0]
    );
    echo "<pre>";
    echo json_encode($response, JSON_PRETTY_PRINT);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>✗ No se encontró el expediente con ID $id_test</p>";
}

echo "<hr>";

echo "<h3>3. Botón de prueba</h3>";
echo "<button class='btnEditarExpediente' data-id='$id_test' style='padding: 10px 20px; background: #ffc107; border: none; cursor: pointer; border-radius: 5px;'>";
echo "Editar Expediente #$id_test";
echo "</button>";

echo "<div id='resultado' style='margin-top: 20px; padding: 15px; background: #f0f0f0; border-radius: 5px; display: none;'></div>";

echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
echo "<script>
function editarExpediente(idExpediente) {
    console.log('=== FUNCIÓN EDITAR LLAMADA ===');
    console.log('ID recibido:', idExpediente);
    
    $.ajax({
        url: 'ajax/expediente.ajax.php',
        method: 'POST',
        data: {
            accion: 'obtener',
            id_expediente: idExpediente
        },
        dataType: 'json',
        success: function(response) {
            console.log('=== RESPUESTA DEL SERVIDOR ===');
            console.log(response);
            
            $('#resultado').show().html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
            
            if (response.success && response.data) {
                alert('Datos cargados correctamente. Revisa la consola (F12)');
            } else {
                alert('Error: ' + (response.message || 'No se pudieron cargar los datos'));
            }
        },
        error: function(xhr, status, error) {
            console.error('=== ERROR AJAX ===');
            console.error('Error:', error);
            console.error('Estado:', status);
            console.error('Respuesta:', xhr.responseText);
            
            $('#resultado').show().html('<span style=\"color: red;\">Error: ' + error + '</span><br><pre>' + xhr.responseText + '</pre>');
        }
    });
}

$(document).on('click', '.btnEditarExpediente', function(e) {
    e.preventDefault();
    var idExpediente = $(this).data('id');
    console.log('=== CLIC EN BOTÓN EDITAR ===');
    console.log('ID del botón:', idExpediente);
    editarExpediente(idExpediente);
});

console.log('Script de test cargado correctamente');
</script>";
?>