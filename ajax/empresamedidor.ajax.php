<?php

require_once "../controladores/empresaMedidorLectura.controlador.php";
require_once "../modelos/empresaMedidorLectura.modelo.php";

class AjaxempresaMedidorLectura{
    public function ajaxCrearempresaMedidorLectura() {
        $respuesta = ControladorEmpresaMedidorL::ctrIngresarMedidorEmpresaL();
        echo $respuesta;
        
    }
    
    public function ajaxCrearempresaMedidorLecturaQR() {
        $respuesta = ControladorEmpresaMedidorL::ctrIngresarMedidorEmpresaLQR();
        echo $respuesta;
        
    }
    
}

if (isset($_POST["idlectura"])) {
    $crear = new AjaxempresaMedidorLectura();
    $crear->ajaxCrearempresaMedidorLectura();
}

if (isset($_POST["idlecturaQR"])) {
    $crear = new AjaxempresaMedidorLectura();
    $crear->ajaxCrearempresaMedidorLecturaQR();
}
