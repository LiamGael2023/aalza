<?php
require_once '../modelos/conexion.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idprogra = $_POST['idprogra'];
    $porcentaje = $_POST['porcentaje'];
    $nota = $_POST['nota'];

    // Conexión a la base de datos
    $conn = Conexion::conectar();

    if ($conn === false) {
        echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
        exit;
    }

    // Actualización de datos
    $sql = "UPDATE programacion SET porcentaje = ? WHERE id = ?";
    $params = array($porcentaje, $idprogra);

    // Ejecutar la consulta
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        $error = sqlsrv_errors();
        echo json_encode(['success' => false, 'message' => $error]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Programación actualizada correctamente']);
    }
}
?>