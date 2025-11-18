<?php

require_once "../controladores/medidor.controlador.php";
require_once "../modelos/medidor.modelo.php";

class AjaxMedidor {
    
    public function ajaxCrearMedidor() {
        $respuesta = ControladorMedidor::ctrIngresarMedidor();
        echo $respuesta;
    }
    
    public function ajaxAsignarLoteCaptacion() {
        $respuesta = ControladorMedidor::ctrAsignarLoteCaptacion();
        echo $respuesta;
    }
    
    
}

if (isset($_POST["codigo"])) {
    $crear = new AjaxMedidor();
    $crear->ajaxCrearMedidor();
}

if (isset($_POST["captacion"])) {
    $crear = new AjaxMedidor();
    $crear->ajaxAsignarLoteCaptacion();
}