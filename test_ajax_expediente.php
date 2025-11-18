<?php
echo "<h2>Test de AJAX Expediente</h2>";

// Probar inclusión de archivos
echo "<h3>1. Verificar archivos</h3>";

$archivos = [
    'controladores/expediente.controlador.php',
    'modelos/expediente.modelo.php',
    'modelos/conexion.php',
    'ajax/expediente.ajax.php'
];

foreach ($archivos as $archivo) {
    if (file_exists($archivo)) {
        echo "✓ <span style='color: green;'>$archivo existe</span><br>";
    } else {
        echo "✗ <span style='color: red;'>$archivo NO existe</span><br>";
    }
}

echo "<hr>";

// Probar controlador
echo "<h3>2. Probar Controlador</h3>";
require_once "controladores/expediente.controlador.php";
require_once "modelos/expediente.modelo.php";

if (class_exists('ControladorExpediente')) {
    echo "✓ <span style='color: green;'>Clase ControladorExpediente existe</span><br>";
    
    $metodos = ['ctrMostrarExpediente', 'ctrCrearExpediente', 'ctrEditarExpediente', 'ctrEliminarExpediente', 'ctrObtenerUltimoNumero'];
    
    foreach ($metodos as $metodo) {
        if (method_exists('ControladorExpediente', $metodo)) {
            echo "✓ <span style='color: green;'>Método $metodo existe</span><br>";
        } else {
            echo "✗ <span style='color: red;'>Método $metodo NO existe</span><br>";
        }
    }
} else {
    echo "✗ <span style='color: red;'>Clase ControladorExpediente NO existe</span><br>";
}

echo "<hr>";

// Probar modelo
echo "<h3>3. Probar Modelo</h3>";

if (class_exists('ModeloExpediente')) {
    echo "✓ <span style='color: green;'>Clase ModeloExpediente existe</span><br>";
    
    $metodos = ['MdlMostrarExpediente', 'mdlCrearExpediente', 'mdlEditarExpediente', 'mdlEliminarExpediente', 'mdlObtenerUltimoNumero'];
    
    foreach ($metodos as $metodo) {
        if (method_exists('ModeloExpediente', $metodo)) {
            echo "✓ <span style='color: green;'>Método $metodo existe</span><br>";
        } else {
            echo "✗ <span style='color: red;'>Método $metodo NO existe</span><br>";
        }
    }
} else {
    echo "✗ <span style='color: red;'>Clase ModeloExpediente NO existe</span><br>";
}

echo "<hr>";

// Probar conexión
echo "<h3>4. Probar Conexión a BD</h3>";

try {
    if (class_exists('Conexion')) {
        $conn = Conexion::conectar();
        if ($conn) {
            echo "✓ <span style='color: green;'>Conexión a BD exitosa</span><br>";
            
            // Probar consulta
            $stmt = $conn->query("SELECT COUNT(*) as total FROM expedientes");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "✓ <span style='color: green;'>Total de expedientes: " . $result['total'] . "</span><br>";
        }
    } else {
        echo "✗ <span style='color: red;'>Clase Conexion NO existe</span><br>";
    }
} catch (Exception $e) {
    echo "✗ <span style='color: red;'>Error de conexión: " . $e->getMessage() . "</span><br>";
}

echo "<hr>";
echo "<h3>✓ Test completado</h3>";
echo "<p><a href='ajax/expediente.ajax.php' target='_blank'>Abrir ajax/expediente.ajax.php</a></p>";
?>