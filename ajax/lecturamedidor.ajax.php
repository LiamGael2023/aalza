<?php

require_once "../controladores/medidorempresa.controlador.php";
require_once "../modelos/medidorempresa.modelo.php";

class AjaxLecturaMedidor{
    public function ajaxCrearLecturaMedidor() {
        $respuesta = ControladorMedidorEmpresa::ctrIngresarLecturaMedidor();
        echo $respuesta;
    }
    
}

if (isset($_POST["junta"])) {
    $crear = new AjaxLecturaMedidor();
    $crear->ajaxCrearLecturaMedidor();
}
