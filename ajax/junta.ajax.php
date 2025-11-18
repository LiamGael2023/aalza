<?php

require_once "../controladores/junta.controlador.php";
require_once "../modelos/junta.modelo.php";

class AjaxJunta{
    public function ajaxCrearJunta() {
        $respuesta = ControladorJunta::ctrIngresarJunta();
        echo $respuesta;
    }
    
    public function ajaxEditarJunta(){

            $item = "id";
            $valor = $this->id;

            $respuesta = ControladorJunta::ctrMostrarJunta($item, $valor);
            
                        
            echo json_encode($respuesta);

    }
    
    public function ajaxJuntaEdit() {
            $respuesta = ControladorJunta::ctrEditarJunta();
            echo $respuesta;
    }
    
    public function ajaxJuntaDelete() {
            $respuesta = ControladorJunta::ctrBorrarJunta();
            echo $respuesta;
        }
    
}

if (isset($_POST["nombre"])) {
    $crear = new AjaxJunta();
    $crear->ajaxCrearJunta();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxJunta();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarJunta();
    }
}

if (isset($_POST["editarIdJunta"])) {
    $crear = new AjaxJunta();
    $crear->ajaxJuntaEdit();
}

if (isset($_POST["idjunta"])) {
    $crear = new AjaxJunta();
    $crear->ajaxJuntaDelete();
}