<?php

require_once "../controladores/persona.controlador.php";
require_once "../modelos/persona.modelo.php";

class AjaxPersona{
    public function ajaxCrearPersona() {
        $respuesta = ControladorPersona::ctrIngresarPersona();
        echo $respuesta;
    }
    
    public $validarUsuario;

    public function ajaxValidarPersona(){

            $item = "nrodocumento";
            $valor = $this->validarUsuario;

            $respuesta = ControladorPersona::ctrMostrarPersona($item, $valor);

            echo json_encode($respuesta);

    }
    
    public function ajaxObtenerUltimoCodigo() {
        $respuesta = ControladorPersona::ctrObtenerUltimoCodigo();  // Asegúrate de tener este método en tu controlador
        echo json_encode($respuesta);
    }
    
    public function ajaxObtenerUsuarios() {
        $item = null;
        $valor = null;
        $respuesta = ControladorPersona::ctrMostrarPersona($item, $valor);
        echo json_encode($respuesta);
    }

    
}

if (isset($_POST["razonsocial"])) {
    $crear = new AjaxPersona();
    $crear->ajaxCrearPersona();
}

if(isset($_POST["validarUsuario"])){

	$editar = new AjaxPersona();
	$editar -> validarUsuario = $_POST["validarUsuario"];
	$editar -> ajaxValidarPersona();

}

if (isset($_POST["accion"]) && $_POST["accion"] == "obtenerUltimoCodigo") {
    $ajaxPersona = new AjaxPersona();
    $ajaxPersona->ajaxObtenerUltimoCodigo();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $ajaxPersona = new AjaxPersona();
    $ajaxPersona->ajaxObtenerUsuarios();
}
