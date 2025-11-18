<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
echo json_encode(array("data" => $datos));
ob_end_clean();

require_once "../controladores/redhidrografica.controlador.php";
require_once "../modelos/redhidrografica.modelo.php";

class tablaCaudalCirculante{

    public function mostrartablaCaudalCirculante() {
        $item = null;
        $valor = null;
        
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        $caudalescirculantes = ControladorRedHidrografica::ctrMostrarCaudalCirculante($item, $valor, $id); 

        if (!is_array($caudalescirculantes)) {
            $caudalescirculantes = [];
        }
        
        //var_dump($caudalescirculantes);

        $datos = array();
function formatValue($value) {
                //return ($value === '-') ? $value : number_format($value, 3, '.', '');
    if ($value === '-' || $value === null || $value === '') {
        return $value;
    }
    
    if (is_numeric($value)) {
        return number_format((float)$value, 3, '.', '');
    } else {
        return '-';
    }
    
            }
        foreach ($caudalescirculantes as $key => $caudalescirculante) {

            $fecha = $caudalescirculante["fecha"] instanceof DateTime ? 
                     $caudalescirculante["fecha"]->format('d/m/Y') : 
                     $caudalescirculante["fecha"];
            
            
            
            $fila = array(
            $key + 1,
            $fecha,
            formatValue($caudalescirculante["altura0"]),
            formatValue($caudalescirculante["altura1"]),
            formatValue($caudalescirculante["altura2"]),
            formatValue($caudalescirculante["altura3"]),
            formatValue($caudalescirculante["altura4"]),
            formatValue($caudalescirculante["altura5"]),
            formatValue($caudalescirculante["altura6"]),
            formatValue($caudalescirculante["altura7"]),
            formatValue($caudalescirculante["altura8"]),
            formatValue($caudalescirculante["altura9"]),
            formatValue($caudalescirculante["altura10"]),
            formatValue($caudalescirculante["altura11"]),
            formatValue($caudalescirculante["altura12"]),
            formatValue($caudalescirculante["altura13"]),
            formatValue($caudalescirculante["altura14"]),
            formatValue($caudalescirculante["altura15"]),
            formatValue($caudalescirculante["altura16"]),
            formatValue($caudalescirculante["altura17"]),
            formatValue($caudalescirculante["altura18"]),
            formatValue($caudalescirculante["altura19"]),
            formatValue($caudalescirculante["altura20"]),
            formatValue($caudalescirculante["altura21"]),
            formatValue($caudalescirculante["altura22"]),
            formatValue($caudalescirculante["altura23"]),
            $caudalescirculante["id"], // Solo el ID para los botones
            $caudalescirculante["idtipo_ingreso"]
        );


            $datos[] = $fila;
        }

        $json_data = json_encode(array("data" => $datos));
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log('JSON Error: ' . json_last_error_msg());
}
        
        header('Content-Type: application/json');
        echo json_encode(array("data" => $datos));
        exit;
    }
}

$activarCaudalCirculante = new tablaCaudalCirculante();
$activarCaudalCirculante->mostrartablaCaudalCirculante();

?>