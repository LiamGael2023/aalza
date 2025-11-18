<?php
require_once "../controladores/coeficiente_edificacion.controlador.php";
require_once "../modelos/coeficiente_edificacion.modelo.php";

if (isset($_POST["accion"])) {
    
    if ($_POST["accion"] == "guardar") {
        ControladorCoeficienteEdificacion::ctrGuardarCoeficienteEdificacion();
    }
    
    if ($_POST["accion"] == "mostrar") {
        $coef = ControladorCoeficienteEdificacion::ctrMostrarCoeficienteEdificacion($_POST["id_expediente"]);
        echo json_encode($coef ? $coef : null);
    }
    
    if ($_POST["accion"] == "eliminar") {
        ControladorCoeficienteEdificacion::ctrEliminarCoeficienteEdificacion();
    }
    
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se recibió ninguna acción"
    ]);
}
?>