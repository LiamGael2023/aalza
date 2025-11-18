<?php
require_once "../controladores/densidad_neta.controlador.php";
require_once "../modelos/densidad_neta.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorDensidadNeta::ctrGuardarDensidadNeta();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $densidad = ControladorDensidadNeta::ctrMostrarDensidadNeta($_POST["id_expediente"]);
        
        if ($densidad) {
            // Cargar también las viviendas
            $densidad['viviendas'] = ControladorDensidadNeta::ctrMostrarViviendas($densidad['id_densidad']);
        }
        
        echo json_encode($densidad ? $densidad : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorDensidadNeta::ctrEliminarDensidadNeta();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>