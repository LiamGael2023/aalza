<?php
require_once "../controladores/area_lote_normativo.controlador.php";
require_once "../modelos/area_lote_normativo.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorAreaLoteNormativo::ctrGuardarAreaLoteNormativo();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $areaLote = ControladorAreaLoteNormativo::ctrMostrarAreaLoteNormativo($_POST["id_expediente"]);
        echo json_encode($areaLote ? $areaLote : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorAreaLoteNormativo::ctrEliminarAreaLoteNormativo();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>