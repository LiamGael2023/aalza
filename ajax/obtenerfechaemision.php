<?php
require_once '../controladores/lectura.controlador.php'; 
require_once '../modelos/lectura.modelo.php'; 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);
$idjunta = $data['idjunta'] ?? null; // Obtener idjunta desde el cuerpo JSON
if (!$idjunta) {
    echo json_encode(['error' => 'El parámetro idjunta es requerido']);
    exit;
}
// Obtener los datos enviados desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['fecha_emision'])) {
    $fechaEmision = $data['fecha_emision'];
    $item2 = "idjunta";
    $valor2 = $idjunta;
    $valor3 = $fechaEmision;

    // Realizar la consulta
    $tarifa = ControladorLectura::ctrMostrarTarifa($item2, $valor2, $valor3);

    // Debug para verificar la consulta
    error_log(print_r($tarifa, true)); // Imprime en el log del servidor
    echo json_encode($tarifa);
}
?>