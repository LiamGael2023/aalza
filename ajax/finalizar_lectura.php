<?php

// Incluir los archivos de conexión a la base de datos
require_once "../controladores/lectura.controlador.php";
require_once "../modelos/lectura.modelo.php";

if (isset($_POST["id"])) {
    $id = $_POST["id"]; // Obtener el ID desde la solicitud AJAX
    $estado = 1; // El estado que deseas asignar (finalizado)

    // Llamar al controlador para actualizar el estado de la programación
    $respuesta = ControladorLectura::ctrFinalizarLectura($id, $estado);

    echo $respuesta;
} else {
    echo json_encode(array("status" => "error", "message" => "ID no válido"));
}
?>