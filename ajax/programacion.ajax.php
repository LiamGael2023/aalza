<?php

require_once "../controladores/programacion.controlador.php";
require_once "../modelos/programacion.modelo.php";

class AjaxProgramacion {
    public function ajaxCrearProgramacion() {
        $respuesta = ControladorProgramacion::ctrIngresarProgramacion();
        echo $respuesta;
    }
}

if (isset($_POST["semanapro"])) {
    $crear = new AjaxProgramacion();
    $crear->ajaxCrearProgramacion();
}