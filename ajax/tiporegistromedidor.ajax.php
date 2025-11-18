<?php

require_once "../controladores/medidor.controlador.php";
require_once "../modelos/medidor.modelo.php";

class AjaxTipoRegistroMedidor {
    public function ajaxCrearTipoRegistroMedidor() {
        $respuesta = ControladorMedidor::ctrIngresarTipoRegistroMedidor();
        echo $respuesta;
    }
//    
//    public $id;
//
//    public function ajaxEditarMarcaMedidor(){
//
//            $item = "id";
//            $valor = $this->id;
//
//            $respuesta = ControladorMedidor::ctrMostrarMarcaMedidor($item, $valor);
//
//            echo json_encode($respuesta);
//
//    }
//    
//    public function ajaxMarcaMedidorEdit() {
//            $respuesta = ControladorMedidor::ctrEditarMarcaMedidor();
//            echo $respuesta;
//    }
//    
//    public function ajaxMarcaMedidorDelete() {
//            $respuesta = ControladorMedidor::ctrBorrarMarcaMedidor();
//            echo $respuesta;
//        }
//    
    
}

if (isset($_POST["descripcion"])) {
    $crear = new AjaxTipoRegistroMedidor();
    $crear->ajaxCrearTipoRegistroMedidor();
}
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    if (isset($_POST["id"])) {
//        $editar = new AjaxMarcaMedidor();
//        $editar->id = $_POST["id"];
//        $editar->ajaxEditarMarcaMedidor();
//    }
//}
//
//if (isset($_POST["editarIdMarcaMedidor"])) {
//    $crear = new AjaxMarcaMedidor();
//    $crear->ajaxMarcaMedidorEdit();
//}
//
//if (isset($_POST["idmarcamedidor"])) {
//    $crear = new AjaxMarcaMedidor();
//    $crear->ajaxMarcaMedidorDelete();
//}