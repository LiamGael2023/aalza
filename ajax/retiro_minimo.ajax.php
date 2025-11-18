<?php
require_once "../controladores/retiro_minimo.controlador.php";
require_once "../modelos/retiro_minimo.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorRetiroMinimo::ctrGuardarRetiroMinimo();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $retiro = ControladorRetiroMinimo::ctrMostrarRetiroMinimo($_POST["id_expediente"]);
        echo json_encode($retiro ? $retiro : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorRetiroMinimo::ctrEliminarRetiroMinimo();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>