<?php
require_once "../controladores/frente_minimo_normativo.controlador.php";
require_once "../modelos/frente_minimo_normativo.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorFrenteMinimoNormativo::ctrGuardarFrenteMinimoNormativo();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $frenteMinimo = ControladorFrenteMinimoNormativo::ctrMostrarFrenteMinimoNormativo($_POST["id_expediente"]);
        echo json_encode($frenteMinimo ? $frenteMinimo : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorFrenteMinimoNormativo::ctrEliminarFrenteMinimoNormativo();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>