<?php

require_once "../controladores/ihm.controlador.php";
require_once "../modelos/ihm.modelo.php";

class AjaxIHM{
    public function ajaxCrearRedHidrografica() {
        $respuesta = ControladorRedHidrografica::ctrIngresarRedHidrografica();
        echo $respuesta;
    }
    
    public $id;

    public function ajaxEditarIHM(){

            $item = "id";
            $valor = $this->id;

            $respuesta = ControladorIHM::ctrMostrarIHM($item, $valor);
            //$categoria = ControladorEstructura::ctrMostrarEstructuraRedHidrografica($item = null, $valor = null);
            
            
            header('Content-Type: application/json');
            echo json_encode($respuesta);

    }
    
    public function ajaxIHMeditar() {
            $respuesta = ControladorIHM::ctrEditarIHM();
            echo $respuesta;
    }
    
    public function ajaxRedHidrograficaDelete() {
            $respuesta = ControladorRedHidrografica::ctrBorrarRedHidrografica();
            echo $respuesta;
        }
    
}

if (isset($_POST["descripcion"])) {
    $crear = new AjaxRedHidrografica();
    $crear->ajaxCrearRedHidrografica();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxIHM();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarIHM();
    }
}

if (isset($_POST["idEdit"])) {
    $crear = new AjaxIHM();
    $crear->ajaxIHMeditar();
}

if (isset($_POST["ideliminar"])) {
    $crear = new AjaxRedHidrografica();
    $crear->ajaxRedHidrograficaDelete();
}