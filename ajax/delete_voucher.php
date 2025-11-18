<?php
require_once '../modelos/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['filePath'], $input['fileId'])) {
        $filePath = $input['filePath'];
        $fileId = intval($input['fileId']); 

        // Ajustar la ruta del archivo eliminando 'ajax/' si es necesario
        $filePath = str_replace('ajax/', '', $filePath);

        $conn = Conexion::conectar();

        if ($conn) {
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $sql = "DELETE FROM vouchers WHERE id = ?";
                    $params = array($fileId);

                    $stmt = sqlsrv_query($conn, $sql, $params);

                    if ($stmt) {
                        echo json_encode([
                            'success' => true,
                            'message' => 'El archivo y su registro fueron eliminados correctamente.'
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'El archivo fue eliminado, pero ocurrió un error al eliminar el registro en la base de datos.',
                            'error' => sqlsrv_errors()
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No se pudo eliminar el archivo físico.'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'El archivo no existe en el servidor.'
                ]);
            }

            sqlsrv_close($conn);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo conectar a la base de datos.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se proporcionaron los parámetros necesarios.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>