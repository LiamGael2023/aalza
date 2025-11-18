<?php

require_once "../controladores/provincia.controlador.php";
require_once "../modelos/provincia.modelo.php";

class AjaxProvincia{
//    public function ajaxCrearComision() {
//        $respuesta = ControladorComision::ctrIngresarComision();
//        echo $respuesta;
//    }
    
    public $departamentoId;

    public function ajaxSelectProvincia(){

            $item = "Id_Departamento";
            $valor = $this->departamentoId;

            $respuesta = ControladorProvincia::ctrSelectProvincia($item, $valor);

            echo json_encode($respuesta);

    }
    
}

//if (isset($_POST["nombre"])) {
//    $crear = new AjaxComision();
//    $crear->ajaxCrearComision();
//}

if (isset($_POST["departamentoId"])) {
    $select = new AjaxProvincia();
    $select->departamentoId = $_POST["departamentoId"];
    $select->ajaxSelectProvincia();
}