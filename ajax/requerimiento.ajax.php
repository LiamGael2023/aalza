<?php

require_once "../controladores/requerimiento.controlador.php";
require_once "../modelos/requerimiento.modelo.php";

class AjaxRequerimiento{
    public function ajaxCrearRequerimiento() {
        $respuesta = ControladorRequerimiento::ctrIngresarRequerimiento();
        echo $respuesta;
    }
    
    public function ajaxAsignarCaptacion() {
        $respuesta = ControladorRequerimiento::ctrAsignarCaptacion();
        echo $respuesta;
    }
    
    public function ajaxTotalesCaptacion($item, $valor) {
        // Llamar al método del controlador y pasar los parámetros
        $respuesta = ControladorRequerimiento::ctrMostrarRequerimientoTotales($item, $valor);
        echo json_encode($respuesta); // Asegúrate de devolver como JSON
    }
    
    public $id;
    
    public function ajaxEditarRequerimiento(){

            $item = "id";
            $valor = $this->id;
            
            

            $respuesta = ControladorRequerimiento::ctrMostrarRequerimientoCaptacion($item, $valor);
            
            header('Content-Type: application/json');
            echo json_encode($respuesta);

    }
    
    public function ajaxRequerimientoEdit() {
            $respuesta = ControladorRequerimiento::ctrEditarRequerimiento();
            echo $respuesta;
    }
    
    public function ajaxRequerimientoEditH() {
            $respuesta = ControladorRequerimiento::ctrEditarRequerimientoH();
            echo $respuesta;
    }
    
    public function ajaxRequerimientoDelete() {
            $respuesta = ControladorRequerimiento::ctrBorrarRequerimientoDet();
            echo $respuesta;
    }
    
}

if (isset($_POST["fecharequerimiento"])) {
    $crear = new AjaxRequerimiento();
    $crear->ajaxCrearRequerimiento();
}

if (isset($_POST["idreq"])) {
    $crear = new AjaxRequerimiento();
    $crear->ajaxAsignarCaptacion();
}

if (isset($_GET["action"]) && $_GET["action"] === "obtenerTotales") {
    $item = $_GET["item"]; // Recibir el nombre del campo
    $valor = $_GET["valor"]; // Recibir el valor
    $crear = new AjaxRequerimiento();
    $crear->ajaxTotalesCaptacion($item, $valor); // Pasar los parámetros
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxRequerimiento();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarRequerimiento();
    }
}

if (isset($_POST["idreqdetEditar"])) {
    $crear = new AjaxRequerimiento();
    $crear->ajaxRequerimientoEdit();
}

if (isset($_POST["idreqdetEditarH"])) {
    $crear = new AjaxRequerimiento();
    $crear->ajaxRequerimientoEditH();
}

if (isset($_POST["ideliminar"])) {
    $crear = new AjaxRequerimiento();
    $crear->ajaxRequerimientoDelete();
}