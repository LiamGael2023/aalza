<?php

require_once "../controladores/medidor.controlador.php";
require_once "../modelos/medidor.modelo.php";

class AjaxModeloMedidor {
    public function ajaxCrearModeloMedidor() {
        $respuesta = ControladorMedidor::ctrIngresarModeloMedidor();
        echo $respuesta;
    }
    
    public $id;

    public function ajaxEditarModeloMedidor() {
        $item = "id";
        $valor = $this->id;

        // Obtener la información del modelo a editar
        $modelo = ControladorMedidor::ctrMostrarModeloMedidor($item, $valor);

        // Obtener las marcas disponibles
        $marcas = ControladorMedidor::ctrMostrarMarcaMedidor($item = null, $valor = null);

        // Preparar la respuesta
        $respuesta = array(
            "modelo" => $modelo,
            "marcas" => $marcas
        );

        echo json_encode($respuesta);
    }
    
    public function ajaxModeloMedidorEdit() {
            $respuesta = ControladorMedidor::ctrEditarModeloMedidor();
            echo $respuesta;
    }
    
    public function ajaxModeloMedidorDelete() {
            $respuesta = ControladorMedidor::ctrBorrarModeloMedidor();
            echo $respuesta;
    }
    
    public $marcaId;

    public function ajaxSelectModeloMedidor(){

            $item = "idmarca_medidor";
            $valor = $this->marcaId;

            $respuesta = ControladorMedidor::ctrSelectModeloMedidor($item, $valor);

            echo json_encode($respuesta);

    }
    
    
}

if (isset($_POST["descripcion"])) {
    $crear = new AjaxModeloMedidor();
    $crear->ajaxCrearModeloMedidor();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxModeloMedidor();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarModeloMedidor();
    }
}

if (isset($_POST["editarIdModeloMedidor"])) {
    $crear = new AjaxModeloMedidor();
    $crear->ajaxModeloMedidorEdit();
}

if (isset($_POST["idmodelomedidor"])) {
    $crear = new AjaxModeloMedidor();
    $crear->ajaxModeloMedidorDelete();
}

if (isset($_POST["marcaId"])) {
    $select = new AjaxModeloMedidor();
    $select->marcaId = $_POST["marcaId"];
    $select->ajaxSelectModeloMedidor();
}