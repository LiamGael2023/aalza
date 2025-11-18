<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/redhidrografica.controlador.php";
require_once "../modelos/redhidrografica.modelo.php";

class AjaxCaudalCirculante{
    
    // Definición de la propiedad
    private $id;

    // Setter para la propiedad id
    public function setId($id) {
        $this->id = $id;
    }
    
    public function ajaxCrearCaudalCirculante() {
        $respuesta = ControladorRedHidrografica::ctrIngresarCaudalCirculante();
        echo $respuesta;
    }
    
    public function ajaxGetRegisteredDates() {
        
        // Verificar si se ha enviado un ID
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID del POST
            $fechas = ControladorRedHidrografica::ctrObtenerFechasRegistradas($id); // Pasar el ID al controlador
            echo json_encode(['dates' => $fechas]);
        } else {
            // Manejar el caso en que no se recibe un ID
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }
    
    public function ajaxMostrarGrafico(){

            $item = "id";
            $valor = $this->id;

            $respuesta = ControladorRedHidrografica::ctrMostrarCaudalCirculanteGrafico($item, $valor);
            
                        
            echo json_encode($respuesta);

    }
    
    public function ajaxCaudalCirculanteDelete() {
            $respuesta = ControladorRedHidrografica::ctrBorrarCaudalCirculante();
            echo $respuesta;
    }
    
}

if (isset($_POST["idredhidrografica"])) {
    $crear = new AjaxCaudalCirculante();
    $crear->ajaxCrearCaudalCirculante();
} elseif (isset($_POST["get_registered_dates"])) {
    $fechas = new AjaxCaudalCirculante();
    $fechas->ajaxGetRegisteredDates();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["id"])) {
        $editar = new AjaxCaudalCirculante();
        $editar->setId($_POST["id"]); // Usar el método setter
        $editar->ajaxMostrarGrafico();
    }
}

if (isset($_POST["ideliminar"])) {
    $crear = new AjaxCaudalCirculante();
    $crear->ajaxCaudalCirculanteDelete();
}