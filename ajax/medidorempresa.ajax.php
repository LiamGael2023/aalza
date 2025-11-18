<?php

require_once "../controladores/medidorempresa.controlador.php";
require_once "../modelos/medidorempresa.modelo.php";

class AjaxMedidorEmpresa{
    public function ajaxCrearMedidorEmpresa() {
        $respuesta = ControladorMedidorEmpresa::ctrIngresarMedidorEmpresa();
        echo $respuesta;
    }
    
}

if (isset($_POST["junta"])) {
    $crear = new AjaxMedidorEmpresa();
    $crear->ajaxCrearMedidorEmpresa();
}
