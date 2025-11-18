<?php

ob_start();

require_once "../controladores/requerimiento.controlador.php";
require_once "../modelos/requerimiento.modelo.php";

class tablaRequerimientoAsignarCaptacion {

    public function mostrartablaRequerimientoAsignarCaptacion() {
        // Obtener el valor de la variable enviada desde JavaScript
        $variable = isset($_POST['variable']) ? $_POST['variable'] : null;
        $idjunta = isset($_POST['idjunta']) ? $_POST['idjunta'] : null;
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
            $captacion = $reqcaptacion["captacion"];
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
            $botones = '<td>'
           . '<div class="btn-group btn-group-sm" role="group">'
           . '';
if (in_array($idjunta, [1])) {
    $botones .= '<a type="button" class="btn btn-sm btn-info btnDuplicarrequerimiento" data-id="'.$reqcaptacion["id"].'" data-idbloque="'.$reqcaptacion["idBloqueCaptacion"].'" title="Duplicar Registro"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg></a>';
} else {
    $botones .= '';
}
// Verificar si $idjunta es 2, 3 o 4
if (in_array($idjunta, [2, 3, 4])) {
    $botones .= '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarrequerimientoH" id="'.$reqcaptacion["id"].'" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lgEdit1" title="Editar Registro"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>';
} else {
    $botones .= '<a type="button" class="btn btn-sm btn-warning p-1 btnEditarrequerimiento" id="'.$reqcaptacion["id"].'" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lgEdit" title="Editar Registro"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>';
}

$botones .= '<a type="button" class="btn btn-sm btn-danger p-1 btnEliminarrequerimiento" data-ideliminar="'.$reqcaptacion["id"].'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
                            <path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058" />
                            <path d="M20 13.5v-7.5" />
                            <path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03" />
                            <path d="M22 22l-5 -5" />
                            <path d="M17 22l5 -5" />
                          </svg></a>'
            . '</div></td>';
            
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
                $eficiencia,
                $botones
            );

            $datos[] = $fila;
        }

        echo json_encode(array("data" => $datos));
    }
}

$activarRequerimientoAsignarCaptacion = new tablaRequerimientoAsignarCaptacion();
$activarRequerimientoAsignarCaptacion->mostrartablaRequerimientoAsignarCaptacion();

?>
