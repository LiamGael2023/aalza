<?php
// Incluir la clase de conexión
require_once '../modelos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor = $_POST['valor'];  // Este es el valor del QR escaneado

    // Conectar a la base de datos
    $conn = Conexion::conectar();

    // Consulta SQL para buscar el medidor usando el valor del QR
    $query = "SELECT 
                me.id,
                CONCAT(m.codigo, ' / ', p.razonsocial, ' / ', j.abreviatura) AS medidorempresa,
                m.codigo,
                m.volumen_acumulado,  -- Asegúrate de que 'volumen_acumulado' está en la consulta
                p.razonsocial,
                j.nombre,
                j.abreviatura
              FROM medidorempresa me
              INNER JOIN medidor m ON me.idmedidor = m.id
              INNER JOIN persona p ON me.idpersona = p.id
              INNER JOIN juntas j ON me.idjunta = j.id
              WHERE me.id = ?";

    // Preparar la consulta SQL
    $stmt = sqlsrv_prepare($conn, $query, array(&$valor));

    // Ejecutar la consulta
    if (sqlsrv_execute($stmt)) {
        // Recuperar el resultado
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($result) {
            // Si encontramos el medidor, devolver la respuesta en formato JSON
            echo json_encode([
                'success' => true,
                'medidorempresa' => utf8_encode($result['medidorempresa']),
                'id' => $result['id'],
                'volumen_acumulado' => $result['volumen_acumulado'] // Asegúrate de enviar esto
            ]);
        } else {
            // Si no se encuentra el medidor, devolver una respuesta con éxito falso
            echo json_encode(['success' => false, 'message' => 'Medidor no encontrado']);
        }
    } else {
        // Si ocurre un error al ejecutar la consulta
        echo json_encode(['success' => false, 'message' => 'Error en la consulta SQL']);
    }

    // Cerrar la conexión
    sqlsrv_close($conn);
}
?>