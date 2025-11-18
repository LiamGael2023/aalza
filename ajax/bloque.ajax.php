<?php

require_once "../controladores/bloque.controlador.php";
require_once "../modelos/bloque.modelo.php";

class AjaxBloque{
    public function ajaxCrearBloque() {
        $respuesta = ControladorBloque::ctrIngresarBloque();
        echo $respuesta;
    }
    
    public $comisionId;
    public $juntaId;

    public function ajaxSelectBloque(){

            $item = "idcomision";
            $item1 = "idjunta";
            $valor = $this->comisionId;
            $valor1 = $this->juntaId;

            $respuesta = ControladorBloque::ctrSelectBloque($item, $item1, $valor, $valor1);

            echo json_encode($respuesta);

    }
    
}

if (isset($_POST["nombre"])) {
    $crear = new AjaxBloque();
    $crear->ajaxCrearBloque();
}

if (isset($_POST["comisionId"])) {
    $select = new AjaxBloque();
    $select->comisionId = $_POST["comisionId"];
    $select->juntaId = $_POST["juntaId"];
    $select->ajaxSelectBloque();
}