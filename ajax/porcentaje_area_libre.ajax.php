<?php
require_once "../controladores/porcentaje_area_libre.controlador.php";
require_once "../modelos/porcentaje_area_libre.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorPorcentajeAreaLibre::ctrGuardarPorcentajeAreaLibre();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $porcentajeArea = ControladorPorcentajeAreaLibre::ctrMostrarPorcentajeAreaLibre($_POST["id_expediente"]);
        echo json_encode($porcentajeArea ? $porcentajeArea : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorPorcentajeAreaLibre::ctrEliminarPorcentajeAreaLibre();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>