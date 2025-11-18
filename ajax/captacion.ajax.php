<?php

require_once "../controladores/captacion.controlador.php";
require_once "../modelos/captacion.modelo.php";

class AjaxCaptacion{
    public function ajaxCrearCaptacion() {
        $respuesta = ControladorCaptacion::ctrIngresarCaptacion();
        echo $respuesta;
    }
    
    public $bloqueId;

    public function ajaxSelectCaptacion(){

            $item = "idbloque";
            $valor = $this->bloqueId;

            $respuesta = ControladorCaptacion::ctrSelectCaptacion($item, $valor);

            echo json_encode($respuesta);

    }
    
    public function ajaxAsignarCaptacion() {
        $respuesta = ControladorCaptacion::ctrAsignarCaptacion();
        echo $respuesta;
    }
    
}

if (isset($_POST["nombreCaptacion"])) {
    $crear = new AjaxCaptacion();
    $crear->ajaxCrearCaptacion();
}

if (isset($_POST["bloqueId"])) {
    $select = new AjaxCaptacion();
    $select->bloqueId = $_POST["bloqueId"];
    $select->ajaxSelectCaptacion();
}

if (isset($_POST["idbloque"])) {
    $crear = new AjaxCaptacion();
    $crear->ajaxAsignarCaptacion();
}