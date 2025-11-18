<?php
require_once '../modelos/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['inputId'])) {
        $id = $_POST['inputId']; // Captura el valor del input
        error_log("ID recibido: " . $id); // Log para depuración

        // Conexión a la base de datos
        $conn = Conexion::conectar();

        // Verificar la conexión
        if ($conn === false) {
            die(json_encode(['error' => 'Error en la conexión a la base de datos', 'details' => sqlsrv_errors()]));
        }

        // Consulta SQL
        $query = "SELECT hora0, hora1, hora2, hora3, hora4, hora5, hora6, hora7, hora8, hora9, hora10, hora11, hora12, hora13, hora14, hora15, hora16, hora17, hora18, hora19, hora20, hora21, hora22, hora23 FROM caudales_circulantes WHERE id = ?";
        $params = array($id); // Usa el ID capturado

        $stmt = sqlsrv_query($conn, $query, $params);

        // Verificar la consulta
        if ($stmt === false) {
            die(json_encode(['error' => 'Error en la consulta', 'details' => sqlsrv_errors()]));
        }

        $data = [];
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row === null) {
            echo json_encode(["error" => "No se encontraron datos para el ID proporcionado."]);
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);
            return; // Detener la ejecución
        }

        // Recoger los datos
        for ($i = 0; $i < 24; $i++) {
            $value = $row["hora$i"];
            // Verifica si el valor es un guion o está vacío
            $data[] = ($value === null || $value === '-' || trim($value) === '') ? '-' : (float)$value; 
        }

        // Cerrar la declaración
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);

        // Enviar la respuesta (por ejemplo, datos en formato JSON)
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "ID no proporcionado."]);
    }
}
?>