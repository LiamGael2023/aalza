<?php
require_once "../controladores/alineamiento_fachada.controlador.php";
require_once "../modelos/alineamiento_fachada.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorAlineamientoFachada::ctrGuardarAlineamientoFachada();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $alineamiento = ControladorAlineamientoFachada::ctrMostrarAlineamientoFachada($_POST["id_expediente"]);
        echo json_encode($alineamiento ? $alineamiento : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorAlineamientoFachada::ctrEliminarAlineamientoFachada();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>