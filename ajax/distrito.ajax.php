<?php

require_once "../controladores/distrito.controlador.php";
require_once "../modelos/distrito.modelo.php";

class AjaxDistrito{
//    public function ajaxCrearComision() {
//        $respuesta = ControladorComision::ctrIngresarComision();
//        echo $respuesta;
//    }
    
    public $provinciaId;

    public function ajaxSelectDistrito(){

            $item = "Id_Provincia";
            $valor = $this->provinciaId;

            $respuesta = ControladorProvincia::ctrSelectDistrito($item, $valor);

            echo json_encode($respuesta);

    }
    
}

//if (isset($_POST["nombre"])) {
//    $crear = new AjaxComision();
//    $crear->ajaxCrearComision();
//}

if (isset($_POST["provinciaId"])) {
    $select = new AjaxDistrito();
    $select->provinciaId = $_POST["provinciaId"];
    $select->ajaxSelectDistrito();
}