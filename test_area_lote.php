<?php
echo "<h2>Test - Área de Lote Normativo</h2>";

$archivos = [
    'modelos/area_lote_normativo.modelo.php',
    'controladores/area_lote_normativo.controlador.php',
    'ajax/area_lote_normativo.ajax.php'
];

foreach ($archivos as $archivo) {
    $existe = file_exists($archivo);
    $color = $existe ? 'green' : 'red';
    $icono = $existe ? '✓' : '✗';
    echo "<p style='color: $color;'>$icono $archivo</p>";
    if ($existe) {
        echo "<small style='margin-left: 20px;'>Ruta: " . realpath($archivo) . "</small><br>";
    }
}
?>