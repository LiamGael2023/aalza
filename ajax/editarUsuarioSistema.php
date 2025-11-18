<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../modelos/conexion.php';

if (isset($_POST['id'])) {
    $idUsuario = $_POST['id'];
    
    // Conectar a la base de datos
    $conn = Conexion::conectar();
    
    // Consulta para obtener los datos del usuario
    $query = "SELECT nombre FROM usuarios WHERE id = ?";
    $params = array($idUsuario);
    $stmt = sqlsrv_query($conn, $query, $params);
    
    if ($stmt) {
        $usuario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        // Asegúrate de devolver los datos correctos como JSON
        echo json_encode(array(
            'success' => true,
            'data' => array(
                'nombre' =>$usuario['nombre']
            )
        ));
    } else {
        echo json_encode(array('success' => false));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}