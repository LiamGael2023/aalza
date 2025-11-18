<?php
// Incluir la clase de conexión
require_once '../modelos/conexion.php';  // Asegúrate de que la ruta sea correcta

if (isset($_POST['id_medidor'])) {
    $id_medidor = $_POST['id_medidor'];

    // Obtener la conexión a la base de datos
    $conn = Conexion::conectar();

    // Consulta SQL para obtener el volumen_acumulado del medidor
    $sql = "select m.volumen_acumulado from medidorempresa me
inner join medidor m on me.idmedidor = m.id
inner join persona p on me.idpersona = p.id
inner join juntas j on me.idjunta = j.id WHERE me.id = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($id_medidor));

    // Ejecutar la consulta
    if (sqlsrv_execute($stmt)) {
        // Verificar si la consulta retorna algún resultado
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Devolver el volumen acumulado en formato JSON
            echo json_encode(['success' => true, 'volumen_acumulado' => $row['volumen_acumulado']]);
        } else {
            // Si no se encuentra el medidor, retornar un error
            echo json_encode(['success' => false, 'message' => 'Medidor no encontrado']);
        }
    } else {
        // Si hay un error en la ejecución de la consulta
        echo json_encode(['success' => false, 'message' => 'Error en la consulta']);
    }

    // Cerrar la conexión
    sqlsrv_close($conn);
} else {
    // Si no se recibe el id_medidor, retornar un error
    echo json_encode(['success' => false, 'message' => 'ID del medidor no recibido']);
}
?>