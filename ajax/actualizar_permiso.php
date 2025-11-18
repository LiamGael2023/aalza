<?php
include '../modelos/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $campo = $_POST['campo'] ?? null;
    $valor = $_POST['valor'] ?? null;

    $campos_validos = ['puede_ver', 'puede_leer', 'puede_editar', 'puede_eliminar'];

    if (!$id || !in_array($campo, $campos_validos) || !in_array($valor, ['0','1'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $conn = Conexion::conectar();

    $sql = "UPDATE permisos SET $campo = ? WHERE id = ?";
    $params = array(intval($valor), intval($id));
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error en BD']);
        exit;
    } else {
        echo json_encode(['success' => true]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}
