<?php

require_once "../controladores/comision.controlador.php";
require_once "../modelos/comision.modelo.php";
require_once "../controladores/junta.controlador.php";
require_once "../modelos/junta.modelo.php";

class AjaxComision{
    public function ajaxCrearComision() {
        $respuesta = ControladorComision::ctrIngresarComision();
        echo $respuesta;
    }
    
    public $juntaId;

    public function ajaxSelectComision(){

            $item = "idjunta";
            $valor = $this->juntaId;

            $respuesta = ControladorComision::ctrSelectComision($item, $valor);

            echo json_encode($respuesta);

    }
    
    public $id;
    
    public function ajaxEditarComision(){

            $item = "id";
            $valor = $this->id;
            
            

            $comision = ControladorComision::ctrMostrarComision($item, $valor);
            
            //$juntas = ControladorMedidor::ctrMostrarMarcaMedidor($item = null, $valor = null);
            $juntas = ControladorJunta::ctrMostrarJunta($item = null, $valor = null);
            
            $respuesta = array(
                "comision" => $comision,
                "junta" => $juntas
            );
            
            header('Content-Type: application/json');
            echo json_encode($respuesta);

    }
    
    public function ajaxComisionEdit() {
            $respuesta = ControladorComision::ctrEditarComision();
            echo $respuesta;
    }
    
    public function ajaxComisionDelete() {
            $respuesta = ControladorComision::ctrBorrarComision();
            echo $respuesta;
        }
    
    
}

if (isset($_POST["nombre"])) {
    $crear = new AjaxComision();
    $crear->ajaxCrearComision();
}

if (isset($_POST["juntaId"])) {
    $select = new AjaxComision();
    $select->juntaId = $_POST["juntaId"];
    $select->ajaxSelectComision();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxComision();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarComision();
    }
}

if (isset($_POST["editarIdComision"])) {
    $crear = new AjaxComision();
    $crear->ajaxComisionEdit();
}

if (isset($_POST["idcomision"])) {
    $crear = new AjaxComision();
    $crear->ajaxComisionDelete();
}