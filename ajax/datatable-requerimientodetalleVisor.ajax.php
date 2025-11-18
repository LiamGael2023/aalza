<?php

ob_start();

require_once "../controladores/requerimiento.controlador.php";
require_once "../modelos/requerimiento.modelo.php";

class tablaRequerimientoAsignarCaptacion {

    public function mostrartablaRequerimientoAsignarCaptacion() {
        // Obtener el valor de la variable enviada desde JavaScript
        $variable = isset($_POST['variable']) ? $_POST['variable'] : null;
        $fechaI = isset($_POST['fechaI']) ? $_POST['fechaI'] : '';  // Fecha inicio enviada por AJAX
        $fechaT = isset($_POST['fechaT']) ? $_POST['fechaT'] : '';  // Fecha fin enviada por AJAX
        // Definir los valores para la consulta
        $item = 'idRequerimiento'; // Este debe ser el campo en tu base de datos para el filtro
        $valor = $variable; // Usar la variable obtenida

        $requerimientocaptacion = ControladorRequerimiento::ctrMostrarRequerimientoCaptacion($item, $valor);

        if (count($requerimientocaptacion) == 0) {
            echo '{"data": []}';
            return;
        }
        
        $datos = array();

        foreach ($requerimientocaptacion as $key => $reqcaptacion) {
            
            $tiempoOperacionFormatted = number_format($reqcaptacion["tiempo_operacion"], 2, '.', '');
            
            $fechainiOriginal = $reqcaptacion["fecha_horaini"];
            // Verificar si $fechaOriginal es un objeto DateTime
            if ($fechainiOriginal instanceof DateTime) {
                $fechaini = $fechainiOriginal->format('d/m/Y H:i');
            } else {
                $fechaini = date('d/m/Y', strtotime($fechainiOriginal));
            }
            
            $fechafinOriginal = $reqcaptacion["fecha_horatermino"];
            // Verificar si $fechaOriginal es un objeto DateTime
            if ($fechafinOriginal instanceof DateTime) {
                $fechafin = $fechafinOriginal->format('d/m/Y H:i');
            } else {
                $fechafin = date('d/m/Y', strtotime($fechafinOriginal));
            }
            
            
            //actualizar aqui
//            $fechaini_date = date("Y-m-d", strtotime($fechainiOriginal));
//            $fechaIn_date = date("Y-m-d", strtotime($fechaI));
//
//
//            // Comparar solo las fechas (sin hora)
//            if ($fechaini_date < $fechaIn_date) {
//                $red = "red";
//            } else {
//                $red = "black";
//            }
                       
            $numeroFila = '<td style="text-align: left !important;">'.($key + 1).'</td>';
            $captacion = utf8_encode($reqcaptacion["captacion"]);
            $fechahoraini = '<td>'.$fechaini.'</td>';
            $fechahorafin = '<td>'.$fechafin.'</td>';
            $tiempooperacion = $tiempoOperacionFormatted;
            $caudalnetoFormateado = number_format($reqcaptacion["caudalneto"], 7, '.', ''); // Formatea a 7 decimales
            $caudalneto = number_format($caudalnetoFormateado, 3, '.', '');
            $caudalbrutoFormateado = number_format($reqcaptacion["caudalbruto"], 7, '.', ''); // Formatea a 7 decimales
            $caudalbruto = number_format($caudalbrutoFormateado, 3, '.', '');
            $volumenfacturado = number_format($reqcaptacion["volfacturado"],5, '.', '');
            $volumenbruto = number_format($reqcaptacion["volbruto"],5, '.', '');
            $totalTuihma = number_format($reqcaptacion["totalTUIHMA"],5, '.', '');
            $eficiencia = '<td>'.utf8_encode($reqcaptacion["eficiencia"]).'</td>';
            
            $fila = array(
                $numeroFila,
                $captacion,
                $fechahoraini,
                $fechahorafin,
                $tiempooperacion,
                $caudalneto,
                $caudalbruto,
                $volumenfacturado,
                $volumenbruto,
                $totalTuihma,
                $eficiencia
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarRequerimientoAsignarCaptacion = new tablaRequerimientoAsignarCaptacion();
$activarRequerimientoAsignarCaptacion->mostrartablaRequerimientoAsignarCaptacion();

?>
