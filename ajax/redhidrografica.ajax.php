<?php

require_once "../controladores/redhidrografica.controlador.php";
require_once "../modelos/redhidrografica.modelo.php";
require_once "../controladores/estructura.controlador.php";
require_once "../modelos/estructura.modelo.php";

class AjaxRedHidrografica{
    public function ajaxCrearRedHidrografica() {
        $respuesta = ControladorRedHidrografica::ctrIngresarRedHidrografica();
        echo $respuesta;
    }
    
    public $id;

    public function ajaxEditarRedHidrografica(){

            $item = "id";
            $valor = $this->id;

            $respuesta = ControladorRedHidrografica::ctrMostrarRedHidrografica($item, $valor);
            //$categoria = ControladorEstructura::ctrMostrarEstructuraRedHidrografica($item = null, $valor = null);
            
            
            header('Content-Type: application/json');
            echo json_encode($respuesta);

    }
    
    public function ajaxRedHidrograficaEdit() {
            $respuesta = ControladorRedHidrografica::ctrEditarRedHidrografica();
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
        $editar = new AjaxRedHidrografica();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarRedHidrografica();
    }
}

if (isset($_POST["redidEdit"])) {
    $crear = new AjaxRedHidrografica();
    $crear->ajaxRedHidrograficaEdit();
}

if (isset($_POST["ideliminar"])) {
    $crear = new AjaxRedHidrografica();
    $crear->ajaxRedHidrograficaDelete();
}