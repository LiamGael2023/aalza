<?php

require_once "../controladores/derechouso.controlador.php";
require_once "../modelos/derechouso.modelo.php";

class AjaxDerechoUso{
    public function ajaxCrearDerechoUso() {
        $respuesta = ControladorDerechoUso::ctrIngresarDerechoUso();
        echo $respuesta;
    }
    
    public $id;

    public function ajaxEditarDerechoUso(){

            $item = "id";
            $valor = $this->id;

            $respuesta = ControladorDerechoUso::ctrMostrarDerechoUso($item, $valor);

            echo json_encode($respuesta);

    }
    
    public function ajaxMensualizadoEdit() {
            $respuesta = ControladorDerechoUso::ctrEditarMensualizado();
            echo $respuesta;
    }
    
    public $idM;

    public function ajaxMensualizadoDerechoUso(){

            $item = "id";
            $valor = $this->idM;

            $respuesta = ControladorDerechoUso::ctrMostrarDerechoUso($item, $valor);

            echo json_encode($respuesta);

    }
    
    public function ajaxAsignarLote() {
        $respuesta = ControladorDerechoUso::ctrAsignarLote();
        echo $respuesta;
    }
    
    public $idTotalLicencia;

    public function ajaxTotalLicencia() {
        $item = "idderecho";
        $valor = $this->idTotalLicencia;
        $respuesta = ControladorDerechoUso::ctrMostrarTotalLicencia($item, $valor);
        echo json_encode($respuesta);
    }
    
    public function ajaxDerechoUsoLoteDelete() {
            $respuesta = ControladorDerechoUso::ctrBorrarDerechoUsoLote();
            echo $respuesta;
        }
    
}

if (isset($_POST["resolucion"])) {
    $crear = new AjaxDerechoUso();
    $crear->ajaxCrearDerechoUso();
}

if (isset($_POST["id"])) {
    $editar = new AjaxDerechoUso();
    $editar->id = $_POST["id"];
    $editar->ajaxEditarDerechoUso();
}

if (isset($_POST["enero"])) {
    $crear = new AjaxDerechoUso();
    $crear->ajaxMensualizadoEdit();
}

if (isset($_GET["idM"])) {
    $editar = new AjaxDerechoUso();
    $editar->idM = $_GET["idM"];
    $editar->ajaxMensualizadoDerechoUso();
}

if (isset($_POST["lote"])) {
    $crear = new AjaxDerechoUso();
    $crear->ajaxAsignarLote();
}

if (isset($_GET["idTotalLicencia"])) {
    $editar = new AjaxDerechoUso();
    $editar->idTotalLicencia = $_GET["idTotalLicencia"];
    $editar->ajaxTotalLicencia();
}

if (isset($_POST["idDerechousoLote"])) {
    $crear = new AjaxDerechoUso();
    $crear->ajaxDerechoUsoLoteDelete();
}