<?php

require_once "../controladores/obraspaquetes.controlador.php";
require_once "../modelos/obraspaquetes.modelo.php";

class AjaxObrasPaquetes {
    public function ajaxCrearObrasPaquetes() {
        $respuesta = ControladorObrasPaquetes::ctrIngresarObrasPaquetes();
        echo $respuesta;
    }
    
    public $id;

    public function ajaxEditarObrasPaquetes(){

            $item = "id";
            $valor = $this->id;

            $respuesta = ControladorObrasPaquetes::ctrMostrarObrasPaquetes($item, $valor);
            
                        
            echo json_encode($respuesta);

    }
    
    public function ajaxObrasPaquetesEdit() {
            $respuesta = ControladorObrasPaquetes::ctrEditarObrasPaquetes();
            echo $respuesta;
    }
    
    public function ajaxObrasPaquetesDelete() {
            $respuesta = ControladorObrasPaquetes::ctrBorrarObrasPaquetes();
            echo $respuesta;
        }
    
    
}

if (isset($_POST["descripcion"])) {
    $crear = new AjaxObrasPaquetes();
    $crear->ajaxCrearObrasPaquetes();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxObrasPaquetes();
        $editar->id = $_POST["id"];
        $editar->ajaxEditarObrasPaquetes();
    }
}

if (isset($_POST["editarIdObraPaquete"])) {
    $crear = new AjaxObrasPaquetes();
    $crear->ajaxObrasPaquetesEdit();
}

if (isset($_POST["idObra"])) {
    $crear = new AjaxObrasPaquetes();
    $crear->ajaxObrasPaquetesDelete();
}