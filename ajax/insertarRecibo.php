<?php
require_once '../modelos/conexion.php'; // Asegúrate de que este archivo esté en el mismo directorio

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos desde la solicitud POST
    $correlativo = $_POST['correlativo'] ?? null;
    $lecturaId = $_POST['lecturaId'] ?? null;
    $idjunta = $_POST['idjunta'] ?? null;
    $fechaini = $_POST['fechaini'] ?? null;
    $fechafin = $_POST['fechafin'] ?? null;
    $sumconsumo = $_POST['sumconsumo'] ?? null;
    $rpmo = $_POST['rpmo'] ?? null;
    $rpi = $_POST['rpi'] ?? null;
    $tuihma = $_POST['tuihma'] ?? null;
    $reconomica = $_POST['reconomica'] ?? null;
    $rpmoMonto = isset($_POST['rpmoMonto']) ? number_format((float)$_POST['rpmoMonto'], 2, '.', '') : null;
    $rpiMonto = isset($_POST['rpiMonto']) ? number_format((float)$_POST['rpiMonto'], 2, '.', '') : null;
    $subtotalMonto = isset($_POST['subtotalMonto']) ? number_format((float)$_POST['subtotalMonto'], 2, '.', '') : null;
    $subtotalMontoReco = isset($_POST['subtotalMontoReco']) ? number_format((float)$_POST['subtotalMontoReco'], 2, '.', '') : null;    
    $totalMonto = isset($_POST['totalMonto']) ? number_format((float)$_POST['totalMonto'], 2, '.', '') : null;
    $observacion = $_POST['observacion'] ?? null;
    
//    if ($fechaini) {
//        $fechaini = DateTime::createFromFormat('d/m/Y', $fechaini)->format('Y-m-d');
//    }
//    if ($fechafin) {
//        $fechafin = DateTime::createFromFormat('d/m/Y', $fechafin)->format('Y-m-d');
//    }
    // Validación básica
    if ($lecturaId && $idjunta && $fechaini && $fechafin) {
        $conn = Conexion::conectar();

        $query = "INSERT INTO reciboUnico 
                (correlativo, idlectura, idjunta, fecha_emision, fecha_vencimiento, sumconsumo, rpmo, rpi, rpmomonto, rpimonto, tuihma, subtotalmonto, totalmonto, observacion, reconomica, totalreconomica) 
              VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $correlativo,
            $lecturaId,
            $idjunta,
            $fechaini,
            $fechafin,
            $sumconsumo,
            $rpmo,
            $rpi,
            $rpmoMonto,
            $rpiMonto,
            $tuihma,
            $subtotalMonto,
            $totalMonto,
            $observacion,
            $reconomica,
            $subtotalMontoReco
        ];

        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Error al generar recibo: ' . print_r(sqlsrv_errors(), true)]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Recibo generado correctamente.']);
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos para generar el recibo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>