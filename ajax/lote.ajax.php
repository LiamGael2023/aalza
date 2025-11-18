<?php

require_once "../controladores/lote.controlador.php";
require_once "../modelos/lote.modelo.php";

class AjaxLote{
    public function ajaxCrearLote() {
        $respuesta = ControladorLote::ctrIngresarLote();
        echo $respuesta;
    }
    
    public $bloqueId;

    public function ajaxSelectLote(){

            $item = "idbloque";
            $valor = $this->bloqueId;

            $respuesta = ControladorLote::ctrSelectLote($item, $valor);

            echo json_encode($respuesta);

    }
    
    public $loteId;

    public function ajaxAreaLote(){

            $item = "id";
            $valor = $this->loteId;

            $respuesta = ControladorLote::ctrAreaLote($item, $valor);

            echo json_encode($respuesta);

    }
    
}

if (isset($_POST["unidadcatastral"])) {
    $crear = new AjaxLote();
    $crear->ajaxCrearLote();
}

if (isset($_POST["bloqueId"])) {
    $select = new AjaxLote();
    $select->bloqueId = $_POST["bloqueId"];
    $select->ajaxSelectLote();
}

if (isset($_POST["loteId"])) {
    $select = new AjaxLote();
    $select->loteId = $_POST["loteId"];
    $select->ajaxAreaLote();
}