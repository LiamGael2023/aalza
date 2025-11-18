<?php
echo "<h2>Test de Rutas - Usos Permitidos</h2>";
echo "<p>Ubicación actual: " . __DIR__ . "</p>";

$rutas = [
    'ajax/uso_permitido.ajax.php',
    '../../ajax/uso_permitido.ajax.php',
    '../ajax/uso_permitido.ajax.php'
];

echo "<h3>Probando rutas AJAX:</h3>";
foreach ($rutas as $ruta) {
    $existe = file_exists($ruta);
    $color = $existe ? 'green' : 'red';
    $icono = $existe ? '✓' : '✗';
    echo "<p style='color: $color;'>$icono $ruta";
    if ($existe) {
        echo " → " . realpath($ruta);
    }
    echo "</p>";
}

echo "<h3>Verificando archivos necesarios:</h3>";
$archivos = [
    '../../modelos/uso_permitido.modelo.php',
    '../../controladores/uso_permitido.controlador.php',
    '../../ajax/uso_permitido.ajax.php'
];

foreach ($archivos as $archivo) {
    $existe = file_exists($archivo);
    $color = $existe ? 'green' : 'red';
    $icono = $existe ? '✓' : '✗';
    echo "<p style='color: $color;'>$icono $archivo</p>";
}
?>