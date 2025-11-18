<?php
require_once '../modelos/conexion.php'; // Archivo con la clase Conexion

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Subir archivo
    $conn = Conexion::conectar(); // Establecer conexión con la base de datos

    $reqvoucher_id = intval($_POST['reqvoucher']); // Obtener el ID del requerimiento
    $file = $_FILES['voucher']; // Archivo subido

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name']; // Ruta temporal
        $fileName = basename($file['name']); // Nombre original del archivo
        $uploadDir = 'uploads/vouchers/'; // Directorio de destino
        $destPath = $uploadDir . uniqid() . '-' . $fileName; // Ruta final

        // Crear el directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Mover el archivo al servidor
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Consulta para insertar los datos en la base de datos
            $sql = "INSERT INTO vouchers (reqvoucher_id, file_path) VALUES (?, ?)";
            $params = [$reqvoucher_id, $destPath];
            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt === false) {
                $errors = sqlsrv_errors();
                echo json_encode(['success' => false, 'message' => 'Error al guardar el voucher en la base de datos.', 'errors' => $errors]);
            } else {
                echo json_encode(['success' => true, 'message' => 'El voucher se subió correctamente.', 'filePath' => 'ajax/'.$destPath]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al mover el archivo al servidor.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir el archivo.']);
    }

    sqlsrv_close($conn); // Cerrar conexión
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recuperar imágenes
    $conn = Conexion::conectar(); // Establecer conexión con la base de datos
    $reqvoucher_id = intval($_GET['reqvoucher_id']); // Obtener el ID del requerimiento

    // Consulta para obtener las rutas de las imágenes ya subidas
    $sql = "SELECT id,reqvoucher_id,file_path FROM vouchers WHERE reqvoucher_id = ?";
    $params = [$reqvoucher_id];
    $stmt = sqlsrv_query($conn, $sql, $params);

    $images = [];
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $images[] = [
                'id' => $row['id'], // Incluye el ID del registro
                'file_path' => 'https://www.chavimochic.gob.pe/SGRHIconnect/ajax/' . $row['file_path'], // Incluye la ruta del archivo
            ];
        }
    }

    // Devuelve las imágenes como JSON
    echo json_encode($images);

    sqlsrv_close($conn); // Cerrar conexión
}
?>