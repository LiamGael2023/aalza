<?php
require_once "../controladores/uso_permitido.controlador.php";
require_once "../modelos/uso_permitido.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorUsoPermitido::ctrGuardarUsoPermitido();
    }
    
    if ($_POST["accion"] == "mostrar") {
        // Cambio: ahora es singular (ctrMostrarUsoPermitido)
        $uso = ControladorUsoPermitido::ctrMostrarUsoPermitido($_POST["id_expediente"]);
        echo json_encode($uso ? $uso : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorUsoPermitido::ctrEliminarUsoPermitido();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>